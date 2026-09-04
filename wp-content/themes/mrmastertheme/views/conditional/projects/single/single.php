<?php
//we're using a title-area specific to the project post type:
echo get_template_part('views/conditional/projects/single/title-area/title-area');

$project_id = get_the_ID();
$project_video_link = get_field('video_link', $project_id);
$project_video_description = get_field('video_description', $project_id);
$project_poster_image = get_field('poster_image', $project_id);
$project_featured_image_id = get_post_thumbnail_id($project_id);

if ($project_poster_image) {
    $poster_image_array = array(
        'poster_image_url' => $project_poster_image['url'],
        'poster_image_width' => $project_poster_image['width'],
        'poster_image_height' => $project_poster_image['height'],
        'poster_image_alt' => $project_poster_image['alt'],
    );
} elseif ($project_featured_image_id) {
    $poster_image_array = array(
        'poster_image_url' => wp_get_attachment_image_url($project_featured_image_id, 'full'),
        'poster_image_width' => wp_get_attachment_image_src($project_featured_image_id, 'full')[1],
        'poster_image_height' => wp_get_attachment_image_src($project_featured_image_id, 'full')[2],
        'poster_image_alt' => get_post_meta($project_featured_image_id, '_wp_attachment_image_alt', true),
    );
} else {
    $poster_image_array = array();
}

if ($project_video_link || $project_featured_image_id) :
?>
    <section class="project-media">
        <div class="container">
            <?php if ($project_video_link) : ?>
                <?= mandr_video_player($project_video_link, $poster_image_array, $project_video_description, 'project-video-' . $project_id) ?>
            <?php elseif ($project_featured_image_id) : ?>
                <?= get_the_post_thumbnail($project_id, 'full') ?>
            <?php endif; ?>
            <span class="container-settings" aria-hidden="true" data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
        <span
            class="padding"
            data-top-padding-desktop="none"
            data-bottom-padding-desktop="double"
            data-top-padding-mobile="single"
            data-bottom-padding-mobile="single">
            <span class="validator-text" data-nosnippet>padding settings</span>
        </span>
    </section>
<?php
endif;

//spit out all the individual page sections (modules)
echo get_template_part('views/global/modules/modules');

?>
<section class="breadcrumbs-row">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="<?= get_post_type_archive_link('mandr_project') ?>">
                < Back to Case Studies
                    </a>
        </nav>
        <span class="container-settings" aria-hidden="true" data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
</section>
<?php

$final_callout = get_field('final_callout', $project_id);

if ($final_callout) :
?>
    <section class="callout" data-callout-icon="default">
        <div class="container">
            <div class="content">
                <?= $final_callout ?>
            </div>
            <span class="container-settings" aria-hidden="true" data-container-width="standard" data-nosnippet>
                <span class="validator-text">settings</span>
            </span>
        </div>
        <div class="callout-decoration"><iframe src="https://my.spline.design/waveformcopy-4OwuYzFFRMfnPcsfWtTNwPgX/" style="width:100%;height:100%;border:none" loading="lazy" referrerpolicy="no-referrer" sandbox="allow-same-origin allow-scripts allow-downloads allow-forms allow-modals allow-orientation-lock allow-pointer-lock allow-popups allow-popups-to-escape-sandbox allow-presentation allow-top-navigation-by-user-activation"></iframe>
        </div>
        <span class="module-settings" aria-hidden="true" data-nosnippet>
            <span
                class="padding"
                data-top-padding-desktop="double"
                data-bottom-padding-desktop="double"
                data-top-padding-mobile="single"
                data-bottom-padding-mobile="single">
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
            <span class="validator-text">module settings</span>
        </span>
    </section>
<?php
endif;
