<aside id="sidebar" class="one-fourth">
    <?php if (!dynamic_sidebar('Sidebar')) :
        //Service Page Links
        $posts_home = get_option('page_for_posts');
        if (is_home() || is_single()) :
            if (have_rows('sidebar_page_links', $posts_home)) :
    ?>
                <section class="sidebar-links-wrap">
                    <?php
                    while (have_rows('sidebar_page_links', $posts_home)) :
                        the_row();
                        $id = get_sub_field('sidebar_page_link');
                        $img = wp_get_attachment_url(get_post_thumbnail_id($id));
                        $title = get_the_title($id);
                        $description = get_sub_field('link_description');
                        $link = get_permalink($id);
                    ?>
                        <div class="sidebar-link">
                            <?php if ($img) { ?>
                                <figure class="sidebar-img-wrap">
                                    <img src="<?php echo $img; ?>" class="sidebar-img">
                                </figure>
                            <?php } ?>

                            <h3><?php echo $title; ?></h3>

                            <?php if ($description) { ?>
                                <div class="sidebar-desc">
                                    <?php echo $description; ?>
                                </div>
                            <?php } ?>

                            <a href="<?php echo $link; ?>" class="read-more">Learn More</a>
                        </div>
                    <?php
                    endwhile;
                    ?>
                </section>
            <?php
            endif;
        else :
            if (have_rows('sidebar_page_links')) :
            ?>
                <section class="sidebar-links-wrap">
                    <?php
                    while (have_rows('sidebar_page_links')) :
                        the_row();
                        $id = get_sub_field('sidebar_page_link');
                        $img = wp_get_attachment_url(get_post_thumbnail_id($id));
                        $title = get_the_title($id);
                        $description = get_sub_field('link_description');
                        $link = get_permalink($id);
                    ?>
                        <div class="sidebar-link">
                            <?php if ($img) { ?>
                                <figure class="sidebar-img-wrap">
                                    <img src="<?php echo $img; ?>" class="sidebar-img">
                                </figure>
                            <?php } ?>

                            <h3><?php echo $title; ?></h3>

                            <?php if ($description) { ?>
                                <div class="sidebar-desc">
                                    <?php echo $description; ?>
                                </div>
                            <?php } ?>

                            <a href="<?php echo $link; ?>" class="read-more">Learn More</a>
                        </div>
                    <?php
                    endwhile;
                    ?>
                </section>
        <?php
            endif;
        endif;
        ?>
    <?php endif; ?>
</aside>