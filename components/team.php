<?php
/**
 * <?tusk> Enhanced Team Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> team Component
 * Auto-Inclusion: [tusk-component-team]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme and configuration
$theme = isset($theme) ? $theme : 'default';
$layout = isset($layout) ? $layout : 'grid'; // grid, carousel, list
$show_social = isset($show_social) ? $show_social : true;
$show_bio = isset($show_bio) ? $show_bio : true;
$animated = isset($animated) ? $animated : true;

// Team members data
$team_members = isset($team_members) ? $team_members : [
    [
        'name' => 'Sarah Johnson',
        'role' => 'CEO & Founder',
        'department' => 'Leadership',
        'avatar' => 'https://via.placeholder.com/300x300/3498db/ffffff?text=SJ',
        'bio' => 'Visionary leader with 15+ years of experience in tech innovation. Passionate about building products that make a difference.',
        'expertise' => ['Strategy', 'Innovation', 'Leadership'],
        'social' => [
            'linkedin' => '#',
            'twitter' => '#',
            'email' => 'sarah@company.com'
        ],
        'featured' => true,
        'years_experience' => 15,
        'location' => 'San Francisco, CA'
    ],
    [
        'name' => 'Michael Chen',
        'role' => 'CTO',
        'department' => 'Engineering',
        'avatar' => 'https://via.placeholder.com/300x300/e74c3c/ffffff?text=MC',
        'bio' => 'Full-stack architect and technology enthusiast. Leads our engineering team with expertise in scalable systems.',
        'expertise' => ['Architecture', 'Full-Stack', 'DevOps'],
        'social' => [
            'linkedin' => '#',
            'github' => '#',
            'email' => 'michael@company.com'
        ],
        'featured' => false,
        'years_experience' => 12,
        'location' => 'Austin, TX'
    ],
    [
        'name' => 'Emily Rodriguez',
        'role' => 'Head of Design',
        'department' => 'Design',
        'avatar' => 'https://via.placeholder.com/300x300/2ecc71/ffffff?text=ER',
        'bio' => 'Creative designer focused on user experience and interface design. Believes in the power of design to solve complex problems.',
        'expertise' => ['UI/UX', 'Branding', 'Research'],
        'social' => [
            'linkedin' => '#',
            'dribbble' => '#',
            'email' => 'emily@company.com'
        ],
        'featured' => true,
        'years_experience' => 8,
        'location' => 'New York, NY'
    ],
    [
        'name' => 'David Thompson',
        'role' => 'Product Manager',
        'department' => 'Product',
        'avatar' => 'https://via.placeholder.com/300x300/f39c12/ffffff?text=DT',
        'bio' => 'Product strategist with a keen eye for market trends. Drives product development from conception to launch.',
        'expertise' => ['Strategy', 'Analytics', 'Agile'],
        'social' => [
            'linkedin' => '#',
            'twitter' => '#',
            'email' => 'david@company.com'
        ],
        'featured' => false,
        'years_experience' => 10,
        'location' => 'Seattle, WA'
    ],
    [
        'name' => 'Lisa Wang',
        'role' => 'Lead Developer',
        'department' => 'Engineering',
        'avatar' => 'https://via.placeholder.com/300x300/9b59b6/ffffff?text=LW',
        'bio' => 'Senior developer specializing in modern web technologies. Passionate about clean code and mentoring junior developers.',
        'expertise' => ['React', 'Node.js', 'TypeScript'],
        'social' => [
            'linkedin' => '#',
            'github' => '#',
            'email' => 'lisa@company.com'
        ],
        'featured' => false,
        'years_experience' => 7,
        'location' => 'Remote'
    ],
    [
        'name' => 'James Miller',
        'role' => 'Marketing Director',
        'department' => 'Marketing',
        'avatar' => 'https://via.placeholder.com/300x300/1abc9c/ffffff?text=JM',
        'bio' => 'Growth-focused marketer with expertise in digital campaigns and brand development. Drives customer acquisition and retention.',
        'expertise' => ['Digital Marketing', 'Growth', 'Analytics'],
        'social' => [
            'linkedin' => '#',
            'twitter' => '#',
            'email' => 'james@company.com'
        ],
        'featured' => false,
        'years_experience' => 9,
        'location' => 'Chicago, IL'
    ]
];

// Group by department for filtering
$departments = array_unique(array_column($team_members, 'department'));
?>

<section class="tusk-team tusk-team--<?php echo $theme; ?> tusk-team--<?php echo $layout; ?>" 
         role="region" 
         aria-label="Our Team">
    <div class="team-container">
        <div class="team-header">
            <h2 class="team-title">Meet Our Team</h2>
            <p class="team-subtitle">The brilliant minds behind our success</p>
            
            <div class="team-stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($team_members); ?></div>
                    <div class="stat-label">Team Members</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($departments); ?></div>
                    <div class="stat-label">Departments</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number"><?php echo round(array_sum(array_column($team_members, 'years_experience')) / count($team_members)); ?></div>
                    <div class="stat-label">Avg Experience</div>
                </div>
            </div>
            
            <div class="team-filters">
                <button class="filter-btn active" data-filter="all">All Team</button>
                <?php foreach ($departments as $dept): ?>
                <button class="filter-btn" data-filter="<?php echo strtolower(str_replace(' ', '-', $dept)); ?>">
                    <?php echo $dept; ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="team-grid<?php echo $animated ? ' animated' : ''; ?>">
            <?php foreach ($team_members as $index => $member): ?>
            <div class="team-member <?php echo $member['featured'] ? 'featured' : ''; ?>" 
                 data-index="<?php echo $index; ?>"
                 data-department="<?php echo strtolower(str_replace(' ', '-', $member['department'])); ?>"
                 role="article"
                 aria-label="Team member: <?php echo htmlspecialchars($member['name']); ?>">
                
                <div class="member-card">
                    <div class="member-avatar">
                        <img src="<?php echo htmlspecialchars($member['avatar']); ?>" 
                             alt="Profile picture of <?php echo htmlspecialchars($member['name']); ?>"
                             loading="lazy">
                        <div class="avatar-overlay">
                            <button class="view-profile-btn" aria-label="View <?php echo htmlspecialchars($member['name']); ?>'s profile">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <?php if ($member['featured']): ?>
                        <div class="featured-badge" aria-label="Featured team member">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26"/>
                            </svg>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="member-info">
                        <h3 class="member-name"><?php echo htmlspecialchars($member['name']); ?></h3>
                        <p class="member-role"><?php echo htmlspecialchars($member['role']); ?></p>
                        <p class="member-department"><?php echo htmlspecialchars($member['department']); ?></p>
                        
                        <?php if ($show_bio): ?>
                        <p class="member-bio"><?php echo htmlspecialchars($member['bio']); ?></p>
                        <?php endif; ?>
                        
                        <div class="member-expertise">
                            <?php foreach ($member['expertise'] as $skill): ?>
                            <span class="expertise-tag"><?php echo htmlspecialchars($skill); ?></span>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="member-details">
                            <div class="detail-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12,6 12,12 16,14"/>
                                </svg>
                                <span><?php echo $member['years_experience']; ?> years</span>
                            </div>
                            <div class="detail-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                                <span><?php echo htmlspecialchars($member['location']); ?></span>
                            </div>
                        </div>
                        
                        <?php if ($show_social && !empty($member['social'])): ?>
                        <div class="member-social">
                            <?php foreach ($member['social'] as $platform => $url): ?>
                            <a href="<?php echo htmlspecialchars($url); ?>" 
                               class="social-link" 
                               aria-label="<?php echo htmlspecialchars($member['name']); ?>'s <?php echo $platform; ?>"
                               target="_blank" 
                               rel="noopener noreferrer">
                                <?php echo $this->getSocialIcon($platform); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="member-glow"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="team-cta">
            <h3>Want to Join Our Team?</h3>
            <p>We're always looking for talented individuals to join our mission</p>
            <div class="cta-buttons">
                <button class="cta-button primary">View Open Positions</button>
                <button class="cta-button secondary">Submit Your Resume</button>
            </div>
        </div>
    </div>
</section>

<style>
/* Base Styles */
.tusk-team {
    padding: 5rem 0;
    position: relative;
    overflow: hidden;
}

.team-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 2rem;
}

.team-header {
    text-align: center;
    margin-bottom: 4rem;
}

.team-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.team-subtitle {
    font-size: 1.2rem;
    opacity: 0.8;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.team-stats {
    display: flex;
    justify-content: center;
    gap: 3rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: #2c3e50;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

.team-filters {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid transparent;
    border-radius: 25px;
    background: rgba(255, 255, 255, 0.1);
    color: #7f8c8d;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.filter-btn.active,
.filter-btn:hover {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

/* Team Grid */
.team-grid {
    display: grid;
    gap: 2.5rem;
    margin-bottom: 4rem;
}

.tusk-team--grid .team-grid {
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
}

.tusk-team--list .team-grid {
    grid-template-columns: 1fr;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* Team Member Cards */
.team-member {
    opacity: 1;
    transform: scale(1);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.team-member.hidden {
    opacity: 0;
    transform: scale(0.8);
    pointer-events: none;
}

.member-card {
    position: relative;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 24px;
    padding: 2.5rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    overflow: hidden;
    cursor: pointer;
    text-align: center;
}

.member-card:hover {
    transform: translateY(-15px) rotate(1deg);
    box-shadow: 0 30px 70px rgba(0, 0, 0, 0.15);
}

.team-member.featured .member-card {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border: 2px solid rgba(102, 126, 234, 0.3);
    transform: scale(1.05);
}

.team-member.featured .member-card:hover {
    transform: translateY(-15px) rotate(1deg) scale(1.05);
}

.member-avatar {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
}

.member-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.member-card:hover .member-avatar img {
    transform: scale(1.1);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
}

.avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.member-card:hover .avatar-overlay {
    opacity: 1;
}

.view-profile-btn {
    background: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #2c3e50;
}

.view-profile-btn:hover {
    transform: scale(1.1);
    background: #3498db;
    color: white;
}

.featured-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #f39c12, #e67e22);
    color: white;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
    animation: featuredPulse 2s infinite;
}

@keyframes featuredPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.member-info {
    position: relative;
    z-index: 2;
}

.member-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.member-role {
    font-size: 1.1rem;
    color: #3498db;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.member-department {
    font-size: 0.9rem;
    color: #7f8c8d;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.member-bio {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #5a6c7d;
    margin-bottom: 1.5rem;
    text-align: left;
}

.member-expertise {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.expertise-tag {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: transform 0.3s ease;
}

.expertise-tag:hover {
    transform: translateY(-2px);
}

.member-details {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    color: #7f8c8d;
}

.detail-item svg {
    color: #3498db;
}

.member-social {
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-link {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(52, 152, 219, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3498db;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.social-link:hover {
    background: #3498db;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
}

.member-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 200px;
    height: 200px;
    background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.4s ease;
    pointer-events: none;
}

.member-card:hover .member-glow {
    transform: translate(-50%, -50%) scale(1.5);
}

/* Animated entrance */
.team-grid.animated .team-member {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.team-grid.animated .team-member:nth-child(1) { animation-delay: 0.1s; }
.team-grid.animated .team-member:nth-child(2) { animation-delay: 0.2s; }
.team-grid.animated .team-member:nth-child(3) { animation-delay: 0.3s; }
.team-grid.animated .team-member:nth-child(4) { animation-delay: 0.4s; }
.team-grid.animated .team-member:nth-child(5) { animation-delay: 0.5s; }
.team-grid.animated .team-member:nth-child(6) { animation-delay: 0.6s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* CTA Section */
.team-cta {
    text-align: center;
    padding: 3rem 2rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    backdrop-filter: blur(10px);
}

.team-cta h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #2c3e50;
}

.team-cta p {
    font-size: 1.1rem;
    color: #7f8c8d;
    margin-bottom: 2rem;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.cta-button {
    padding: 1rem 2rem;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.cta-button.primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.cta-button.primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
}

.cta-button.secondary {
    background: transparent;
    color: #3498db;
    border: 2px solid #3498db;
}

.cta-button.secondary:hover {
    background: #3498db;
    color: white;
    transform: translateY(-3px);
}

/* Theme Variants */
.tusk-team--default {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #2c3e50;
}

.tusk-team--dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
}

.tusk-team--dark .member-card {
    background: rgba(45, 45, 45, 0.95);
    border-color: rgba(255, 255, 255, 0.1);
}

.tusk-team--dark .member-name,
.tusk-team--dark .stat-number,
.tusk-team--dark .team-cta h3 {
    color: white;
}

.tusk-team--dark .team-title {
    background: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.tusk-team--minimal {
    background: #ffffff;
    color: #333333;
}

.tusk-team--minimal .member-card {
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e9ecef;
}

.tusk-team--gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.tusk-team--gradient .member-card {
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.2);
}

.tusk-team--gradient .member-name,
.tusk-team--gradient .stat-number,
.tusk-team--gradient .team-cta h3 {
    color: white;
}

.tusk-team--neon {
    background: #0a0a0a;
    color: #00ff88;
}

.tusk-team--neon .member-card {
    background: rgba(0, 20, 40, 0.9);
    border: 1px solid #00ff88;
    box-shadow: 0 0 30px rgba(0, 255, 136, 0.2);
}

.tusk-team--neon .featured-badge {
    background: linear-gradient(135deg, #00ff88, #00d4ff);
}

.tusk-team--corporate {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: white;
}

.tusk-team--corporate .member-card {
    background: rgba(255, 255, 255, 0.1);
}

.tusk-team--corporate .member-name,
.tusk-team--corporate .stat-number,
.tusk-team--corporate .team-cta h3 {
    color: white;
}

.tusk-team--warm {
    background: linear-gradient(135deg, #ff9a56 0%, #ffad56 100%);
    color: #2c3e50;
}

.tusk-team--cool {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
}

.tusk-team--cool .member-card {
    background: rgba(255, 255, 255, 0.15);
}

.tusk-team--cool .member-name,
.tusk-team--cool .stat-number,
.tusk-team--cool .team-cta h3 {
    color: white;
}

/* Responsive Design */
@media (max-width: 968px) {
    .team-container {
        padding: 0 1.5rem;
    }
    
    .team-stats {
        gap: 2rem;
    }
    
    .team-filters {
        gap: 0.5rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
}

@media (max-width: 768px) {
    .tusk-team {
        padding: 3rem 0;
    }
    
    .team-header {
        margin-bottom: 2.5rem;
    }
    
    .team-stats {
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .tusk-team--grid .team-grid {
        grid-template-columns: 1fr;
    }
    
    .member-card {
        padding: 2rem;
    }
    
    .member-avatar {
        width: 100px;
        height: 100px;
    }
    
    .member-details {
        flex-direction: column;
        gap: 1rem;
    }
    
    .team-cta {
        padding: 2rem 1rem;
    }
    
    .team-cta h3 {
        font-size: 1.5rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-button {
        width: 100%;
        max-width: 280px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .team-container {
        padding: 0 1rem;
    }
    
    .member-card {
        padding: 1.5rem;
    }
    
    .member-avatar {
        width: 80px;
        height: 80px;
    }
    
    .team-filters {
        flex-direction: column;
        align-items: center;
    }
    
    .filter-btn {
        width: 100%;
        max-width: 200px;
    }
    
    .member-expertise {
        gap: 0.25rem;
    }
    
    .expertise-tag {
        font-size: 0.75rem;
        padding: 0.25rem 0.6rem;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .member-card,
    .member-avatar img,
    .member-glow,
    .cta-button,
    .featured-badge {
        animation: none;
        transition: none;
    }
    
    .team-grid.animated .team-member {
        animation: none;
        opacity: 1;
        transform: none;
    }
}

/* High contrast mode */
@media (prefers-contrast: high) {
    .member-card {
        border: 2px solid black;
    }
    
    .filter-btn,
    .cta-button {
        border: 2px solid black;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const teamSections = document.querySelectorAll('.tusk-team');
    
    teamSections.forEach(section => {
        const filterBtns = section.querySelectorAll('.filter-btn');
        const teamMembers = section.querySelectorAll('.team-member');
        const statNumbers = section.querySelectorAll('.stat-number');
        const ctaButtons = section.querySelectorAll('.cta-button');
        
        // Initialize filtering
        initializeFiltering(filterBtns, teamMembers);
        
        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add entrance animations if not already animated
                    const grid = section.querySelector('.team-grid');
                    if (!grid.classList.contains('animated')) {
                        grid.classList.add('animated');
                    }
                    
                    // Animate stat numbers
                    statNumbers.forEach(stat => {
                        animateStatNumber(stat);
                    });
                }
            });
        }, observerOptions);
        
        observer.observe(section);
        
        // Add click handlers to team members
        teamMembers.forEach((member, index) => {
            const viewBtn = member.querySelector('.view-profile-btn');
            
            member.addEventListener('click', () => {
                handleMemberClick(member, index);
            });
            
            if (viewBtn) {
                viewBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    handleMemberClick(member, index);
                });
            }
            
            // Add keyboard support
            member.setAttribute('tabindex', '0');
            member.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    member.click();
                }
            });
        });
        
        // CTA button interactions
        ctaButtons.forEach(button => {
            button.addEventListener('click', () => {
                handleCTAClick(button);
            });
        });
    });
    
    function initializeFiltering(filterBtns, teamMembers) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Update active state
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                
                const filter = btn.dataset.filter;
                
                // Filter team members
                teamMembers.forEach(member => {
                    const department = member.dataset.department;
                    
                    if (filter === 'all' || department === filter) {
                        member.classList.remove('hidden');
                    } else {
                        member.classList.add('hidden');
                    }
                });
                
                // Add stagger animation to visible members
                setTimeout(() => {
                    const visibleMembers = Array.from(teamMembers).filter(m => !m.classList.contains('hidden'));
                    visibleMembers.forEach((member, index) => {
                        member.style.animationDelay = (index * 0.1) + 's';
                        member.style.animation = 'none';
                        member.offsetHeight; // Trigger reflow
                        member.style.animation = 'fadeInUp 0.6s ease forwards';
                    });
                }, 100);
            });
        });
    }
    
    function handleMemberClick(member, index) {
        const name = member.querySelector('.member-name')?.textContent || 'Team Member';
        const role = member.querySelector('.member-role')?.textContent || '';
        const bio = member.querySelector('.member-bio')?.textContent || '';
        const department = member.querySelector('.member-department')?.textContent || '';
        const location = member.querySelector('.detail-item:last-child span')?.textContent || '';
        const avatar = member.querySelector('.member-avatar img')?.src || '';
        const expertise = Array.from(member.querySelectorAll('.expertise-tag')).map(tag => tag.textContent);
        
        // Add pulse effect
        const card = member.querySelector('.member-card');
        card.style.animation = 'memberPulse 0.6s ease';
        
        setTimeout(() => {
            card.style.animation = '';
        }, 600);
        
        // Log interaction
        console.log(`Team member clicked: ${index} - ${name}`);
        
        // Show member profile
        if (window.TuskToast) {
            window.TuskToast.info(`${name}`, `${role} - ${department}`);
        } else {
            showMemberModal(member, index);
        }
    }
    
    function animateStatNumber(element) {
        const text = element.textContent;
        const targetValue = parseInt(text.replace(/[^\d]/g, ''));
        
        if (isNaN(targetValue)) return;
        
        let currentValue = 0;
        const increment = targetValue / 60;
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= targetValue) {
                currentValue = targetValue;
                clearInterval(timer);
            }
            
            element.textContent = Math.floor(currentValue);
        }, 33);
    }
    
    function handleCTAClick(button) {
        const text = button.textContent.trim();
        
        // Add ripple effect
        const ripple = document.createElement('div');
        ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.6);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;
        
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = '50%';
        ripple.style.top = '50%';
        ripple.style.marginLeft = ripple.style.marginTop = -(size / 2) + 'px';
        
        button.style.position = 'relative';
        button.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
        
        // Log interaction
        console.log(`CTA clicked: ${text}`);
        
        if (window.TuskToast) {
            if (text.includes('Positions')) {
                window.TuskToast.info('Careers', 'Redirecting to our careers page...');
            } else {
                window.TuskToast.success('Thank You!', 'We\'ll review your application and get back to you soon.');
            }
        }
    }
    
    function showMemberModal(member, index) {
        // Create modal
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            transition: opacity 0.3s ease;
        `;
        
        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            position: relative;
        `;
        
        const name = member.querySelector('.member-name')?.textContent || 'Team Member';
        const role = member.querySelector('.member-role')?.textContent || '';
        const bio = member.querySelector('.member-bio')?.textContent || '';
        const department = member.querySelector('.member-department')?.textContent || '';
        const avatar = member.querySelector('.member-avatar img')?.src || '';
        const expertise = Array.from(member.querySelectorAll('.expertise-tag')).map(tag => tag.textContent);
        const details = Array.from(member.querySelectorAll('.detail-item')).map(item => item.textContent);
        
        content.innerHTML = `
            <button onclick="this.closest('[style*=fixed]').remove()" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #7f8c8d; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">×</button>
            
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="${avatar}" alt="${name}" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 1rem; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                <h2 style="margin: 0 0 0.5rem 0; color: #2c3e50; font-size: 1.8rem;">${name}</h2>
                <p style="margin: 0 0 0.25rem 0; color: #3498db; font-size: 1.1rem; font-weight: 600;">${role}</p>
                <p style="margin: 0 0 1rem 0; color: #7f8c8d; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">${department}</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <h3 style="color: #2c3e50; margin-bottom: 1rem; font-size: 1.2rem;">About</h3>
                <p style="color: #5a6c7d; line-height: 1.6; margin: 0;">${bio}</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <h3 style="color: #2c3e50; margin-bottom: 1rem; font-size: 1.2rem;">Expertise</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    ${expertise.map(skill => `<span style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 0.3rem 0.8rem; border-radius: 15px; font-size: 0.8rem; font-weight: 500;">${skill}</span>`).join('')}
                </div>
            </div>
            
            <div>
                <h3 style="color: #2c3e50; margin-bottom: 1rem; font-size: 1.2rem;">Details</h3>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    ${details.map(detail => `<p style="margin: 0; color: #7f8c8d; font-size: 0.9rem;">${detail}</p>`).join('')}
                </div>
            </div>
        `;
        
        modal.appendChild(content);
        document.body.appendChild(modal);
        
        // Trigger animations
        requestAnimationFrame(() => {
            modal.style.opacity = '1';
            content.style.transform = 'scale(1)';
        });
        
        // Close handlers
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
        const handleEscape = (e) => {
            if (e.key === 'Escape') {
                modal.remove();
                document.removeEventListener('keydown', handleEscape);
            }
        };
        document.addEventListener('keydown', handleEscape);
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
@keyframes memberPulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
`;
document.head.appendChild(style);
</script>

<?php
// Helper function to get social icons
function getSocialIcon($platform) {
    $icons = [
        'linkedin' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>',
        'twitter' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>',
        'github' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>',
        'email' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'dribbble' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="10"/><path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32"/></svg>'
    ];
    
    return isset($icons[$platform]) ? $icons[$platform] : $icons['email'];
}

// Make the function accessible to the template
$this = new class {
    public function getSocialIcon($platform) {
        return getSocialIcon($platform);
    }
};
?>