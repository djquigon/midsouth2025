<section class="resource-list">
    <div class="container">
        <ul 
            class="resources"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-column-count="two"
            data-column-gap="large"
            data-row-gap="large"
        >
        <?php
            //declare an arguments array, initialized to the Resources post type. We'll fill it with any query string parameters set up by the resource filter form
            $args = [
                'post_type' => 'mandr_resource',
                'is_paged' => true,
                'paged' => get_query_var( 'paged' ), //essential for our custom pagination to work
                'posts_per_page' => 6,
            ];

            //grab the resource search term if used:
            if (isset($_GET['resource-search'])) {
                //initialize search key in $args if it hasn't already:
                if (!array_key_exists('s', $args) && strlen($_GET['resource-search']) > 0) {

                    //grab the searched term
                    $resource_search_term = $_GET['resource-search'];

                    //push it to the args
                    $args['s'] = $resource_search_term;
                }
            }

            //grab the resource category filter if used:
            if (isset($_GET['resource-category'])) {
                //initialize tax_query key in $args if it hasn't already:
                if (!array_key_exists('tax_query', $args)) {
                    //grab the selected post category filter
                    $resource_category_filter = $_GET['resource-category'];

                    //push it to the args:
                    $args['tax_query'] = [
                        [   //for some reason, it's necessary to nest the tax query in 2 arrays:
                            'taxonomy' => 'resource_category',
                            'terms' => array(
                                $resource_category_filter
                            ),
                        ]
                    ];
                }
            } 
            
            //intialize the query:
            $resource_query = new WP_Query($args);

            //loop through the queried posts and spit out the individual listing HTML
            if ($resource_query->have_posts()) :
                while ($resource_query->have_posts()) :
                    $resource_query->the_post();

                    get_template_part('views/conditional/resources/archive/modules/resource-list/components/individual-listing', null, array('id' => get_the_ID()));

                endwhile;
                
            else :
        ?>
                <li class="no-results">
                    <h3>We're sorry, but there are currently no resources in this area.</h3>
                </li>
        <?php
            endif;
        ?>
        </ul>
        <?php
            if ($resource_query->have_posts()) {
                numbered_pagination($resource_query);
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
</section>