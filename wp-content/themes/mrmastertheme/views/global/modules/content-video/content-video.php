<?php
$tag_type = get_sub_field('tag_type');

$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

$closing_tag = '</' . $tag_type . '>';

if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="content-video ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="content-video">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="content-video ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="content-video">';
}

$module_background_settings = get_sub_field('module_background');
$module_background_type = $module_background_settings['background_type'];

if ($module_background_type === 'color') {
    $module_background_color = $module_background_settings['background_color'];

    $module_background_settings_tag = '<span class="background" style="background-color:' . $module_background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
} else if ($module_background_type === 'image') {
    $module_background_image = $module_background_settings['background_image'];
    $module_background_image_url = $module_background_image['url'];
    $module_background_image_position = $module_background_settings['background_image_position'];

    if ($module_background_settings['include_overlay']) {
        $module_background_image_overlay = $module_background_settings['overlay_color'];

        $module_background_settings_tag = '<span class="background" style="background-image:url(' . $module_background_image_url . '); --overlay-color:' . $module_background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $module_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else {
        $module_background_settings_tag = '<span class="background" style="background-image:url(' . $module_background_image_url . ')" data-background-image-position="' . $module_background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    }
} else {
    $module_background_settings_tag = '';
}

$module_padding_settings = get_sub_field('module_padding');
$module_top_padding_desktop = $module_padding_settings['top_padding_desktop'];
$module_bottom_padding_desktop = $module_padding_settings['bottom_padding_desktop'];
$module_top_padding_mobile = $module_padding_settings['top_padding_mobile'];
$module_bottom_padding_mobile = $module_padding_settings['bottom_padding_mobile'];

$module_padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $module_top_padding_desktop . '" data-bottom-padding-desktop="' . $module_bottom_padding_desktop . '" data-top-padding-mobile="' . $module_top_padding_mobile . '" data-bottom-padding-mobile="' . $module_bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

$text_color_settings = get_sub_field('text_color');

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

$content = get_sub_field('content');
$video_link = get_sub_field('video_link');
$video_description = get_sub_field('video_description');
$video_thumbnail = get_sub_field('video_thumbnail');
?>

<?php
if ($content || $video_link) :
    echo $opening_tag;
?>
    <div class="container">
        <div class="columns">
            <div class="column content-column" <?= $text_color_attribute ?>>
                <?= $content ?>
            </div>
            <div class="column video-column">
                <?php if ($video_link) : ?>
                    <div class="video-wrapper">
                        <?php if ($video_thumbnail) : ?>
                            <a href="<?= $video_link ?>" class="popup-video" aria-label="<?= esc_attr($video_description) ?>">
                                <?php // Perf remediation (item D): responsive srcset + intrinsic dimensions + lazy-load.
                                echo wp_get_attachment_image($video_thumbnail['ID'], 'large', false, array(
                                    'alt'      => $video_thumbnail['alt'] ?? '',
                                    'loading'  => 'lazy',
                                    'decoding' => 'async',
                                )); ?>
                            </a>
                        <?php else : ?>
                            <a href="<?= $video_link ?>" class="popup-video" aria-label="<?= esc_attr($video_description) ?>">
                                Watch Video
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <span class="container-settings" aria-hidden="true" data-container-width="wide" data-nosnippet>
            <span class="validator-text" data-nosnippet>container settings</span>
        </span>
    </div>
    <span class="module-settings" aria-hidden="true" data-nosnippet>
        <?= $module_padding_settings_tag ?>
        <?= $module_background_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>