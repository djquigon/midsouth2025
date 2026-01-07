<?php
    $project_id = $args['id'];
    
    //project permalink
    $project_permalink = get_the_permalink($project_id);

    //project title
    $project_title = get_the_title($project_id);

    //assign a post image size, these are set up in library/custom-theme/php/initialization.php
    $project_image_size_name = 'medium-square';

    //use the project ID to get the featured image ID, if it's set. 
    if (get_post_thumbnail_id($project_id)) {
        $project_image_id = get_post_thumbnail_id($project_id);

        //use featured image ID & size name to grab all the relevant info:
        $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
        $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
        $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
        $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', TRUE);
    } elseif (get_field('project_media_gallery', $project_id)) {
        //If we don't have a set featured image, we'll try to grab the first image in the project's gallery. 
        $project_media_gallery = get_field('project_media_gallery', $project_id);

        //We need to 1st determine the type of media that sits in the 1st position of the Project's media gallery
        if ($project_media_gallery[0]['media_type']) {
            //In the single project's media gallery, we're using a boolean ACF field to toggle between Image & Video 'media type'. So, if that boolean returns 'true', we're dealing with an image:
            
            $project_image_id = $project_media_gallery[0]['slide_image']['id'];

            //use project media gallery data to grab all the relevant info: 
            $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
            $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
            $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
            $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', TRUE);
        } else {
            //If the aforementioned boolean returns 'false' we know we're dealing with a video 
            $video_link = $project_media_gallery[0]['slide_video']['video_link'];

            //so next, we determine if a poster image was manually set by the user, or if we're just grabbing whatever default image the video platform provides:
            if ($project_media_gallery[0]['slide_video']['poster_image']) {
                $project_image_id = $project_media_gallery[0]['slide_video']['poster_image']['id'];

                $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
                $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
                $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
                $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', TRUE);
            } else {
                //If we're needing to use an image that comes from a video platform, first we need to determine which video platform that is:
                
                if (str_contains($video_link, 'youtube')) {
                    $youtube_id = youtube_video_id($video_link);

                    $project_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
                    $project_image_width = 480;
                    $project_image_height = 360;
                    $project_image_alt = 'default video thumbnail image supplied by YouTube';
                } elseif (str_contains($video_link, 'vimeo')) {
                    //Load in the oEmbed XML
                    $oembed_endpoint = 'http://vimeo.com/api/oembed';
                    $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
                    $oembed = simplexml_load_string(curl_get($xml_url)); 

                    //grab the image url:
                    $project_image_url = html_entity_decode($oembed->thumbnail_url);

                    $project_image_width = 640;
                    $project_image_height = 360;
                    $project_image_alt = 'default video thumbnail image supplied by Vimeo';
                }
            }                        

            //set up the video poster image array that we'll pass to the 
            $poster_image_array = [
                'poster_image_url' => $project_image_url,
                'poster_image_width' => $project_image_width,
                'poster_image_height' => $project_image_height,
                'poster_image_alt' => $project_image_alt
            ];

            //we'll also need the video's description 
            $video_description = $project_media_gallery[0]['slide_video']['video_description'];
            
            //for accessibility purposes, we'll associate this ID with the description's aria attributes:
            $video_aria_id = 'video-widget-'.rand(0, 999);
        }
    } else {
        $project_image_id = false;
    } 

    //excerpt:
    $project_excerpt = get_the_excerpt($project_id);
?>
<li>
    <article>
        <?php
            //if we have a featured image associated with the Project, OR if we don't have a featured image set but the 1st slide in the project's media gallery is an image:
            if (get_post_thumbnail_id($project_id) || !get_post_thumbnail_id($project_id) && get_field('project_media_gallery', $project_id)[0]['media_type']) :
        ?>
                <figure>
                    <a href="<?= $project_permalink ?>">
                        <img 
                            src="<?= $project_image_url ?>" 
                            height="<?= $project_image_height ?>" 
                            width="<?= $project_image_width ?>" 
                            alt="<?= $project_image_alt ?>"
                        > 
                    </a>
                </figure>
        <?php
            //if neither of the above 2 situations are true, we may be using a video as the project's 'thumbnail', so call the function with the appropriate parameters passed: 
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
            <a href="<?= $project_permalink ?>">
                <?= $project_title ?>
            </a>
        </h3>
        <?php
            //post the excerpt if it exists:                            
            if ($project_excerpt) :
        ?>
                <blockquote 
                    class="excerpt" 
                    cite="<?= $project_permalink ?>"
                >
                    <?= $project_excerpt ?>
                </blockquote>
        <?php
            endif;

            //spit out the widgetized project category list:
            echo get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => $project_id));
        ?>     
        <a href="<?= $project_permalink ?>" class="button">
            View Project
        </a>
    </article>
</li>
