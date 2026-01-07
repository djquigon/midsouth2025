<?php
// Get current page ID
$current_page_id = get_the_ID();

// Query all popup posts
$popup_query = new WP_Query([
    'post_type' => 'mandr_popup',
    'posts_per_page' => -1,
    'post_status' => 'publish'
]);

// Loop through popup posts
if ($popup_query->have_posts()) {    
    while ($popup_query->have_posts()) {
        $popup_query->the_post();

        // Get ACF Settings fields for this popup
        $pages_to_display_on = get_field('pages_to_display_on');

        // pass to js and add cookie if true so it doesn't show again
        $only_show_once = get_field('only_show_once'); 

        // Check if this popup should be shown on current page:
        $should_show = false;

        if (!$pages_to_display_on || empty($pages_to_display_on)) {
            // If no pages specified, show on all pages
            $should_show = true;
        } else {
            // Check if current page is in the list
            $should_show = in_array($current_page_id, $pages_to_display_on);
        }

        // If popup should be shown, add it to the JavaScript data
        if ($should_show) :
            //Get ACF Content fields for this popup
            $content_rows = get_field('rows');
            //in case we need an ID or additional class names:
            $unique_identifiers = get_field('unique_identifiers');

            if ($unique_identifiers) {
                $module_id = $unique_identifiers['id'];
                $module_class_names = $unique_identifiers['class_names'];
            } else {
                $module_id = false;
                $module_class_names = false;
            }

            //get popup size
            $popup_size = get_field('popup_size');

            //build out the opening tag HTML:
            if ($module_id && $module_class_names) {
                $opening_tag = '<div id="' . $module_id . '" class="popup-content ' . $module_class_names . ' ' . $popup_size . '">';
            } else if ($module_id && !$module_class_names) {
                $opening_tag = '<div id="' . $module_id . '" class="popup-content ' . $popup_size . '">';
            } else if (!$module_id && $module_class_names) {
                $opening_tag = '<div class="popup-content ' . $module_class_names . ' ' . $popup_size . '">';
            } else {
                $opening_tag = '<div class="popup-content ' . $popup_size . '">';
            }

            //build out the closing tag HTML
            $closing_tag = '</div>';

            //establish the background settings
            $background_settings = get_field('background');

            if ($background_settings) {
                $background_type = $background_settings['background_type'];
            } else {
                $background_type = false;
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
            $text_color_settings = get_field('text_color');
            $text_color_attribute = '';

            //if any of these color fields are used, we'll use them to build out CSS variables to add to each row, at the column level
            if ($text_color_settings) {
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

            // Get the popup HTML
            ob_start();

            if ($content_rows) :
                echo $opening_tag;

                //loop through each row of content
                foreach ($content_rows as $content_row) { 
                    $column_count = $content_row['column_count'];

                    //depending on the column count, grab the right template file: 
                    echo get_template_part('views/global/modules/standard-content/layout-options/' . $column_count . '-column', null, array('content_row' => $content_row, 'text_color_attribute' => $text_color_attribute));
                }
?>
                <button class="close-popup" aria-label="Close popup">×</button>
                <span class="module-settings" data-nosnippet>
                    <?= $background_settings_tag ?>
                    <span class="validator-text">module settings</span>
                </span>

            <?php 
                echo $closing_tag;  
                $popup_html = ob_get_clean();

                // Add popup data to JavaScript as object:
            ?>
                <script>
                    window.mrPopupData = window.mrPopupData || [];
                    window.mrPopupData.push({
                        pages: <?php echo json_encode($pages_to_display_on ?: []); ?>,
                        html: <?php echo json_encode($popup_html); ?>,
                        only_show_once: <?php echo json_encode($only_show_once); ?>
                    });
                </script>
<?php
            endif;

            // Add current page ID to JavaScript as object:
?>
            <script>
                window.mrCurrentPageId = <?php echo $current_page_id; ?>;
            </script>
<?php
        endif;
    }
    wp_reset_postdata();
}

