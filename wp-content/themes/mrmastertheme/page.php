<?php
    //This is the default page template
    get_header();
?>

<main id="main" class="primary-content">
    <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
    <?php 
        if (have_posts()) : 
            while (have_posts()) : the_post();  

                //if the page isn't password-protected:
                if ( ! post_password_required( $post ) ) :

                    //In the interest of keeping the theme directory structure consistent, we're opting to not use the default 'page-templates' folder. Instead, we use files like page.php, index.php, & single.php as a sort of 'map'. Depending on the conditional, you're routed to a particular place in the 'views/conditional' folder.
                    if (is_page('locations')) {
                        get_template_part('views/conditional/pages/locations-page/locations-page');
                    } elseif (is_page('faqs-archive')) {
                        get_template_part('views/conditional/pages/FAQs-page/FAQs-page');
                    } elseif (has_term('secondary-homepage', 'page_category')) {
                        //This is our example of how to use page categories in the same way one would typically use a 'Page Template'. Our conditional checks for the inclusion of a particular term, or 'page category' in this case.   

                        //'secondary homepages' can be fairly common. We're needing to use this so that we can demonstrate the different options we have for 'homepage hero/title areas'
                        
                        //homepage-specific title area:
                        get_template_part('views/conditional/pages/front-page/title-area/title-area');

                        //homepage-specific modules:
                        get_template_part('views/conditional/pages/front-page/modules/modules');
                    } else {
                        //if it's not a page that has a unique identifier, i.e. it's just a standard page:
                        
                        //grab the global title area module
                        get_template_part('views/global/title-area/title-area');
                        
                        //spit out all the individual page sections (modules)
                        get_template_part( 'views/global/modules/modules' ); 
                    } 
                else : 
            ?>
                    <div class="container">
                        <?= get_the_password_form(); ?>
                    </div>
            <?php
                endif; 
            endwhile;
        endif; 
    ?>
    </article>
</main>

<?php
get_footer();
?>