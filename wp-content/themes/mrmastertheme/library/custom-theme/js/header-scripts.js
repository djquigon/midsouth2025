(function ($) { 
    'use strict';
    //var $document = $(document); 
    //var $window = $(window); 

    //On Load 
    //$window.on('load', function() {
    //}); 

    //On Ready
    $(document).ready(function () {
        // Magnific - For Video Only
        $('.popup-video').magnificPopup({
            disableOn: 480, 
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false,
            iframe: {
                patterns: {
                    youtube: {
                        src: '//www.youtube.com/embed/%id%?autoplay=1&modestbranding=1',
                    },
                },
            },
        });

        // Magnific - Images & Galleries
        var groups = {};

        $("a[rel^='magnificMe']").each(function () {
            var id = parseInt($(this).attr('data-group'), 10);

            if (!groups[id]) {
                groups[id] = [];
            }

            groups[id].push(this);
        });

        $.each(groups, function () {
            $(this).magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                closeBtnInside: false,
                gallery: { enabled: true },

                image: {
                    verticalFit: true,
                    titleSrc: function (item) {
                        return (
                            '<a class="image-source-link" href="' +
                            item.src +
                            '" target="_blank">view file</a>'
                        );
                    },
                },
                iframe: {
                    patterns: {
                        youtube: {
                            src: '//www.youtube.com/embed/%id%?autoplay=1&amp;rel=0',
                        },
                    },
                },
            });
        });

        
        //Responsive wrap for Wordpress aligned images
        /*
        $('img.alignleft').each(function () {
            var $this = $(this);

            if ($this.parent('a').length > 0) {
                $this
                    .parent('a')
                    .wrap('<span class="mobile-center-image"></span>');
            } else {
                $this.wrap('<span class="mobile-center-image"></span>');
            }
        });

        $('img.alignright').each(function () {
            var $this = $(this);

            if ($this.parent('a').length > 0) {
                $this
                    .parent('a')
                    .wrap('<span class="mobile-center-image"></span>');
            } else {
                $this.wrap('<span class="mobile-center-image"></span>');
            }
        });
        */

        
        //Smooth in page scrolling
        $("a[href*='#']:not([href='#'])").on('click', function () {
            if (
                location.pathname.replace(/^\//, '') ===
                    this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname
            ) {
                var target = $(this.hash);
                target = target.length
                    ? target
                    : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    // Scroll
                    $('html,body').animate(
                        {
                            scrollTop: target.offset().top - 100,
                        },
                        1000,
                        function () {
                            // Focus and guarantee focus
                            var $target = $(target);
                            $target.focus();
                            if ($target.is(':focus')) {
                                return false;
                            } else {
                                $target.attr('tabindex', '-1');
                                $target.focus();
                            }
                            // click if a toggle
                            if (
                                $target.is('a.trigger') &&
                                !$target.hasClass('active')
                            ) {
                                $target.click();
                            }
                        }
                    );
                    return false;
                }
            }
        });

        //Load specific tab depending upon the hash in URL
        function hashLoad() {
            // Keep page at top until after load
            $(document).scrollTop(0);

            // Get hash from URL, removing # (compatibility)
            var hashTarget = location.hash.replace('#', '');

            // Find hash id on page (using .find to guarantee we're just searching existing nodes), adding # back for search
            hashTarget = $('body').find('#' + hashTarget);

            $('html,body').animate(
                {
                    scrollTop: hashTarget.offset().top - 100,
                },
                1000,
                function () {
                    // Focus and guarantee focus
                    var $target = $(hashTarget);
                    $target.focus();
                    if ($target.is(':focus')) {
                        //return false;
                    } else {
                        $target.attr('tabindex', '-1');
                        $target.focus();
                    }
                    // click if a toggle
                    if (
                        $target.is('a.trigger') &&
                        !$target.hasClass('active')
                    ) {
                        $target.click();
                    }
                }
            );

            return false;
        }

        // Only load if there is a hash in URL
        if (location.hash !== '') {
            $(window).on('load', hashLoad);
        } 



        //Random accessibility fixes:
        //add (opens in new window) screenreader only text
        $('a[target="_blank"]').append(
            '<span class="visually-hidden">This link opens in a new tab</span>'
        );

        //add aria-label to all woocommerce pagination
        //$('.woocommerce-pagination').attr('aria-label','sequential page links of products in this category');

        //add aria-label to all woocommerce required fields
        //$('abbr[title="required"]').attr('aria-label','this is a required form field');
    });
})(jQuery);

function importGoogleMapsLibrary() {
    const { Map } = google.maps.importLibrary("maps");
}
 