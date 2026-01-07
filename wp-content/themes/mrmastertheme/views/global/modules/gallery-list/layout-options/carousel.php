<?php
    //first we set up the arguments passed from the gallery List module's main php file:
    $manual_selection_or_automatic = $args['manual_selection_or_automatic'];
    $gallery_list = $args['gallery_list'];

    $all_galleries_button_text = $args['all_galleries_button_text'];
    $all_galleries_button_link = $args['all_galleries_button_link'];

    $slide_count = $args['slide_count'];
    if ($slide_count == 'two') {
        $slide_count_number = 2;
    } elseif ($slide_count == 'three') {
        $slide_count_number = 3;
    }

    //assign a post image size, these are set up in library/custom-theme/php/initialization.php
    $gallery_image_size_name = 'medium-square'; 

    $text_color_attribute = $args['text_color_attribute'];

    //we use a random integer to prevent duplicate IDs, in the case of any other slider instances on the same page:
    $random_integer = rand(0, 999);

    if ($gallery_list) :
?>
    <div id="gallery-carousel-<?= $random_integer; ?>" class="gallery-carousel-row container">
        <?php
            foreach ($gallery_list as $list_item) :
                //If user chose to manually select their galleries, pull post object from that Post Object list                
                if ($manual_selection_or_automatic == true) {
                    $gallery_post_object = $list_item['gallery_post_object'];
                } else {
                    //Otherwise, pull posts from get_posts
                    $gallery_post_object = $list_item;
                }

                $gallery_id = $gallery_post_object->ID;
                $gallery_link = get_permalink($gallery_id);
                $gallery_title = get_the_title($gallery_id);
                $gallery_excerpt = get_the_excerpt($gallery_id);
                
                //use the gallery ID to get the featured image ID, if it's set. 
                if (get_post_thumbnail_id($gallery_id)) {
                    $gallery_image_id = get_post_thumbnail_id($gallery_id);

                    //use featured image ID & size name to grab all the relevant info:
                    $gallery_image_url = wp_get_attachment_image_url($gallery_image_id, $gallery_image_size_name);
                    $gallery_image_width = wp_get_attachment_image_src($gallery_image_id, $gallery_image_size_name)[1];
                    $gallery_image_height = wp_get_attachment_image_src($gallery_image_id, $gallery_image_size_name)[2];
                    $gallery_image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', TRUE);
                } elseif (get_field('media_gallery', $gallery_id)) {
                    //If we don't have a set featured image, we'll try to grab the first image in the gallery's gallery. 
                    $media_gallery = get_field('media_gallery', $gallery_id);

                    //We need to 1st determine the type of media that sits in the 1st position of the gallery's media gallery
                    if ($media_gallery[0]['media_type']) {
                        //In the single gallery's media gallery, we're using a boolean ACF field to toggle between Image & Video 'media type'. So, if that boolean returns 'true', we're dealing with an image:
                        
                        $gallery_image_id = $media_gallery[0]['slide_image']['id'];

                        //use gallery media gallery data to grab all the relevant info: 
                        $gallery_image_url = wp_get_attachment_image_url($gallery_image_id, $gallery_image_size_name);
                        $gallery_image_width = wp_get_attachment_image_src($gallery_image_id, $gallery_image_size_name)[1];
                        $gallery_image_height = wp_get_attachment_image_src($gallery_image_id, $gallery_image_size_name)[2];
                        $gallery_image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', TRUE);
                    } else {
                        //If the aforementioned boolean returns 'false' we know we're dealing with a video 
                        $video_link = $media_gallery[0]['slide_video']['video_link'];

                        //so next, we determine if a poster image was manually set by the user, or if we're just grabbing whatever default image the video platform provides:
                        if ($media_gallery[0]['slide_video']['poster_image']) {
                            $gallery_image_id = $media_gallery[0]['slide_video']['poster_image']['id'];

                            $gallery_image_url = wp_get_attachment_image_url($gallery_image_id, $gallery_image_size_name);
                            $gallery_image_width = wp_get_attachment_image_src($gallery_image_id, $gallery_image_size_name)[1];
                            $gallery_image_height = wp_get_attachment_image_src($gallery_image_id, $gallery_image_size_name)[2];
                            $gallery_image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', TRUE);
                        } else {
                            //If we're needing to use an image that comes from a video platform, first we need to determine which video platform that is:
                            
                            if (str_contains($video_link, 'youtube')) {
                                $youtube_id = youtube_video_id($video_link);

                                $gallery_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
                                $gallery_image_width = 480;
                                $gallery_image_height = 360;
                                $gallery_image_alt = 'default video thumbnail image supplied by YouTube';
                            } elseif (str_contains($video_link, 'vimeo')) {
                                //Load in the oEmbed XML
                                $oembed_endpoint = 'http://vimeo.com/api/oembed';
                                $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
                                $oembed = simplexml_load_string(curl_get($xml_url)); 

                                //grab the image url:
                                $gallery_image_url = html_entity_decode($oembed->thumbnail_url);

                                $gallery_image_width = 640;
                                $gallery_image_height = 360;
                                $gallery_image_alt = 'default video thumbnail image supplied by Vimeo';
                            }
                        }                        

                        //set up the video poster image array that we'll pass to the 
                        $poster_image_array = [
                            'poster_image_url' => $gallery_image_url,
                            'poster_image_width' => $gallery_image_width,
                            'poster_image_height' => $gallery_image_height,
                            'poster_image_alt' => $gallery_image_alt
                        ];

                        //we'll also need the video's description 
                        $video_description = $media_gallery[0]['slide_video']['video_description'];
                        
                        //for accessibility purposes, we'll associate this ID with the description's aria attributes:
                        $video_aria_id = 'video-widget-'.rand(0, 999);
                    }
                } else {
                    $gallery_image_id = false;
                } 
        ?>
                <div class="gallery-slide" <?= $text_color_attribute ?>> 
                    <?php
                        //if we have a featured image associated with the gallery, OR if we don't have a featured image set but the 1st slide in the gallery's media gallery is an image:
                        if (get_post_thumbnail_id($gallery_id) || !get_post_thumbnail_id($gallery_id) && get_field('media_gallery', $gallery_id)[0]['media_type']) :
                    ?>
                            <figure>
                                <a href="<?= $gallery_link ?>">
                                    <img 
                                        src="<?= $gallery_image_url ?>" 
                                        height="<?= $gallery_image_height ?>" 
                                        width="<?= $gallery_image_width ?>" 
                                        alt="<?= $gallery_image_alt ?>"
                                    > 
                                </a>
                            </figure>
                    <?php
                        //if neither of the above 2 situations are true, we may be using a video as the gallery's 'thumbnail', so call the function with the appropriate parameters passed: 
                        else :       
                    ?>
                            <figure>
                                <?php
                                    echo mandr_video_player(
                                        $video_link,
                                        $poster_image_array, 
                                        $video_description, 
                                        $video_aria_id
                                    );
                                ?>
                            </figure>
                    <?php
                        endif;
                    ?>
                    <h3 class="gallery-title">
                        <a href="<?= $gallery_link; ?>"><?= $gallery_title; ?></a>
                    </h3>
                    <?php if ($gallery_excerpt) : ?>
                        <blockquote 
                            class="excerpt" 
                            cite="<?= $gallery_link; ?>"
                        >
                            <?= $gallery_excerpt; ?>
                        </blockquote>
                    <?php 
                        endif; 
                        
                        //print the list of gallery categories (conditional widget - gallery post type)
                        echo get_template_part('views/conditional/galleries/widgets/gallery-category-list/gallery-category-list', null, array('id' => $gallery_id));
                    ?>
                    <a href="<?= $gallery_link; ?>" class="button">View gallery</a>
                </div>
        <?php
            endforeach;
        ?>
        <div id="append-arrows-<?= $random_integer ?>" class="container arrows-row">
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
            <span class="validator-text" data-nosnippet>container settings</span>
        </span>
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
        if ($all_galleries_button_text && $all_galleries_button_link) :
    ?>
            <div class="all-button-row" data-desktop-hide="true">
                <div class="container">
                    <a 
                        href="<?= $all_galleries_button_link ?>" 
                        class="button" 
                        aria-label="View All galleries"
                    >
                        <?= $all_galleries_button_text ?>
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
            jQuery('#gallery-carousel-<?= $random_integer ?>').slick({
                //accessibility: true,
                //adaptiveHeight: false,
                appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                appendDots: $('#append-dots-<?= $random_integer ?>'),
                arrows: true,
                //asNavFor: $(element)
                //autoplay: false,
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
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: {
                            appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                            arrows: true,
                            autoplay: 5000,
                            dots: true,
                            rows: 0,
                            slide: '.gallery-slide',
                            slidesToScroll: 1,
                            slidesToShow: 2
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1
                        },
                    },
                ],
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object 
                rows: 0, //Setting this to 1 adds more divs that will require style changes, and setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.
                //rtl: false,
                slide: '.gallery-slide',
                //slidesPerRow: 1,
                slidesToScroll: 1,
                slidesToShow: <?= $slide_count_number ?>,
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
        <span class="validator-text" data-nosnippet>slider settings</span>
    </span>
<?php
endif;
