<?php
//first, let's grab all the project categories terms:
$project_categories = get_terms(array('taxonomy' => 'project_category', 'hide_empty' => false));

//grab the archive link for the form action & 'clear search' button
$project_archive_link = get_post_type_archive_link('mandr_project');
if ($project_categories) :
?>
    <div class="container filter-form-container">
        <form
            role="search"
            action="<?= esc_url($project_archive_link); ?>"
            id="project-filters">
            <ul
                class="form-fields"
                data-flex="flex"
                data-flex-wrap="wrap"
                data-justify-content="space-between"
                data-align-items="center">
                <li class="project-filters-title">
                    <p>Project Case Studies</p>
                </li>
                <li class="project-search-term-filter">
                    <label for="project-search" class="screenreader-only">Filter Projects by a search term:</label>
                    <input
                        name="project-search"
                        id="project-search"
                        type="text"
                        placeholder="Search..."
                        <?= (isset($_GET['project-search'])) ? 'value="' . esc_attr($_GET['project-search']) . '"' : ''; ?>>
                </li>
                <?php
                if ($project_categories) :
                    //I'm not the biggest fan of the ternary operator, but what we're doing here with it is saving some space while handling some UX work.

                    //If a category isn't used in the search, default to the placeholder option. If a category is used, ensure it's pre-selected when the page loads.
                ?>
                    <li class="project-category-filter">
                        <select name="project-category" id="project-category">
                            <option
                                <?= (!isset($_GET['project-category'])) ? 'selected' : ''; ?>
                                disabled>
                                Category
                            </option>
                            <?php
                            foreach ($project_categories as $category) :
                            ?>
                                <option
                                    value="<?= esc_attr($category->term_id); ?>"
                                    <?= (isset($_GET['project-category']) && $_GET['project-category'] == $category->term_id) ? 'selected' : ''; ?>>
                                    <?= esc_html($category->name); ?>
                                </option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                    </li>
                <?php
                endif;
                ?>
                <li class="project-filter-submit">
                    <input class="button" type="submit" value="Filter Projects">
                </li>
                <?php
                //if any filters are being used, print a 'clear' button
                if (isset($_GET['project-search']) || isset($_GET['project-category'])) :
                ?>
                    <li class="project-filter-clear">
                        <a href="<?= esc_url($project_archive_link); ?>">Clear Filters</a>
                    </li>
                <?php
                endif;
                ?>
            </ul>
        </form>
        <span class="container-settings" aria-hidden="true" data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
<?php
endif;
?>