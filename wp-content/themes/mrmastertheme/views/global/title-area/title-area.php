<header class="title-area">
    <div class="container">
        <h1>
            <?php
                if (is_home()) {
                    if (get_option('page_for_posts', true)) {
                        echo get_the_title(get_option('page_for_posts', true));
                    } else {
                        echo 'Blog';
                    }
                } elseif (is_archive()) {
                    echo get_the_archive_title();
                } elseif (is_search()) {
                    echo sprintf('Search Results for %s', get_search_query());
                } elseif (strlen(get_field('title_area')['page_title']) > 0) {
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
        <span 
            class="container-settings"
            data-container-width="standard"
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span class="module-settings">
        <span 
            class="padding" 
            data-top-padding-desktop="double" 
            data-bottom-padding-desktop="double" 
            data-top-padding-mobile="single" 
            data-bottom-padding-mobile="single"
        >
            <span class="validator-text" data-nosnippet>padding settings</span>
        </span>                            
    </span>
</header>