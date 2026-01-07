<?php
    // We only want the featured post to display on the posts archive page 1, not on any subsequent pages or filter form results:
    if (
        !is_paged() && 
        !isset($_GET['post-category']) && 
        !isset($_GET['post-tags']) && 
        !isset($_GET['post-date']) &&
        get_field('featured_post', get_option('page_for_posts'))
    ) : 
        $featured_post = get_field('featured_post', get_option('page_for_posts'));
        $post_id = $featured_post->ID;

        //use the post ID to get the featured image ID
        $post_image_id = get_post_thumbnail_id($post_id); 

        //based on if we actually have an image, configure the settings we'll use later:
        if ($post_image_id) {
            $post_listing_column_count = 'two';

            //assign a post image size, these are set up in library/custom-theme/php/initialization.php
            $post_image_size_name = 'medium-square';

            //use featured image ID & size name to grab all the relevant info:
            $post_image_url = wp_get_attachment_image_url($post_image_id, $post_image_size_name);
            $post_image_width = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[1];
            $post_image_height = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[2];
            $post_image_alt = get_post_meta($post_image_id, '_wp_attachment_image_alt', TRUE);
        } else {
            $post_listing_column_count = 'one';
        }

        //post title, date, author info:
        $post_title = get_the_title($post_id);
        $post_date = get_the_date('F j, Y',$post_id);
        $post_date_datetime_format = get_the_date('Y-m-d',$post_id);
        $post_author_id = get_post_field('post_author', $post_id);
        $post_author_name = get_the_author_meta('display_name', $post_author_id);

        //excerpt:
        if (get_the_excerpt($post_id)) {
            $post_excerpt = get_the_excerpt($post_id);
        } 
?>
<section class="featured-post">
    <div class="container">
        <h2>Featured Article</h2>
        <article>
            <div class="content-row">
                <div class="columns">
                    <?php
                        if ($post_image_id) :
                            //if image exists, 2 column layout for listing:
                    ?>
                            <div 
                                class="column left one-third"
                                data-mobile-hide="true"
                            >
                                <figure>
                                    <a href="<?= get_the_permalink($post_id) ?>">
                                        <img src="<?= $post_image_url ?>" height="<?= $post_image_height ?>" width="<?= $post_image_width ?>" alt="<?= $post_image_alt ?>"> 
                                    </a>
                                </figure>
                            </div>
                            <div class="column right two-thirds">
                                <?php 
                                    //title, time, author, & mobile featured image
                                ?>
                                <h3><a href="<?= get_the_permalink($post_id) ?>"><?= $post_title ?></a></h3>
                                <time datetime="<?= $post_date_datetime_format ?>"><?= $post_date ?></time>
                                <span class="author">Author: <?= $post_author_name ?></span>
                                <figure data-desktop-hide="true">
                                    <a href="<?= get_the_permalink($post_id) ?>">
                                        <img src="<?= $post_image_url ?>" height="<?= $post_image_height ?>" width="<?= $post_image_width ?>" alt="<?= $post_image_alt ?>"> 
                                    </a>
                                </figure>
                                <?php
                                    //post the excerpt if it exists:                            
                                    if ($post_excerpt) :
                                ?>
                                        <blockquote 
                                            class="excerpt" 
                                            cite="<?= get_the_permalink($post_id) ?>"
                                        >
                                            <?= $post_excerpt ?>
                                        </blockquote>
                                <?php
                                    endif;

                                    //spit out the widgetized category & tags lists
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $post_id));
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => $post_id));
                                ?>
                                <a href="<?= get_the_permalink($post_id) ?>" class="button">Read Article</a>                    
                            </div>
                    <?php
                        else: 
                            //if there's no image, just a single column:
                    ?>
                            <div class="column">
                                <?php 
                                    //title, time, author
                                ?>
                                <h3><a href="<?= get_the_permalink($post_id) ?>"><?= $post_title ?></a></h3>
                                <time datetime="<?= $post_date_datetime_format ?>"><?= $post_date ?></time>
                                <span class="author">Author: <?= $post_author_name ?></span>
                                <?php
                                    //post the excerpt if it exists:
                                    if ($post_excerpt) :
                                ?>
                                        <blockquote 
                                            class="excerpt" 
                                            cite="<?= get_the_permalink($post_id) ?>"
                                        >
                                            <?= $post_excerpt ?>
                                        </blockquote>
                                <?php
                                    endif;

                                    //spit out the widgetized category & tags lists
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $post_id));
                                    echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => $post_id));
                                ?>
                                <a href="<?= get_the_permalink($post_id) ?>" class="button">Read Article</a>
                            </div>
                    <?php
                        endif;
                    ?>
                </div>
                <span 
                    class="row-settings" 
                    data-column-count="<?= $post_listing_column_count ?>" 
                    data-column-width="variable" 
                >
                    <span class="validator-text" data-nosnippet>row settings</span>
                </span>
            </div>
        </article>
        <span 
            class="container-settings"
            data-container-width="standard" 
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span 
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single"
    >
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</section>
<?php
    endif;
?>