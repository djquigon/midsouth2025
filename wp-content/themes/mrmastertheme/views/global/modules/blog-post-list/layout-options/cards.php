<?php
    //first we set up the arguments passed from the blogs module's main php file:
    $module_title = $args['module_title'];

    $articles = $args['articles'];

    $column_count = $args['column_count'];

    $overlay_content = $args['overlay_content'] ? 'content-overlay' : '';

    $text_color_attribute = $args['text_color_attribute'];

    $container_width = $args['container_width'];

    $all_blogs_button = $args['all_blogs_button'];
    $all_blogs_button_text = $all_blogs_button['button_text'];
    $all_blogs_button_link = $all_blogs_button['button_link'];

    //if a title is set, print it:
    if ($module_title) :
?>
        <div class="title-view-all-row">
            <div class="container" <?= $text_color_attribute ?>>
                <?= '<h2>' . $module_title . '</h2>'; ?>
                <?php
                //if we've got both fields set for the button, print it (desktop view only)
                if ($all_blogs_button_text && $all_blogs_button_link) :
                ?>
                    <a href="<?= $all_blogs_button_link ?>" class="button" data-mobile-hide="true"><?= $all_blogs_button_text ?></a>
                <?php
                endif;
                ?>
                <span
                    class="container-settings"

                    data-container-width="<?= $container_width ?>"
                    data-flex="flex"
                    data-justify-content="space-between">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;

    if ($articles) :
?>
        <div class="articles-row">
            <ul class="articles-list columns <?= $overlay_content ?>" <?= $text_color_attribute ?>>
                <?php
                    foreach ($articles as $article) :
                        // Both ACF post object fields and get_posts() return post objects
                        $title = get_the_title($article->ID);
                        $excerpt = get_the_excerpt($article->ID);
                        $permalink = get_the_permalink($article->ID);
                        $publish_date = get_the_date('F j, Y', $article->ID);
                        $publish_date_datetime = get_the_date('Y-m-d', $article->ID);
                        $categories = get_the_category($article->ID);

                        //use the post ID to get the featured image ID
                        $post_image_id = get_post_thumbnail_id($article->ID); 

                        //based on if we actually have an image, configure the settings we'll use later:
                        if ($post_image_id) { 

                            //assign a post image size, these are set up in library/custom-theme/php/initialization.php
                            $post_image_size_name = 'medium-square';

                            //use featured image ID & size name to grab all the relevant info:
                            $post_image_url = wp_get_attachment_image_url($post_image_id, $post_image_size_name);
                            $post_image_width = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[1];
                            $post_image_height = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[2];
                            $post_image_alt = get_post_meta($post_image_id, '_wp_attachment_image_alt', TRUE);
                        }  
                ?>
                        <li class="column">
                            <?php
                                if ($overlay_content) {
                                    echo get_template_part('views/global/modules/blog-post-list/components/card-overlay', null, array('id' => $article->ID, 'trim_excerpt' => true));
                                } else {
                                    echo get_template_part('views/global/modules/blog-post-list/components/card-standard', null, array('id' => $article->ID, 'trim_excerpt' => true));
                                }
                            ?>
                        </li>
                <?php
                    endforeach;
                ?>
            </ul>
            <span
                class="row-settings"
                data-container-width="<?= $container_width ?>"
                data-column-count="<?= $column_count ?>"
                data-column-gap="large"
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
<?php
    endif;

    //if we've got both fields set for the button, print it (mobile view only)
    if ($all_blogs_button_text && $all_blogs_button_link) :
?>
        <div class="all-button-row" data-desktop-hide="true">
            <div class="container">
                <a href="<?= $all_blogs_button_link ?>" class="button"><?= $all_blogs_button_text ?></a>
                <span
                    class="container-settings"
                    data-container-width="<?= $container_width ?>"
                    data-flex="flex"
                    data-justify-content="center">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;
?>