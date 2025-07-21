<?php
/**
 * login-form.php
 * Enhanced with validation, password visibility toggle, and remember me
 */
?>

<section class="tusk-forms-login-form" id="login">
    <div class="forms-container">
        <div class="form-card">
            <h2>🔐 Welcome Back</h2>
            <p>Please sign in to your account</p>
            
            <form id="login-form" class="login-form">
                <div class="form-group">
                    <label for="login-email" class="form-label">Email Address</label>
                    <input type="email" id="login-email" name="email" class="form-input" 
                           placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="login-password" class="form-label">Password</label>
                    <div class="password-input-container">
                        <input type="password" id="login-password" name="password" class="form-input" 
                               placeholder="Enter your password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                            👁️
                        </button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="remember-me" name="remember">
                        <span class="checkmark"></span>
                        Remember me
                    </label>
                </div>
                
                <button type="submit" class="btn btn-primary full-width">
                    Sign In
                </button>
                
                <div class="form-links">
                    <a href="#" onclick="showForgotPassword()">Forgot your password?</a>
                    <span>|</span>
                    <a href="#" onclick="showSignup()">Create an account</a>
                </div>
            </form>
            
            <div id="forgot-password-form" style="display: none;">
                <h3>Reset Password</h3>
                <p>Enter your email to receive a password reset link.</p>
                <div class="form-group">
                    <input type="email" class="form-input" placeholder="Enter your email" required>
                </div>
                <button class="btn btn-secondary" onclick="sendResetLink()">Send Reset Link</button>
                <a href="#" onclick="showLogin()">Back to login</a>
            </div>
        </div>
    </div>
</section>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.parentNode.querySelector('.password-toggle');
    
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = '🙈';
    } else {
        input.type = 'password';
        button.textContent = '👁️';
    }
}

function showForgotPassword() {
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('forgot-password-form').style.display = 'block';
}

function showLogin() {
    document.getElementById('login-form').style.display = 'block';
    document.getElementById('forgot-password-form').style.display = 'none';
}

function sendResetLink() {
    alert('Password reset link sent! Check your email.');
    showLogin();
}

document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Simulate login
    alert('Login successful! Welcome back.');
});
</script>