<?php
    //We'll start with some constant definitions:
    define( 'LOCATIONS_VUE_PLUGIN_URL', get_template_directory_uri() . '/views/conditional/pages/locations-page/modules/locations-map' ); 
    define( 'LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME', 'locations-map' ); 
    define( 'LOCATIONS_VUE_LOCAL_DEV', LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME  . '_dev');
    define( 'LOCATIONS_VUE_LOCAL_DEV_CHUNK', LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME  . '_dev-chunk');

    //Next we'll use the definitions above to register shortcode scripts:
    add_action('wp_enqueue_scripts', 'vue_local_register_scripts');
    function vue_local_register_scripts() {
        wp_register_script('vue_app_locations', LOCATIONS_VUE_PLUGIN_URL . '/dist/js/app.js', [], THEME_VERSION, true);

        //if we're developing locally:
        if (vue_is_local_development()) {
            wp_register_script(LOCATIONS_VUE_LOCAL_DEV, 'http://localhost:8080/js/app.js', [], THEME_VERSION, true);
            wp_register_script(LOCATIONS_VUE_LOCAL_DEV_CHUNK, 'http://localhost:8080/js/chunk-vendors.js', [], THEME_VERSION, true);
        } else {
            wp_register_script(LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME . '_chunks', LOCATIONS_VUE_PLUGIN_URL . '/dist/js/chunk-vendors.js', [], THEME_VERSION, true);
            wp_register_script(LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME, LOCATIONS_VUE_PLUGIN_URL . '/dist/js/app.js', [], THEME_VERSION, true);
        }    

        //Load up the Google Maps API:
        wp_register_script('Google-Maps-API', 'https://maps.googleapis.com/maps/api/js?v=beta&key=' . MR_GOOGLE_MAPS_API_KEY . '&libraries=places&region=us&callback=importGoogleMapsLibrary', false, null); 
        wp_enqueue_script('Google-Maps-API');

        //Load up the CSS Stylesheet that is specific to the vue app:
        wp_enqueue_style('vue-app-locations-styling', LOCATIONS_VUE_PLUGIN_URL . '/dist/css/locations-map-style.css', false, filemtime(get_stylesheet_directory() . '/views/conditional/pages/locations-page/modules/locations-map/dist/css'));
    }
    
    //Pull in the file that defines all of our callback functions:
    require_once TEMPLATEPATH . '/views/conditional/pages/locations-page/modules/locations-map/functions/callbacks.php';

    //Lastly, build the shortcode that we'll use to print the vue app on the front-end:
    add_shortcode('locations-map', 'vue_locations_map_shortcode');
    function vue_locations_map_shortcode($args) {
        //run all of your callback functions, have them return data as a PHP variable/array/object that will get passed to the vue app as a JavaScript Object:        
        $the_locations_callback = get_all_locations_via_query();
        $the_search_term_callback = get_locations_search_term();
        
        //if we're developing locally:
        if (vue_is_local_development()) {
            wp_enqueue_script(LOCATIONS_VUE_LOCAL_DEV);
            wp_enqueue_script(LOCATIONS_VUE_LOCAL_DEV_CHUNK);
    
            wp_localize_script(LOCATIONS_VUE_LOCAL_DEV, 'the_locations', $the_locations_callback);
            wp_localize_script(LOCATIONS_VUE_LOCAL_DEV, 'search_term', $the_search_term_callback);
        } else {
            wp_enqueue_script(LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME . '_chunks');
            wp_enqueue_script(LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME);
            
            wp_localize_script(LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME, 'the_locations', $the_locations_callback);
            wp_localize_script(LOCATIONS_VUE_PLUGIN_SHORTCODE_NAME, 'search_term', $the_search_term_callback);
        }    

        ob_start();

        //the ID for this element is referenced in the Vue app's main.js file, it's what the app gets 'mounted' to:
        echo '<section id="locations-map"></section>';

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
?>