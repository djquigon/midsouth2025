<?php
    //In this particular case, we're using a title-area.php file that is customized for the Resources archive because the M&R Master Theme's design calls for the inclusion of a search & category form here.
?>
<header class="title-area">
    <div class="container">
        <h1>
            <?php 
                if (isset($_GET['resource-search']) || isset($_GET['resource-category'])) {
                    //if we're looking at the results of a filtered resource search:
                    echo 'Filtered Resources:';
                } elseif(is_tax('resource_category')) {
                    //if we're looking at a specific resource category view:
                    echo get_the_archive_title();
                } else {
                    echo 'Resources';
                }
            ?>
        </h1>
        <?php
            //if your resources archive needs it:
            echo get_template_part('views/conditional/resources/archive/widgets/search-category-form/search-category-form');
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