<?php
    //first, let's grab all the filter terms:
    $post_categories = get_terms(array('taxonomy' => 'category','hide_empty' => false));
    $post_tags = get_terms(array('taxonomy' => 'post_tag','hide_empty' => false));
    
    //to get the archive to work in conjunction with categories & tags is a bit tricky:
    //grab ALL the posts, but only return IDs to keep query lite
    $archive_query = new WP_Query( array('post_type' => 'post', 'posts_per_page' => -1, 'fields' => 'ids') ); 

    if ($archive_query->have_posts()) {
        $post_archives = true;

        //initialize array to fill with Month & Year pairs:
        $monthly_archives_array = [];

        //loop and use each post ID to grab a month & year
        foreach($archive_query->posts as $post_id) {
            $post_month_numerical = get_the_date($format = 'n', $post = $post_id);
            $post_month_string = get_the_date($format = 'F', $post = $post_id);
            $post_year = get_the_date($format = 'Y', $post = $post_id);

            $post_date_array = array(
                'post_month_numerical' => $post_month_numerical,
                'post_month_string' => $post_month_string,
                'post_year' => $post_year,
            );

            //push the post date to the monthly archives array if it's not already there
            if (!in_array($post_date_array, $monthly_archives_array)) {
                array_push($monthly_archives_array,$post_date_array);
            }
        } 
    } else {
        $post_archives = false;
    }    

    //reset post data since we just queried
    wp_reset_postdata();

    if ($post_categories || $post_tags || $post_archives) :
?>
        <form 
            role="search" 
            action="<?= get_the_permalink(get_option('page_for_posts')) ?>" 
            id="post-filters" 
        >
            <ul
                class="form-fields"
                data-flex="flex" 
                data-flex-wrap="wrap" 
                data-justify-content="space-between"
                data-align-items="center"
            >
                <?php
                    if ($post_categories) :
                        //I'm not the biggest fan of the ternary operator, but what we're doing here with it is saving some space while handling some UX work.

                        //If a category isn't used in the search, default to the placeholder option. If a category is used, ensure it's pre-selected when the page loads.
                ?>
                        <li class="post-category-filter">
                            <select name="post-category" id="post-category">
                                <option 
                                    <?= (!isset($_GET['post-category'])) ? 'selected' : ''; ?> 
                                    disabled
                                >
                                    Category
                                </option>
                                <?php
                                    foreach($post_categories as $category) :
                                ?>
                                        <option 
                                            value="<?= $category->term_id ?>"
                                            <?= (isset($_GET['post-category']) && $_GET['post-category'] == $category->term_id) ? 'selected' : ''; ?> 
                                        >
                                            <?= $category->name ?>
                                        </option> 
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </li>
                <?php
                    endif;
                    
                    if ($post_tags) :
                        //We're treating tags a little differently. We need the user to be able to select multiple, but the default look of that HTML is ugly. The tags 'dropdown' is a button that toggles the visibility of the actual <select> element
                ?>
                        <li class="post-tags-filter">
                            <button 
                                type="button" 
                                id="tags-filter-toggle"
                                aria-expanded="false" 
                                aria-controls="post-tags"
                            >
                                Tags
                            </button>
                            <select 
                                name="post-tags" 
                                id="post-tags" 
                                aria-hidden="true" 
                                size="<?= count($post_tags) + 1 ?>" 
                                multiple
                            >
                                <option 
                                    <?= (!isset($_GET['post-tags'])) ? 'selected' : ''; ?> 
                                    disabled
                                >
                                    Tags
                                </option>
                                <?php
                                    foreach($post_tags as $tag) :
                                ?>
                                        <option 
                                            value="<?= $tag->term_id ?>"
                                            <?= (isset($_GET['post-tags']) && $_GET['post-tags'] == $tag->term_id) ? 'selected' : ''; ?> 
                                        >
                                            <?= $tag->name ?>
                                        </option> 
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </li>
                <?php
                    endif;

                    if ($post_archives) :
                ?>
                        <li class="post-date-filter">
                            <select name="post-date" id="post-date">
                                <option 
                                    <?= (!isset($_GET['post-date'])) ? 'selected' : ''; ?> 
                                    disabled
                                >
                                    Date
                                </option>
                                <?php
                                    foreach ($monthly_archives_array as $month) :
                                ?>
                                    <option 
                                        value="<?= $month['post_month_numerical'].' '.$month['post_year'] ?>"
                                        <?= (isset($_GET['post-date']) && $_GET['post-date'] == ($month['post_month_numerical'].' '.$month['post_year'])) ? 'selected' : ''; ?> 
                                    >
                                        <?= $month['post_month_string'].' '.$month['post_year'] ?>
                                    </option>
                                <?php
                                    endforeach;
                                ?>
                            </select>
                        </li>
                <?php
                    endif;
                ?>
                <li class="post-filter-submit">
                    <input type="submit" value="Filter Posts">
                </li>
                <?php
                    //if any filters are being used, print a 'clear' button
                    if (isset($_GET['post-category']) || isset($_GET['post-tags']) || isset($_GET['post-date'])) :
                ?>
                     <li class="post-filter-clear">
                        <a href="<?= get_the_permalink(get_option('page_for_posts')) ?>">Clear Filters</a>
                    </li>   
                <?php
                    endif;
                ?>
            </ul>
        </form>
<?php
    endif;
?>