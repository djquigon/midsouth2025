<?php
    $resource_id = $args['id'];

    //grab the resource categories
    $resource_categories = get_the_terms($resource_id, 'resource_category');

    if ($resource_categories) :
?>
        <ul
            class="resource-categories" 
            data-flex="flex"
        >
            <?php
                foreach ($resource_categories as $category) :  
                    $category_id = $category->term_id;
                    $category_name = $category->name;
            ?>
                    <li>
                        <a href="/resources/?resource-search=&resource-category=<?= $category_id?>"><?= $category_name ?></a> 
                    </li>
            <?php
                endforeach;
            ?>
        </ul>
<?php
    endif; 
?>