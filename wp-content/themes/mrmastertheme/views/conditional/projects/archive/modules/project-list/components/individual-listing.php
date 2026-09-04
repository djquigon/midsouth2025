<?php
$project_id = $args['id'];

//project permalink
$project_permalink = get_the_permalink($project_id);

//project title
$project_title = get_the_title($project_id);

//assign a post image size, these are set up in library/custom-theme/php/initialization.php
$project_image_size_name = 'full';
$project_image_url = false;
$project_image_width = false;
$project_image_height = false;
$project_image_alt = '';
$default_project_image = get_stylesheet_directory_uri() . '/library/custom-theme/images/featured.jpg';
$poster_image = get_field('poster_image', $project_id);

//use the project ID to get the featured image ID, if it's set.
if (get_post_thumbnail_id($project_id)) {
    $project_image_id = get_post_thumbnail_id($project_id);

    //use featured image ID & size name to grab all the relevant info:
    $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
    $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
    $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
    $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', TRUE);
} elseif ($poster_image) {
    $project_image_url = $poster_image['url'];
    $project_image_width = $poster_image['width'];
    $project_image_height = $poster_image['height'];
    $project_image_alt = $poster_image['alt'];
} else {
    $project_image_id = false;
}

if (!$project_image_url) {
    $project_image_url = $default_project_image;
    $project_image_width = 1024;
    $project_image_height = 1024;
    $project_image_alt = $project_title;
}

//excerpt:
$project_excerpt = get_the_excerpt($project_id);
?>
<li>
    <article>
        <?php
        ?>
        <figure>
            <a href="<?= $project_permalink ?>">
                <img
                    src="<?= $project_image_url ?>"
                    height="<?= $project_image_height ?>"
                    width="<?= $project_image_width ?>"
                    alt="<?= $project_image_alt ?>">
            </a>
        </figure>
        <?php
        ?>
        <h3>
            <a href="<?= $project_permalink ?>">
                <?= $project_title ?>
            </a>
        </h3>
        <?php
        //post the excerpt if it exists:                            
        if ($project_excerpt) :
        ?>
            <blockquote
                class="excerpt"
                cite="<?= $project_permalink ?>">
                <?= $project_excerpt ?>
            </blockquote>
        <?php
        endif;

        //spit out the widgetized project category list:
        echo get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => $project_id));
        ?>
        <a href="<?= $project_permalink ?>" class="button">
            View Project
        </a>
    </article>
</li>