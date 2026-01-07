<?php
get_header();
?>
<main id="main" class="primary-content">
    <?php
    //In the interest of keeeping things modular & consistent, we use files like index.php & single.php as a sort of 'map'. Depending on the conditional, you're routed to a particular place in the 'views/conditional' folder.

    if (get_post_type() === 'post') {
        //if it's the posts archive (i.e. the Blog/News page):
        echo get_template_part('views/conditional/posts/archive/archive');
    } elseif (get_post_type() === 'mandr_gallery') {
        echo get_template_part('views/conditional/galleries/archive/archive');
    } elseif (get_post_type() === 'mandr_project') {
        echo get_template_part('views/conditional/projects/archive/archive');
    } elseif (get_post_type() === 'mandr_resource') {
        echo get_template_part('views/conditional/resources/archive/archive');
    } elseif (get_post_type() === 'mandr_team_member') {
        echo get_template_part('views/conditional/team/archive/archive');
    } elseif (get_post_type() === 'mandr_testimonial') {
        echo get_template_part('views/conditional/testimonials/archive/archive');
    } elseif (get_post_type() === 'CUSTOM_POST_TYPE_NAME') {
        //or if we're dealing with some sort of custom post type archive:                
        //echo get_template_part('views/conditional/CUSTOM_POST_TYPE_NAME/title-area/title-area');
        //echo get_template_part('views/conditional/CUSTOM_POST_TYPE_NAME/etc/etc');
    }
    ?>
</main>
<?php
get_footer();
?>