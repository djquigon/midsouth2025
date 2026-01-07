<?php
    //first we set up the arguments passed from the blogs module's main php file:
    $module_title = $args['module_title'];

    $no_posts_provided = $args['no_posts_provided'];

    $articles = $args['articles'];
    if ($no_posts_provided):
        $featured_article = get_field('featured_post', get_option('page_for_posts'));
        $articles = array_slice($articles, 0, 2);
    else :
        $articles = array_slice($articles, 0, 3);
        //first article is the featured article
        $featured_article = $articles[0];
        //remove first article from array
        array_shift($articles);
    endif;

    $text_color_attribute = $args['text_color_attribute'];

    $container_width = $args['container_width'];

    $all_blogs_button = $args['all_blogs_button'];
    $all_blogs_button_text = $all_blogs_button['button_text'];
    $all_blogs_button_link = $all_blogs_button['button_link'];

    //if a title is set, print it:
    if ($module_title) :
?>
        <div class="title-view-all-row">
            <div class="container" <?= $text_color_attribute ?>>
                <?= '<h2>' . $module_title . '</h2>'; ?>
                <?php
                    //if we've got both fields set for the button, print it (desktop view only)
                    if ($all_blogs_button_text && $all_blogs_button_link) :
                ?>
                        <a href="<?= $all_blogs_button_link ?>" class="button" data-mobile-hide="true"><?= $all_blogs_button_text ?></a>
                <?php
                    endif;
                ?>
                <span
                    class="container-settings"

                    data-container-width="<?= $container_width ?>"
                    data-flex="flex"
                    data-justify-content="space-between">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;
?>
        <div class="articles-row container" data-column-gap="large">
            <?php
                if ($featured_article) :
            ?>
                    <div class="featured-article-column" <?= $text_color_attribute ?>>
                        <?php
                            //by default, Master Theme design calls for overlay card style:
                            echo get_template_part('views/global/modules/blog-post-list/components/card-overlay', null, array('id' => $featured_article->ID, 'trim_excerpt' => false));
                        ?>
                    </div>
            <?php
                endif;

                if ($articles) :
            ?>
                    <div class="other-articles-column">
                        <ul class="articles-list" <?= $text_color_attribute ?>>
                            <?php
                                foreach ($articles as $article) :
                                    // Both ACF post object fields and get_posts() return post objects
                                    $title = get_the_title($article->ID);
                                    $excerpt = get_the_excerpt($article->ID);
                                    $permalink = get_the_permalink($article->ID);
                                    $publish_date = get_the_date('F j, Y', $article->ID);
                                    $publish_date_datetime = get_the_date('Y-m-d', $article->ID);
                                    $categories = get_the_category($article->ID);
                            ?>
                                    <li class="article row">
                                        <article>
                                            <header>
                                                <h3 class="title">
                                                    <a href="<?= $permalink ?>">
                                                        <?= $title ?>
                                                    </a>
                                                </h3>
                                                <time datetime="<?= $publish_date_datetime ?>"><?= $publish_date ?></time>
                                            </header>
                                            <?php
                                                //post the excerpt if it exists:                            
                                                if ($excerpt) :
                                            ?>
                                                    <blockquote 
                                                        class="excerpt" 
                                                        cite="<?= $permalink ?>"
                                                    >
                                                        <?= $excerpt ?>
                                                    </blockquote>
                                            <?php
                                                endif;
                                                
                                                //list out post category & tags if available:
                                                echo get_template_part('views/conditional/posts/widgets/post-meta/post-category-list', null, array('id' => $article->ID));
                                                echo get_template_part('views/conditional/posts/widgets/post-meta/post-tag-list', null, array('id' => $article->ID));
                                            ?> 
                                            <a href="<?= $permalink ?>" class="button">Read Article</a>
                                        </article>
                                    </li>
                            <?php
                                endforeach;
                            ?>
                        </ul>
                    </div>
            <?php
                endif;
            ?>
            <span
                class="container-settings"
                data-container-width="<?= $container_width ?>"
                data-flex="flex"
                data-column-count="two"
                data-flex-direction="row">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
<?php
    //if we've got both fields set for the button, print it (mobile view only)
    if ($all_blogs_button_text && $all_blogs_button_link) :
?>
        <div class="all-button-row" data-desktop-hide="true">
            <div class="container">
                <a href="<?= $all_blogs_button_link ?>" class="button"><?= $all_blogs_button_text ?></a>
                <span
                    class="container-settings"
                    data-container-width="<?= $container_width ?>"
                    data-flex="flex"
                    data-justify-content="center">
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;  
?>