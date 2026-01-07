<article id="post-<?php the_ID(); ?>">
    <?php
    //Title Area (specific to single testimonials):
    echo get_template_part('views/conditional/testimonials/single/title-area/title-area');

    //Testimonial Info Module
    echo get_template_part('views/conditional/testimonials/single/modules/testimonial-info/testimonial-info');
    ?>
    <aside class="pre-footer-breadcrumb">
        <div class="breadcrumb-navigation">
            <?php
            //Pre-Footer Breadcrumb(s):
            echo get_template_part('views/conditional/testimonials/single/widgets/navigation/navigation');
            ?>
        </div>
    </aside>
</article>