<section class="testimonials">
    <div class="container">
        <!-- Flex layout, but can be set to a masonry layout (see testimonials.scss) -->
        <ul
            class="testimonials-list"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-column-count="three"
            data-column-gap="large"
            data-row-gap="large"
            data-layout="masonry">
            <?php
            //declare an arguments array, initialized to the Testimonials post type. We'll fill it with any query string parameters set up by the testimonial filter form
            $args = [
                'post_type' => 'mandr_testimonial',
                'is_paged' => true,
                'paged' => get_query_var('paged'), //essential for our custom pagination to work
                'posts_per_page' => 6,
            ];

            //grab the testimonial category filter if used:
            if (isset($_GET['testimonial-category'])) {
                //initialize tax_query key in $args if it hasn't already:
                if (!array_key_exists('tax_query', $args)) {
                    //grab the selected post category filter
                    $testimonial_category_filter = $_GET['testimonial-category'];

                    //push it to the args:
                    $args['tax_query'] = [
                        [   //for some reason, it's necessary to nest the tax query in 2 arrays:
                            'taxonomy' => 'testimonial_category',
                            'terms' => array(
                                $testimonial_category_filter
                            ),
                        ]
                    ];
                }
            }

            //intialize the query:
            $testimonial_query = new WP_Query($args);

            //loop through the queried posts and spit out the individual testimonial HTML
            if ($testimonial_query->have_posts()) :
                while ($testimonial_query->have_posts()) :
                    $testimonial_query->the_post();

                    get_template_part('views/conditional/testimonials/archive/modules/testimonials/components/individual-testimonial', null, array('id' => get_the_ID()));

                endwhile;

            else :
            ?>
                <li class="no-results">
                    <h3>We're sorry, but there are currently no testimonials in this area.</h3>
                </li>
            <?php
            endif;
            ?>
        </ul>
        <?php
        if ($testimonial_query->have_posts()) {
            numbered_pagination($testimonial_query);
        }
        ?>
        <span
            class="container-settings"
            data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single">
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</section>