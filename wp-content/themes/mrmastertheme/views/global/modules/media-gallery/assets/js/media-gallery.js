(function () {
    initializeCarouselThumbnailButtons();
    initializeMasonryThumbnailButtons();
    initializeModalExitControls();
    intializeMasonrySlideHeight();
    reinitializeCarouselThumbnailButtons();
})(); 

function initializeCarouselThumbnailButtons() {
    //check for the existence of slide thumbnails:
    if (document.getElementsByClassName('carousel-slide-thumbnail').length > 0) {
        //select the thumbnail button elements:
        const slide_thumbnails = document.getElementsByClassName('carousel-slide-thumbnail'); 

        //loop through the slide thumbnails:
        for (let i = 0; i < slide_thumbnails.length; i++) {

            //grab the main slider element that we'll be controlling with the thumbnails:
            const main_slider_id = slide_thumbnails[i].getAttribute('data-main-slider-ID'); 

            //grab the slide count from the thumbnail button:
            const slide_count = slide_thumbnails[i].getAttribute('data-slide-count');

            //now we're ready to add a click event to each slide thumbnail <button>
            slide_thumbnails[i].addEventListener('click', function() {
                //call the slick.js function that will change the main slide
                $('#'+main_slider_id).slick('slickGoTo', slide_count);
            }); 
        }
    }
}

function initializeMasonryThumbnailButtons() {
    //check for the existence of masonry thumbnails:
    if (document.getElementsByClassName('masonry-slide-thumbnail').length > 0) {
        //select the thumbnail button elements:
        const masonry_thumbnails = document.getElementsByClassName('masonry-slide-thumbnail'); 

        //grab the <main> for a later
        const main_element = document.getElementById('main');

        //loop through the slide thumbnails:
        for (let i = 0; i < masonry_thumbnails.length; i++) {

            //grab the modal element that we'll be toggling to open:
            const modal_id = masonry_thumbnails[i].getAttribute('data-modal-ID'); 
            const modal_element = document.getElementById(modal_id);

            //grab the parent module element so we can manipulate it's z-index:
            const parent_module_element = masonry_thumbnails[i].closest('.media-gallery');

            //grab the modal slider element that we'll be controlling with the thumbnails:
            const slider_id = masonry_thumbnails[i].getAttribute('data-slider-ID'); 

            //grab the slide count from the thumbnail button:
            const slide_count = masonry_thumbnails[i].getAttribute('data-slide-count');

            //now we're ready to add a click event to each thumbnail <button>
            masonry_thumbnails[i].addEventListener('click', function() {
                //toggle the <main>'s data attribute that positions it's z-index higher than the <header> menu
                if (main_element.getAttribute('data-modal-lightbox') === 'false' || !main_element.getAttribute('data-modal-lightbox')) {
                    main_element.setAttribute('data-modal-lightbox', 'true');
                }  

                //toggle the parent module element's data attribute that positions it's z-index higher than the sibling module elements
                if (parent_module_element.getAttribute('data-modal-open') === 'false' || !parent_module_element.getAttribute('data-modal-open')) {
                    parent_module_element.setAttribute('data-modal-open', 'true');
                }

                //'open' the modal element
                if (modal_element.getAttribute('aria-hidden') === 'true') {
                    modal_element.setAttribute('aria-hidden', 'false');
                }  

                //call the slick.js function that will change the main slide
                $('#'+slider_id).slick('slickGoTo', slide_count);
            }); 
        }
    }
}

function initializeModalExitControls() {
    //check for the existence of modal close buttons, which indicates we're using a media gallery module w/ masonry layout:
    if (document.getElementsByClassName('modal-close').length > 0) {
        //select the modal close button elements:
        const modal_close_buttons = document.getElementsByClassName('modal-close');

        //grab the <main> for a later
        const main_element = document.getElementById('main');      

        //we also want to make sure to stop any video playback in the media gallery:
        const youtube_iframes = document.getElementsByClassName('youtube-iframe');
        const vimeo_iframes = document.getElementsByClassName('vimeo-iframe');

        //loop through the modal_close_buttons:
        for (let i = 0; i < modal_close_buttons.length; i++) {

            //grab the modal element that we'll be toggling to open:
            const modal_id = modal_close_buttons[i].getAttribute('data-modal-ID'); 
            const modal_element = document.getElementById(modal_id);

            //grab the parent module element so we can manipulate it's z-index:
            const parent_module_element = modal_close_buttons[i].closest('.media-gallery');

            //now we're ready to add a click event to each modal close <button>
            modal_close_buttons[i].addEventListener('click', function() {
                //toggle the <main>'s data attribute that positions it's z-index higher than the <header> menu
                if (main_element.getAttribute('data-modal-lightbox') === 'true') {
                    main_element.setAttribute('data-modal-lightbox', 'false');
                }  

                //toggle the parent module element's data attribute that positions it's z-index higher than the sibling module elements
                if (parent_module_element.getAttribute('data-modal-open') === 'true') {
                    parent_module_element.setAttribute('data-modal-open', 'false');
                }

                //'close' the modal element
                if (modal_element.getAttribute('aria-hidden') === 'false') {
                    modal_element.setAttribute('aria-hidden', 'true');
                } 

                //loop through the video iframe elements, & use their respective JS APIs to force a pause/stop:
                for (let i2 = 0; i2 < youtube_iframes.length; i2++) {
                    youtube_iframes[i2].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                }    

                for (let i3 = 0; i3 < vimeo_iframes.length; i3++) {
                    var player = new Vimeo.Player(vimeo_iframes[i3]);
                    player.pause();
                } 
            }); 
        }

        //we also want to enable the user to use the ESC key to close the modal lightbox:
        document.addEventListener('keydown', function(event) {  
            if (event.keyCode === 27) {
                //toggle the <main>'s data attribute that positions it's z-index higher than the <header> menu
                if (main_element.getAttribute('data-modal-lightbox') === 'true') {
                    main_element.setAttribute('data-modal-lightbox', 'false');
                } 

                //just grab all the media galleries on page:                
                const media_gallery_parent_modules = document.getElementsByClassName('media-gallery');
 
                //loop through them all: 
                for (let i = 0; i < media_gallery_parent_modules.length; i++) {

                    //toggle them closed:
                    if (media_gallery_parent_modules[i].getAttribute('data-modal-open') === 'true') {
                        media_gallery_parent_modules[i].getAttribute('data-modal-open', 'false');
                    }

                    //also 'close' the gallery element itself to prevent it from being picked up by screenreaders:
                    const modal_gallery_element = media_gallery_parent_modules[i].getElementsByClassName('modal-gallery');

                    for (let i2 = 0; i2 < modal_gallery_element.length; i2++) {
                        if (modal_gallery_element[i2].getAttribute('aria-hidden') === 'false') {
                            modal_gallery_element[i2].setAttribute('aria-hidden', 'true');
                        } 
                    }
                } 

                //loop through the video iframe elements, & use their respective JS APIs to force a pause/stop:
                for (let i3 = 0; i3 < youtube_iframes.length; i3++) {
                    youtube_iframes[i3].contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                } 

                for (let i4 = 0; i4 < vimeo_iframes.length; i4++) {
                    var player = new Vimeo.Player(vimeo_iframes[i4]);
                    player.pause();
                } 

                console.log('recompile');
            }
        });
    } 
}

function intializeMasonrySlideHeight() {

    function calculateMasonrySlideHeight() {
        //only proceed if masonry layout is chosen & slides exist
        if (document.getElementsByClassName('masonry-slide').length > 0) { 
            const masonry_slides = document.getElementsByClassName('masonry-slide'); 

            //we set the height of the modal media gallery slider to max out at 80% of the viewport height, so we want the slides to match:
            var slide_height = window.innerHeight * .8;

            //we'll apply the height as a CSS variable to the parent element, which will allow all the slides to inherit it:
            masonry_slides[0].closest('.slick-track').style.setProperty('height',slide_height + 'px');
        } 
    }

    //call the function so that it (re)calculates on resize & (re)load
    window.addEventListener('resize', calculateMasonrySlideHeight);
    window.addEventListener('load', calculateMasonrySlideHeight);
}

function reinitializeCarouselThumbnailButtons() {
    //check for the existence of slide thumbnails:
    if (document.getElementsByClassName('carousel-slide-thumbnail').length > 0) {
        const slide_thumbnails = document.getElementsByClassName('carousel-slide-thumbnail'); 
        const thumbnail_slider = slide_thumbnails[0].closest('div[id*="slider-thumbnails"]');

        window.addEventListener('resize', function(){
            if(window.innerWidth > 768  ) {
                //the .not('.slick-initialized') is necessary to prevent a very niche javascript console error ¯\_(ツ)_/¯ : 
                $(thumbnail_slider).not('.slick-initialized').slick({
                    //accessibility: true,
                    arrows: false,
                    dots: false,
                    autoplay: true,
                    autoplaySpeed: 7000,
                    asNavFor: thumbnail_slider.getAttribute('data-as-nav-for'),
                    fade: false,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: "unslick"
                        },
                    ], 
                    rows: 0, 
                    slide: '.thumbnail-slide',
                    slidesToScroll: 1,
                    slidesToShow: 5, 
                });
            }
        });
    }
}