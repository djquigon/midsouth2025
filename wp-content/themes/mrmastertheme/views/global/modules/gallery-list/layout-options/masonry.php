<?php
    //first we set up the arguments passed from the Gallery List module's main php file:

    $gallery_list = $args['gallery_list'];

    $text_color_attribute = $args['text_color_attribute'];

    $manual_selection_or_automatic = $args['manual_selection_or_automatic'];

    $all_galleries_button_text = $args['all_galleries_button_text'];
    $all_galleries_button_link = $args['all_galleries_button_link']; 

    if ($gallery_list) :
?>
        <div class="galleries-row">
            <div class="container">
                <ul class="galleries" <?= $text_color_attribute ?>>
                    <?php
                        foreach ($gallery_list as $list_item) :
                            // If user chose to manually select their galleries, pull post object from that Post Object list
                            // Otherwise, pull posts from get_posts
                            if ($manual_selection_or_automatic == true) {
                                $gallery_post_object = $list_item['gallery_post_object'];
                            } else {
                                $gallery_post_object = $list_item;
                            }

                            $gallery_id = $gallery_post_object->ID;
                            $gallery_link = get_permalink($gallery_id);
                            $gallery_title = get_the_title($gallery_id);

                            //use the gallery ID to get the featured image ID, if it's set. 
                            if (get_post_thumbnail_id($gallery_id)) {
                                $gallery_image_id = get_post_thumbnail_id($gallery_id);

                                //use featured image ID & size name to grab all the relevant info:
                                $gallery_image_url = wp_get_attachment_image_url($gallery_image_id, null);
                                $gallery_image_width = wp_get_attachment_image_src($gallery_image_id,null)[1];
                                $gallery_image_height = wp_get_attachment_image_src($gallery_image_id,null)[2];
                                $gallery_image_alt = get_post_meta($gallery_image_id, '_wp_attachment_image_alt', TRUE);
                            } elseif (get_field('media_gallery', $gallery_id)) {
                                //If we don't have a set featured image, we'll try to grab the first image in the gallery's gallery. 
                                $media_gallery = get_field('media_gallery', $gallery_id);

                                //We need to 1st determine the type of media that sits in the 1st position of the gallery's media gallery
                                if ($media_gallery[0]['media_type']) {
                                    //In the single gallery's media gallery, we're using a boolean ACF field to toggle between Image & Video 'media type'. So, if that boolean returns 'true', we're dealing with an image:

                                    $gallery_image_url = $media_gallery[0]['slide_image']['url'];
                                    $gallery_image_width = $media_gallery[0]['slide_image']['width'];
                                    $gallery_image_height = $media_gallery[0]['slide_image']['height'];
                                    $gallery_image_alt = $media_gallery[0]['slide_image']['alt']; 
                                } else {
                                    //If the aforementioned boolean returns 'false' we know we're dealing with a video 
                                    $video_link = $media_gallery[0]['slide_video']['video_link'];

                                    //so next, we determine if a poster image was manually set by the user, or if we're just grabbing whatever default image the video platform provides:
                                    if ($media_gallery[0]['slide_video']['poster_image']) {
                                        $gallery_image_id = $media_gallery[0]['slide_video']['poster_image']['id'];

                                        $gallery_image_url = wp_get_attachment_image_url($gallery_image_id);
                                        $gallery_image_width = wp_get_attachment_image_src($gallery_image_id)[1];
                                        $gallery_image_height = wp_get_attachment_image_src($gallery_image_id)[2];
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
                        <li>
                            <article>
                                <a href="<?= $gallery_link; ?>"> 
                                    <figure>
                                        <img 
                                            src="<?= $gallery_image_url ?>" 
                                            height="<?= $gallery_image_height ?>" 
                                            width="<?= $gallery_image_width ?>" 
                                            alt="<?= $gallery_image_alt ?>"
                                        > 
                                    </figure> 
                                    <span 
                                        class="text-wrapper"
                                        data-flex="flex"
                                        data-flex-direction="column"
                                        data-flex-wrap="wrap"
                                        data-align-items="center"
                                        data-justify-content="center"
                                    >
                                        <h3><?= $gallery_title; ?></h3>
                                        <span class="pseudo-link">View Gallery</span>
                                    </span>
                                </a>
                            </article> 
                        </li>
                    <?php
                        endforeach;
                    ?>
                </ul>
            </div>
            <span
                class="row-settings"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
<?php
    endif;
    
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
