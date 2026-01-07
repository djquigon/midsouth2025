<?php
    //this file is referenced also by the Post single view's 'Similar Articles' module

    //grab the post ID from the template's arguments
    $post_id = $args['id'];

    //permalink
    $post_permalink = get_the_permalink($post_id);


    //post image size:
    $post_image_size_name = 'medium-portrait';

    //featured image data:
    if (get_post_thumbnail_id($post_id)) {
        $post_image_id = get_post_thumbnail_id($post_id);         
    } elseif(!get_post_thumbnail_id($post_id) && get_field('featured_image_fallback' , 'options')) {
        $post_image_id = get_field('featured_image_fallback' , 'options');         
    } else {
        $post_image_id = false;
    }
    

    //use featured image ID & size name to grab all the relevant info:
    if ($post_image_id) {
        $post_image_url = wp_get_attachment_image_url($post_image_id, $post_image_size_name);
        $post_image_width = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[1];
        $post_image_height = wp_get_attachment_image_src($post_image_id, $post_image_size_name)[2];
        $post_image_alt = get_post_meta($post_image_id, '_wp_attachment_image_alt', TRUE);
    }

    //title
    $post_title = get_the_title($post_id);

    //date
    $post_date = get_the_date('F j, Y',$post_id);
    $post_date_datetime_format = get_the_date('Y-m-d',$post_id);

    //excerpt:
    if (get_the_excerpt($post_id)) {
        $post_excerpt = get_the_excerpt($post_id);
    } 
?>

<article data-card-style="standard">
    <header>
        <?php
            if ($post_image_id) :
        ?>
                <figure>
                    <a href="<?= $post_permalink ?>">
                        <img src="<?= $post_image_url ?>" height="<?= $post_image_height ?>" width="<?= $post_image_width ?>" alt="<?= $post_image_alt ?>"> 
                    </a>
                </figure>
        <?php
            endif;
        ?>
        <h3>
            <a href="<?= $post_permalink ?>">
                <?= $post_title ?>
            </a>
        </h3>
        <time datetime="<?= $post_date_datetime_format ?>"><?= $post_date ?></time>
    </header>
    <?php
        //post the excerpt if it exists:                            
        if ($post_excerpt) :
    ?>
            <blockquote 
                class="excerpt" 
                cite="<?= $post_permalink ?>"
            >
                <?php 
                    if ($args['trim_excerpt']) {
                        echo my_string_limit_words($post_excerpt, 20);
                    } else {
                        echo $post_excerpt;
                    }
                ?>
            </blockquote>
    <?php
        endif;
        
        //spit out the widgetized category & tags lists
        echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $post_id));
        echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => $post_id));
    ?>
    <a href="<?= $post_permalink ?>" class="button">Read Article</a>  
</article>