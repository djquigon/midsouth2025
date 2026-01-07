<?php
//The Homepage template
get_header();
?>

<main id="main" class="primary-content">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post();
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                <?php
                    //homepage-specific title area:
                    get_template_part('views/conditional/pages/front-page/title-area/title-area');

                    //homepage-specific modules:
                    get_template_part('views/conditional/pages/front-page/modules/modules');
                ?>
            </article>
    <?php
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();
?>