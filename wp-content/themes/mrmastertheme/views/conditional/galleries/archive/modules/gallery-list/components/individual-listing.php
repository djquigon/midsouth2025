<?php
    $gallery_id = $args['id'];
    
    //gallery permalink
    $gallery_permalink = get_the_permalink($gallery_id);

    //gallery title
    $gallery_title = get_the_title($gallery_id);

    //assign a post image size, these are set up in library/custom-theme/php/initialization.php
    $gallery_image_size_name = 'medium-square';

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

    //excerpt:
    $gallery_excerpt = get_the_excerpt($gallery_id);
?>
<li>
    <article>
        <?php
            //if we have a featured image associated with the gallery, OR if we don't have a featured image set but the 1st slide in the gallery's media gallery is an image:
            if (get_post_thumbnail_id($gallery_id) || !get_post_thumbnail_id($gallery_id) && get_field('media_gallery', $gallery_id)[0]['media_type']) :
        ?>
                <figure>
                    <a href="<?= $gallery_permalink ?>">
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
        <h3>
            <a href="<?= $gallery_permalink ?>">
                <?= $gallery_title ?>
            </a>
        </h3>
        <?php
            //post the excerpt if it exists:                            
            if ($gallery_excerpt) :
        ?>
                <blockquote 
                    class="excerpt" 
                    cite="<?= $gallery_permalink ?>"
                >
                    <?= $gallery_excerpt ?>
                </blockquote>
        <?php
            endif;

            //spit out the widgetized gallery category list:
            echo get_template_part('views/conditional/galleries/widgets/gallery-category-list/gallery-category-list', null, array('id' => $gallery_id));
        ?>     
        <a href="<?= $gallery_permalink ?>" class="button">
            View Gallery
        </a>
    </article>
</li>
