<article id="post-<?php the_ID(); ?>">
    <?php
        //Title Area (specific to single posts):
        echo get_template_part('views/conditional/posts/single/title-area/title-area');

        //Global Modules
        echo get_template_part( 'views/global/modules/modules' );

        //Author Profile Module (specific to single posts):
        echo get_template_part( 'views/conditional/posts/single/modules/author-profile/author-profile' );
    ?>
    <aside class="categories-tags-share">
        <div class="container">
            <?php
                //the widgetized category & tags lists:
                echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => get_the_ID()));
                echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => get_the_ID()));

                //social share button
                echo get_template_part('views/conditional/posts/single/widgets/social-share-buttons/shortcode');
            ?>
            <span 
                class="container-settings"
                data-container-width="standard" 
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </aside>
    <?php
        //Similar Articles Module (specific to single posts):
        echo get_template_part( 'views/conditional/posts/single/modules/similar-articles/similar-articles' );
    ?>
    <aside class="pre-footer-breadcrumb">
        <div class="container">
            <?php
                //Pre-Footer Breadcrumb(s):
                echo get_template_part('views/conditional/posts/single/widgets/breadcrumbs/back-to-archive');
            ?>
            <span 
                class="container-settings"
                data-container-width="standard" 
            >
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </aside>
</article>