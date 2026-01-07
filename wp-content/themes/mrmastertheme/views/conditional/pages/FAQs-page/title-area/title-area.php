<header class="title-area">
    <div class="container">
        <h1>
            <?php
                if (strlen(get_field('title_area')['page_title']) > 0) {
                        echo get_field('title_area')['page_title'];
                    } else {
                        echo get_the_title();
                    }
            ?> 
        </h1>
        <?= get_template_part('views/conditional/pages/FAQs-page/widgets/filter-form/filter-form'); ?>
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