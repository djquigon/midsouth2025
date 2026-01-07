<?php
    $media_gallery = $args['media_gallery'];

    //Set the sizing of the images for the slider. Image sizes are registered in this file: \library\custom-theme\php\initialization.php
    $slider_main_image_size_name = 'slider-main';
    $slider_main_image_size_array = wp_get_registered_image_subsizes()[$slider_main_image_size_name];

    $slider_thumbnails_image_size_name = 'slider-thumbnails';
    $slider_thumbnails_image_size_array = wp_get_registered_image_subsizes()[$slider_thumbnails_image_size_name];

    //This seems like a roundabout way to get the main slider image height, but due to how we're passing around template arguments, this works better in the long-run. For convenience, this will allow a simple change of the main image size name referenced above when necessary. Our goal here is to force a consistent height on all slides
    $slider_main_height = $slider_main_image_size_array['height'];
    $slider_thumbnails_height = $slider_thumbnails_image_size_array['height'];

    //we use a random integer to prevent duplicate IDs, in the case of any other slider instances on the same page:
    $random_integer = rand(0, 999);
?>
<div class="slider-main-row container">
    <div id="slider-main-<?= $random_integer ?>">
        <?php
            //loop through each slide's data
            foreach ($media_gallery as $main_slide) : 
                //we're using a boolean ACF field to toggle between Image & Video fields for each slide:
                if ($main_slide['media_type']) {
                    $media_type = 'image';
                } else {
                    $media_type = 'video';
                }

                //establish the arguments that we'll pass to the slide's HTML template:                    
                $template_args = array(
                    'media_type' => $media_type,
                    'slide_image' => $main_slide['slide_image'],
                    'slide_video' => $main_slide['slide_video'],
                    'slider_main_image_size_name' => $slider_main_image_size_name,
                    'slider_main_image_size_array' => $slider_main_image_size_array,
                );
        ?>
                <figure 
                    class="main-slide" 
                    style="--main-slide-height:<?= $slider_main_height ?>px"
                >
                    <?= get_template_part('views/global/modules/media-gallery/components/carousel-slide', null, $template_args) ?>
                </figure>
        <?php
            endforeach;
        ?>
    </div>  
    <div id="append-arrows-<?= $random_integer ?>" class="container">
        <span
            class="container-settings"
            data-container-width="standard"
            data-arrows-position="edges">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>      
    <span
        class="container-settings"
        data-container-width="standard"
    >
        <span class="validator-text" data-nosnippet>settings</span>
    </span>
</div>
<?php
    //don't even print the slider thumbnails or slider settings (for both) unless there's more than 1 slide:
    if (count($media_gallery) > 1) :
?>
        <div class="slider-thumbmnails-row container">
            <div 
                id="slider-thumbnails-<?= $random_integer ?>" 
                style="--thumbnail-slide-height:<?= $slider_thumbnails_height ?>px"
                data-as-nav-for="#slider-main-<?= $random_integer ?>"
            >
                <?php 
                    //intitialize a counter:
                    $count = 0;

                    //loop through each slide's data
                    foreach ($media_gallery as $thumbnail_slide) : 
                        //we're using a boolean ACF field to toggle between Image & Video fields for each slide:
                        if ($thumbnail_slide['media_type']) {
                            $media_type = 'image';
                        } else {
                            $media_type = 'video';
                        }

                        //establish the arguments that we'll pass to the slide's HTML template:                    
                        $template_args = array(
                            'media_type' => $media_type,
                            'slide_count' => $count,
                            'slide_image' => $thumbnail_slide['slide_image'],
                            'slide_video' => $thumbnail_slide['slide_video'],
                            'slider_thumbnails_image_size_name' => $slider_thumbnails_image_size_name,
                            'slider_thumbnails_image_size_array' => $slider_thumbnails_image_size_array,
                            'main_slider_ID' => 'slider-main-'.$random_integer,
                        );
                ?>
                        <div class="thumbnail-slide">
                            <?= get_template_part('views/global/modules/media-gallery/components/carousel-thumbnail-button', null, $template_args) ?>
                        </div>
                <?php
                        $count++;
                    endforeach;
                ?> 
            </div>      
            <span class="slider-settings">
                <script>  
                    jQuery('#slider-main-<?= $random_integer ?>').slick({
                        //accessibility: true,
                        appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                        arrows: true,
                        autoplay: true,
                        autoplaySpeed: 7000,
                        asNavFor: $('#slider-thumbnails-<?= $random_integer ?>'),
                        fade: true,
                        /*
                        responsive: [
                            {
                                breakpoint: 1024,
                                settings: {
                                    arrows: false,
                                },
                            },
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1
                                },
                            },
                        ],
                        */
                        rows: 0, 
                        slide: '.main-slide',
                        slidesToScroll: 1,
                        slidesToShow: 1, 
                    }); 
                </script>
                <script>  
                    jQuery('#slider-thumbnails-<?= $random_integer ?>').slick({
                        //accessibility: true,
                        arrows: false,
                        dots: false,
                        autoplay: true,
                        autoplaySpeed: 7000,
                        asNavFor: $('#slider-main-<?= $random_integer ?>'), 
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
                </script>
                <span class="validator-text" data-nosnippet>slider settings</span>
            </span>    
            <span
                class="container-settings"
                data-container-width="standard"
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
<?php
    endif;
?>