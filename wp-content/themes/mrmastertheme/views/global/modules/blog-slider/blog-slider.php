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
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="blog-slider ' . $module_class_names . '">';
} else if ($module_id && !$module_class_names) {
    $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="blog-slider">';
} else if (!$module_id && $module_class_names) {
    $opening_tag = '<' . $tag_type . ' class="blog-slider ' . $module_class_names . '">';
} else {
    $opening_tag = '<' . $tag_type . ' class="blog-slider">';
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
$articles_category = get_sub_field('articles_category'); //acf taxonomy field

if ($articles_category) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $articles_category,
            ),
        ),
    );
    $articles = new WP_Query($args);
} else {
    $articles = get_sub_field('articles');
    if (!$articles) {
        $articles = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
    }
}



//we're only generating HTML if the module has articles to display
if ($articles) :
    echo $opening_tag;
    //prevent duplicate IDs when multiple sliders exist on the same page
    $random_integer = rand(0, 999);
?>
    <?php if ($intro_content) : ?>
        <div class="intro-content-row">
            <div class="container">
                <div class="content-wrapper">
                    <?= $intro_content ?>
                </div>
                <span class="container-settings" data-container-width="<?= $container_width ?>">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
    <?php endif; ?>
    <div class="slick-wrapper">
        <div id="blog-carousel-arrows-<?= $random_integer; ?>" class="slider-arrows container">
            <!-- Slick arrows will be appended here -->
        </div>
        <div id="blog-carousel-<?= $random_integer; ?>" class="blog-carousel-row container">
            <?php
            foreach ($articles as $article) :
                $article_id = $article->ID;
                $article_link = get_permalink($article_id);
                $article_title = get_the_title($article_id);
                $article_featured_image = get_the_post_thumbnail_url($article_id, 'full');
                $article_featured_image_alt = get_post_meta($article_featured_image, '_wp_attachment_image_alt', true);
            ?>
                <div class="blog-slide">
                    <figure class="blog-image <?= !$article_featured_image ? 'blog-image--fallback' : '' ?>">
                        <a href="<?= $article_link ?>">
                            <?php if ($article_featured_image) : ?>
                                <?php // Perf remediation (item D): responsive srcset + intrinsic dimensions (alt pulled from
                                // the attachment automatically). Kept eager — this is a slider, so the first slide is visible.
                                echo get_the_post_thumbnail($article_id, 'large', array('decoding' => 'async')); ?>
                            <?php else : ?>
                                <img
                                    src="/wp-content/themes/mrmastertheme/library/custom-theme/images/logos/logo.svg"
                                    alt="<?= get_bloginfo('name') ?>">
                            <?php endif; ?>
                        </a>
                    </figure>
                    <div class="blog-content">
                        <h4 class="blog-title">
                            <a href="<?= $article_link; ?>"><?= $article_title; ?></a>
                        </h4>
                        <a href="<?= $article_link; ?>" class="button button--clear">Read Article</a>
                    </div>
                </div>
            <?php
            endforeach;
            ?>
            <span
                class="container-settings"
                data-container-width="<?= $container_width ?>">
                <span class="validator-text" data-nosnippet>container settings</span>
            </span>
        </div>
    </div>
    <span class="slider-settings">
        <script>
            jQuery('#blog-carousel-<?= $random_integer ?>').slick({
                arrows: true,
                appendArrows: '#blog-carousel-arrows-<?= $random_integer ?>',
                //autoplay: true,
                dots: false,
                adaptiveHeight: false,
                responsive: [{
                        breakpoint: 1280,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                        },
                    },
                    {
                        breakpoint: 769,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
                rows: 0,
                slide: '.blog-slide',
                slidesToScroll: 1,
                slidesToShow: 3,
            });
        </script>
        <span class="validator-text" data-nosnippet>slider settings</span>
    </span>
    <span class="module-settings" data-nosnippet>
        <?= $padding_settings_tag ?>
        <span class="validator-text">module settings</span>
    </span>
<?php
    echo $closing_tag;
endif;
?>