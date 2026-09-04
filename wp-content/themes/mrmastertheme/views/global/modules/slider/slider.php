<?php
$tag_type = get_sub_field('tag_type');

$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

$closing_tag = '</' . $tag_type . '>';

if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="slider ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="slider">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="slider ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="slider">';
}

$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

$background_settings = get_sub_field('background');
$background_type = $background_settings['background_type'];

if ($background_type === 'color') {
    $background_color = $background_settings['background_color'];

    $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
} else if ($background_type === 'image') {
    $background_image = $background_settings['background_image'];
    $background_image_url = $background_image['url'];
    $background_image_position = $background_settings['background_image_position'];

    if ($background_settings['include_overlay']) {
        $background_image_overlay = $background_settings['overlay_color'];

        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else {
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    }
} else {
    $background_settings_tag = '';
}

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

$intro_content = get_sub_field('intro_content');
$slides = get_sub_field('slides');

$random_integer = rand(0, 999);
?>

<?php
if ($slides) :
    echo $opening_tag;
?>
    <div class="container" <?= $text_color_attribute ?>>
        <?php if ($intro_content) : ?>
            <div class="intro-content">
                <?= $intro_content ?>
            </div>
        <?php endif; ?>

        <div id="module-slider-<?= $random_integer ?>" class="slides-row">
            <?php foreach ($slides as $slide) : ?>
                <div class="slide">
                    <?= $slide['slide'] ?>
                </div>
            <?php endforeach; ?>
            <div id="append-arrows-<?= $random_integer ?>" class="arrows-row">
                <span class="container-settings" aria-hidden="true">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
        <span class="container-settings" aria-hidden="true" data-container-width="wide">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span class="slider-settings">
        <script>
            jQuery('#module-slider-<?= $random_integer ?>').slick({
                appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                arrows: true,
                autoplay: false,
                dots: false,
                infinite: true,
                rows: 0,
                slide: '.slide',
                slidesToScroll: 1,
                slidesToShow: 5,
                responsive: [{
                        breakpoint: 1600,
                        settings: {
                            slidesToShow: 4,
                        }
                    },
                    {
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 3,
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                ],
            });
        </script>
        <span class="validator-text" data-nosnippet>settings</span>
    </span>
    <span class="module-settings" aria-hidden="true" data-nosnippet>
        <?= $padding_settings_tag ?>
        <?= $background_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>