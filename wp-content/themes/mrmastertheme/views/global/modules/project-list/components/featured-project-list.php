<?php
    $project_media_gallery = $args['project_media_gallery'];
    $random_integer = $args['random_integer'];

    if ($project_media_gallery) :
?>
<div id="featured-project-gallery-slider-<?= $random_integer; ?>" >
    <?php
        foreach ($project_media_gallery as $list_item) :
            //determine what type of media we're working with, image or video: 
            $media_type = $list_item['media_type'];
            $slide_image = $list_item['slide_image'];
            $slide_video = $list_item['slide_video'];

            $slider_main_image_size_name= 'slider-main';
            $slider_main_image_size_array = wp_get_registered_image_subsizes()[$slider_main_image_size_name];            
    ?>
            <figure class="featured-project-gallery-slide">
                <?php
                    //if the slide is an image only:
                    if ($media_type == 'image') :
                        $slide_image_id = $slide_image['ID'];

                        //use slide image ID to grab all the relevant info: 
                        $slide_image_url = wp_get_attachment_image_url($slide_image_id, $slider_main_image_size_name);
                        $slide_image_width = $slider_main_image_size_array['width'];
                        $slide_image_height = $slider_main_image_size_array['height'];
                        $slide_image_alt = get_post_meta($slide_image_id, '_wp_attachment_image_alt', TRUE);
                ?> 
                        <img 
                            src="<?= $slide_image_url ?>" 
                            width="<?= $slide_image_width ?>" 
                            height="<?= $slide_image_height ?>" 
                            alt="<?= $slide_image_alt ?>"
                        >
                <?php
                    else :
                        //if the slide is a video: 
                        $video_link = $slide_video['video_link'];
                        $poster_image = $slide_video['poster_image']; 
                        $video_description = $slide_video['video_description']; 

                        //for accessibility purposes, we'll associate this ID with the description's aria attributes:
                        $video_aria_id = 'video-widget-'.rand(0, 999);

                        //if we have a poster image set:
                        if ($poster_image) {
                            
                            //use poster image ID to grab all the relevant info:
                            $poster_image_id = $poster_image['ID'];

                            //we build an array of the image's attributes
                            $poster_image_array = [
                                'poster_image_url' => wp_get_attachment_image_url($poster_image_id, $slider_main_image_size_name),
                                'poster_image_width' => $slider_main_image_size_array['width'],
                                'poster_image_height' => $slider_main_image_size_array['height'],
                                'poster_image_alt' => get_post_meta($poster_image_id, '_wp_attachment_image_alt', TRUE)
                            ];

                        } else {
                            //we'll pass an empty array which will trigger the shortcode to rely on the video platform's poster image
                            $poster_image_array = [];
                        }
                
                        //call the global video player widget function, passing all the necessary parameters:
                        echo mandr_video_player(
                            $video_link, 
                            $poster_image_array, 
                            $video_description, 
                            $video_aria_id
                        );
                    endif;
                ?>
            </figure>
    <?php
        endforeach;
    ?>
</div>
<?php
    else : 
?>
        <h2>No images have been uploaded for this project yet.</h2>
<?php
    endif;
?>