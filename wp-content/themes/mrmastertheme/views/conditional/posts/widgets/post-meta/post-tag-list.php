<?php
    $post_id = $args['id'];

    if (get_the_terms($post_id,'post_tag')) {
        $post_tags = get_the_terms($post_id,'post_tag');
    } else {
        $post_tags = false;
    }   

    if ($post_tags) :
?>
        <ul 
            class="post-tags" 
            data-flex="flex"
        >
<?php
            foreach ($post_tags as $tag) :  
                $tag_id = $tag->term_id;
                $tag_name = $tag->name;
?>
                <li>
                    <a href="<?= get_the_permalink(get_option('page_for_posts')) ?>?post-tags=<?= $tag_id ?>"><?= $tag_name ?></a> 
                </li>
<?php
            endforeach;
?>
        </ul>
<?php
    endif;
?>