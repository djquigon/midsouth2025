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
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="full-width-two-columns ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="full-width-two-columns">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="full-width-two-columns ' . $module_class_names . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="full-width-two-columns">';
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

    //do the order of the columns need to be swapped for the mobile view?
    $reverse_order_mobile = get_sub_field('reverse_order_mobile');
     if ($reverse_order_mobile) {
        $mobile_reverse_order_setting = 'data-mobile-reverse-order="true"';
    } else {
        $mobile_reverse_order_setting = '';
    }

    //grab the top & bottom padding settings values, for both desktop & mobile
    $padding_settings = get_sub_field('column_content_padding'); 

    //build out the padding settings <span> HTML:
    $padding_settings_tag = '<span class="padding" data-padding-desktop="' . $padding_settings['padding_desktop'] . '" data-padding-mobile="' . $padding_settings['padding_mobile'] . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

    //variables to hold column data:
    $left_column = get_sub_field('left_column');  
    $right_column = get_sub_field('right_column'); 

    //if we're using 2 image-only columns, we need to create a CSS min-height exception for that
    if ($left_column['content_type'] === 'background-image' && $right_column['content_type'] === 'background-image') {
        $images_only_setting = 'data-images-only="true"';
    } else {
        $images_only_setting = '';
    }
?>

<?php
    if ($left_column && $right_column) :
        echo $opening_tag;
?>  
        <div class="columns-row">
            <div 
                class="columns" 
                <?= $mobile_reverse_order_setting ?>
                <?= $images_only_setting ?>
            > 
                <?php
                    //spit out the left column, depending on chosen content type:
                    if ($left_column['content_type'] === 'background-image') {
                        echo get_template_part('views/global/modules/full-width-two-columns/layout-options/image-column', null, array('column' => $left_column)); 
                    } else {
                        echo get_template_part('views/global/modules/full-width-two-columns/layout-options/content-column', null, array('column' => $left_column , 'text_color_attribute' => $text_color_attribute, 'padding_settings_tag' => $padding_settings_tag)); 
                    }
                        
                    //spit out the right column:
                    if ($right_column['content_type'] === 'background-image') {
                        echo get_template_part('views/global/modules/full-width-two-columns/layout-options/image-column', null, array('column' => $right_column)); 
                    } else {
                        echo get_template_part('views/global/modules/full-width-two-columns/layout-options/content-column', null, array('column' => $right_column , 'text_color_attribute' => $text_color_attribute, 'padding_settings_tag' => $padding_settings_tag)); 
                    }
                ?> 
            </div>
            <span 
                class="row-settings"
                data-column-count="2"
                data-column-gap="none"
                data-column-width="variable"
                data-row-gap="none"
            >
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
        </div> 
<?php
        echo $closing_tag;
    endif;
?>