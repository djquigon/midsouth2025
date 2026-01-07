<?php
get_header();
?>
<main id="main" class="primary-content">
    <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
        <?php
        //In the interest of keeeping things modular & consistent, we use files like index.php & single.php as a sort of 'map'. Depending on the conditional, you're routed to a particular place in the 'views/conditional' folder.

        if (get_post_type() === 'post') {
            //if we're dealing with blog posts:
            echo get_template_part('views/conditional/posts/single/single');
        } elseif (get_post_type() === 'mandr_location') {
            //or if we're dealing with locations that have a single view:  
            echo get_template_part('views/conditional/locations/single/single');
        } elseif (get_post_type() === 'mandr_gallery') {
            //or if we're dealing with galleries that have a single view:  
            echo get_template_part('views/conditional/galleries/single/single');
        } elseif (get_post_type() === 'mandr_project') {
            //or if we're dealing with projects that have a single view:  
            echo get_template_part('views/conditional/projects/single/single');
        } elseif (get_post_type() === 'mandr_resource') {
            //or if we're dealing with resourcess that have a single view:  
            echo get_template_part('views/conditional/resources/single/single');
        } elseif (get_post_type() === 'mandr_team_member') {
            //or if we're dealing with team members that have a single view:  
            echo get_template_part('views/conditional/team/single/single');
        } elseif (get_post_type() === 'mandr_testimonial') {
            //or if we're dealing with testimonials that have a single view:  
            echo get_template_part('views/conditional/testimonials/single/single');
        }
        ?>
    </article>
</main>
<?php
get_footer();
?>