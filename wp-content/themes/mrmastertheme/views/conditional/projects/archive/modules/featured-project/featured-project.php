<?php
// We only want the featured project to display on the project archive page 1, not on filtered or paginated results.
if (
    !is_paged() &&
    !isset($_GET['project-search']) &&
    !isset($_GET['project-category'])
) :
    $featured_project_term = get_term_by('slug', 'featured', 'project_category');

    if (!$featured_project_term) {
        $featured_project_term = get_term_by('name', 'Featured', 'project_category');
    }

    if ($featured_project_term) {
        $featured_projects = get_posts(array(
            'post_type' => 'mandr_project',
            'posts_per_page' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'project_category',
                    'field' => 'term_id',
                    'terms' => array($featured_project_term->term_id),
                ),
            ),
        ));
    } else {
        $featured_projects = array();
    }

    if ($featured_projects) :
        $project_id = $featured_projects[0]->ID;
        $project_permalink = get_the_permalink($project_id);
        $project_title = get_the_title($project_id);
        $project_excerpt = get_the_excerpt($project_id);

        // Use the featured image first, then fall back to the first project media item.
        $project_image_id = false;
        $project_image_url = '';
        $project_image_width = '';
        $project_image_height = '';
        $project_image_alt = '';
        $project_media_is_video = false;
        $video_link = '';
        $video_description = '';
        $video_aria_id = '';
        $poster_image_array = array();
        $poster_image = get_field('poster_image', $project_id);

        if (get_post_thumbnail_id($project_id)) {
            $project_image_id = get_post_thumbnail_id($project_id);
            $project_image_url = wp_get_attachment_image_url($project_image_id, 'full');
            $project_image_width = wp_get_attachment_image_src($project_image_id, 'full')[1];
            $project_image_height = wp_get_attachment_image_src($project_image_id, 'full')[2];
            $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', true);
        } else {
            $video_link = get_field('video_link', $project_id);
            $video_description = get_field('video_description', $project_id);
            $video_aria_id = 'featured-project-video-' . rand(0, 999);

            if ($poster_image) {
                $project_image_url = $poster_image['url'];
                $project_image_width = $poster_image['width'];
                $project_image_height = $poster_image['height'];
                $project_image_alt = $poster_image['alt'];
            } elseif ($video_link && str_contains($video_link, 'youtube')) {
                $youtube_id = youtube_video_id($video_link);
                $project_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
                $project_image_width = 480;
                $project_image_height = 360;
                $project_image_alt = 'default video thumbnail image supplied by YouTube';
            } elseif ($video_link && str_contains($video_link, 'vimeo')) {
                $oembed_endpoint = 'http://vimeo.com/api/oembed';
                $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
                $oembed = simplexml_load_string(curl_get($xml_url));

                if ($oembed && !empty($oembed->thumbnail_url)) {
                    $project_image_url = html_entity_decode($oembed->thumbnail_url);
                    $project_image_width = 640;
                    $project_image_height = 360;
                    $project_image_alt = 'default video thumbnail image supplied by Vimeo';
                }
            }

            if ($video_link && $project_image_url) {
                $project_media_is_video = true;
                $poster_image_array = array(
                    'poster_image_url' => $project_image_url,
                    'poster_image_width' => $project_image_width,
                    'poster_image_height' => $project_image_height,
                    'poster_image_alt' => $project_image_alt,
                );
            }
        }

        $project_listing_column_count = ($project_image_url || $project_media_is_video) ? 'two' : 'one';
?>
        <section class="featured-project curved-top">
            <div class="container">
                <h6 style="color: #00816D;">Featured Project</h6>
                <article>
                    <div class="content-row">
                        <div class="columns">
                            <?php if ($project_image_url || $project_media_is_video) : ?>
                                <div
                                    class="column left"
                                    data-mobile-hide="true">
                                    <?php if ($project_media_is_video) : ?>
                                        <figure>
                                            <?php
                                            echo mandr_video_player(
                                                $video_link,
                                                $poster_image_array,
                                                $video_description,
                                                $video_aria_id
                                            );
                                            ?>
                                        </figure>
                                    <?php else : ?>
                                        <figure>
                                            <a href="<?= esc_url($project_permalink); ?>">
                                                <img
                                                    src="<?= esc_url($project_image_url); ?>"
                                                    height="<?= esc_attr($project_image_height); ?>"
                                                    width="<?= esc_attr($project_image_width); ?>"
                                                    alt="<?= esc_attr($project_image_alt); ?>">
                                            </a>
                                        </figure>
                                    <?php endif; ?>
                                </div>
                                <div class="column right">
                                    <h3><a href="<?= esc_url($project_permalink); ?>"><?= esc_html($project_title); ?></a></h3>
                                    <?php if ($project_media_is_video) : ?>
                                        <figure data-desktop-hide="true">
                                            <?php
                                            echo mandr_video_player(
                                                $video_link,
                                                $poster_image_array,
                                                $video_description,
                                                $video_aria_id . '-mobile'
                                            );
                                            ?>
                                        </figure>
                                    <?php else : ?>
                                        <figure data-desktop-hide="true">
                                            <a href="<?= esc_url($project_permalink); ?>">
                                                <img
                                                    src="<?= esc_url($project_image_url); ?>"
                                                    height="<?= esc_attr($project_image_height); ?>"
                                                    width="<?= esc_attr($project_image_width); ?>"
                                                    alt="<?= esc_attr($project_image_alt); ?>">
                                            </a>
                                        </figure>
                                    <?php endif; ?>
                                    <?php if ($project_excerpt) : ?>
                                        <blockquote
                                            class="excerpt"
                                            cite="<?= esc_url($project_permalink); ?>">
                                            <?= esc_html($project_excerpt); ?>
                                        </blockquote>
                                    <?php endif; ?>
                                    <?php get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => $project_id)); ?>
                                    <a href="<?= esc_url($project_permalink); ?>" class="button">View Project</a>
                                </div>
                            <?php else : ?>
                                <div class="column">
                                    <h3><a href="<?= esc_url($project_permalink); ?>"><?= esc_html($project_title); ?></a></h3>
                                    <?php if ($project_excerpt) : ?>
                                        <blockquote
                                            class="excerpt"
                                            cite="<?= esc_url($project_permalink); ?>">
                                            <?= esc_html($project_excerpt); ?>
                                        </blockquote>
                                    <?php endif; ?>
                                    <?php get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => $project_id)); ?>
                                    <a href="<?= esc_url($project_permalink); ?>" class="button">View Project</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <span
                            class="row-settings"
                            data-column-count="<?= esc_attr($project_listing_column_count); ?>"
                            data-column-width="variable">
                            <span class="validator-text" data-nosnippet>row settings</span>
                        </span>
                    </div>
                </article>
                <span
                    class="container-settings" aria-hidden="true"
                    data-container-width="standard">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
            <span
                class="padding"
                data-top-padding-desktop="double"
                data-bottom-padding-desktop="double"
                data-top-padding-mobile="single"
                data-bottom-padding-mobile="single">
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
        </section>
<?php
    endif;
endif;
?>