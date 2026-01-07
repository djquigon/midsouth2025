<?php
    //because this module may be referenced by certain post types (e.g. Projects) we'll use a lot of conditionals for setting variables that may not be there, & we're doing this to prevent PHP errors.

    //we may not always want to use <section>, and instead opt for <aside> or <div>
    if (get_sub_field('tag_type')) {
        $tag_type = get_sub_field('tag_type');
    } else {
        //default to <div>
        $tag_type = 'div';
    }

    //in case we need an ID or additional class names:
    if (get_sub_field('unique_identifiers')) {
        $unique_identifiers = get_sub_field('unique_identifiers');
        $module_id = $unique_identifiers['id'];
        $module_class_names = $unique_identifiers['class_names'];
    } else {
        $unique_identifiers = null;
        $module_id = null;
        $module_class_names = null;
    }
    

    //build out the closing tag HTML
    $closing_tag = '</' . $tag_type . '>';

    //determine the layout option:
    if (isset($args['layout'])) {
        //if this template file has been passed a layout argument, use it:
        $layout = $args['layout'];
    } elseif (!isset($args['layout']) && get_sub_field('layout')) {
        //if it's not passed a layout argument, we're likely working with a module, so grab the setting:
        $layout = get_sub_field('layout');
    } else {
        //otherwise, default to the carousel layout:
        $layout = 'carousel';
    }

    
    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="media-gallery ' . $module_class_names . '" data-layout="' . $layout . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="media-gallery" data-layout="' . $layout . '">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="media-gallery ' . $module_class_names . '" data-layout="' . $layout . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="media-gallery" data-layout="' . $layout . '">';
    }

    //grab the top & bottom padding settings values, for both desktop & mobile
    if (get_sub_field('padding')) {
        $padding_settings = get_sub_field('padding');
        $top_padding_desktop = $padding_settings['top_padding_desktop'];
        $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
        $top_padding_mobile = $padding_settings['top_padding_mobile'];
        $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];
    } else {
        //default to double & single:
        $top_padding_desktop = 'double';
        $bottom_padding_desktop = 'double';
        $top_padding_mobile = 'single';
        $bottom_padding_mobile = 'single';
    }

    //build out the padding settings <span> HTML:
    $padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';


    //establish the background settings
    if (get_sub_field('background')) {
        $background_settings = get_sub_field('background');
        $background_type = $background_settings['background_type'];
    } else {
        //default to transparent:
        $background_type = 'transparent';
    }
    

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
    if (get_sub_field('text_color')) {
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
    $module_title = get_sub_field('module_title');
    $include_intro_content = get_sub_field('include_intro_content');
    $intro_content = get_sub_field('intro_content');


    if (isset($args['media_gallery'])) {
        //if this template file has been passed a Media Gallery array as an argument, use it:
        $media_gallery = $args['media_gallery'];
    } else {
        //otherwise, we're using an ACF flexible content layout, so reference the sub-field instead:
        $media_gallery = get_sub_field('media_gallery');
    }

    //we're only generating HTML if the module has a list of images/videos to display
    if ($media_gallery) :
        echo $opening_tag; 

        //if we're using a module title &/ intro content, spit em out:
        echo get_template_part('views/global/modules/media-gallery/components/title-area', null, array(
            'module_title' => $module_title,
            'include_intro_content' => $include_intro_content,
            'intro_content' => $intro_content,
            'text_color_attribute' => $text_color_attribute
        ));
        

        //depending on the chosen layout option, we grab the appropriate template file:
        if ($layout === 'carousel') {
            echo get_template_part('views/global/modules/media-gallery/layout-options/carousel', null, array('media_gallery' => $media_gallery));
        } elseif ($layout === 'masonry') {
            echo get_template_part('views/global/modules/media-gallery/layout-options/masonry', null, array('media_gallery' => $media_gallery));
        }
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