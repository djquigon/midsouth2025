<nav id="toggled-nav" aria-label="Toggled Menu" aria-hidden="true">
    <div class="menu-wrap">
        <?php
            //Sometimes we feature a search form in the toggled menu. Remember to deactivate the 'Disable Search' plugin so this works:
            echo get_search_form();
        ?>

        <?php
            //We want to be conservative with our HTML. So instead of having entirely separate desktop & mobile menu view files, we include all of the possible menus in the same "window" HTML, and use CSS & breakpoints to control the display
       
            //Toggled menu for desktop view:
            if (has_nav_menu('toggled_menu_desktop_primary')) {
                /*
                wp_nav_menu(array(
                    'container'       => 'ul',
                    'menu_class'      => 'toggled-menu-desktop-primary',
                    'menu_id'         => 'toggled-menu-desktop-primary',
                    'depth'           => 0,
                    'theme_location' => 'toggled_menu_desktop_primary'
                ));
                */
                //instead of the default wordpress <nav> > <ul> structure, we'll use our custom code to build out a menu that enables the use of sub-menu 'dropdown' or 'paginated' behaviour:

                //If a menu is registered to this location, get the name & clean it:
                $toggled_menu_desktop_primary_name = str_replace(' - ',' ',wp_get_nav_menu_name('toggled_menu_desktop_primary'));
                $toggled_menu_desktop_primary_name = str_replace(' ','-',$toggled_menu_desktop_primary_name);

                //pass the nav items to our custom function that builds the menu HTML
                echo mobile_nav_build_primary($toggled_menu_desktop_primary_name);
            }
        ?>

        <?php
            //Sometimes, we have a sort of 'secondary menu' in the toggled menu:
            if (has_nav_menu('toggled_menu_desktop_secondary')) {
                /*
                wp_nav_menu(array(
                    'container'       => 'ul',
                    'menu_class'      => 'toggled-menu-desktop-secondary',
                    'menu_id'         => 'toggled-menu-desktop-secondary',
                    'depth'           => 0,
                    'theme_location' => 'toggled_menu_desktop_secondary'
                ));
                */

                //instead of the default wordpress <nav> > <ul> structure, we'll use our custom code to build out a menu that enables the use of sub-menu 'dropdown' or 'paginated' behaviour:

                //If a menu is registered to this location, get the name & clean it:
                $toggled_menu_desktop_secondary_name = str_replace(' - ',' ',wp_get_nav_menu_name('toggled_menu_desktop_secondary'));
                $toggled_menu_desktop_secondary_name = str_replace(' ','-',$toggled_menu_desktop_secondary_name);

                //pass the nav items to our custom function that builds the menu HTML
                echo mobile_nav_build_primary($toggled_menu_desktop_secondary_name);
            }
        ?>

        <?php
            //When it's finally time to hide the other desktop menus and show all the menu items in one place, we have a conglomerate menu location
            if (has_nav_menu('conglomerate_menu')) {
                /*
                wp_nav_menu(array(
                    'container'       => 'ul',
                    'menu_class'      => 'toggled-menu-mobile-conglomerate',
                    'menu_id'         => 'toggled-menu-mobile-conglomerate',
                    'depth'           => 0,
                    'theme_location' => 'conglomerate_menu'
                ));
                */

                //instead of the default wordpress <nav> > <ul> structure, we'll use our custom code to build out a menu that enables the use of sub-menu 'dropdown' or 'paginated' behaviour:

                //If a menu is registered to this location, get the name & clean it:
                $mobile_conglomerate_menu_name = str_replace(' - ',' ',wp_get_nav_menu_name('conglomerate_menu'));
                $mobile_conglomerate_menu_name = str_replace(' ','-',$mobile_conglomerate_menu_name);

                //pass the nav items to our custom function that builds the menu HTML
                echo mobile_nav_build_primary($mobile_conglomerate_menu_name);
            }
        ?>
    </div>
    <?php
        //This button element works with the dark overlay to add 'click to close' functionality
    ?>
    <button id="close-toggled-menu">
        <span class="button-text" data-visually-hidden="true">close the toggled menu</span> 
    </button>
</nav>