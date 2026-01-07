<nav class="testimonial-navigation">
    <div class="container">

        <?php
        // Previous testimonial
        $prev_testimonial = get_previous_post(true, '', 'testimonial_category');
        if ($prev_testimonial) :
            $prev_title = get_the_title($prev_testimonial->ID);
        ?>
            <a href="<?= get_permalink($prev_testimonial->ID) ?>" class="nav-button prev" aria-label="Previous testimonial: <?= $prev_title ?>">
                <span class="nav-arrow">←</span>
                <span class="nav-text">Previous</span>
            </a>
        <?php endif; ?>

        <?php
        // Next testimonial
        $next_testimonial = get_next_post(true, '', 'testimonial_category');
        if ($next_testimonial) :
            $next_title = get_the_title($next_testimonial->ID);
        ?>
            <a href="<?= get_permalink($next_testimonial->ID) ?>" class="nav-button next" aria-label="Next testimonial: <?= $next_title ?>">
                <span class="nav-text">Next</span>
                <span class="nav-arrow">→</span>
            </a>
        <?php endif; ?>
        <span
            class="container-settings"
            data-container-width="standard"
            data-flex="flex"
            data-flex-direction="row"
            data-justify-content="space-between"
            data-align-items="center">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
</nav>