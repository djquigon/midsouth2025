(function () {
    fixedHeaderSpacing(); 
    toggleHeaderTransparentBackground();
})(); 
 

//Handles heading scroll sticky toggle & margin offset
function fixedHeaderSpacing() {
    //header - help give visibility:hidden on scroll down, but only after transition, and then remove on scroll up 
    //this class is removed in the scroll functions below
    document
        .getElementById('header')
        .addEventListener('transitionend', function () {
            this.classList.add('transition-done');
        });

    function headerSetMargin() {
        var header = document.getElementById('header');
        var primary_wrap = document.getElementById('main');
        var admin_bar_height = document.getElementById('wpadminbar')
            ? document.getElementById('wpadminbar').clientHeight
            : 0;

        primary_wrap.style.marginTop = header.clientHeight + 'px';
        document.documentElement.style.setProperty(
            '--header-height',
            header.clientHeight + 'px'
        );
        document.documentElement.style.setProperty(
            '--header-height-with-adminbar',
            header.clientHeight + admin_bar_height + 'px'
        );
        header.style.position = 'fixed';
    }

    window.addEventListener('resize', headerSetMargin);
    window.addEventListener('load', headerSetMargin);

    var scrollTopVal = $(window).scrollTop();

    function scrollAddClass() {
        // classes used to hide/display the navigation
        // hide when scrolling down, show when scrolling up
        // keep showing when overlay is active (determined in css)
        // throttled so it will wait 33ms between each check
        if ($(window).scrollTop() > 100) {
            var scrollTopNow = $(window).scrollTop();

            if (scrollTopNow > scrollTopVal) {
                // scrolling down
                $(document.body).addClass('scrolling-down');
                $(document.body).removeClass('scrolling-up');
            } else if (scrollTopNow < scrollTopVal) {
                document
                    .getElementById('header')
                    .classList.remove('transition-done');
                // scrolling up
                document
                    .getElementById('header')
                    .classList.remove('transition-done'); 
                $(document.body).addClass('scrolling-up');
                $(document.body).removeClass('scrolling-down');
            }

            scrollTopVal = scrollTopNow;
        } else {
            $(document.body).addClass('scrolling-up');
            $(document.body).removeClass('scrolling-down');
        }

        //add a distinct class for when you've scrolled back up to the very top of the page
        if ($(window).scrollTop() === 0) {
            $(document.body).addClass('scrollpoint-zero');
        } else {
            $(document.body).removeClass('scrollpoint-zero');
        }
    }
    $(window).on('scroll', $.throttle(33, scrollAddClass));
} 

//At times, a site's homepage design will feature a version of the header that has a transparent background, but only when your scroll position is at or near the top of the page. This is typically because the top of the homepage will feature a background image or video. Once you've scrolled past this module, you need to toggle a class on the <header> that will allow you to add a background-color for UX, because scrolling in the 'up' direction will display the header. 
function toggleHeaderTransparentBackground() {  
    //only proceed if we're on the homepage
    if (document.body.classList.contains('home')) {
        const header = document.getElementById('header');

        window.addEventListener('scroll', function () {
            //for each scroll, calculate two things:
            
            //the distance the user has scrolled from the top of the page:
            var scroll_distance = document.documentElement.scrollTop;

            //the distance from the bottom of the page's first 'module'. Typically this is the aforementioned homepage 'header' or 'hero' section
            var first_module_on_page = document.querySelector('body > main > article').firstElementChild;
            //console.log(first_module_on_page);
            var threshold = first_module_on_page.offsetHeight;  

            if (scroll_distance > threshold) {
                header.classList.add('background-active');
            } else {
                header.classList.remove('background-active');
            }
        });
    }
}