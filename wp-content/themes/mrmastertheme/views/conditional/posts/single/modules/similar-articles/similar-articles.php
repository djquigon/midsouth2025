<?php
    $curent_post_id = get_the_id();

    //first, we grab the categories and tags applied to the current post:
    if (get_the_terms($curent_post_id, 'category')) {
        $post_categories = get_the_terms($curent_post_id, 'category');
    } else {
        $post_categories = false;
    } 

    if (get_the_terms($curent_post_id, 'post_tag')) {
        $post_tags = get_the_terms($curent_post_id, 'post_tag');
    } else {
        $post_tags = false;
    }

    //declare an empty arguments array, for us to fill if any categories or tags are applied to the current post:
    $args = [];

    //grab the post category filter if used:
    if ($post_categories) {
        //initialize tax_query key in $args if it hasn't already:
        if (!in_array('tax_query', $args)) {
            $args['tax_query'] = [];
        }

        //declare empty array to hold all category IDs
        $post_category_array = [];

        //loop through the categories, push each ID to the category array
        foreach ($post_categories as $category)  {
            array_push($post_category_array, $category->term_id);
        }
         
        //push the category array to the arguments array
        array_push($args['tax_query'], array(
                'taxonomy' => 'category',
                'terms' => array(
                    $post_category_array
                ),
            )
        );
    } 

    //grab the post tags filter if used:
    if ($post_tags) {
        //initialize tax_query key in $args if it hasn't already:
        if (!in_array('tax_query', $args)) {
            $args['tax_query'] = [];
        }
        
        //initialize an array to hold the tag IDs
        $post_tag_array = [];

        //loop through the tags, push each ID to the category array
        foreach ($post_tags as $tag)  {
            array_push($post_tag_array, $tag->term_id);
        }

        array_push($args['tax_query'], array(
                'taxonomy' => 'post_tag',
                'terms' => $post_tag_array 
            )
        );
    }

    //if both the category & tags filters are used, add the 'relation' parameter to combine the 2 queries:
    if ($post_categories && $post_tags) {
        $args['tax_query']['relation'] = 'OR';
    }

    //push 'per page' count to the arguments array:
    $args['posts_per_page'] = 3;

    //exclude the current post:
    $args['post__not_in'] = [$curent_post_id];

    //we're only going to use this module if either a category or tag is applied to the current post:
    if ($post_categories || $post_tags) : 

        //use the $args to query similar posts:
        $post_query = new WP_Query($args);

        if ($post_query->have_posts()) :
?>
            <section class="similar-articles">
                <div class="title-all-button-row">
                    <div class="container">
                        <h2 class="title">Similar Articles</h2>
                        <a href="<?= get_the_permalink(get_option('page_for_posts')) ?>" class="button" data-mobile-hide="true">All Articles</a>
                        <span 
                            class="container-settings" 
                            data-flex="flex" 
                            data-justify-content="space-between" 
                            data-container-width="standard"
                        >
                            <span class="validator-text" data-nosnippet="">settings</span>
                        </span>
                    </div>
                </div> 
                <div class="content-row">
                    <div class="columns">
                        <?php
                            while ($post_query->have_posts()) : $post_query->the_post();
                        ?>
                                <div class="column">
                                    <?php 
                                        //because this same card layout is used for posts but by different modules, we opt to put the template file in the more global folder
                                        echo get_template_part('views/global/modules/blog-post-list/components/card-standard', null, array('id' => get_the_ID())); 
                                    ?>
                                </div>
                        <?php
                            endwhile;
                        ?> 
                    </div>
                    <span 
                        class="row-settings" 
                        data-column-count="three"  
                        data-column-gap="large"
                        data-container-width="standard"
                    >
                        <span class="validator-text" data-nosnippet="">row settings</span>
                    </span>
                </div>
                <div class="all-button-row" data-desktop-hide="true">
                    <div class="container">
                        <a href="<?= get_the_permalink(get_option('page_for_posts')) ?>" class="button">All Articles</a>
                        <span 
                            class="container-settings" 
                            data-container-width="standard"
                        >
                            <span class="validator-text" data-nosnippet>settings</span>
                        </span>
                    </div>
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
<?php
            wp_reset_postdata();
        endif; 
    endif; 
?>