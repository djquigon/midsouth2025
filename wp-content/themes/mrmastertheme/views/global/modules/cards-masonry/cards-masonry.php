<?php
$tag_type = get_sub_field('tag_type');

$unique_identifiers = get_sub_field('unique_identifiers');
$module_id = $unique_identifiers['id'];
$module_class_names = $unique_identifiers['class_names'];

$background_type = get_sub_field('background_type'); //true = clear background, false = image background

if ($background_type) {
    $background_type_class = 'background-clear';
} else {
    $background_type_class = '';
}

$closing_tag = '</' . $tag_type . '>';

if ($module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="cards-masonry ' . $module_class_names . ' ' . $background_type_class . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="cards-masonry ' . $background_type_class . '">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="cards-masonry ' . $module_class_names . ' ' . $background_type_class . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="cards-masonry ' . $background_type_class . '">';
}

$container_width = get_sub_field('container_width');

$padding_settings = get_sub_field('padding');
$top_padding_desktop = $padding_settings['top_padding_desktop'];
$bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
$top_padding_mobile = $padding_settings['top_padding_mobile'];
$bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

$padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';

$intro_content = get_sub_field('intro_content');
$cards = get_sub_field('cards');
$outro_content = get_sub_field('outro_content');
?>

<?php
if ($cards) :
    echo $opening_tag;
?>
    <div class="container">
        <?php if ($intro_content) : ?>
            <div class="intro-content">
                <?= $intro_content ?>
            </div>
        <?php endif; ?>

        <div class="masonry-items">
            <?php foreach ($cards as $card) :
                $card_content = $card['content'];
                $card_content = mandr_change_heading_tag($card_content, 'h5', 'h3', 'h5');
                $card_content = mandr_change_heading_tag($card_content, 'h6', 'h3', 'h6');
                $card_link = $card['link'];
                $card_item_class = $card_link ? 'masonry-item has-link' : 'masonry-item';
            ?>
                <div class="<?= $card_item_class ?>">
                    <?php if ($card_link) : ?>
                        <a href="<?= $card_link ?>" class="masonry-item-link masonry-item-content">
                            <?= $card_content ?>
                        </a>
                    <?php else : ?>
                        <div class="masonry-item-content">
                            <?= $card_content ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <span class="container-settings" aria-hidden="true" data-container-width="<?= $container_width ?>" data-nosnippet>
            <span class="validator-text">settings</span>
        </span>
    </div>
    <?php if ($outro_content) : ?>
        <div class="container">
            <div class="outro-content">
                <?= $outro_content ?>
            </div>
            <span class="container-settings" aria-hidden="true" data-container-width="<?= $container_width ?>" data-nosnippet>
                <span class="validator-text">settings</span>
            </span>
        </div>
    <?php endif; ?>
    <span class="module-settings" aria-hidden="true" data-nosnippet>
        <?= $padding_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>
