<div class="gallery-list">
    <div class="container">
        <ul 
            class="galleries"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-column-count="three"
            data-column-gap="small"
            data-row-gap="large"
        >
        <?php
            //declare an arguments array, initialized to the Galleries post type. We'll fill it with any query string parameters set up by the gallery filter form
            $args = [
                'post_type' => 'mandr_gallery',
                'is_paged' => true,
                'paged' => get_query_var( 'paged' ), //essential for our custom pagination to work
                'posts_per_page' => 6,
            ];

            //grab the gallery search term if used:
            if (isset($_GET['gallery-search'])) {
                //initialize search key in $args if it hasn't already:
                if (!array_key_exists('s', $args) && strlen($_GET['gallery-search']) > 0) {

                    //grab the searched term
                    $gallery_search_term = $_GET['gallery-search'];

                    //push it to the args
                    $args['s'] = $gallery_search_term;
                }
            }

            //grab the gallery category filter if used:
            if (isset($_GET['gallery-category'])) {
                //initialize tax_query key in $args if it hasn't already:
                if (!array_key_exists('tax_query', $args)) {
                    //grab the selected post category filter
                    $gallery_category_filter = $_GET['gallery-category'];

                    //push it to the args:
                    $args['tax_query'] = [
                        [   //for some reason, it's necessary to nest the tax query in 2 arrays:
                            'taxonomy' => 'gallery_category',
                            'terms' => array(
                                $gallery_category_filter
                            ),
                        ]
                    ];
                }
            } 
            
            //intialize the query:
            $gallery_query = new WP_Query($args);

            //loop through the queried posts and spit out the individual listing HTML
            if ($gallery_query->have_posts()) :
                while ($gallery_query->have_posts()) :
                    $gallery_query->the_post();

                    get_template_part('views/conditional/galleries/archive/modules/gallery-list/components/individual-listing', null, array('id' => get_the_ID()));

                endwhile;
                
            else :
        ?>
                <li class="no-results">
                    <h3>We're sorry, but there are currently no galleries in this area.</h3>
                </li>
        <?php
            endif;
        ?>
        </ul>
        <?php
            if ($gallery_query->have_posts()) {
                numbered_pagination($gallery_query);
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