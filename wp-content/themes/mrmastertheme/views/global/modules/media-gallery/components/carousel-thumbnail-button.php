<?php
    //grab the arguments passed to this template file:
    $media_type = $args['media_type'];
    $slide_count = $args['slide_count'];
    $slide_image = $args['slide_image'];
    $slide_video = $args['slide_video'];
    $main_slider_ID = $args['main_slider_ID'];

    $slider_thumbnails_image_size_name = $args['slider_thumbnails_image_size_name'];
    $slider_thumbnails_image_size_array = $args['slider_thumbnails_image_size_array'];

    //if the slide is an image only:
    if ($media_type == 'image') { 

        $slide_image_id = $slide_image['ID'];

        //use slide image ID to grab all the relevant info: 
        $slide_image_url = wp_get_attachment_image_url($slide_image_id, $slider_thumbnails_image_size_name);
    } else {
    //the slide is a video:
        $video_link = $slide_video['video_link'];
        $poster_image = $slide_video['poster_image']; 
         
        if (str_contains($video_link, 'youtube')) { 
            //extract the video 
            $youtube_id = youtube_video_id($video_link);            

            if ($poster_image) {
                $slide_image_url = $poster_image['url'];
            } else {
                $slide_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
            } 
        } elseif (str_contains($video_link, 'vimeo')) {                

            if ($poster_image) {
                $slide_image_url = $poster_image['url'];
            } else {
                //Load in the oEmbed XML
                $oembed_endpoint = 'http://vimeo.com/api/oembed';
                $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
                $oembed = simplexml_load_string(curl_get($xml_url)); 

                //grab the image url:
                $slide_image_url = html_entity_decode($oembed->thumbnail_url);
            } 
        }
    }
?>
<button 
    class="carousel-slide-thumbnail"
    style="background-image: url('<?= $slide_image_url ?>')"
    data-main-slider-ID="<?= $main_slider_ID ?>"
    data-slide-count="<?= $slide_count ?>"
>
    <span class="screenreader-only">navigation button for the media gallery slider</span>
</button>