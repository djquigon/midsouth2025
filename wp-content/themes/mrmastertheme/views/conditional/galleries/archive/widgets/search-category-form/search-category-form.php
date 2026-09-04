<?php
    //first, let's grab all the gallery categories terms:
    $gallery_categories = get_terms(array('taxonomy' => 'gallery_category','hide_empty' => false));

    //grab the archive link for the form action & 'clear search' button
    $gallery_archive_link = get_post_type_archive_link('mandr_gallery');
?>
    <form 
        role="search" 
        action="<?= $gallery_archive_link ?>" 
        id="gallery-filters" 
    >
        <ul
            class="form-fields"
            data-flex="flex" 
            data-flex-wrap="wrap" 
            data-justify-content="space-between"
            data-align-items="center"
        >
            <li class="gallery-search-term-filter">
                <label for="gallery-search" class="screenreader-only">Filter Galleries by a search term:</label>
                <input name="gallery-search" id="gallery-search" type="text" placeholder="Search..." <?= (isset($_GET['gallery-search'])) ? 'value="'.$_GET['gallery-search'].'"' : ''; ?>>
            </li>
            <?php
                if ($gallery_categories) :
                    //I'm not the biggest fan of the ternary operator, but what we're doing here with it is saving some space while handling some UX work.

                    //If a category isn't used in the search, default to the placeholder option. If a category is used, ensure it's pre-selected when the page loads.
            ?>
                    <li class="gallery-category-filter">
                        <select name="gallery-category" id="gallery-category">
                            <option 
                                <?= (!isset($_GET['gallery-category'])) ? 'selected' : ''; ?> 
                                disabled
                            >
                                Category
                            </option>
                            <?php
                                foreach($gallery_categories as $category) :
                            ?>
                                    <option 
                                        value="<?= $category->term_id ?>"
                                        <?= (isset($_GET['gallery-category']) && $_GET['gallery-category'] == $category->term_id) ? 'selected' : ''; ?> 
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
            ?>
            <li class="gallery-filter-submit">
                <input type="submit" value="Filter Galleries">
            </li>
            <?php
                //if any filters are being used, print a 'clear' button
                if (isset($_GET['gallery-search']) || isset($_GET['gallery-category'])) :
            ?>
                    <li class="gallery-filter-clear">
                        <a href="<?= $gallery_archive_link ?>">Clear Filters</a>
                    </li>   
            <?php
                endif;
            ?>
        </ul>
    </form> 