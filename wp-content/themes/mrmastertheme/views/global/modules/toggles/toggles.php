<?php
$section_id = get_sub_field('section_id');
$section_classes = get_sub_field('section_classes');
$toggles = get_sub_field('toggles'); // repeater
$module_title = get_sub_field('module_title');
$container_width = get_sub_field('container_width');

//in case we need an ID or additional class names:
$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

//build out the opening tag HTML:
if ($module_id && $module_class_names) {
    $opening_tag = '<section id="' . $module_id . '" class="toggles ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<section id="' . $module_id . '" class="toggles">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<section class="toggles ' . $module_class_names . '">';
} else {
    $opening_tag = '<section class="toggles">';
}

//build out the closing tag HTML
$closing_tag = '</section>';

//grab the top & bottom padding settings values, for both desktop & mobile
$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

//build out the padding settings <span> HTML:
$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span data-nosnippet class="validator-text">padding settings</span></span>';

//establish the background settings
$background_settings = get_sub_field('background');
$background_type = $background_settings['background_type'];

if ($background_type === 'color') {
    $background_color = $background_settings['background_color'];

    //build out the background settings <span> HTML:
    $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text">background settings</span></span>';
} else if ($background_type === 'image') {
    $background_image = $background_settings['background_image'];
    $background_image_url = $background_image['url'];
    $background_image_position = $background_settings['background_image_position'];

    //use an overlay if it's set up:
    if ($background_settings['include_overlay']) {
        $background_image_overlay = $background_settings['overlay_color'];

        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text">background settings</span></span>';
    } else {
        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text">background settings</span></span>';
    }
} else {
    //transparent background, so no need for settings <span> HTML:
    $background_settings_tag = '';
}

//only output HTML if we have cards to display
if ($toggles) :
    echo $opening_tag;
?>
    <?php if ($module_title) :
    ?>
        <header class="intro-content-row">
            <div class="container">
                <?php
                if ($module_title) {
                    echo '<h2>' . $module_title . '</h2>';
                }
                ?>
                <span
                    class="container-settings"
                    data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </header>
    <?php
    endif;
    ?>
    <div class="toggles__container container">
        <span
            class="container-settings"
            data-container-width="<?= $container_width ?>">
            <span class="validator-text">settings</span>
        </span>
        <?php
        foreach ($toggles as $toggle) :

            $title = $toggle['title']; // text
            $content = $toggle['content']; // WYSIWYG
        ?>
            <div class="toggle">
                <button class="toggle__trigger" aria-expanded="false">
                    <span class="toggle__trigger-text screenreader-only" data-show="display" data-hide="collapse"></span>
                    <?= $title; ?>
                    <span class="toggle__trigger-icon" aria-hidden="true"></span>
                </button>
                <div class="toggle__box" aria-hidden="true">
                    <?= $content ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <span class="module-settings">
        <?= $padding_settings_tag ?>
        <?= $background_settings_tag ?>
    </span>
<?php
    echo $closing_tag;
endif;
?>