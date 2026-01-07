<?php
    $post_id = $args['id'];

    if (get_the_terms($post_id,'category')) {
        $post_categories = get_the_terms($post_id,'category');
    } else {
        $post_categories = false;
    }   

    if ($post_categories) :
?>
        <ul 
            class="post-categories" 
            data-flex="flex"
        >
<?php
            foreach ($post_categories as $category) :  
                $category_id = $category->term_id;
                $category_name = $category->name;
?>
                <li>
                    <a href="<?= get_term_link($category_id)?>"><?= $category_name ?></a> 
                </li>
<?php
            endforeach;
?>
        </ul>
<?php
    endif;
?>