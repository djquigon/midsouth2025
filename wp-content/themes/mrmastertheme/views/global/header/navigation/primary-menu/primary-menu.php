<nav id="primary-nav" aria-label="Primary Menu">
    <div class="container">
        <?php
            //Adjust the settings as needed, or remove entirely if you need something more custom:
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
            //HTML for our site logo, always use an SVG
            echo get_template_part('views/global/widgets/site-logo-home-link/site-logo-home-link');
        ?>        

        <?php
            //If a primary menu is created AND assigned to the appropriate menu location, call the nav menu function:
            if (has_nav_menu('primary_menu')) {
                wp_nav_menu(array(
                    'container'       => 'ul',
                    'menu_class'      => 'primary-menu',
                    'menu_id'         => '',
                    'depth'           => 0,
                    'theme_location' => 'primary_menu'
                ));
            }
        ?>

        <?php
            //We're always going to need a trigger for the toggled menu:
        ?>
        <button id="menu-toggle-trigger" aria-expanded="false" aria-controls="toggled-nav">
            <span class="button-bars">
                <span class="bar top"></span> 
                <span class="bar middle"></span>
                <span class="bar bottom"></span>
            </span>
            <span class="button-text" data-visually-hidden="true">toggle visibility of menu</span> 
        </button>
    </div>
</nav>