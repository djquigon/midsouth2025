<?php
    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = get_sub_field('tag_type');

    //in case we need an ID or additional class names:
    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<section id="' . $module_id . '" class="video-full-width ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<section id="' . $module_id . '" class="video-full-width">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<section class="video-full-width ' . $module_class_names . '">';
    } else {
        $opening_tag = '<section class="video-full-width">';
    }

    //build out the closing tag HTML:
    $closing_tag = '</' . $tag_type . '>';

    
    //Video settings:
    $video_link = get_sub_field('video_link');
    $video_title = get_sub_field('video_title');
    
    $video_poster_image = get_sub_field('poster_image');

    if ($video_poster_image) {
        $poster_image_url = $video_poster_image['url'];
    } else {
        //if no poster image set, use the video link to grab the default from YouTube/Vimeo. Use the background
        if (str_contains($video_link, 'youtube')) {
            $youtube_id = youtube_video_id($video_link);

            $poster_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
        } elseif(str_contains($video_link, 'vimeo')) {
            $oembed_endpoint = 'http://vimeo.com/api/oembed';
            $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
            $oembed = simplexml_load_string(curl_get($xml_url)); 

            //grab the image url:
            $poster_image_url = html_entity_decode($oembed->thumbnail_url);
        } else {
            $poster_image_url = false;
        }
    }

    $video_description = get_sub_field('description');

    if (!$video_description) {
        $video_description = 'play video';
    } 
    

    $all_videos_button_text = get_sub_field('all_videos_button')['button_text'];
    $all_videos_button_link = get_sub_field('all_videos_button')['button_link'];


    if ($video_link) :
        echo $opening_tag;
?>

<?php
        if ($video_title) :
?>
            <div class="video-title-row">
                <div class="container">
                    <h2><?= $video_title ?></h2>
                    <span 
                        class="container-settings" 
                        data-container-width="standard"
                    >
                        <span class="validator-text">settings</span>
                    </span>
                </div>
            </div>
<?php
        endif;
?>
        <div class="play-button-row">
            <div class="container">
                <a href="<?= $video_link ?>" class="popup-video">
                    <span class="description screenreader-only">
                        <?= $video_description ?>
                    </span>
                </a>
                <span 
                    class="container-settings" 
                    data-container-width="standard"
                >
                    <span class="validator-text">settings</span>
                </span>
            </div>
        </div>
<?php
        if ($all_videos_button_text && $all_videos_button_link) :
?>
            <div class="all-button-row">
                <div class="container">
                    <a 
                        href="<?= $all_videos_button_link ?>" 
                        class="button" 
                        aria-label="View All Videos"
                    >
                        <?= $all_videos_button_text ?>
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
        <span class="module-settings" data-nosnippet>
            <span 
                class="padding"
                data-top-padding-desktop="double"
                data-bottom-padding-desktop="double"
                data-top-padding-mobile="single"
                data-bottom-padding-mobile="single"
            >
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
            <?php
                if ($poster_image_url) :
            ?>
                    <span 
                        class="background" 
                        style="background-image:url(' <?= $poster_image_url ?> '); --overlay-color: rgba(0,0,0,.8)" 
                        data-background-image-position="center" 
                        data-background-overlay="true"
                    >
                        <span class="validator-text" data-nosnippet>background settings</span>
                    </span>
            <?php
                endif;
            ?>
            <span class="validator-text" data-nosnippet>module settings</span>
        </span>
<?php
        echo $closing_tag;
    endif;
?>