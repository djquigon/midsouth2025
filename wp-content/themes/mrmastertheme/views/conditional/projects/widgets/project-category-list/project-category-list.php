<?php
$project_id = $args['id'];
$project_archive_link = get_post_type_archive_link('mandr_project');

// grab the project categories
$project_categories = get_the_terms($project_id, 'project_category');

if ($project_categories) :
?>
    <ul class="project-categories">
        <?php
        foreach ($project_categories as $category) :
            $category_id = $category->term_id;
            $category_name = $category->name;
            $category_link = add_query_arg(array(
                'project-search' => '',
                'project-category' => $category_id,
            ), $project_archive_link);
        ?>
            <li>
                <a href="<?= esc_url($category_link); ?>"><?= esc_html($category_name); ?></a>
            </li>
        <?php
        endforeach;
        ?>
    </ul>
<?php
endif;
?>