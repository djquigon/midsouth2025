<div class="project-list">
    <div class="container">
        <ul 
            class="projects"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-column-count="three"
            data-column-gap="small"
            data-row-gap="large"
        >
        <?php
            //declare an arguments array, initialized to the Projects post type. We'll fill it with any query string parameters set up by the project filter form
            $args = [
                'post_type' => 'mandr_project',
                'is_paged' => true,
                'paged' => get_query_var( 'paged' ), //essential for our custom pagination to work
                'posts_per_page' => 6,
            ];

            //grab the project search term if used:
            if (isset($_GET['project-search'])) {
                //initialize search key in $args if it hasn't already:
                if (!array_key_exists('s', $args) && strlen($_GET['project-search']) > 0) {

                    //grab the searched term
                    $project_search_term = $_GET['project-search'];

                    //push it to the args
                    $args['s'] = $project_search_term;
                }
            }

            //grab the project category filter if used:
            if (isset($_GET['project-category'])) {
                //initialize tax_query key in $args if it hasn't already:
                if (!array_key_exists('tax_query', $args)) {
                    //grab the selected post category filter
                    $project_category_filter = $_GET['project-category'];

                    //push it to the args:
                    $args['tax_query'] = [
                        [   //for some reason, it's necessary to nest the tax query in 2 arrays:
                            'taxonomy' => 'project_category',
                            'terms' => array(
                                $project_category_filter
                            ),
                        ]
                    ];
                }
            } 
            
            //intialize the query:
            $project_query = new WP_Query($args);

            //loop through the queried posts and spit out the individual listing HTML
            if ($project_query->have_posts()) :
                while ($project_query->have_posts()) :
                    $project_query->the_post();

                    get_template_part('views/conditional/projects/archive/modules/project-list/components/individual-listing', null, array('id' => get_the_ID()));

                endwhile;
                
            else :
        ?>
                <li class="no-results">
                    <h3>We're sorry, but there are currently no projects in this area.</h3>
                </li>
        <?php
            endif;
        ?>
        </ul>
        <?php
            if ($project_query->have_posts()) {
                numbered_pagination($project_query);
            }
        ?>
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
</div>