<?php
    add_action('after_setup_theme', 'mandr_setup_theme');

    function mandr_setup_theme() {
        //Define theme version 
        define("THEME_VERSION", '1.0.0');

        //ACF Google Maps Key - change during site build to be a key that is specific to the client
        define("MR_GOOGLE_MAPS_API_KEY", 'AIzaSyD8GEflr1NopcQOtoGClDxI7Cr2LQUXtcg'); 
        if (defined("MR_GOOGLE_MAPS_API_KEY")) {
            add_filter('acf/settings/google_api_key', function () {
                return MR_GOOGLE_MAPS_API_KEY;
            });    
        }

        //Add WordPress HTML5 support
        add_theme_support('html5', ['caption', 'comment-form', 'gallery', 'search-form', 'script', 'style']);

        //Let WordPress manage the document title. By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
        add_theme_support('title-tag');

        //Create Options page
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page();
        }

        //Add excerpts to pages
        add_post_type_support('page', 'excerpt');

        //Add Editor Stylesheet from main style.css
        //add_editor_style( get_stylesheet_directory_uri().'/style.css' );
        //add_editor_style( get_stylesheet_directory_uri().'/admin/shortcake-style.css' );

        //This theme uses post thumbnails
        if (function_exists('add_theme_support')) {
            // Normal post thumbnails:
            add_theme_support('post-thumbnails');
            set_post_thumbnail_size(600, 400, true); 

            // Other custom-theme image sizes:
            add_image_size('slider-main', 1300, 650, true);
            add_image_size('slider-thumbnails', 240, 150, true);
            add_image_size('medium-portrait', 600, 400, true); 
            add_image_size('medium-square', 600, 600, true); 
        }

        //Add custom image size to Wordpress admin area
        add_filter('image_size_names_choose', 'my_custom_image_sizes');
        function my_custom_image_sizes($sizes) {
            return array_merge($sizes, array(
                'medium-portrait' => 'Medium Portrait',
                'medium-square' => 'Medium Square',
            ));
        }

        //Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        //Custom menu support
        add_theme_support('menus');
        if (function_exists('register_nav_menus')) {
            register_nav_menus(
                array(
                    'primary_menu' => 'Primary Menu',
                    'secondary_menu' => 'Secondary Menu',
                    'toggled_menu_desktop_primary' => 'Toggled Menu - Primary (Desktop View)',
                    'toggled_menu_desktop_secondary' => 'Toggled Menu - Secondary (Desktop View)',
                    'conglomerate_menu' => 'Conglomerate Menu (For Mobile)',
                    'footer_menu' => 'Footer "Quicklinks" Menu'
                )
            );
        }
    }
