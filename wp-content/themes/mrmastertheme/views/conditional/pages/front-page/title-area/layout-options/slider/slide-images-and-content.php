<?php
    //Set up our data from the arguments passed to this template file:
    $background = $args['background'];

    //the slider images:
    $slider_media = $background['slider_media'];

    //intialize random integer to apply to the slider ID
    $random_integer = rand(0,999); 
    
    $container_width = $args['container_width'];
    $text_color_attribute = $args['text_color_attribute'];  

    if ($slider_media) :
        //build out the image slider:
?>
        <div class="image-slider-row">
            <div id="title-area-image-slider-<?= $random_integer ?>">
                <?php
                    foreach ($slider_media as $image) :
                ?>
                        <picture 
                            class="image-slide" 
                        > 
                            <img
                                src="<?= $image['image']['url'] ?>"
                                width="<?= $image['image']['width'] ?>"
                                height="<?= $image['image']['height'] ?>"
                                alt="<?= $image['image']['alt'] ?>"
                            >
                        </picture>
                <?php
                    endforeach;
                ?>
            </div> 
        </div> 
<?php
        //build out the content slider:
?>
        <div class="content-slider-row">
            <div class="container">
                <div id="title-area-content-slider-<?= $random_integer ?>">
                    <?php
                        foreach ($slider_media as $content_slide) :
                    ?>
                            <div class="content-slide">
                                <div class="content" <?= $text_color_attribute ?>>
                                    <?= $content_slide['content'] ?>
                                </div>
                            </div>
                    <?php
                        endforeach;
                    ?>
                </div> 
                <span 
                    class="container-settings"
                    data-container-width="<?= $container_width ?>" 
                >
                    <span class="validator-text" data-nosnippet>container settings</span>
                </span>
            </div>
        </div> 
<?php
        //include arrows if the design calls for it:
?>
        <div id="append-arrows-<?= $random_integer ?>" class="container arrows-row">
            <span
                class="container-settings"
                data-container-width="standard"
                data-arrows-position="edges">
                <span class="validator-text" data-nosnippet>arrow settings</span>
            </span>
        </div> 
<?php
        //include dots if the design calls for it:
?>        
        <div id="append-dots-<?= $random_integer ?>" class="container dots-row">
            <span 
                class="container-settings" 
                data-container-width="standard"
                data-dots-position="left"
            >
                <span class="validator-text" data-nosnippet>dots settings</span>
            </span>
        </div>
<?php
        //manage the slider settings:
?>
        <span class="slider-settings">
            <script>  
                jQuery('#title-area-image-slider-<?= $random_integer ?>').slick({
                    asNavFor: '#title-area-content-slider-<?= $random_integer ?>',
                    arrows: true,
                    appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                    dots: true,
                    appendDots: $('#append-dots-<?= $random_integer ?>'),
                    autoplay: false,
                    //autoplay: 5000,
                    fade: true,
                    rows: 0, 
                    slide: '.image-slide',
                    slidesToScroll: 1,
                    slidesToShow: 1
                }); 
            </script>
            <script>  
                jQuery('#title-area-content-slider-<?= $random_integer ?>').slick({
                    asNavFor: '#title-area-image-slider-<?= $random_integer ?>',
                    arrows: false,
                    dots: false,
                    autoplay: false,
                    //autoplay: 5000,
                    rows: 0, 
                    slide: '.content-slide',
                    slidesToScroll: 1,
                    slidesToShow: 1
                }); 
            </script>
            <span class="validator-text" data-nosnippet>slider settings</span>
        </span>
<?php
    endif;
?>