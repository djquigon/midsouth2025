<?php
    //This function holds any functions that apply to widgets, global or otherwise

    //check ACF Options tab for enabled emergency message
    function is_emergency_message_enabled() {
        if (get_field('emergency_message_toggle', 'options') === true) {
            return true;
        } 
    }

    //check ACF Options tab for enabled loading animation
    function is_loading_animation_enabled() {
        if (get_field('loading_animation_toggle', 'options') === true) {
            return true;
        } 
    }

    //Display numbered pagination for blog / archive
    function numbered_pagination($query = null) {
        if ($query === null) {
            global $wp_query;
            $query = $wp_query;
        }

        $total = $query->max_num_pages;
        if ($total > 1) :
        ?>
            <nav class="post-pagination" aria-label="Pagination for posts">
                <?php
                $current = max(1, get_query_var('paged'));

                $big = 999999;

                echo paginate_links(array(
                    'base'                  => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'                => '&paged=%#%',
                    'current'               => $current,
                    'total'                 => $total,
                    'prev_text'             => 'Previous Page',
                    'next_text'             => 'Next Page',
                    'type'                  => 'list',
                    'before_page_number'    => '<span class="visually-hidden">Page</span>'
                ));
                ?>
            </nav>
    <?php
        endif;
    }
?>