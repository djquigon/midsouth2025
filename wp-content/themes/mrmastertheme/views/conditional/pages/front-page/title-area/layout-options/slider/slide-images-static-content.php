<?php
    //Set up our data from the arguments passed to this template file:
    $background = $args['background'];

    //the slider images:
    $slider_images = $background['slider_media'];

    //intialize random integer to apply to the slider ID
    $random_integer = rand(0,999);
    
    //the static content:
    $content = $background['static_content'];
    
    $container_width = $args['container_width'];
    $text_color_attribute = $args['text_color_attribute'];  

    if ($slider_images) :
?>
        <div class="image-slider-row">
            <div id="title-area-image-slider-<?= $random_integer ?>">
                <?php
                    foreach ($slider_images as $image) :
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
    endif; 

    if ($content) :
?>
        <div 
            class="content-row"
            data-flex="flex"
            data-justify-content="center"
            data-align-items="center"
        >
            <div class="container">
                <div 
                    class="content"
                    <?= $text_color_attribute ?>
                >
                    <?= $content ?>
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
    endif;
?>

<?php
    if ($slider_images) :
?>
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
                jQuery('#title-area-image-slider-<?= $random_integer ?>').slick({
                    appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                    appendDots: $('#append-dots-<?= $random_integer ?>'),
                    arrows: true,
                    autoplay: false,
                    //autoplay: 5000,
                    dots: true,
                    rows: 0, 
                    slide: '.image-slide',
                    slidesToScroll: 1,
                    slidesToShow: 1
                }); 
            </script>
            <span class="validator-text" data-nosnippet>slider settings</span>
        </span>
<?php
    endif;
?>