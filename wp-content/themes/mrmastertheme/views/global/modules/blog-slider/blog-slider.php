<?php
//we may not always want to use <section>, and instead opt for <aside> or <div>
$tag_type = get_sub_field('tag_type');

//in case we need an ID or additional class names:
$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

//build out the closing tag HTML
$closing_tag = '</' . $tag_type . '>';

//get the selected layout option from settings:
$layout = get_sub_field('layout');

//build out the opening tag HTML:
if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="project-slider ' . $module_class_names . '" data-layout="' . $layout . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="project-slider" data-layout="' . $layout . '">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="project-slider ' . $module_class_names . '" data-layout="' . $layout . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="project-slider" data-layout="' . $layout . '">';
}

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
$all_projects_button_text = get_sub_field('all_projects_button_text');
$all_projects_button_link = get_sub_field('all_projects_button_link');
$module_title = get_sub_field('module_title');
$include_intro_content = get_sub_field('include_intro_content');
$intro_content = get_sub_field('intro_content');

$slide_count = get_sub_field('slide_count');

$project_list = get_sub_field('project_list');

if (!$project_list) {
    $project_list = get_posts([
        'post_type' => 'mandr_project',
        'status' => 'publish',
        'posts_per_page' => 10
    ]);
}

//we're only generating HTML if the module has a list of project CPT posts to display
if ($project_list) :
    echo $opening_tag;
    //prevent duplicate IDs when multiple sliders exist on the same page
    $random_integer = rand(0, 999);
?>
    <span class="project-list-wrapper">
        <div class="intro-content-row">
            <?php if ($include_intro_content) : ?>
                <div class="container">
                    <?php echo $intro_content; ?>
                    <span class="container-settings" data-container-width="standard">
                        <span class="validator-text" data-nosnippet>settings</span>
                    </span>
                </div>
            <?php endif; ?>
        </div>
        <div id="project-carousel-<?= $random_integer; ?>" class="project-carousel-row container">
            <?php
            foreach ($project_list as $project) :
                $project_id = $project->ID;
                $project_link = get_permalink($project_id);
                $project_title = get_the_title($project_id);
                $project_excerpt = get_the_excerpt($project_id);

                $project_image_size_name = 'full';

                if (get_post_thumbnail_id($project_id)) {
                    $project_image_id = get_post_thumbnail_id($project_id);

                    $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
                    $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
                    $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
                    $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', true);
                } elseif (get_field('project_media_gallery', $project_id)) {
                    $project_media_gallery = get_field('project_media_gallery', $project_id);

                    if ($project_media_gallery[0]['media_type']) {
                        $project_image_id = $project_media_gallery[0]['slide_image']['id'];

                        $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
                        $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
                        $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
                        $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', true);
                    } else {
                        $video_link = $project_media_gallery[0]['slide_video']['video_link'];

                        if ($project_media_gallery[0]['slide_video']['poster_image']) {
                            $project_image_id = $project_media_gallery[0]['slide_video']['poster_image']['id'];

                            $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
                            $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
                            $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
                            $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', true);
                        } else {
                            if (str_contains($video_link, 'youtube')) {
                                $youtube_id = youtube_video_id($video_link);

                                $project_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
                                $project_image_width = 480;
                                $project_image_height = 360;
                                $project_image_alt = 'default video thumbnail image supplied by YouTube';
                            } elseif (str_contains($video_link, 'vimeo')) {
                                $oembed_endpoint = 'http://vimeo.com/api/oembed';
                                $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
                                $oembed = simplexml_load_string(curl_get($xml_url));

                                $project_image_url = html_entity_decode($oembed->thumbnail_url);

                                $project_image_width = 640;
                                $project_image_height = 360;
                                $project_image_alt = 'default video thumbnail image supplied by Vimeo';
                            }
                        }

                        $poster_image_array = [
                            'poster_image_url' => $project_image_url,
                            'poster_image_width' => $project_image_width,
                            'poster_image_height' => $project_image_height,
                            'poster_image_alt' => $project_image_alt,
                        ];

                        $video_description = $project_media_gallery[0]['slide_video']['video_description'];

                        $video_aria_id = 'video-widget-' . rand(0, 999);
                    }
                } else {
                    $project_image_id = false;
                }
            ?>
                <div class="project-slide" <?= $text_color_attribute ?>>
                    <?php
                    if (get_post_thumbnail_id($project_id) || !get_post_thumbnail_id($project_id) && get_field('project_media_gallery', $project_id)[0]['media_type']) :
                    ?>
                        <figure>
                            <a href="<?= $project_link ?>">
                                <img
                                    src="<?= $project_image_url ?>"
                                    height="<?= $project_image_height ?>"
                                    width="<?= $project_image_width ?>"
                                    alt="<?= $project_image_alt ?>">
                            </a>
                        </figure>
                    <?php
                    endif;
                    ?>
                    <div class="project-content">
                        <h3 class="project-title">
                            <a href="<?= $project_link; ?>"><?= $project_title; ?></a>
                        </h3>
                        <a href="<?= $project_link; ?>" class="view-btn">View Project</a>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
            <span
                class="container-settings"
                data-container-width="widest">
                <span class="validator-text" data-nosnippet>container settings</span>
            </span>
        </div>
        <span class="bottom-row-wrapper">
            <div id="append-arrows-<?= $random_integer ?>" class="container arrows-row">
                <span
                    class="container-settings"
                    data-container-width="standard"
                    data-arrows-position="center">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
            <?php
            if ($all_projects_button_text && $all_projects_button_link) :
            ?>
                <div class="all-button-row">
                    <div class="container" data-flex="flex" data-justify-content="center">
                        <a
                            href="<?= $all_projects_button_link ?>"
                            class="button"
                            aria-label="View All Projects">
                            <?= $all_projects_button_text ?>
                        </a>
                        <span
                            class="container-settings"
                            data-container-width="standard">
                            <span class="validator-text" data-nosnippet>settings</span>
                        </span>
                    </div>
                </div>
            <?php
            endif;
            ?>
        </span>
        <span class="slider-settings">
            <script>
                jQuery('#project-carousel-<?= $random_integer ?>').slick({
                    appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                    arrows: true,
                    autoplay: true,
                    dots: false,
                    adaptiveHeight: false,
                    responsive: [{
                            breakpoint: 1280,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                            },
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                slidesToScroll: 1,
                                slidesToShow: 1,
                            },
                        },
                    ],
                    rows: 0,
                    slide: '.project-slide',
                    slidesToScroll: 1,
                    slidesToShow: 5,
                });
            </script>
            <span class="validator-text" data-nosnippet>slider settings</span>
        </span>
    </span>
    <?php
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