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
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="locations ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="locations">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="locations ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="locations">';
}

//grab the top & bottom padding settings values, for both desktop & mobile
$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

//build out the padding settings <span> HTML:
$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

//grab the container width from settings
$container_width = get_sub_field('container_width');

//declare variables for content
$intro_content = get_sub_field('intro_content');
$locations = get_sub_field('locations');
if (!$locations) {
    $locations = get_posts(array(
        'post_type' => 'mandr_location',
        'posts_per_page' => -1,
    ));
}

//we're only generating HTML if the module has locations to display
if ($locations) :
    echo $opening_tag;
?>
    <?php if ($intro_content) : ?>
        <div class="intro-content-row">
            <div class="container">
                <?= $intro_content ?>
                <span class="container-settings" data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
    <?php endif; ?>
    <div class="locations-container container">
        <div class="locations-grid">
            <?php
            foreach ($locations as $location) :
                $location_id = is_object($location) ? $location->ID : (int) $location;
                $location_link = get_permalink($location_id);
                $location_title = get_the_title($location_id);

                $location_image_size_name = 'full';
                $location_image_id = get_post_thumbnail_id($location_id);
                $location_image_url = '';
                $location_image_alt = '';

                if ($location_image_id) {
                    $location_image_url = wp_get_attachment_image_url($location_image_id, $location_image_size_name);
                    $location_image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', true);
                }

                //Get location_info fields for directions & review links
                $location_info = get_field('location_info', $location_id);
                $geolocation = $location_info['geolocation'] ?? null;
                $review_link = $location_info['review_link'] ?? null;
                $directions_url = null;
                if ($geolocation && !empty($geolocation['address'])) {
                    $directions_url = 'https://www.google.com/maps/search/' . urlencode($geolocation['address']);
                } else {
                    $directions_url = null;
                }
            ?>
                <div class="location-card">
                    <a href="<?= esc_url($location_link); ?>" class="location-card-link" aria-label="<?= esc_attr($location_title); ?>"></a>
                    <span class="location-image">
                        <?php if ($location_image_id) :
                            // Perf remediation (item D): emit srcset + intrinsic width/height + lazy-loading
                            // instead of a raw full-size <img>. Grid cards are never the LCP, so lazy is safe;
                            // width/height also curbs layout shift (CLS).
                            echo wp_get_attachment_image($location_image_id, 'large', false, array(
                                'alt'      => $location_image_alt,
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                            ));
                        endif; ?>
                    </span>
                    <div class="location-content">
                        <h3 class="location-title"><?= esc_html($location_title); ?></h3>
                        <div class="location-links">
                            <?php if ($directions_url) : ?>
                                <a href="<?= esc_url($directions_url); ?>" target="_blank" class="location-link button button--clear">Get Directions</a>
                            <?php endif; ?>
                            <?php if ($review_link) : ?>
                                <a href="<?= esc_url($review_link); ?>" target="_blank" class="location-link button button--clear">Leave Us a Review</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="<?= esc_url($location_link); ?>" class="button">See Location Details</a>
                </div>
            <?php
            endforeach;
            ?>
        </div>
        <span class="container-settings" data-container-width="<?= $container_width ?>">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span class="module-settings" data-nosnippet>
        <?= $padding_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>