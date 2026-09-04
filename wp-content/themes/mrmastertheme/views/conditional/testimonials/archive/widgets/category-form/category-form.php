<?php
//first, let's grab all the resource categories terms:
$testimonial_categories = get_terms(array('taxonomy' => 'testimonial_category', 'hide_empty' => false));

//grab the archive link for the form action & 'clear search' button
$testimonial_archive_link = get_post_type_archive_link('mandr_testimonial');
?>
<form
    role="search"
    action="<?= $testimonial_archive_link ?>"
    id="testimonial-filters">
    <ul
        class="form-fields"
        data-flex="flex"
        data-flex-wrap="wrap"
        data-justify-content="space-between"
        data-align-items="center">
        <?php
        if ($testimonial_categories) :
            //I'm not the biggest fan of the ternary operator, but what we're doing here with it is saving some space while handling some UX work.

            //If a category isn't used in the search, default to the placeholder option. If a category is used, ensure it's pre-selected when the page loads.
        ?>
            <li class="testimonial-category-filter">
                <select name="testimonial-category" id="testimonial-category">
                    <option
                        <?= (!isset($_GET['testimonial-category'])) ? 'selected' : ''; ?>
                        disabled>
                        Category
                    </option>
                    <?php
                    foreach ($testimonial_categories as $category) :
                    ?>
                        <option
                            value="<?= $category->term_id ?>"
                            <?= (isset($_GET['testimonial-category']) && $_GET['testimonial-category'] == $category->term_id) ? 'selected' : ''; ?>>
                            <?= $category->name ?>
                        </option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </li>
        <?php
        endif;
        ?>
        <li class="testimonial-filter-submit">
            <input type="submit" value="Filter Testimonials">
        </li>
        <?php
        //if any filters are being used, print a 'clear' button
        if (isset($_GET['testimonial-search']) || isset($_GET['testimonial-category'])) :
        ?>
            <li class="testimonial-filter-clear">
                <a href="<?= $testimonial_archive_link ?>">Clear Filters</a>
            </li>
        <?php
        endif;
        ?>
    </ul>
</form>