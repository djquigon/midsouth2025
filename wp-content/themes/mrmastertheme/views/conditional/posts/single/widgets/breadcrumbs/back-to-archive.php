<?php
    $posts_archive_page_id = get_option('page_for_posts');
    if ($posts_archive_page_id) :
?>
        <nav class="breadcrumbs">
            <a href="<?= get_the_permalink($posts_archive_page_id); ?>">
                Back to <?= get_the_title($posts_archive_page_id); ?>
            </a>
        </nav>
<?php
    endif;
?>