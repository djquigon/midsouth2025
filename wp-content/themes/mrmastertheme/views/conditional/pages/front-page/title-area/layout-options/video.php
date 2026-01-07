<?php
    //Set up our data from the arguments passed to this template file:
    $background = $args['background'];

    $video_link = $background['video_link']; 
    $video_description = $background['video_description']; 
    
    $mobile_image = $background['mobile_image'];

    if ($mobile_image) {
        $mobile_image_data_attribute = 'data-mobile-image="true"';
    } else {
        $mobile_image_data_attribute = '';
    }

    $content = $background['content'];
    $container_width = $args['container_width'];
    $text_color_attribute = $args['text_color_attribute'];

    $protocols = array('http://', 'https://');

    if (str_contains($video_link, 'youtube')) {
        $video_id = str_replace('https://www.youtube.com/watch?v=', '', $video_link);

        $iframe_string = '<iframe frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" title="HEAVEN | RENE RINNEKANGAS SNOWBOARD VIDEO" width="640" height="360" src="https://www.youtube.com/embed/'.$video_id.'?autoplay=1&amp;controls=0&amp;mute=1&amp;loop=1&disablekb=1&loop=1&amp;playlist='.$video_id.'&amp;playsinline=1&amp;rel=0&amp;modestbranding=1&amp;fs=0&amp;iv_load_policy=3&amp;disablekb=1&amp;enablejsapi=1&amp;origin=https%3A%2F%2F'.str_replace($protocols, '', get_bloginfo('wpurl')).'&amp;widgetid=1&amp;forigin=https%3A%2F%2F'.str_replace($protocols, '', get_bloginfo('wpurl')).'%2F&amp;aoriginsup=1&amp;gporigin=https%3A%2F%2F'.str_replace($protocols, '', get_bloginfo('wpurl')).'%2Fwp-admin%2Fpost.php%3Fpost%3D2%26action%3Dedit%26classic-editor&amp;vf=6"></iframe>'; 

        $video_platform = 'youtube';
    } elseif (str_contains($video_link, 'vimeo')) {
        $video_id = str_replace('https://vimeo.com/', '', $video_link);

        $iframe_string = '<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/'.$video_id.'?badge=0&amp;autopause=0&background=true&amp;player_id=0&amp;app_id=58479" class="vimeo-iframe" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media; web-share" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="GLUE" tabindex="-1"></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';

        $video_platform = 'vimeo';
    } else {
        $iframe_string = false;
        $video_platform = 'other';
    }

    if ($iframe_string) :
?>
    <div 
        class="background"
        data-flex="flex"
        data-justify-content="center"
        data-align-items="center"
        data-video-platform="<?= $video_platform ?>"
        <?= $mobile_image_data_attribute ?>
    >  
        <?php
            if ($video_description) :
                //include a video description tag for accessibility:
        ?>
                <span class="video-description screenreader-only">
                    <?= $video_description ?>
                </span>
        <?php
            endif;
        
            //spit out the video html:
            echo $iframe_string; 
            
            if ($mobile_image) :
                //you may want to use a fallback image for mobile:
        ?>
                <picture 
                    class="mobile-fallback-image" 
                    data-desktop-hide="true"
                >
                    <img 
                        src="<?= $mobile_image['url'] ?>"
                        width="<?= $mobile_image['width'] ?>"
                        height="<?= $mobile_image['height'] ?>"
                        alt="<?= $mobile_image['alt'] ?>"
                    >
                </picture>
        <?php
            endif;
        ?>
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