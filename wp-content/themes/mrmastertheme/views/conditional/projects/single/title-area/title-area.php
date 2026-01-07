<header class="title-area">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="<?= get_post_type_archive_link('mandr_project') ?>">
                Back to Portfolio
            </a> 
        </nav>
        <h1>
            <?php
                if (strlen(get_field('title_area')['page_title']) > 0) {
                    echo get_field('title_area')['page_title'];
                } else {
                    echo get_the_title();
                }
            ?>
        </h1>
        <?php
            if (get_field('title_area')['include_intro_content'] && strlen(get_field('title_area')['intro_content']) > 0) :
        ?>
                <div class="intro-content">
                    <?= get_field('title_area')['intro_content'] ?>
                </div>
        <?php
            endif;
        ?>
        <?=
            get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => get_the_id()));
        ?>
        <span 
            class="container-settings"
            data-container-width="standard" 
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