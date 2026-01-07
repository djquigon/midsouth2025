<?php
    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = get_sub_field('tag_type');


    //in case we need an ID or additional class names:
    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    //build out the closing tag HTML
    $closing_tag = '</'.$tag_type.'>';

    //get the selected layout option from settings:
    $layout = get_sub_field('layout');

    //grab the column count from settings (applicable to 'Cards' layout):
    $column_count = get_sub_field('column_count');

    //grab the container width from settings
    $container_width = get_sub_field('container_width');

    
    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<'.$tag_type.' id="'.$module_id.'" class="faqs '.$module_class_names.'" data-layout="'.$layout.'">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<'.$tag_type.' id="'.$module_id.'" class="faqs" data-layout="'.$layout.'">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<'.$tag_type.' class="faqs '.$module_class_names.'" data-layout="'.$layout.'">';
    } else {
        $opening_tag = '<'.$tag_type.' class="faqs" data-layout="'.$layout.'">';
    }


    //grab the top & bottom padding settings values, for both desktop & mobile
    $padding_settings = get_sub_field('padding');
    $top_padding_desktop = $padding_settings['top_padding_desktop'];
    $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
    $top_padding_mobile = $padding_settings['top_padding_mobile'];
    $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

    //build out the padding settings <span> HTML:
    $padding_settings_tag = '<span class="padding" data-top-padding-desktop="'.$top_padding_desktop.'" data-bottom-padding-desktop="'.$bottom_padding_desktop.'" data-top-padding-mobile="'.$top_padding_mobile.'" data-bottom-padding-mobile="'.$bottom_padding_mobile.'"><span class="validator-text" data-nosnippet>padding settings</span></span>';


    //establish the background settings
    $background_settings = get_sub_field('background');
    $background_type = $background_settings['background_type'];

    if ($background_type === 'color') {
        $background_color = $background_settings['background_color'];

        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-color:'.$background_color.'"><span class="validator-text" data-nosnippet>background settings</span></span>';

    } else if ($background_type === 'image') {
        $background_image = $background_settings['background_image'];
        $background_image_url = $background_image['url'];
        $background_image_position = $background_settings['background_image_position'];

        //use an overlay if it's set up:
        if ($background_settings['include_overlay']) {
            $background_image_overlay = $background_settings['overlay_color'];

            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url('.$background_image_url.'); --overlay-color:'.$background_image_overlay.'" data-background-overlay="true" data-background-image-position="'.$background_image_position.'"><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url('.$background_image_url.')" data-background-image-position="'.$background_image_position.'"><span class="validator-text" data-nosnippet>background settings</span></span>';
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
            $text_color_attribute .= '--headings-color:'.$text_color_settings['headings_color'].';';    
        }

        if ($text_color_settings['body_text_color']) {
            $text_color_attribute .= '--body-text-color:'.$text_color_settings['body_text_color'].';';    
        }

        if ($text_color_settings['link_color']) {
            $text_color_attribute .= '--link-color:'.$text_color_settings['link_color'].';';    
        }

        if ($text_color_settings['link_hover_color']) {
            $text_color_attribute .= '--link-hover-color:'.$text_color_settings['link_hover_color'].';';    
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

    //declare variable to hold title:
    $module_title = get_sub_field('module_title');

    //declare variable to hold FAQs:
    $faqs = get_sub_field('faqs');

    //declare variable to hold 'All' button:
    $all_faqs_button = get_sub_field('all_faqs_button');

    //set up arguments to pass to the layout template(s):
    $template_args = array(
        'module_title' => $module_title,
        'faqs' => $faqs,
        'text_color_attribute' => $text_color_attribute,
        'container_width' => $container_width,
        'column_count' => $column_count,
        'all_faqs_button' => $all_faqs_button,
    );
?>

<?php
    //we're only generating HTML if the module has FAQs to print
    if ($faqs) :
        echo $opening_tag;

        //depending on the chosen layout option, we grab the appropriate template file:
        if ($layout === 'toggles') {
            echo get_template_part('views/global/modules/faqs/layout-options/toggles', null, $template_args);
        } else if ($layout === 'cards') {
            echo get_template_part('views/global/modules/faqs/layout-options/cards', null, $template_args);
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