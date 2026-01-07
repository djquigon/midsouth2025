<section class="post-list">
    <div class="container">
        <ul class="posts">
        <?php
            //declare an empty arguments array, for us to fill if any query string parameters are set up by the post filter form
            $args = [];

            //grab the post category filter if used:
            if (isset($_GET['post-category'])) {
                //initialize tax_query key in $args if it hasn't already:
                if (!in_array('tax_query', $args)) {
                    $args['tax_query'] = [];
                }

                //grab the post category value
                $post_category_filter = $_GET['post-category'];
                        
                array_push($args['tax_query'], array(
                        'taxonomy' => 'category',
                        'terms' => array(
                            $post_category_filter
                        ),
                    )
                );
            } 

            //grab the post tags filter if used:
            if (isset($_GET['post-tags'])) {
                //initialize tax_query key in $args if it hasn't already:
                if (!in_array('tax_query', $args)) {
                    $args['tax_query'] = [];
                }

                //because of the possibility of multiple tags being selected, we need to properly sift through the query string to grab each tag ID
                $post_filter_query_string = explode('&', $_SERVER['QUERY_STRING']);

                //initialize an array to hold the tag IDs
                $post_tag_filter_IDs = [];

                //loop through the query string, but only deal with the tag related parameters
                foreach ($post_filter_query_string as $parameter) {
                    if (str_contains($parameter,'post-tags=')) {
                        //strip it of just the ID
                        $parameter_tag_ID = str_replace('post-tags=','',$parameter);

                        //cast ID string as int and push to the array of tag IDs
                        array_push($post_tag_filter_IDs, (int)$parameter_tag_ID);
                    }
                }

                array_push($args['tax_query'], array(
                        'taxonomy' => 'post_tag',
                        'terms' => $post_tag_filter_IDs 
                    )
                );
            }

            //if both the category & tags filters are used, add the 'relation' parameter to combine the 2 queries:
            if (isset($_GET['post-category']) && isset($_GET['post-tags'])) {
                $args['tax_query']['relation'] = 'AND';
            }

            //grab the date filter if used:
            if (isset($_GET['post-date'])) {
                //initialize date_query key in $args if it hasn't already:
                if (!in_array('date_query', $args)) {
                    $args['date_query'] = [];
                }

                //use explode() to separate the month from the year in the date parameter:
                $post_date_filter_array = explode(' ',$_GET['post-date']);

                $args['date_query'] = array(
                    'year' => $post_date_filter_array[1],
                    'month' => $post_date_filter_array[0]
                );
            }

            //if we're not filtering posts, not in the category archive, & if a 'featured post' is selected, omit it from the query:
            if (
                !is_paged() &&
                !is_category() &&
                !isset($_GET['post-category']) && 
                !isset($_GET['post-tags']) && 
                !isset($_GET['post-date']) &&
                get_field('featured_post', get_option('page_for_posts'))
            ) {
                $featured_post = get_field('featured_post', get_option('page_for_posts'));

                if (!in_array('post__not_in', $args)) {
                    $args['post__not_in'] = [$featured_post->ID];
                } 
            }

            //if the args array isn't empty, use them
            if ($args) { 
                $post_query = new WP_Query($args);
            } else {
                //default to the standard query 
                $post_query = $wp_query;
            } 

            //loop through the queried posts and spit out the individual listing HTML
            if ($post_query->have_posts()) :
                while ($post_query->have_posts()) :
                    $post_query->the_post();

                    get_template_part('views/conditional/posts/archive/modules/post-list/components/individual-listing', null, array('id' => get_the_ID()));

                endwhile;
                
            else :
        ?>
            <li class="no-results">
                <h3>We're sorry, but there are currently no posts in this area.</h3>
            </li> 
        <?php
            endif;
        ?>
        </ul>
        <?php
            if ($post_query->have_posts()) {
                numbered_pagination($post_query);
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