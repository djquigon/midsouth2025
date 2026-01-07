<nav id="secondary-nav" aria-label="Secondary Menu">
    <div class="container">
        <?php
            //typically, the secondary menu is "right-aligned"
        ?>
        <span 
            class="container-settings" 
            data-flex="flex" 
            data-justify-content="flex-end"
            data-align-items="center"
            data-container-width="standard"
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
        <?php
            //call the nav menu function:
            wp_nav_menu(array(
                'container'       => 'ul',
                'menu_class'      => 'secondary-menu',
                'menu_id'         => '',
                'depth'           => 0,
                'theme_location' => 'secondary_menu'
            ));
        ?>
        <?php
            //Remember to deactivate the 'Disable Search' plugin if your site needs a search form.
            //call the search form function:
            echo get_search_form();
        ?>
    </div>
</nav>