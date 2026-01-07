<?php
$testimonials_archive_link = get_post_type_archive_link('mandr_testimonial');
if ($testimonials_archive_link) :
?>
    <nav class="breadcrumbs">
        <a href="<?= $testimonials_archive_link; ?>">
            Back to Testimonials
        </a>
    </nav>
<?php
endif;
?>