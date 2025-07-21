<?php
/**
 * about.php
 * Enhanced about section with team profiles, company stats, and interactive elements
 */
?>

<section class="tusk-hero-about" id="about">
    <div class="hero-container">
        <h2>🐘 About TuskPHP</h2>
        <p>Discover the story behind the framework that's revolutionizing web development</p>
        
        <div class="about-content">
            <div class="about-text">
                <h3>🌟 Our Mission</h3>
                <p>At TuskPHP, we believe that web development should be <strong>powerful</strong>, <strong>secure</strong>, and <strong>enjoyable</strong>. Our mission is to provide developers with the tools they need to build amazing applications without the complexity.</p>
                
                <p>Founded by a team of passionate developers who were frustrated with the limitations of existing frameworks, TuskPHP was born from the desire to create something better - something that combines the robustness of enterprise solutions with the simplicity that developers love.</p>
                
                <h3>💡 Our Vision</h3>
                <p>We envision a future where developers can focus on creating innovative solutions rather than wrestling with complicated frameworks. TuskPHP is designed to get out of your way and let you build what matters.</p>
                
                <div class="about-stats">
                    <div class="stat-card">
                        <span class="stat-number" data-target="15000">0</span>
                        <span class="stat-label">Developers</span>
                    </div>
                    
                    <div class="stat-card">
                        <span class="stat-number" data-target="500">0</span>
                        <span class="stat-label">Projects Built</span>
                    </div>
                    
                    <div class="stat-card">
                        <span class="stat-number" data-target="99.9">0</span>
                        <span class="stat-label">% Uptime</span>
                    </div>
                    
                    <div class="stat-card">
                        <span class="stat-number" data-target="24">0</span>
                        <span class="stat-label">/7 Support</span>
                    </div>
                </div>
            </div>
            
            <div class="about-image">
                🐘
            </div>
        </div>
    </div>
</section>

<section class="team-section" id="team">
    <div class="hero-container">
        <h2>👥 Meet Our Team</h2>
        <p>The brilliant minds behind TuskPHP's success</p>
        
        <div class="team-grid">
            <div class="team-member" data-member="sarah">
                <div class="member-avatar">👩‍💼</div>
                <h3 class="member-name">Sarah Johnson</h3>
                <p class="member-role">Founder & CEO</p>
                <p class="member-bio">Visionary leader with 15+ years in web development. Former senior architect at major tech companies.</p>
                <div class="member-social">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">💼</a>
                    <a href="#" class="social-link">🐦</a>
                </div>
            </div>
            
            <div class="team-member" data-member="mike">
                <div class="member-avatar">👨‍💻</div>
                <h3 class="member-name">Mike Chen</h3>
                <p class="member-role">CTO & Lead Developer</p>
                <p class="member-bio">Security expert and performance optimization specialist. PhD in Computer Science from MIT.</p>
                <div class="member-social">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">💼</a>
                    <a href="#" class="social-link">🐙</a>
                </div>
            </div>
            
            <div class="team-member" data-member="alex">
                <div class="member-avatar">👨‍🎨</div>
                <h3 class="member-name">Alex Rodriguez</h3>
                <p class="member-role">Head of Design</p>
                <p class="member-bio">UX/UI designer passionate about creating intuitive developer experiences and beautiful interfaces.</p>
                <div class="member-social">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">🎨</a>
                    <a href="#" class="social-link">📱</a>
                </div>
            </div>
            
            <div class="team-member" data-member="lisa">
                <div class="member-avatar">👩‍🔬</div>
                <h3 class="member-name">Lisa Wang</h3>
                <p class="member-role">Head of Community</p>
                <p class="member-bio">Developer advocate who loves connecting with the community and helping developers succeed.</p>
                <div class="member-social">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">🎤</a>
                    <a href="#" class="social-link">📝</a>
                </div>
            </div>
            
            <div class="team-member" data-member="david">
                <div class="member-avatar">👨‍🔧</div>
                <h3 class="member-name">David Kim</h3>
                <p class="member-role">DevOps Engineer</p>
                <p class="member-bio">Infrastructure specialist ensuring TuskPHP runs smoothly and scales efficiently worldwide.</p>
                <div class="member-social">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">⚙️</a>
                    <a href="#" class="social-link">☁️</a>
                </div>
            </div>
            
            <div class="team-member" data-member="emma">
                <div class="member-avatar">👩‍📊</div>
                <h3 class="member-name">Emma Thompson</h3>
                <p class="member-role">Marketing Director</p>
                <p class="member-bio">Growth marketing expert focused on helping developers discover and love TuskPHP.</p>
                <div class="member-social">
                    <a href="#" class="social-link">📧</a>
                    <a href="#" class="social-link">📈</a>
                    <a href="#" class="social-link">🎯</a>
                </div>
            </div>
        </div>
        
        <div class="join-team">
            <h3>🚀 Want to Join Our Team?</h3>
            <p>We're always looking for talented individuals who share our passion for great developer tools.</p>
            <div class="career-buttons">
                <button class="btn btn-primary" onclick="showCareers()">View Open Positions</button>
                <button class="btn btn-secondary" onclick="showInternships()">Internship Program</button>
            </div>
        </div>
    </div>
</section>

<section class="company-values" id="values">
    <div class="hero-container">
        <h2>💎 Our Values</h2>
        <p>The principles that guide everything we do</p>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🎯</div>
                <h3>Developer-First</h3>
                <p>Every decision we make is driven by what's best for developers and their experience.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h3>Security by Design</h3>
                <p>Security isn't an afterthought - it's built into the foundation of everything we create.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">🌍</div>
                <h3>Open & Inclusive</h3>
                <p>We believe in open source, diversity, and creating technology that works for everyone.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">⚡</div>
                <h3>Performance Focused</h3>
                <p>Speed and efficiency aren't luxuries - they're necessities in modern web development.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Community Driven</h3>
                <p>Our community shapes our roadmap, and we're committed to supporting developer success.</p>
            </div>
            
            <div class="value-card">
                <div class="value-icon">🔬</div>
                <h3>Innovation</h3>
                <p>We're constantly pushing boundaries and exploring new ways to improve web development.</p>
            </div>
        </div>
    </div>
</section>

<script>
// Animate counters when they come into view
function animateAboutCounters() {
    const counters = document.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const increment = target / 100;
        let current = 0;
        
        const updateCounter = () => {
            if (current < target) {
                current += increment;
                if (target === 99.9) {
                    counter.textContent = current.toFixed(1);
                } else {
                    counter.textContent = Math.ceil(current);
                }
                setTimeout(updateCounter, 20);
            } else {
                if (target === 99.9) {
                    counter.textContent = target.toFixed(1);
                } else {
                    counter.textContent = target;
                }
            }
        };
        
        updateCounter();
    });
}

// Team member interactions
document.querySelectorAll('.team-member').forEach(member => {
    member.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
    });
    
    member.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
    
    member.addEventListener('click', function() {
        const memberName = this.getAttribute('data-member');
        showMemberDetails(memberName);
    });
});

function showMemberDetails(memberName) {
    const memberData = {
        sarah: {
            name: "Sarah Johnson",
            role: "Founder & CEO",
            bio: "Sarah founded TuskPHP with a vision to simplify web development without sacrificing power. With over 15 years of experience in software architecture and team leadership, she previously worked as a senior architect at Google and Microsoft. Sarah holds an MS in Computer Science from Stanford and is passionate about developer tools, open source, and building inclusive tech communities.",
            achievements: [
                "Founded 3 successful tech startups",
                "Keynote speaker at 20+ international conferences",
                "Contributor to 15+ open source projects",
                "Awarded 'Developer Tool Innovator of the Year' 2023"
            ]
        },
        mike: {
            name: "Mike Chen",
            role: "CTO & Lead Developer",
            bio: "Mike leads the technical vision and development of TuskPHP. He's a security expert with a PhD in Computer Science from MIT, specializing in web application security and performance optimization. Before TuskPHP, Mike worked at the NSA's cybersecurity division and later at Facebook's security team.",
            achievements: [
                "PhD in Computer Science from MIT",
                "Former NSA cybersecurity specialist",
                "Published 50+ research papers on web security",
                "Discovered 12 critical CVEs in major frameworks"
            ]
        }
        // Add more member data as needed
    };
    
    const member = memberData[memberName];
    if (member) {
        alert(`${member.name}\n${member.role}\n\n${member.bio}\n\nKey Achievements:\n${member.achievements.join('\n')}`);
    }
}

function showCareers() {
    alert(`🚀 Current Open Positions:

Senior PHP Developer
Frontend React Developer  
DevOps Engineer
Technical Writer
Community Manager

All positions offer:
✅ Competitive salary + equity
✅ Remote-first culture
✅ Health, dental, vision insurance
✅ Unlimited PTO
✅ $5,000 learning budget
✅ Latest equipment provided

Email: careers@tuskphp.com`);
}

function showInternships() {
    alert(`📚 TuskPHP Internship Program:

Summer 2024 Internships Available:
• Software Engineering (Remote)
• UX/UI Design (Remote) 
• Developer Relations (Hybrid)
• Technical Writing (Remote)

Program Benefits:
✅ 12-week paid internship
✅ Mentorship from senior engineers
✅ Real project contributions
✅ Full-time offer potential
✅ Learning & development budget

Apply: internships@tuskphp.com`);
}

// Intersection observer for animations
const aboutObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            if (entry.target.id === 'about') {
                animateAboutCounters();
            }
            entry.target.classList.add('animate-in');
        }
    });
}, { threshold: 0.3 });

// Observe sections for animations
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('#about, #team, #values');
    sections.forEach(section => {
        aboutObserver.observe(section);
    });
    
    // Add hover effects to value cards
    document.querySelectorAll('.value-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.boxShadow = '0 10px 30px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
        });
    });
});
</script>