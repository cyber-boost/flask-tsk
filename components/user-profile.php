<?php
/**
 * <?tusk> Enhanced User Profile Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> user-profile Component
 * Auto-Inclusion: [tusk-component-user-profile]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and data configuration
$theme = isset($theme) ? $theme : 'default';
$user_name = isset($user_name) ? $user_name : 'John Doe';
$user_email = isset($user_email) ? $user_email : 'john.doe@example.com';
$user_role = isset($user_role) ? $user_role : 'Senior Developer';
$user_avatar = isset($user_avatar) ? $user_avatar : 'https://via.placeholder.com/150x150/4CAF50/ffffff?text=JD';
$user_bio = isset($user_bio) ? $user_bio : 'Passionate developer with 5+ years of experience in web technologies. Love creating amazing user experiences.';
$editable = isset($editable) ? $editable : true;
?>

<section class="tusk-user-profile tusk-user-profile--<?php echo $theme; ?>" role="main" aria-label="User Profile">
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="avatar-section">
                    <div class="avatar-wrapper">
                        <img 
                            src="<?php echo htmlspecialchars($user_avatar); ?>" 
                            alt="Profile picture of <?php echo htmlspecialchars($user_name); ?>"
                            class="profile-avatar"
                            loading="lazy"
                        >
                        <?php if ($editable): ?>
                        <button class="avatar-edit" aria-label="Change profile picture">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                                <circle cx="12" cy="13" r="4"/>
                            </svg>
                        </button>
                        <?php endif; ?>
                    </div>
                    <div class="status-indicator" title="Online" aria-label="User is online"></div>
                </div>
                
                <div class="profile-info">
                    <h1 class="profile-name"><?php echo htmlspecialchars($user_name); ?></h1>
                    <p class="profile-role"><?php echo htmlspecialchars($user_role); ?></p>
                    <p class="profile-email">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <?php echo htmlspecialchars($user_email); ?>
                    </p>
                </div>
                
                <?php if ($editable): ?>
                <div class="profile-actions">
                    <button class="btn-edit" aria-label="Edit profile">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button class="btn-settings" aria-label="Profile settings">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1 1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                    </button>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="profile-bio">
                <h2>About</h2>
                <p><?php echo htmlspecialchars($user_bio); ?></p>
            </div>
            
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-number">156</span>
                    <span class="stat-label">Projects</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">2.4k</span>
                    <span class="stat-label">Followers</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">847</span>
                    <span class="stat-label">Following</span>
                </div>
            </div>
            
            <div class="profile-skills">
                <h3>Skills</h3>
                <div class="skills-list">
                    <span class="skill-tag">JavaScript</span>
                    <span class="skill-tag">PHP</span>
                    <span class="skill-tag">React</span>
                    <span class="skill-tag">Node.js</span>
                    <span class="skill-tag">MySQL</span>
                    <span class="skill-tag">Docker</span>
                    <span class="skill-tag">Git</span>
                    <span class="skill-tag">AWS</span>
                </div>
            </div>
            
            <div class="profile-contact">
                <h3>Get in Touch</h3>
                <div class="contact-buttons">
                    <a href="mailto:<?php echo htmlspecialchars($user_email); ?>" class="contact-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        Email
                    </a>
                    <a href="#" class="contact-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/>
                            <rect x="2" y="9" width="4" height="12"/>
                            <circle cx="4" cy="4" r="2"/>
                        </svg>
                        LinkedIn
                    </a>
                    <a href="#" class="contact-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/>
                        </svg>
                        GitHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-user-profile {
    padding: 4rem 0;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-container {
    max-width: 800px;
    width: 100%;
    padding: 0 1.5rem;
}

.profile-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3498db, #e74c3c, #f39c12, #2ecc71);
    background-size: 200% 100%;
    animation: gradientShift 3s ease-in-out infinite;
}

@keyframes gradientShift {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

.profile-header {
    display: flex;
    align-items: center;
    gap: 2rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.avatar-section {
    position: relative;
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
}

.avatar-edit {
    position: absolute;
    bottom: 5px;
    right: 5px;
    background: #3498db;
    color: white;
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.avatar-edit:hover {
    background: #2980b9;
    transform: scale(1.1);
}

.status-indicator {
    position: absolute;
    top: 10px;
    right: 15px;
    width: 16px;
    height: 16px;
    background: #2ecc71;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 2px 8px rgba(46, 204, 113, 0.4);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(46, 204, 113, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(46, 204, 113, 0); }
    100% { box-shadow: 0 0 0 0 rgba(46, 204, 113, 0); }
}

.profile-info {
    flex: 1;
    min-width: 250px;
}

.profile-name {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.profile-role {
    font-size: 1.2rem;
    color: #7f8c8d;
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.profile-email {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #95a5a6;
    font-size: 0.95rem;
}

.profile-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-edit, .btn-settings {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6c757d;
}

.btn-edit:hover, .btn-settings:hover {
    background: #e9ecef;
    border-color: #adb5bd;
    transform: translateY(-2px);
}

.profile-bio {
    margin-bottom: 2rem;
}

.profile-bio h2 {
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.profile-bio p {
    line-height: 1.6;
    color: #5a6c7d;
    font-size: 1rem;
}

.profile-stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(52, 152, 219, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(52, 152, 219, 0.1);
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

.profile-skills {
    margin-bottom: 2rem;
}

.profile-skills h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.skills-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.skill-tag {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
    transition: transform 0.3s ease;
}

.skill-tag:hover {
    transform: translateY(-2px);
}

.profile-contact h3 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.contact-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.contact-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: white;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    text-decoration: none;
    color: #6c757d;
    font-weight: 500;
    transition: all 0.3s ease;
}

.contact-btn:hover {
    border-color: #3498db;
    color: #3498db;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(52, 152, 219, 0.15);
}

/* Theme Variants */
.tusk-user-profile--default {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.tusk-user-profile--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
}

.tusk-user-profile--dark .profile-card {
    background: rgba(45, 45, 45, 0.95);
    color: white;
}

.tusk-user-profile--dark .profile-name,
.tusk-user-profile--dark .profile-bio h2,
.tusk-user-profile--dark .profile-skills h3,
.tusk-user-profile--dark .profile-contact h3,
.tusk-user-profile--dark .stat-number {
    color: white;
}

.tusk-user-profile--minimal {
    background: #f8f9fa;
}

.tusk-user-profile--minimal .profile-card {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.tusk-user-profile--gradient {
    background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 50%, #4ecdc4 100%);
}

.tusk-user-profile--neon {
    background: #0a0a0a;
}

.tusk-user-profile--neon .profile-card {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 40px rgba(0, 255, 136, 0.2);
    color: #00ff88;
}

.tusk-user-profile--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
}

.tusk-user-profile--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
}

.tusk-user-profile--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
}

/* Responsive Design */
@media (max-width: 768px) {
    .tusk-user-profile {
        padding: 2rem 0;
    }
    
    .profile-card {
        padding: 1.5rem;
        margin: 1rem;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    
    .profile-stats {
        flex-direction: column;
        gap: 1rem;
    }
    
    .contact-buttons {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .profile-card {
        margin: 0.5rem;
        padding: 1rem;
    }
    
    .profile-name {
        font-size: 1.5rem;
    }
    
    .skills-list {
        justify-content: center;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .profile-card::before,
    .status-indicator,
    .profile-avatar,
    .skill-tag,
    .contact-btn {
        animation: none;
        transition: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .profile-card {
        border: 2px solid black;
    }
    
    .skill-tag,
    .contact-btn {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userProfiles = document.querySelectorAll('.tusk-user-profile');
    
    userProfiles.forEach(profile => {
        const editBtn = profile.querySelector('.btn-edit');
        const settingsBtn = profile.querySelector('.btn-settings');
        const avatarEdit = profile.querySelector('.avatar-edit');
        
        // Edit profile functionality
        if (editBtn) {
            editBtn.addEventListener('click', () => {
                alert('Edit profile functionality would be implemented here');
                // In a real application, this would open an edit form
            });
        }
        
        // Settings functionality
        if (settingsBtn) {
            settingsBtn.addEventListener('click', () => {
                alert('Settings functionality would be implemented here');
                // In a real application, this would open a settings modal
            });
        }
        
        // Avatar edit functionality
        if (avatarEdit) {
            avatarEdit.addEventListener('click', () => {
                const input = document.createElement('input');
                input.type = 'file';
                input.accept = 'image/*';
                input.onchange = function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const avatar = profile.querySelector('.profile-avatar');
                            avatar.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                };
                input.click();
            });
        }
        
        // Add hover effects to stats
        const statItems = profile.querySelectorAll('.stat-item');
        statItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transform = 'scale(1.05)';
                item.style.transition = 'transform 0.3s ease';
            });
            
            item.addEventListener('mouseleave', () => {
                item.style.transform = 'scale(1)';
            });
        });
    });
});
</script>