<?php
    //Set up our data from the arguments passed to this template file:
    $background = $args['background'];

    //the slider images:
    $slider_content = $background['slider_media'];

    //intialize random integer to apply to the slider ID
    $random_integer = rand(0,999);
    
    //the static background image:
    $background_image = $background['static_image'];
    
    $container_width = $args['container_width'];
    $text_color_attribute = $args['text_color_attribute'];  

    if ($slider_content) :
?>
        <div class="content-slider-row">
            <div class="container">
                <div id="title-area-content-slider-<?= $random_integer ?>">
                    <?php
                        foreach ($slider_content as $content_slide) :
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
        <div id="append-arrows-<?= $random_integer ?>" class="container arrows-row">
            <span
                class="container-settings"
                data-container-width="standard"
                data-arrows-position="edges">
                <span class="validator-text" data-nosnippet>arrow settings</span>
            </span>
        </div> 
        <div id="append-dots-<?= $random_integer ?>" class="container dots-row">
            <span 
                class="container-settings" 
                data-container-width="standard"
                data-dots-position="left"
            >
                <span class="validator-text" data-nosnippet>dots settings</span>
            </span>
        </div>
        <span class="slider-settings">
            <script>  
                jQuery('#title-area-content-slider-<?= $random_integer ?>').slick({
                    appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                    appendDots: $('#append-dots-<?= $random_integer ?>'),
                    arrows: true,
                    autoplay: false,
                    //autoplay: 5000,
                    dots: true,
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