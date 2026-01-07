<?php
    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = get_sub_field('tag_type');
    
    //in case we need an ID or additional class names:
    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    
    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<'.$tag_type.' id="'.$module_id.'" class="resource-list '.$module_class_names.'">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<'.$tag_type.' id="'.$module_id.'" class="resource-list">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<'.$tag_type.' class="resource-list '.$module_class_names.'">';
    } else {
        $opening_tag = '<'.$tag_type.' class="resource-list">';
    }
    

    //build out the closing tag HTML
    $closing_tag = '</'.$tag_type.'>';


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

    
    //declare variable to hold title & intro content:
    $module_title = get_sub_field('module_title');
    $intro_content = get_sub_field('intro_content');

    //declare variable to hold the resources:
    $resources = get_sub_field('resources');

    //variables for handling 'all' button:
    $all_resources_button = get_sub_field('all_resources_button');
    $all_resources_button_text = $all_resources_button['button_text'];
    $all_resources_button_link = $all_resources_button['button_link'];

    //set up arguments to pass to the layout template(s):
    $template_args = array(
        'module_title' => $module_title,
        'intro_content' => $intro_content,
        'resources' => $resources,
        'text_color_attribute' => $text_color_attribute,
        'all_resources_button' => $all_resources_button,
    );
?>

<?php
    //we're only generating HTML if the module has resources to print
    if ($resources) :
        echo $opening_tag;

        //if we're using a module title &/ 'view all' button:
        if ($module_title || ($all_resources_button_text && $all_resources_button_link)) :
    ?>
            <div class="title-all-button-row">
                <div class="container"<?= $text_color_attribute ?>>
                    <?php
                        if ($module_title) :
                    ?>
                            <h2 class="title"><?= $module_title ?></h2>
                    <?php
                        endif;
    
                        if ($all_resources_button_text && $all_resources_button_link) :
                    ?>
                            <a href="<?= $all_resources_button_link ?>" class="button" data-mobile-hide="true"><?= $all_resources_button_text ?></a>
                    <?php
                        endif;
                    ?>
                    <span 
                        class="container-settings" 
                        data-flex="flex" 
                        data-justify-content="space-between" 
                        data-container-width="standard"
                    >
                        <span class="validator-text" data-nosnippet>settings</span>
                    </span>
                </div>
            </div>
    <?php
        endif;
    ?>
    <div class="resources-row">
        <div class="container"<?= $text_color_attribute ?>>
            <ul 
                class="resources"
                data-flex="flex"
                data-flex-wrap="wrap"
                data-column-count="two"
                data-column-gap="large"
                data-row-gap="large"
            >
            <?php
                //loop through the resources
                foreach ($resources as $resource) :
                    //first, check if we're dealing with a new Resource or an existing Resource 
                    if ($resource['new_or_existing_resource'] === true) {
                        //true = existing Resource (post data)

                        //grab the ID so that we can use it to grab all the other Resource data
                        $resource_id = $resource['existing_resource'];
                        echo get_template_part('views/conditional/resources/single/modules/resource-list/components/resource-listing-existing', null, array('id' => $resource_id));
                    } else {
                        //false = new Resource (repeater field data)
                        echo get_template_part('views/conditional/resources/single/modules/resource-list/components/resource-listing-new', null, array('resource' => $resource['new_resource']));
                    }   
                endforeach;
            ?>
            </ul>
            <span 
                class="container-settings" 
                data-container-width="standard"
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </div>
    <?php
        //if we do have a 'view all button', generate a duplicate for the mobile view only:
        if ($all_resources_button_text && $all_resources_button_link) :
    ?>
        <div class="all-button-row" data-desktop-hide="true">
            <div class="container"<?= $text_color_attribute ?>>
                <a href="<?= $all_resources_button_link ?>" class="button" ><?= $all_resources_button_text ?></a> 
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
        <span class="module-settings">
            <?= $padding_settings_tag ?>
            <?= $background_settings_tag ?>
            <span class="validator-text">Module settings</span>
        </span>
<?php
        echo $closing_tag;
    endif;
?>