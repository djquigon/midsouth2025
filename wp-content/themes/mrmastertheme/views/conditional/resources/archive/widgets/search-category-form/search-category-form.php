<?php
    //first, let's grab all the resource categories terms:
    $resource_categories = get_terms(array('taxonomy' => 'resource_category','hide_empty' => false));

    //grab the archive link for the form action & 'clear search' button
    $resource_archive_link = get_post_type_archive_link('mandr_resource');
?>
    <form 
        role="search" 
        action="<?= $resource_archive_link ?>" 
        id="resource-filters" 
    >
        <ul
            class="form-fields"
            data-flex="flex" 
            data-flex-wrap="wrap" 
            data-justify-content="space-between"
            data-align-items="center"
        >
            <li class="resource-search-term-filter">
                <label for="resource-search" class="screenreader-only">Filter Resources by a search term:</label>
                <input name="resource-search" id="resource-search" type="text" placeholder="Search..." <?= (isset($_GET['resource-search'])) ? 'value="'.$_GET['resource-search'].'"' : ''; ?>>
            </li>
            <?php
                if ($resource_categories) :
                    //I'm not the biggest fan of the ternary operator, but what we're doing here with it is saving some space while handling some UX work.

                    //If a category isn't used in the search, default to the placeholder option. If a category is used, ensure it's pre-selected when the page loads.
            ?>
                    <li class="resource-category-filter">
                        <select name="resource-category" id="resource-category">
                            <option 
                                <?= (!isset($_GET['resource-category'])) ? 'selected' : ''; ?> 
                                disabled
                            >
                                Category
                            </option>
                            <?php
                                foreach($resource_categories as $category) :
                            ?>
                                    <option 
                                        value="<?= $category->term_id ?>"
                                        <?= (isset($_GET['resource-category']) && $_GET['resource-category'] == $category->term_id) ? 'selected' : ''; ?> 
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
            <li class="resource-filter-submit">
                <input type="submit" value="Filter Resources">
            </li>
            <?php
                //if any filters are being used, print a 'clear' button
                if (isset($_GET['resource-search']) || isset($_GET['resource-category'])) :
            ?>
                    <li class="resource-filter-clear">
                        <a href="<?= $resource_archive_link ?>">Clear Filters</a>
                    </li>   
            <?php
                endif;
            ?>
        </ul>
    </form> 