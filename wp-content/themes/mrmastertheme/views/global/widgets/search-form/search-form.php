<form class="custom-theme-search" role="search" method="get" action="<?php echo home_url('/'); ?>">
    <ul class="search-form-fields">
        <li class="search-string">
            <label data-visually-hidden="true">Search for:</label>
            <input type="text" name="s" value="<?php the_search_query(); ?>" placeholder="Search...">
        </li>
        <li class="submit-button">
            <label data-visually-hidden="true">Submit Search Form</label>
            <input type="submit" value="Search">
        </li>
    </ul>
</form>