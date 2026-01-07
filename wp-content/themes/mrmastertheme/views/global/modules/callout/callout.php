<?php
    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = get_sub_field('tag_type');

    //in case we need an ID or additional class names:
    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    //build out the closing tag HTML
    $closing_tag = '</' . $tag_type . '>';


    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="callout ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="callout">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="callout ' . $module_class_names . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="callout">';
    }

    //establish the MODULE background settings
    $module_background_settings = get_sub_field('module_background');
    $module_background_type = $module_background_settings['background_type'];

    if ($module_background_type === 'color') {
        $module_background_color = $module_background_settings['background_color'];

        //build out the background settings <span> HTML:
        $module_background_settings_tag = '<span class="background" style="background-color:' . $module_background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else if ($module_background_type === 'image') {
        $module_background_image = $module_background_settings['background_image'];
        $module_background_image_url = $module_background_image['url'];
        $module_background_image_position = $module_background_settings['background_image_position'];

        //use an overlay if it's set up:
        if ($module_background_settings['include_overlay']) {
            $module_background_image_overlay = $module_background_settings['overlay_color'];

            //build out the background settings <span> HTML:
            $module_background_settings_tag = '<span class="background" style="background-image:url(' . $module_background_image_url . '); --overlay-color:' . $module_background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $module_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            //build out the background settings <span> HTML:
            $module_background_settings_tag = '<span class="background" style="background-image:url(' . $module_background_image_url . ')" data-background-image-position="' . $module_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        }
    } else {
        //transparent background, so no need for settings <span> HTML:
        $module_background_settings_tag = '';
    }


    //grab the MODULE's top & bottom padding settings values, for both desktop & mobile
    $module_padding_settings = get_sub_field('module_padding');
    $module_top_padding_desktop = $module_padding_settings['top_padding_desktop'];
    $module_bottom_padding_desktop = $module_padding_settings['bottom_padding_desktop'];
    $module_top_padding_mobile = $module_padding_settings['top_padding_mobile'];
    $module_bottom_padding_mobile = $module_padding_settings['bottom_padding_mobile'];

    //build out the MODULE padding settings <span> HTML:
    $module_padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $module_top_padding_desktop . '" data-bottom-padding-desktop="' . $module_bottom_padding_desktop . '" data-top-padding-mobile="' . $module_top_padding_mobile . '" data-bottom-padding-mobile="' . $module_bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';




    //grab the CONTAINER width from settings
    $container_width = get_sub_field('container_width');

    //establish the CONTAINER background settings
    $container_background_settings = get_sub_field('container_background');
    $container_background_type = $container_background_settings['background_type'];
    if ($container_background_type === 'color') {
        $container_background_color = $container_background_settings['background_color'];

        //build out the background settings <span> HTML:
        $container_background_settings_tag = '<span class="background" style="background-color:' . $container_background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else if ($container_background_type === 'image') {
        $container_background_image = $container_background_settings['background_image'];
        $container_background_image_url = $container_background_image['url'];
        $container_background_image_position = $container_background_settings['background_image_position'];
        //build out the background settings <span> HTML:
        $container_background_settings_tag = '<span class="background" style="background-image:url(' . $container_background_image_url . ')" data-background-image-position="' . $container_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else {
        //transparent background, so no need for settings <span> HTML:
        $container_background_settings_tag = '';
    }

    //grab the CONTAINER's top & bottom padding settings values, for both desktop & mobile
    $container_padding_settings = get_sub_field('container_padding');
    $container_top_padding_desktop = $container_padding_settings['top_padding_desktop'];
    $container_bottom_padding_desktop = $container_padding_settings['bottom_padding_desktop'];
    $container_top_padding_mobile = $container_padding_settings['top_padding_mobile'];
    $container_bottom_padding_mobile = $container_padding_settings['bottom_padding_mobile'];

    //build out the CONTAINER padding settings <span> HTML:
    $container_padding_settings = '<span class="padding" data-top-padding-desktop="' . $container_top_padding_desktop . '" data-bottom-padding-desktop="' . $container_bottom_padding_desktop . '" data-top-padding-mobile="' . $container_top_padding_mobile . '" data-bottom-padding-mobile="' . $container_bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';


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

    //declare variable to hold content:
    $content = get_sub_field('content');
?>

<?php
    //we're only generating HTML if the module has content to print
    if ($content) :
        echo $opening_tag;
?>
        <div class="container">
            <div class="content" <?= $text_color_attribute ?>>
                <?= $content ?>
            </div>
            <span class="container-settings" data-container-width="<?= $container_width ?>" data-nosnippet>
                <?= $container_padding_settings ?>
                <?= $container_background_settings_tag ?>
                <span class="validator-text">settings</span>
            </span>
        </div>
        <span class="module-settings" data-nosnippet>
            <?= $module_padding_settings_tag ?>
            <?= $module_background_settings_tag ?>
            <span class="validator-text">module settings</span>
        </span>
<?php
        echo $closing_tag;
    endif;
?>