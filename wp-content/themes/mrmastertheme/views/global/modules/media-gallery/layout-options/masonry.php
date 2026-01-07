<?php
    $media_gallery = $args['media_gallery'];

    //we use a random integer to prevent duplicate IDs, in the case of any other slider instances on the same page:
    $random_integer = rand(0, 999);
?>
<div class="thumbnails-row">
    <div class="container">
        <ul class="gallery-thumbnails">
            <?php
                //intitialize a counter:
                $count = 0;

                foreach ($media_gallery as $thumbnail) : 
                    if ($thumbnail['media_type']) {
                        $media_type = 'image';
                    } else {
                        $media_type = 'video';
                    }

                    //establish the arguments that we'll pass to the slide's HTML template:                    
                    $template_args = array(
                        'media_type' => $media_type,
                        'slide_count' => $count,
                        'slide_image' => $thumbnail['slide_image'],
                        'slide_video' => $thumbnail['slide_video'],
                        'modal_ID' => 'modal-'.$random_integer,
                        'slider_ID' => 'masonry-gallery-'.$random_integer,
                    );
            ?>
                    <li>
                        <?= get_template_part('views/global/modules/media-gallery/components/masonry-thumbnail-button', null, $template_args) ?>
                    </li>
            <?php
                    $count++;
                endforeach;
            ?>
        </ul>
        <span 
            class="container-settings" 
            data-container-width="standard"
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
</div>
<div id="<?= 'modal-'.$random_integer ?>" class="modal-gallery" aria-hidden="true">
    <div class="slider-wrap">
        <div id="masonry-gallery-<?= $random_integer ?>">
            <?php
                foreach ($media_gallery as $slide) {
                    if ($slide['media_type']) {
                        $media_type = 'image';
                    } else {
                        $media_type = 'video';
                    }

                    //establish the arguments that we'll pass to the slide's HTML template:                    
                    $template_args = array(
                        'media_type' => $media_type,
                        'slide_image' => $slide['slide_image'],
                        'slide_video' => $slide['slide_video'],
                    );  

                    echo get_template_part('views/global/modules/media-gallery/components/masonry-slide', null, $template_args);
                }
            ?>
        </div>
        <div id="append-arrows-<?= $random_integer ?>" class="arrows-row">
            <span
                class="arrow-settings" 
                data-arrows-position="edges"
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <span class="slider-settings">
            <script>  
                jQuery('#masonry-gallery-<?= $random_integer ?>').slick({
                    appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                    appendDots: $('#append-dots-<?= $random_integer ?>'),
                    arrows: true, 
                    autoplay: 5000, 
                    autoplay: false,
                    dots: false, 
                    rows: 0, 
                    slide: '.masonry-slide', 
                    slidesToScroll: 1,
                    slidesToShow: 1, 
                }); 
            </script>
            <span class="validator-text" data-nosnippet>slider settings</span>
        </span>
    </div>
    <button 
        class="modal-close"
        data-modal-ID="modal-<?= $random_integer ?>"
    >
        <span class="screenreader-only">Close modal gallery</span>
    </button>
</div>