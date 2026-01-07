<?php
    //first we set up the arguments passed from the testimonial module's main php file:
    $module_title = $args['module_title'];
    $intro_content = $args['intro_content'];
    
    $testimonials = $args['testimonials'];
    
    $text_color_attribute = $args['text_color_attribute']; 
    
    $all_testimonials_button = $args['all_testimonials_button'];
    $all_testimonials_button_text = $all_testimonials_button['button_text'];
    $all_testimonials_button_link = $all_testimonials_button['button_link'];

    //initialize a random number that we'll use to ensure unique IDs get plugged into the slick slider script. This is just in case we're using multiple sliders on a page
    $random_integer = rand(0,999);

    if ($module_title || ($all_testimonials_button_text && $all_testimonials_button_link)) :
?>
        <div class="title-all-button-row">
            <div class="container"<?= $text_color_attribute ?>>
                <?php
                    if ($module_title) :
                ?>
                        <h2 class="title"><?= $module_title ?></h2>
                <?php
                    endif;

                    if ($all_testimonials_button_text && $all_testimonials_button_link) :
                ?>
                        <a href="<?= $all_testimonials_button_link ?>" class="button" data-mobile-hide="true"><?= $all_testimonials_button_text ?></a>
                <?php
                    endif;
                ?>
                <span 
                    class="container-settings" 
                    data-flex="flex" 
                    data-justify-content="space-between" 
                    data-align-items="center"
                    data-container-width="standard"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;

    if ($intro_content) :
?>
        <div class="intro-content-row">
            <div class="container"<?= $text_color_attribute ?>>
                <?= $intro_content ?>
                <span 
                    class="container-settings" 
                    data-container-width="standard"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif; 
?>
        <div id="testimonial-slider-<?= $random_integer ?>" class="testimonial-slider-row">
            <?php
                foreach ($testimonials as $testimonial) : 
                    $testimonial_content = $testimonial['testimonial'];
                    $testimonial_author_name = $testimonial['author_name'];
                    $testimonial_author_title = $testimonial['author_title'];
            ?>
                    <div class="testimonial-slide"<?= $text_color_attribute ?>>
                        <div class="container">
                            <div class="content">
                                <?= $testimonial_content ?>
                            </div>
                            <div class="author">
                                <span class="name"><?= $testimonial_author_name ?></span>
                                <?php
                                    if ($testimonial_author_title) :
                                ?>
                                        <span class="title"><?= $testimonial_author_title ?></span>
                                <?php
                                    endif;
                                ?>
                            </div>
                            <span 
                                class="container-settings"
                                data-container-width="standard"
                            >
                                <span class="validator-text" data-nosnippet>settings</span>
                            </span>
                        </div>
                    </div>
            <?php
                endforeach;
            ?>
            <div id="append-arrows-<?= $random_integer ?>" class="container arrows-row">
                <span 
                    class="container-settings"
                    data-container-width="standard"
                    data-arrows-position="edges"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div> 
        </div>
        <div id="append-dots-<?= $random_integer ?>" class="container dots-row">
            <span 
                class="container-settings" 
                data-container-width="standard"
                data-dots-position="center"
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <?php
            if ($all_testimonials_button_text && $all_testimonials_button_link) :
        ?>
            <div class="all-button-row" data-desktop-hide="true">
                <div class="container">
                    <a 
                        href="<?= $all_testimonials_button_link ?>" 
                        class="button" 
                        aria-label="View All Testimonials"
                    >
                        <?= $all_testimonials_button_text ?>
                    </a> 
                    <span 
                        class="container-settings" 
                        data-container-width="standard"
                    >
                        <span class="validator-text" data-nosnippet>settings</span>
                    </span>
                </div>
            </div>
        <?php
            endif;
        ?>
        <span class="slider-settings">
            <script>  
                jQuery('#testimonial-slider-<?= $random_integer ?>').slick({
                    //accessibility: true,
                    //adaptiveHeight: false,
                    appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                    appendDots: $('#append-dots-<?= $random_integer ?>'),
                    arrows: true,
                    //asNavFor: $(element)
                    //autoplay: true,
                    autoplay: 5000,
                    //centerMode: false,
                    //centerPadding: '50px',
                    //cssEase: 'ease',
                    //customPaging: function(slider, i) {
                    //    return '<button type="button" data-role="none">' + (i + 1) + '</button>';
                    //},
                    dots: true,
                    //dotsClass: 'slick-dots',
                    //draggable: true,
                    //easing: 'linear',
                    //edgeFriction: 0.15,
                    //fade: false,
                    //focusOnSelect: false,
                    //focusOnChange: false,
                    //infinite: true,
                    //initialSlide: 0,
                    //lazyLoad: 'ondemand',
                    //mobileFirst: false,
                    //nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next">Next</button>',
                    //pauseOnDotsHover: false,
                    //pauseOnFocus: true,
                    //pauseOnHover: true,
                    //prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous">Previous</button>',
                    //respondTo: 'window',
                    //responsive: [
                    //	{
                    //	  breakpoint: 1024,
                    //	  settings: {
                    //		slidesToShow: 1,
                    //	  }
                    //	}
                    //], 
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                    rows: 0, //Setting this to 1 adds more divs that will require style changes, and setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.
                    //rtl: false,
                    slide: '.testimonial-slide',
                    //slidesPerRow: 1,
                    slidesToScroll: 1,
                    slidesToShow: 1,
                    //speed: 300,
                    //swipe: true,
                    //swipeToSlide: false,
                    //touchMove: true,
                    //touchThreshold: 5,
                    //useCSS: true,
                    //useTransform: true,
                    //variableWidth: false,
                    //vertical: false,
                    //verticalSwiping: false,
                    //waitForAnimate: true
                    //zIndex: 1000
                }); 
            </script>
            <span class="validator-text" data-nosnippet>settings</span>
        </span>