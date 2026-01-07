<?php
    //grab the arguments passed to this template file:
    $media_type = $args['media_type']; 
    $slide_image = $args['slide_image'];
    $slide_video = $args['slide_video']; 
?>
<figure class="masonry-slide"> 
    <?php
        if ($media_type === 'image') :
            //for images, we just spit out an <img> tag
            $slide_image_url = $slide_image['url']; 
            $slide_image_width = $slide_image['width']; 
            $slide_image_height = $slide_image['height']; 
            $slide_image_alt = $slide_image['alt']; 
    ?>
            <img 
                src="<?= $slide_image_url ?>"
                width="<?= $slide_image_width ?>"
                height="<?= $slide_image_height ?>"
                alt="<?= $slide_image_alt ?>"
            >
    <?php
        //for video, we need to spit out the appropriate formatted iframe, based on platform:
        elseif ($media_type === 'video') :
            $video_link = $slide_video['video_link'];
            $video_description = $slide_video['video_description'];

            if (str_contains($video_link, 'youtube')) {
                $video_id = str_replace('https://www.youtube.com/watch?v=', '', $video_link);

                $iframe_string = '<iframe src="https://www.youtube.com/embed/'.$video_id.'?enablejsapi=1" class="youtube-iframe" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen tabindex="-1"></iframe>';
            } elseif (str_contains($video_link, 'vimeo')) {
                $video_id = str_replace('https://vimeo.com/', '', $video_link);

                $iframe_string = '<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/'.$video_id.'?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" class="vimeo-iframe" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="GLUE" tabindex="-1"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
            }

            echo $iframe_string;
    ?>

            <span class="description screenreader-only">
                <?= $video_description ?>
            </span>
    <?php
        endif;
    ?>
</figure>