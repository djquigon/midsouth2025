// Load Vimeo player script
/*
const vimeoScript = document.createElement('script');
vimeoScript.src = 'https://player.vimeo.com/api/player.js';
document.head.appendChild(vimeoScript);

// Load YouTube IFrame API
const tag = document.createElement('script');
tag.src = 'https://www.youtube.com/iframe_api';
const firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

let youtubePlayer;

function onYouTubeIframeAPIReady() {
    const vimeoElement = document.getElementById('vimeo-video');
    const youtubeElement = document.getElementById('youtube-video');

    // Only initialize YouTube if Vimeo is not present
    if (!vimeoElement && youtubeElement) {
        const youtubeUrl = youtubeElement.dataset.videoUrl;
        const videoId = extractYouTubeId(youtubeUrl);

        youtubePlayer = new YT.Player('youtube-video', {
            videoId: videoId,
            playerVars: {
                autoplay: 1,
                controls: 0, // Hide main controls
                mute: 1,
                loop: 1,
                playlist: videoId,
                playsinline: 1,
                rel: 0, // No related videos at end
                modestbranding: 1, // Smaller YouTube logo
                fs: 0, // Disable fullscreen button
                iv_load_policy: 3, // Hide annotations
                disablekb: 1, // Disable keyboard
                enablejsapi: 1,
                origin: window.location.origin,
            },
            events: {
                onReady: onPlayerReady,
            },
        });
    }
}

function onPlayerReady(event) {
    event.target.playVideo();
}

function extractYouTubeId(url) {
    const regExp =
        /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;

    /*
    const match = url.match(regExp);
    return match && match[2].length === 11 ? match[2] : null;
}

function initializeSlider() {
    if (document.getElementById('hero-slider-wrapper')) {
        const sliderWrapper = document.getElementById('hero-slider-wrapper');
        const arrowsRow = sliderWrapper.querySelector('.arrows-row');
        const appendArrowsId = arrowsRow ? '#' + arrowsRow.id : null;
        const dotsRow = sliderWrapper.querySelector('.dots-row');
        const appendDotsId = dotsRow ? '#' + dotsRow.id : null;
    
        jQuery(sliderWrapper).slick({
            arrows: true,
            autoplay: true,
            dots: true,
            rows: 0,
            infinite: true,
            slide: '.hero-slide',
            appendArrows: appendArrowsId,
            appendDots: appendDotsId,
        });
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Handle Vimeo video
    const vimeoElement = document.getElementById('vimeo-video');
    if (vimeoElement) {
        const vimeoUrl = vimeoElement.dataset.videoUrl;
        const vimeoPlayer = new Vimeo.Player('vimeo-video', {
            url: vimeoUrl,
            width: 1920,
            controls: false,
            muted: true,
            autoplay: true,
            loop: true,
            quality: '720p',
        });
    }

    // Initialize slider if present
    initializeSlider();
});
*/
