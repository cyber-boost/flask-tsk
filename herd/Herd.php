<?php
namespace TuskPHP\Herd;
use TuskPHP\{TuskDb, Memory, TuskObject};
use TuskPHP\Herd\Services\{HerdManager, Primary, Registration, Password, TwoFactor, Guard, Session, Token, Audit, Intelligence, AutoLogin};
use TuskPHP\App\Class\{Stomp, Trunk};
class Herd
{
 private static $instance = null;
 private static $user = null;
 private static $guard = 'web';
 private static $guards = [];
 // Service instances
 private $herdManager;
 private $primary;
 private $registration;
 private $password;
 private $twoFactor;
 private $guardService;
 private $session;
 private $token;
 private $audit;
 private $intelligence;
 private $autoLogin;
 public function __construct()
 {
 $this->initializeServices();
 $this->loadConfiguration();
 }
 public static function getInstance(): self
 {
 if (self::$instance === null) {
 self::$instance = new self();
 }
 return self::$instance;
 }
 private function initializeServices(): void
 {
 $this->herdManager = new HerdManager();
 $this->primary = new Primary();
 $this->registration = new Registration();
 $this->password = new Password();
 $this->twoFactor = new TwoFactor();
 $this->guardService = new Guard();
 $this->session = new Session();
 $this->token = new Token();
 $this->audit = new Audit();
 $this->intelligence = new Intelligence();
 $this->autoLogin = new AutoLogin();
 }
 private function loadConfiguration(): void
 {
 // Load herd configuration from Memory or config
 $config = Memory::recall('herd_config');
 if (!$config) {
 $config = $this->getDefaultConfig();
 Memory::remember('herd_config', $config, 3600);
 }
 self::$guards = $config['guards'] ?? ['web', 'api', 'admin'];
 }
 // ==========================================
 // 1. PRIMARY LOGIN FLOW
 // ==========================================
 public static function login(string $email, string $password, bool $remember = false): bool
 {
 return self::getInstance()->primary->attemptLogin($email, $password, $remember);
 }
 public static function once(array $credentials): bool
 {
 return self::getInstance()->primary->attemptOnce($credentials);
 }
 public static function logout(): bool
 {
 $result = self::getInstance()->primary->performLogout();
 // Integrate with Stomp for session destruction if needed
 if ($result && class_exists('TuskPHP\App\Class\Stomp')) {
 $stomp = new Stomp();
 $stomp->destroySession(session_id(), 'User logout', true);
 }
 // Clear user from memory
 self::$user = null;
 Memory::forget('herd_current_user');
 return $result;
 }
 public static function user(): ?array
 {
 if (self::$user === null) {
 self::$user = self::getInstance()->primary->getCurrentUser();
 // Cache in Memory for performance
 if (self::$user) {
 Memory::remember('herd_current_user', self::$user, 1800); // 30 minutes
 }
 }
 return self::$user;
 }
 public static function id(): ?int
 {
 $user = self::user();
 return $user['id'] ?? null;
 }
 public static function check(): bool
 {
 return self::user() !== null;
 }
 public static function guest(): bool
 {
 return !self::check();
 }
 public static function guard(string $guardName): self
 {
 $instance = self::getInstance();
 $instance->guardService->switchGuard($guardName);
 self::$guard = $guardName;
 return $instance;
 }
 // ==========================================
 // 2. REGISTRATION & ACCOUNT LIFECYCLE 
 // ==========================================
 public static function createUser(array $data): array
 {
 return self::getInstance()->registration->createUser($data);
 }
 public static function invite(string $email, string $role = 'user'): bool
 {
 return self::getInstance()->registration->inviteUser($email, $role);
 }
 public static function activate(string $token): array
 {
 return self::getInstance()->registration->verifyEmail($token);
 }
 public static function deactivate(int $userId): bool
 {
 return self::getInstance()->registration->deactivateUser($userId);
 }
 public static function restore(int $userId): bool
 {
 return self::getInstance()->registration->restoreUser($userId);
 }
 public static function purge(int $userId): bool
 {
 return self::getInstance()->registration->purgeUser($userId);
 }
 // ==========================================
 // OBJECT-STYLE ACCESS METHODS
 // ==========================================
 public function herd(): HerdManager
 {
 return $this->herdManager;
 }
 // ==========================================
 // HELPER METHODS
 // ==========================================
 private function getDefaultConfig(): array
 {
 return [
 'guards' => [
 'web' => [
 'driver' => 'session',
 'provider' => 'users'
 ],
 'api' => [
 'driver' => 'token',
 'provider' => 'users'
 ],
 'admin' => [
 'driver' => 'session',
 'provider' => 'admins'
 ]
 ],
 'providers' => [
 'users' => [
 'driver' => 'tusk',
 'model' => 'User'
 ]
 ],
 'passwords' => [
 'users' => [
 'provider' => 'users',
 'table' => 'password_resets',
 'expire' => 60
 ]
 ],
 'session' => [
 'lifetime' => 120,
 'expire_on_close' => false,
 'encrypt' => false,
                 'files' => \TuskPHP\TuskPath::storage('herd/sessions'),
 'connection' => null,
 'table' => 'sessions',
 'store' => null,
 'lottery' => [2, 100],
 'cookie' => 'herd_session',
 'path' => '/',
 'domain' => null,
 'secure' => false,
 'http_only' => true,
 'same_site' => 'lax'
 ]
 ];
 }
 public static function getCurrentGuard(): string
 {
 return self::$guard;
 }
 // ==========================================
 // 3. PASSWORD MANAGEMENT
 // ==========================================
 public static function requestPasswordReset(string $email): array
 {
 return self::getInstance()->password->requestReset($email);
 }
 public static function validateResetToken(string $token): array
 {
 return self::getInstance()->password->validateResetToken($token);
 }
 public static function resetPassword(string $token, string $newPassword): array
 {
 return self::getInstance()->password->resetPassword($token, $newPassword);
 }
 public static function updatePassword(string $current, string $new): array
 {
 $userId = self::id();
 if (!$userId) {
 return [
 'success' => false,
 'errors' => ['auth' => 'User not authenticated']
 ];
 }
 return self::getInstance()->password->updatePassword($userId, $current, $new);
 }
 public static function forcePasswordChange(int $userId): array
 {
 return self::getInstance()->password->forcePasswordChange($userId);
 }
 public static function herdWisdom(): array
 {
 return [
 'total_members' => TuskDb::query("SELECT COUNT(*) FROM users WHERE deleted_at IS NULL")[0]['count'] ?? 0,
 'active_sessions' => Memory::recall('active_sessions_count') ?? 0,
 'guard' => self::$guard,
 'memory_usage' => Memory::wisdom(),
 'last_activity' => date('Y-m-d H:i:s')
 ];
 }
 // ==========================================
 // 4. INTELLIGENCE & ANALYTICS
 // ==========================================
 public static function analytics(): array
 {
 return self::getInstance()->intelligence->getIntelligenceReport();
 }
 public static function liveStats(): array
 {
 return [
 'currently_online' => self::getInstance()->herdManager->getCurrentlyOnline(),
 'recent_logins' => self::getInstance()->herdManager->getRecentLogins(5),
 'failed_attempts' => self::getInstance()->herdManager->getRecentFailedAttempts(5),
 'active_sessions' => self::getInstance()->herdManager->getActiveSessions(),
 'security_score' => self::getInstance()->intelligence->getSecurityScore(),
 'last_updated' => date('Y-m-d H:i:s')
 ];
 }
 public static function footprint(): array
 {
 return self::getInstance()->intelligence->getFootprintAnalytics();
 }
     public static function eye(): array
    {
        return self::getInstance()->intelligence->getSecurityIntelligence();
    }
 public static function track(string $action, array $data = []): void
 {
 $userId = self::id();
 if ($userId) {
 self::getInstance()->intelligence->trackUserActivity($userId, $action, $data);
 }
 }
 public static function wisdom(): array
 {
 $instance = self::getInstance();
 return [
 'herd_stats' => $instance->herdManager->getStats(),
 'intelligence' => $instance->intelligence->getIntelligenceReport(),
 'insights' => $instance->intelligence->generateInsights(),
 'recommendations' => $instance->intelligence->getRecommendations(),
 'elephant_wisdom' => [
 'total_members' => TuskDb::query("SELECT COUNT(*) FROM users WHERE deleted_at IS NULL")[0]['count'] ?? 0,
 'active_sessions' => Memory::recall('active_sessions_count') ?? 0,
 'guard' => self::$guard,
 'memory_usage' => Memory::wisdom(),
 'last_activity' => date('Y-m-d H:i:s')
 ]
 ];
 }
 // ==========================================
 // 5. MAGIC LINKS & AUTO-LOGIN
 // ==========================================
 public static function generateMagicLink(int $userId, array $options = []): array
 {
 return self::getInstance()->autoLogin->generateMagicLink($userId, $options);
 }
 public static function sendMagicLink(int $userId, array $options = []): array
 {
 return self::getInstance()->autoLogin->sendMagicLinkEmail($userId, $options);
 }
 public static function verifyMagicLink(string $token): array
 {
 return self::getInstance()->autoLogin->verifyMagicLink($token);
 }
 public static function loginWithMagicLink(string $token): array
 {
 return self::getInstance()->autoLogin->loginWithMagicLink($token);
 }
 public static function generateAutoLogin(int $userId, string $redirect = '/dashboard/', int $validDays = 3): array
 {
 $options = [
 'purpose' => 'auto_login',
 'redirect' => $redirect,
 'valid_days' => $validDays,
 'max_uses' => 1
 ];
 return self::generateMagicLink($userId, $options);
 }
 public static function verifyAutoLogin(string $token): array
 {
 return self::verifyMagicLink($token);
 }
 public static function loginWithToken(string $token): bool
 {
 $result = self::loginWithMagicLink($token);
 return $result['success'] ?? false;
 }
} 