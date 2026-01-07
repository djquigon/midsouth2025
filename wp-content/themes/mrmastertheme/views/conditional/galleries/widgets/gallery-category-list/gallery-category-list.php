<?php
    $gallery_id = $args['id'];

    //grab the gallery categories
    $gallery_categories = get_the_terms($gallery_id, 'gallery_category');

    if ($gallery_categories) :
?>
        <ul
            class="gallery-categories" 
            data-flex="flex"
            data-flex-wrap="wrap"
        >
            <?php
                foreach ($gallery_categories as $category) :  
                    $category_id = $category->term_id;
                    $category_name = $category->name;
            ?>
                    <li>
                        <a href="/galleries/?gallery-search=&gallery-category=<?= $category_id?>"><?= $category_name ?></a> 
                    </li>
            <?php
                endforeach;
            ?>
        </ul>
<?php
    endif; 
?>