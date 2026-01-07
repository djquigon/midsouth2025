<?php
    //grab the ACF group field that holds all the data for the homepage title area:
    $homepage_title_area = get_field('homepage_title_area');

    //in case we need an ID or additional class names:
    $unique_identifiers = $homepage_title_area['unique_identifiers'];
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    // Background settings
    $background_type = $homepage_title_area['background_type'];

    // Get background settings based on type
    if ($background_type === 'image') {
        $background = $homepage_title_area['background_image'];
        $slider_type_string = '';
    } else if ($background_type === 'video') {
        $background = $homepage_title_area['background_video'];
        $slider_type_string = '';
    } else if ($background_type === 'slider') {
        $background = $homepage_title_area['background_slider'];
        $slider_type_string = 'data-slider-type="'.$background['slider_type'].'"';
    }

    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<header id="'.$module_id.'" class="title-area '.$module_class_names.'" data-background-type="'.$background_type.'"'.$slider_type_string.'>';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<header id="'.$module_id.'" class="title-area" data-background-type="'.$background_type.'"'.$slider_type_string.'>';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<header class="title-area '.$module_class_names.'" data-background-type="'.$background_type.'"'.$slider_type_string.'>';
    } else {
        $opening_tag = '<header class="title-area" data-background-type="'.$background_type.'"'.$slider_type_string.'>';
    }

    //build out the closing tag HTML
    $closing_tag = '</header>';

    //grab the container width for content, slider controls, etc.
    $container_width = $homepage_title_area['container_width'];

    //text color settings - these affect the entire module but are applied at the content level, slider or static:
    $text_color_settings = $homepage_title_area['text_color'];

    //if any of these color fields are used, we'll use them to build out CSS variables to add to each row, at the column level
    if (isset($text_color_settings)) {
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
    } 
    
    if (
        empty($text_color_settings['headings_color']) &&
        empty($text_color_settings['body_text_color']) &&
        empty($text_color_settings['link_color']) &&
        empty($text_color_settings['link_hover_color'])
    ) {
        $text_color_attribute = '';
    }

    // Set up arguments to pass to the layout template
    $template_args = array(
        'background' => $background,
        'container_width' => $container_width,
        'text_color_attribute' => $text_color_attribute
    ); 
 
    echo $opening_tag; 

    // Load the appropriate layout template based on background type
    if ($background_type === 'image') {
        echo get_template_part('views/conditional/pages/front-page/title-area/layout-options/image', null, $template_args);
    } else if ($background_type === 'video') {
        echo get_template_part('views/conditional/pages/front-page/title-area/layout-options/video', null, $template_args);
    } else if ($background_type === 'slider') { 
        //If we're using a slider, we next need to determine what kind of slider:

        if ($background['slider_type'] === 'slide-images-static-content') {
            echo get_template_part('views/conditional/pages/front-page/title-area/layout-options/slider/slide-images-static-content', null, $template_args);
        } elseif ($background['slider_type'] === 'slide-content-static-image') {
            echo get_template_part('views/conditional/pages/front-page/title-area/layout-options/slider/slide-content-static-image', null, $template_args);
        } elseif ($background['slider_type'] === 'slide-images-and-content') {
            echo get_template_part('views/conditional/pages/front-page/title-area/layout-options/slider/slide-images-and-content', null, $template_args);
        }
    }

    // Overlay settings (shared across all background types)
    $include_overlay = $homepage_title_area['include_overlay'];
    $overlay_color = $homepage_title_area['overlay_color'];

    if ($include_overlay) :
?> 
        <span 
            class="overlay" 
            style="background-color: <?= $overlay_color; ?>"
        >
            <span class="validator-text" data-nosnippet>overlay</span>
        </span>
<?php 
    endif; 

    //For layout options that feature a static image background, use the same component file:
    if ($background_type === 'image') {
        $background_args = [
            'background_image' => $homepage_title_area['background_image']['image'],
            'background_image_position' => $homepage_title_area['background_image']['background_image_position']
        ];
        
        echo get_template_part('views/conditional/pages/front-page/title-area/components/background-image', null, $background_args); 
    } elseif ($background_type === 'slider' && $background['slider_type'] === 'slide-content-static-image') {
        $background_args = [
            'background_image' => $homepage_title_area['background_slider']['static_image']['image'],
            'background_image_position' => $homepage_title_area['background_slider']['static_image']['background_image_position']
        ];
        
        echo get_template_part('views/conditional/pages/front-page/title-area/components/background-image', null, $background_args); 
    }

    echo $closing_tag;
?>