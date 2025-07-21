<?php
/**
 * <?tusk> Enhanced Video Embed Component
 * Created: 2025-06-26
 * Strong. Secure. Scalable. 🐘
 *
 * <?tusk> video-embed Component
 * Auto-Inclusion: [tusk-component-video-embed]
 * Themes: default, dark, minimal, gradient, neon, corporate, warm, cool
 */

// Theme configuration
$theme = isset($theme) ? $theme : 'default';
$video_url = isset($video_url) ? $video_url : 'https://www.youtube.com/embed/dQw4w9WgXcQ';
$video_title = isset($video_title) ? $video_title : 'Featured Video';
$video_description = isset($video_description) ? $video_description : 'Watch our latest content and discover amazing insights.';
$autoplay = isset($autoplay) ? $autoplay : false;
$show_controls = isset($show_controls) ? $show_controls : true;
?>

<section class="tusk-video-embed tusk-video-embed--<?php echo $theme; ?>" role="region" aria-label="Video Content">
    <div class="video-container">
        <div class="video-header">
            <h2 class="video-title"><?php echo htmlspecialchars($video_title); ?></h2>
            <p class="video-description"><?php echo htmlspecialchars($video_description); ?></p>
        </div>
        
        <div class="video-wrapper" role="img" aria-label="Video player">
            <div class="video-aspect-ratio">
                <iframe 
                    src="<?php echo htmlspecialchars($video_url); ?>?autoplay=<?php echo $autoplay ? '1' : '0'; ?>&controls=<?php echo $show_controls ? '1' : '0'; ?>&rel=0&modestbranding=1"
                    title="<?php echo htmlspecialchars($video_title); ?>"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    loading="lazy">
                </iframe>
                <div class="video-loading" aria-hidden="true">
                    <div class="loading-spinner"></div>
                    <span>Loading video...</span>
                </div>
            </div>
        </div>
        
        <div class="video-actions">
            <button class="btn-fullscreen" aria-label="Toggle fullscreen">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"/>
                </svg>
                Fullscreen
            </button>
            <button class="btn-share" aria-label="Share video">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/>
                    <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                </svg>
                Share
            </button>
        </div>
    </div>
</section>

<!-- CSS styles moved to components/components.css -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const videoEmbeds = document.querySelectorAll('.tusk-video-embed');
    
    videoEmbeds.forEach(embed => {
        const fullscreenBtn = embed.querySelector('.btn-fullscreen');
        const shareBtn = embed.querySelector('.btn-share');
        const videoWrapper = embed.querySelector('.video-wrapper');
        const iframe = embed.querySelector('iframe');
        
        // Fullscreen functionality
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', () => {
                if (videoWrapper.requestFullscreen) {
                    videoWrapper.requestFullscreen();
                } else if (videoWrapper.webkitRequestFullscreen) {
                    videoWrapper.webkitRequestFullscreen();
                } else if (videoWrapper.msRequestFullscreen) {
                    videoWrapper.msRequestFullscreen();
                }
            });
        }
        
        // Share functionality
        if (shareBtn) {
            shareBtn.addEventListener('click', async () => {
                const shareData = {
                    title: embed.querySelector('.video-title')?.textContent || 'Check out this video',
                    text: embed.querySelector('.video-description')?.textContent || '',
                    url: window.location.href
                };
                
                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                    } catch (err) {
                        console.log('Error sharing:', err);
                    }
                } else {
                    // Fallback: copy URL to clipboard
                    navigator.clipboard.writeText(window.location.href).then(() => {
                        const originalText = shareBtn.textContent;
                        shareBtn.textContent = 'Copied!';
                        setTimeout(() => {
                            shareBtn.textContent = originalText;
                        }, 2000);
                    });
                }
            });
        }
        
        // Hide loading spinner when iframe loads
        if (iframe) {
            iframe.addEventListener('load', () => {
                const loading = embed.querySelector('.video-loading');
                if (loading) {
                    loading.style.display = 'none';
                }
            });
        }
    });
});
</script>