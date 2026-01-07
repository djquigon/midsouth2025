<?php
    //In this particular case, we're using a title-area.php file that is customized for the Blog because the M&R Master Theme's design calls for the inclusion of a filter form here.

    //The global title-area.php file does include code that considers the blog
?>
<header class="title-area">
    <div class="container">
        <h1>
            <?php
                if (is_category()) {
                    //if we're on a category page, and a custom page title is set up in that category's meta fields, use it:
                    $the_category_id = $wp_query->get_queried_object()->term_id;
                    if (get_field('page_title', 'category_'.$the_category_id)) {
                        echo get_field('page_title', 'category_'.$the_category_id);
                    } else {
                        //just dump the archive title:
                        echo get_the_archive_title();
                    }
                } elseif (!is_category() && (isset($_GET['post-category']) || isset($_GET['post-tags']) || isset($_GET['post-date']))) { 
                    //if we're on the main posts archive and we're filtering by anything:
                    echo 'Filtered '.get_the_title(get_option('page_for_posts')).' Posts: ';
                } else {
                    //if we're not filtering, default to the name of the Posts Archive page
                    echo get_the_title(get_option('page_for_posts'));
                }
            ?>
        </h1>
        <?php
            //if your blog needs it:
            echo get_template_part('views/conditional/posts/archive/widgets/filter-form/filter-form');
        ?>
        <span 
            class="container-settings"
            data-container-width="standard"
            data-flex="flex"
            data-flex-wrap="wrap"
            data-justify-content="space-between"
            data-align-items="center"
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span 
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single"
    >
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</header>