<article class="team-member-single" id="post-<?php the_ID(); ?>">
    <?php
    // Breadcrumbs
    echo get_template_part('views/conditional/team/single/modules/breadcrumbs/breadcrumbs');
    // Team Member Details Module
    echo get_template_part('views/conditional/team/single/modules/team-member-details/team-member-details');
    ?>
</article>