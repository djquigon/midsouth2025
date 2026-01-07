<?php
    //There's no need for this 'module' to be grouped with the rest of the ACF flexible layout options, because it's going to be in the same pre-footer area in 9/10 site designs:
    $similar_projects = get_field('similar_projects');

    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = $similar_projects['tag_type'];

    //grab the container width from settings
    $container_width = $similar_projects['container_width'];

    //in case we need an ID or additional class names:
    $unique_identifiers = $similar_projects['unique_identifiers'];
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    //build out the closing tag HTML
    $closing_tag = '</' . $tag_type . '>';
    
    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="similar-projects ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="similar-projects">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="similar-projects ' . $module_class_names . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="similar-projects">';
    }


    //grab the top & bottom padding settings values, for both desktop & mobile
    $padding_settings = $similar_projects['padding'];
    $top_padding_desktop = $padding_settings['top_padding_desktop'];
    $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
    $top_padding_mobile = $padding_settings['top_padding_mobile'];
    $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

    //build out the padding settings <span> HTML:
    $padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';


    //establish the background settings
    $background_settings = $similar_projects['background'];
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
    $text_color_settings = $similar_projects['text_color'];

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

    //Variables for Module Title & Intro Content:
    $module_title = $similar_projects['module_title'];
    $include_intro_content = $similar_projects['include_intro_content'];
    $intro_content = $similar_projects['intro_content'];


    //Determine the method of pulling in similar projects:
    $manual_selection_or_automatic = $similar_projects['manual_selection_or_automatic'];

    if ($manual_selection_or_automatic) {
        $projects = $similar_projects['projects'];
    } else {
        // Automatically pulls in the 3 most recent projects that contain at least one of this project's categories
        $project_categories = get_the_terms(get_the_ID(), 'project_category');

        // Custom built tax query that loops through each project category of this post and adds it to the query
        $tax_query = array(
            'relation'      => 'OR',
        );
        
        foreach ($project_categories as $cat) {
            array_push($tax_query, array(
                'taxonomy' => 'project_category',
                'field'    => 'slug',
                'terms'    => $cat->slug
            ));
        }

        // Set up args that utilize the custom built tax query
        $posts_args = array(
            'post_type'         => 'mandr_project',
            'status'            => 'publish',
            'posts_per_page'    => 3,
            'tax_query'    => $tax_query,
        );

        // Retrieves projects with the customer args
        $projects = get_posts($posts_args);
    }

    //Set up arguments to pass to the layout template(s):
    $template_args = array(
        'module_title' => $module_title,
        'intro_content' => $intro_content,
        'projects' => $projects,
        'text_color_attribute' => $text_color_attribute,
        'container_width' => $container_width,
    );
?>

<?php
    //we're only generating HTML if the module has projects to display:
    if ($projects) :
        echo $opening_tag;

        if ($module_title || $include_intro_content) {
            echo get_template_part('views/conditional/projects/single/modules/similar-projects/components/intro-content', null, $template_args);
        }

        echo get_template_part('views/conditional/projects/single/modules/similar-projects/components/projects-list', null, $template_args);
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