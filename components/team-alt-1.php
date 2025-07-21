<?php
/**
 * Team Alternative 1 - Interactive Cards with Hover Effects
 * ======================================================
 * Modern team showcase with detailed member profiles and social links
 * Perfect for highlighting team expertise and personalities
 */

$theme = $_SESSION['theme'] ?? $config['theme'] ?? 'tusk_modern';
$teamMembers = $teamMembers ?? [
    [
        'name' => 'Sarah Johnson',
        'position' => 'CEO & Founder',
        'department' => 'Leadership',
        'bio' => 'Visionary leader with 15+ years in tech. Previously led engineering teams at Google and Microsoft. Passionate about building products that make a difference.',
        'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=300&h=400&fit=crop&crop=face',
        'skills' => ['Strategic Planning', 'Product Vision', 'Team Leadership'],
        'experience' => '15+ years',
        'location' => 'San Francisco, CA',
        'languages' => ['English', 'Spanish'],
        'social' => [
            'linkedin' => 'https://linkedin.com/in/sarahjohnson',
            'twitter' => 'https://twitter.com/sarahjohnson',
            'email' => 'sarah@company.com'
        ],
        'achievements' => ['Forbes 30 Under 30', 'TEDx Speaker', 'Y Combinator Alumni'],
        'quote' => 'Innovation happens when diverse minds collaborate toward a common goal.'
    ],
    [
        'name' => 'Michael Chen',
        'position' => 'CTO',
        'department' => 'Engineering',
        'bio' => 'Full-stack architect and AI enthusiast. Built scalable systems serving millions of users. Loves solving complex technical challenges.',
        'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=400&fit=crop&crop=face',
        'skills' => ['System Architecture', 'Machine Learning', 'Cloud Computing'],
        'experience' => '12+ years',
        'location' => 'Seattle, WA',
        'languages' => ['English', 'Mandarin'],
        'social' => [
            'linkedin' => 'https://linkedin.com/in/michaelchen',
            'github' => 'https://github.com/michaelchen',
            'email' => 'michael@company.com'
        ],
        'achievements' => ['AWS Certified', 'Open Source Contributor', 'Patent Holder'],
        'quote' => 'Great code is written for humans to read, not just machines to execute.'
    ],
    [
        'name' => 'Emily Rodriguez',
        'position' => 'Head of Design',
        'department' => 'Design',
        'bio' => 'UX strategist and creative director. Passionate about creating intuitive experiences that delight users and drive business results.',
        'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=400&fit=crop&crop=face',
        'skills' => ['User Experience', 'Design Systems', 'Product Strategy'],
        'experience' => '10+ years',
        'location' => 'Austin, TX',
        'languages' => ['English', 'Portuguese'],
        'social' => [
            'linkedin' => 'https://linkedin.com/in/emilyrodriguez',
            'dribbble' => 'https://dribbble.com/emilyrodriguez',
            'email' => 'emily@company.com'
        ],
        'achievements' => ['Design Award Winner', 'Figma Community Leader', 'Conference Speaker'],
        'quote' => 'Design is not just how it looks, but how it works and feels.'
    ],
    [
        'name' => 'David Kim',
        'position' => 'VP of Marketing',
        'department' => 'Marketing',
        'bio' => 'Growth hacker and brand strategist. Expert in digital marketing, analytics, and building communities around products.',
        'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=400&fit=crop&crop=face',
        'skills' => ['Growth Marketing', 'Analytics', 'Brand Strategy'],
        'experience' => '8+ years',
        'location' => 'New York, NY',
        'languages' => ['English', 'Korean'],
        'social' => [
            'linkedin' => 'https://linkedin.com/in/davidkim',
            'twitter' => 'https://twitter.com/davidkim',
            'email' => 'david@company.com'
        ],
        'achievements' => ['Marketing Excellence Award', 'Growth Hacker of the Year', 'Podcast Host'],
        'quote' => 'The best marketing doesn\'t feel like marketing.'
    ],
    [
        'name' => 'Lisa Wang',
        'position' => 'Head of Operations',
        'department' => 'Operations',
        'bio' => 'Operations expert and process optimizer. Ensures everything runs smoothly behind the scenes while scaling for growth.',
        'image' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=300&h=400&fit=crop&crop=face',
        'skills' => ['Operations Management', 'Process Optimization', 'Team Coordination'],
        'experience' => '9+ years',
        'location' => 'Los Angeles, CA',
        'languages' => ['English', 'Mandarin'],
        'social' => [
            'linkedin' => 'https://linkedin.com/in/lisawang',
            'email' => 'lisa@company.com'
        ],
        'achievements' => ['Operational Excellence Award', 'Six Sigma Black Belt', 'MBA Graduate'],
        'quote' => 'Excellence is not a skill, it\'s an attitude.'
    ],
    [
        'name' => 'James Thompson',
        'position' => 'Senior Developer',
        'department' => 'Engineering',
        'bio' => 'Full-stack developer and tech mentor. Enjoys building elegant solutions and helping junior developers grow their careers.',
        'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=400&fit=crop&crop=face',
        'skills' => ['React', 'Node.js', 'Database Design'],
        'experience' => '7+ years',
        'location' => 'Denver, CO',
        'languages' => ['English'],
        'social' => [
            'linkedin' => 'https://linkedin.com/in/jamesthompson',
            'github' => 'https://github.com/jamesthompson',
            'email' => 'james@company.com'
        ],
        'achievements' => ['Code Review Champion', 'Mentorship Award', 'Hackathon Winner'],
        'quote' => 'Code with passion, debug with patience.'
    ]
];

$departments = array_unique(array_column($teamMembers, 'department'));
?>

<section class="tusk-team-alt-1" id="tusk-team-alt-1">
    <div class="team-container">
        <!-- Header -->
        <div class="team-header">
            <h2 class="team-title">Meet Our Team</h2>
            <p class="team-subtitle">The brilliant minds behind our success</p>
        </div>

        <!-- Department Filter -->
        <div class="department-filter">
            <button class="dept-btn active" data-department="all">All Team</button>
            <?php foreach ($departments as $dept): ?>
                <button class="dept-btn" data-department="<?= strtolower($dept) ?>">
                    <?= htmlspecialchars($dept) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Team Grid -->
        <div class="team-grid">
            <?php foreach ($teamMembers as $index => $member): ?>
                <div class="team-card" data-department="<?= strtolower($member['department']) ?>" data-member="<?= $index ?>">
                    <!-- Card Front -->
                    <div class="card-front">
                        <div class="member-image-container">
                            <img src="<?= $member['image'] ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="member-image">
                            <div class="image-overlay">
                                <button class="view-profile-btn">View Profile</button>
                            </div>
                        </div>
                        <div class="member-info">
                            <h3 class="member-name"><?= htmlspecialchars($member['name']) ?></h3>
                            <p class="member-position"><?= htmlspecialchars($member['position']) ?></p>
                            <div class="member-meta">
                                <span class="department-badge"><?= htmlspecialchars($member['department']) ?></span>
                                <span class="experience-badge"><?= htmlspecialchars($member['experience']) ?></span>
                            </div>
                            <p class="member-bio"><?= htmlspecialchars(substr($member['bio'], 0, 120)) ?>...</p>
                            <div class="member-skills">
                                <?php foreach (array_slice($member['skills'], 0, 3) as $skill): ?>
                                    <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Social Links -->
                    <div class="social-links">
                        <?php foreach ($member['social'] as $platform => $link): ?>
                            <a href="<?= $link ?>" class="social-link <?= $platform ?>" target="_blank" rel="noopener">
                                <?php if ($platform === 'linkedin'): ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.447 20.452H16.893V14.883C16.893 13.555 16.866 11.846 15.041 11.846C13.188 11.846 12.905 13.291 12.905 14.785V20.452H9.351V9H12.765V10.561H12.811C13.288 9.661 14.448 8.711 16.181 8.711C19.782 8.711 20.447 11.081 20.447 14.166V20.452ZM5.337 7.433C4.193 7.433 3.274 6.507 3.274 5.368C3.274 4.23 4.194 3.305 5.337 3.305C6.477 3.305 7.401 4.23 7.401 5.368C7.401 6.507 6.476 7.433 5.337 7.433ZM7.119 20.452H3.555V9H7.119V20.452ZM22.225 0H1.771C0.792 0 0 0.774 0 1.729V22.271C0 23.227 0.792 24 1.771 24H22.222C23.2 24 24 23.227 24 22.271V1.729C24 0.774 23.2 0 22.225 0Z"/>
                                    </svg>
                                <?php elseif ($platform === 'twitter'): ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                <?php elseif ($platform === 'github'): ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0C5.374 0 0 5.373 0 12 0 17.302 3.438 21.8 8.207 23.387c.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                <?php elseif ($platform === 'dribbble'): ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 0C5.374 0 0 5.374 0 12s5.374 12 12 12 12-5.374 12-12S18.626 0 12 0zm7.568 5.302c1.4 1.5 2.252 3.5 2.252 5.7-.3-.1-3.3-.6-6.07-.3-.3-.8-.7-1.6-1.1-2.4 3.1-1.2 4.6-3.1 4.9-3zm-1.5-1.6c-.4.7-1.6 2.5-4.6 3.6-1.4-2.6-3-4.8-3.3-5.2 1.1-.3 2.3-.4 3.5-.4 1.7 0 3.3.4 4.8 1.1-.1-.1-.2-.1-.4-.1zm-6.4-.9c.3.4 1.9 2.6 3.3 5.1-4.2 1.1-7.9 1.1-8.3 1.1C7.1 6.2 8.7 4.2 11.6 2.8zM2.1 12c0-.1 0-.3 0-.4 0 0 .1 0 .1 0 .4 0 4.8 0 9.4-1.3.5 1 .9 2 1.3 3-1.2.3-2.3.8-3.4 1.4-1.2.7-2.2 1.5-3.1 2.4C3.8 16.2 2.1 14.2 2.1 12zm2.5 7.4c.7-.9 1.5-1.6 2.4-2.2 1-.6 2-1.1 3.1-1.4.8 2.1 1.3 4.2 1.5 5.2-1.2.5-2.5.8-3.9.8-1.1-.1-2.2-.4-3.1-.9v-.5zm6.9.8c-.2-.8-.6-2.7-1.3-4.7 2.6-.4 5.1 0 5.4.1-.4 1.8-1.6 3.3-3.2 4.3-.3.2-.6.3-.9.3z"/>
                                    </svg>
                                <?php else: ?>
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                                        <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <polyline points="22,6 12,13 2,6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Member Detail Modal -->
    <div class="member-modal" id="memberModal" style="display: none;">
        <div class="modal-backdrop"></div>
        <div class="modal-content">
            <button class="modal-close">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
            <div class="modal-body">
                <!-- Modal content will be populated by JavaScript -->
            </div>
        </div>
    </div>
</section>

<style>
.tusk-team-alt-1 {
    padding: 4rem 1rem;
    background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary, #f8fafc) 100%);
    min-height: 100vh;
}

.team-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
}

.team-header {
    text-align: center;
    margin-bottom: 3rem;
}

.team-title {
    font-size: 3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.team-subtitle {
    font-size: 1.2rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.department-filter {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 3rem;
    flex-wrap: wrap;
}

.dept-btn {
    padding: 0.75rem 1.5rem;
    border: 2px solid var(--border-color);
    background: var(--bg-primary);
    color: var(--text-primary);
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.dept-btn:hover {
    border-color: var(--primary-color);
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.dept-btn.active {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.team-card {
    background: var(--bg-primary);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.team-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    border-color: var(--primary-color);
}

.member-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.member-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.team-card:hover .member-image {
    transform: scale(1.1);
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--primary-color)80, var(--secondary-color)80);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.team-card:hover .image-overlay {
    opacity: 1;
}

.view-profile-btn {
    padding: 0.75rem 1.5rem;
    background: white;
    color: var(--primary-color);
    border: none;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    transform: translateY(20px);
}

.team-card:hover .view-profile-btn {
    transform: translateY(0);
}

.view-profile-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.member-info {
    padding: 2rem;
}

.member-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.member-position {
    font-size: 1.1rem;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

.member-meta {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.department-badge,
.experience-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.department-badge {
    background: var(--primary-color);
    color: white;
}

.experience-badge {
    background: var(--bg-secondary, #f8fafc);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.member-bio {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.member-skills {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.skill-tag {
    padding: 0.25rem 0.5rem;
    background: var(--bg-secondary, #f8fafc);
    color: var(--text-primary);
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    border: 1px solid var(--border-color);
}

.social-links {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transition: all 0.3s ease;
}

.team-card:hover .social-links {
    opacity: 1;
}

.social-link {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.social-link:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

.social-link.linkedin:hover {
    background: #0077b5;
}

.social-link.twitter:hover {
    background: #1da1f2;
}

.social-link.github:hover {
    background: #333;
}

.social-link.dribbble:hover {
    background: #ea4c89;
}

.member-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1000;
}

.modal-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(4px);
}

.modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    background: var(--bg-primary);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255,255,255,0.9);
    border: none;
    color: var(--text-primary);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
    z-index: 10;
}

.modal-close:hover {
    background: white;
    transform: scale(1.1);
}

.modal-body {
    padding: 2rem;
    overflow-y: auto;
    max-height: 80vh;
}

@media (max-width: 768px) {
    .team-title {
        font-size: 2rem;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .department-filter {
        justify-content: center;
    }
    
    .dept-btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    
    .modal-content {
        width: 95%;
        max-height: 95vh;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deptButtons = document.querySelectorAll('.dept-btn');
    const teamCards = document.querySelectorAll('.team-card');
    const viewProfileBtns = document.querySelectorAll('.view-profile-btn');
    const modal = document.getElementById('memberModal');
    const modalClose = modal.querySelector('.modal-close');
    const modalBackdrop = modal.querySelector('.modal-backdrop');
    const modalBody = modal.querySelector('.modal-body');
    
    // Team member data for modal
    const teamData = <?= json_encode($teamMembers) ?>;
    
    // Department filtering
    deptButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            deptButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            const selectedDept = this.dataset.department;
            
            teamCards.forEach(card => {
                if (selectedDept === 'all' || card.dataset.department === selectedDept) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // View profile functionality
    viewProfileBtns.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const card = this.closest('.team-card');
            const memberIndex = parseInt(card.dataset.member);
            const member = teamData[memberIndex];
            
            showMemberModal(member);
        });
    });
    
    function showMemberModal(member) {
        modalBody.innerHTML = `
            <div class="modal-member-profile">
                <div class="modal-header">
                    <img src="${member.image}" alt="${member.name}" class="modal-avatar">
                    <div class="modal-member-info">
                        <h2 class="modal-name">${member.name}</h2>
                        <p class="modal-position">${member.position}</p>
                        <div class="modal-meta">
                            <span class="modal-dept">${member.department}</span>
                            <span class="modal-location">${member.location}</span>
                        </div>
                    </div>
                </div>
                
                <div class="modal-quote">
                    <blockquote>"${member.quote}"</blockquote>
                </div>
                
                <div class="modal-bio">
                    <h3>About</h3>
                    <p>${member.bio}</p>
                </div>
                
                <div class="modal-details">
                    <div class="detail-section">
                        <h4>Experience</h4>
                        <p>${member.experience}</p>
                    </div>
                    
                    <div class="detail-section">
                        <h4>Languages</h4>
                        <p>${member.languages.join(', ')}</p>
                    </div>
                </div>
                
                <div class="modal-skills">
                    <h4>Core Skills</h4>
                    <div class="modal-skill-tags">
                        ${member.skills.map(skill => `<span class="modal-skill-tag">${skill}</span>`).join('')}
                    </div>
                </div>
                
                <div class="modal-achievements">
                    <h4>Achievements</h4>
                    <ul class="achievement-list">
                        ${member.achievements.map(achievement => `<li>${achievement}</li>`).join('')}
                    </ul>
                </div>
                
                <div class="modal-social">
                    <h4>Connect</h4>
                    <div class="modal-social-links">
                        ${Object.entries(member.social).map(([platform, link]) => `
                            <a href="${link}" class="modal-social-link ${platform}" target="_blank" rel="noopener">
                                ${platform.charAt(0).toUpperCase() + platform.slice(1)}
                            </a>
                        `).join('')}
                    </div>
                </div>
            </div>
        `;
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal() {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    modalClose.addEventListener('click', closeModal);
    modalBackdrop.addEventListener('click', closeModal);
    
    // Escape key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });
    
    // Entrance animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const cardObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                cardObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    teamCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        cardObserver.observe(card);
    });
});
</script>

<style>
/* Modal Styles */
.modal-member-profile {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.modal-header {
    display: flex;
    gap: 1.5rem;
    align-items: center;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--border-color);
}

.modal-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-color);
}

.modal-name {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.modal-position {
    font-size: 1.2rem;
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.modal-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.modal-dept,
.modal-location {
    padding: 0.25rem 0.75rem;
    background: var(--bg-secondary, #f8fafc);
    border-radius: 12px;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.modal-quote {
    background: var(--bg-secondary, #f8fafc);
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid var(--primary-color);
}

.modal-quote blockquote {
    font-style: italic;
    font-size: 1.1rem;
    color: var(--text-primary);
    margin: 0;
}

.modal-bio h3,
.modal-details h4,
.modal-skills h4,
.modal-achievements h4,
.modal-social h4 {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.modal-bio p {
    color: var(--text-secondary);
    line-height: 1.6;
}

.modal-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.detail-section {
    background: var(--bg-secondary, #f8fafc);
    padding: 1rem;
    border-radius: 8px;
}

.modal-skill-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.modal-skill-tag {
    padding: 0.5rem 1rem;
    background: var(--primary-color);
    color: white;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.achievement-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.achievement-list li {
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-light, #f1f5f9);
    position: relative;
    padding-left: 1.5rem;
}

.achievement-list li:before {
    content: "🏆";
    position: absolute;
    left: 0;
    top: 0.5rem;
}

.achievement-list li:last-child {
    border-bottom: none;
}

.modal-social-links {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.modal-social-link {
    padding: 0.5rem 1rem;
    background: var(--bg-secondary, #f8fafc);
    color: var(--text-primary);
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
}

.modal-social-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

@media (max-width: 600px) {
    .modal-header {
        flex-direction: column;
        text-align: center;
    }
    
    .modal-details {
        grid-template-columns: 1fr;
    }
}
</style>