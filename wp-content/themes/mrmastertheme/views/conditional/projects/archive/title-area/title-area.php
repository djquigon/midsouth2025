<?php
//In this particular case, we're using a title-area.php file that is customized for the Projects archive because the M&R Master Theme's design calls for the inclusion of a search & category form here.
?>
<header class="title-area">
    <div class="container">
        <?php
        if (isset($_GET['project-search']) || isset($_GET['project-category'])) {
        ?>
            <h1 style="text-align: center; width: 100%;">
                <?php
                //if we're looking at the results of a filtered resource search:
                echo 'Filtered Projects:';
                ?>
            </h1>
        <?php
        } elseif (is_tax('project_category')) {
            //if we're looking at a specific resource category view:
        ?>
            <h1 style="text-align: center; width: 100%;">
                <?php
                echo get_the_archive_title();
                ?>
            </h1>
        <?php
        } else {
            // get Projects Page Intro Content
            $projects_page_intro_content = get_field('case_studies_page_intro_content',  'option');
            echo $projects_page_intro_content;
        }
        ?>
        <span
            class="container-settings" aria-hidden="true"
            data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single">
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</header>