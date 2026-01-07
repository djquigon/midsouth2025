<?php
    get_header();
?>
    <main id="main" class="primary-content">
        <?php
            //Because of their relationship to SEO, we use a dedicated PHP file for Post Category archives. A primary reason is that we need the permalink structure.
            
            //title area specific to the posts archive, mostly because of the filter form:
            echo get_template_part('views/conditional/posts/archive/title-area/title-area');

            //if the modules are in use grab the supplementary SEO content section that is specific to THAT category
            //since we'd be pulling that SEO content from a taxonomy term, we need to specify that in what we eventually pass to the ACF functions have_rows()
            $the_category_id = $wp_query->get_queried_object()->term_id;
            $category_id_for_acf = 'category_'.$the_category_id;
            get_template_part('views/global/modules/modules', null, array('id' => $category_id_for_acf)); 

            //the list of posts, filtered or otherwise
            get_template_part('views/conditional/posts/archive/modules/post-list/post-list');
        ?>
    </main>
<?php 
    get_footer(); 
?>