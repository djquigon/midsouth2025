<?php
    $project_id = $args['id'];

    //grab the project categories
    $project_categories = get_the_terms($project_id, 'project_category');

    if ($project_categories) :
?>
        <ul
            class="project-categories" 
            data-flex="flex"
            data-flex-wrap="wrap"
        >
            <?php
                foreach ($project_categories as $category) :  
                    $category_id = $category->term_id;
                    $category_name = $category->name;
            ?>
                    <li>
                        <a href="/projects/?project-search=&project-category=<?= $category_id?>"><?= $category_name ?></a> 
                    </li>
            <?php
                endforeach;
            ?>
        </ul>
<?php
    endif; 
?>