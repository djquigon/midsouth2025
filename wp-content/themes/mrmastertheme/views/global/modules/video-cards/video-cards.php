<?php
    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = get_sub_field('tag_type');

    //in case we need an ID or additional class names:
    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    //grab the column count from settings:
    $column_count = get_sub_field('column_count');

    // Map column count values to grid system format
    $grid_column_count = '';
    switch ($column_count) {
        case 'one-col':
            $grid_column_count = 'one';
            break;
        case 'two-col':
            $grid_column_count = 'two';
            break;
        case 'three-col':
            $grid_column_count = 'three';
            break;
        case 'four-col':
            $grid_column_count = 'four';
            break;
        default:
            $grid_column_count = 'three'; // default fallback
    }

    //grab the container width from settings
    $container_width = get_sub_field('container_width');

    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="video-cards ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="video-cards">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="video-cards ' . $module_class_names . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="video-cards">';
    }

    //build out the closing tag HTML
    $closing_tag = '</' . $tag_type . '>';

    //grab the top & bottom padding settings values, for both desktop & mobile
    $padding_settings = get_sub_field('padding');
    $top_padding_desktop = $padding_settings['top_padding_desktop'];
    $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
    $top_padding_mobile = $padding_settings['top_padding_mobile'];
    $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

    //build out the padding settings <span> HTML:
    $padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

    //establish the background settings
    $background_settings = get_sub_field('background');
    $background_type = $background_settings['background_type'];

    if ($background_type === 'color') {
        $background_color = $background_settings['background_color'];

        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else if ($background_type === 'image') {
        $background_image = $background_settings['background_image'];
        $background_image_url = $background_image['url'];
        $background_image_position = $background_settings['background_image_position'];

        //use an overlay if it's set up:
        if ($background_settings['include_overlay']) {
            $background_image_overlay = $background_settings['overlay_color'];

            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        }
    } else {
        //transparent background, so no need for settings <span> HTML:
        $background_settings_tag = '';
    }

    //text color settings - these affect the entire module but are applied at the column level
    $text_color_settings = get_sub_field('text_color');

    //if any of these color fields are used, we'll use them to build out CSS variables to add to each row, at the column level
    if ($text_color_settings['headings_color'] || $text_color_settings['body_text_color'] || $text_color_settings['link_color'] || $text_color_settings['link_hover_color']) {
        $text_color_attribute = 'style="';

        if ($text_color_settings['headings_color']) {
            $text_color_attribute .= '--headings-color:' . $text_color_settings['headings_color'] . ';';
        }

        if ($text_color_settings['body_text_color']) {
            $text_color_attribute .= '--body-text-color:' . $text_color_settings['body_text_color'] . ';';
        }

        if ($text_color_settings['link_color']) {
            $text_color_attribute .= '--link-color:' . $text_color_settings['link_color'] . ';';
        }

        if ($text_color_settings['link_hover_color']) {
            $text_color_attribute .= '--link-hover-color:' . $text_color_settings['link_hover_color'] . ';';
        }

        $text_color_attribute .= '"';
    } 
    
    if (
        empty($text_color_settings['headings_color']) &&
        empty($text_color_settings['body_text_color']) &&
        empty($text_color_settings['link_color']) &&
        empty($text_color_settings['link_hover_color'])
    ) {
        $text_color_attribute = '';
    }

    //Begin working with variables & fields specific to this module:
    $all_videos_button_text = get_sub_field('all_videos_button')['button_text'];
    $all_videos_button_link = get_sub_field('all_videos_button')['button_link'];
    $module_title = get_sub_field('module_title');
    $include_intro_content = get_sub_field('include_intro_content');
    $intro_content = get_sub_field('intro_content');

    //declare variable to hold video rows:
    $videos = get_sub_field('videos');

    //set up arguments to pass to the layout template(s):
    $template_args = array(
        'module_title' => $module_title,
        'include_intro_content' => $include_intro_content,
        'intro_content' => $intro_content,
        'videos' => $videos,
        'all_videos_button_text' => $all_videos_button_text,
        'all_videos_button_link' => $all_videos_button_link,
        'column_count' => $grid_column_count,
        'text_color_attribute' => $text_color_attribute,
    );    

    //we're only generating HTML if the module has a list of videos to display:
    if ($videos) :
        echo $opening_tag;

        //Print HTML for Module Title, 'View All' Button, & Intro Content (all optional):
        echo get_template_part('views/global/modules/video-cards/components/title-area', null, $template_args);
?>
        <div class="videos-row">
            <div class="container">
                <ul 
                    class="video-list" 
                    data-grid="grid" 
                    data-column-count="<?= $grid_column_count; ?>" 
                    data-column-gap="small" 
                    data-row-gap="small"
                >
                    <?php 
                        foreach ($videos as $video) :
                            $video_link = $video['video_link'];
                            $poster_image = $video['poster_image'];

                            if ($poster_image) {
                                $poster_image_array = [
                                    'poster_image_url' => $poster_image['url'],
                                    'poster_image_width' => $poster_image['width'],
                                    'poster_image_height' => $poster_image['height'],
                                    'poster_image_alt' => $poster_image['alt']
                                ];
                            } else {
                                $poster_image_array = [];    
                            }

                            $description_visibility = $video['description_visibility'];
                            $description = $video['description'];

                            $video_aria_id = rand(0, 999);
                    ?>
                            <li>
                                <?php 
                                    echo mandr_video_player(
                                        $video_link, 
                                        $poster_image_array, 
                                        $description, 
                                        $video_aria_id
                                    );

                                    if ($description) :
                                ?>
                                    <div 
                                        class="description<?php if (!$description_visibility) { echo ' screenreader-only'; } ?>"
                                    >   
                                        <?= $description ?>
                                    </div>
                                <?php
                                    endif;
                                ?>
                                <a href="<?= $video_link ?>" class="button popup-video">Watch Video</a>
                            </li>
                    <?php 
                        endforeach; 
                    ?>
                </ul>
                <span 
                    class="container-settings" 
                    data-container-width="<?= $container_width ?>"
                >
                    <span class="validator-text">settings</span>
                </span>
            </div>
        </div>
<?php
        if ($all_videos_button_text && $all_videos_button_link) :
?>
            <div class="all-button-row" data-desktop-hide="true">
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
            <?= $padding_settings_tag ?>
            <?= $background_settings_tag ?>
            <span class="validator-text">module settings</span>
        </span>
<?php
        echo $closing_tag;
    endif;
?>