<?php
    //You'll either be pulling your location info from the WordPress database or from some sort of API. We'll use the WordPress API as our example.

    //In most cases, a single query / API call will be sufficient for grabbing all your locations. In cases of large scale, you'll need to put together some sort of AJAX functionality

    function get_all_locations_via_query() {        
        //set the arguments
        $args = array(
            'post_type' => 'mandr_location', 
            'posts_per_page' => -1,
            'fields' => 'ids'
        );

        //to keep the query lite, we're only returning the ID
        $location_ids = get_posts($args);

        //declare empty return array that we'll gradually fill with data
        $locations_return = [];

        //check if the 'M&R Branding' ACF Option is enabled from the WP Admin. Based on this, determine which default & active icons we'll use. These can be changed per client, just replace the SVG(s)
        if (get_field('enable_mandr_theme_styling','options')) {
            $icon_default = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/mandr-location-marker-default.svg';
            
            $icon_active = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/mandr-location-marker-active.svg';
        } else {
            $icon_default = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/default-icon.svg';
            
            $icon_active = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/default-icon-active.svg';
        }

        //loop through all the locations
        if ($location_ids) { 
            foreach ($location_ids as $location_id) { 
                //grab all the relevant info from the location posts meta fields & taxonomies

                //name
                $location_name = get_the_title($location_id);

                //link
                $location_link = get_post_permalink($location_id);

                //grab the google location info (for map)
                $location_info = get_field('location_info',$location_id);
                $location_geolocation_info = $location_info['geolocation'];
                
                $location_lat = $location_geolocation_info['lat'];
                $location_lng = $location_geolocation_info['lng'];
                $location_address = $location_geolocation_info['address'];
                $location_street_number = $location_geolocation_info['street_number'];
                $location_street_name = $location_geolocation_info['street_name'];
                $location_street_name_short = $location_geolocation_info['street_name_short'];
                $location_city = $location_geolocation_info['city'];
                $location_state = $location_geolocation_info['state'];
                $location_state_short = $location_geolocation_info['state_short'];
                $location_post_code = $location_geolocation_info['post_code'];

                //location's place ID can be used by other Google APIs to grab information. We'll use it to generate a proper Google Maps address link
                $location_place_id = $location_geolocation_info['place_id'];

                //grab the location contact information
                $location_contact_info = $location_info['contact_information'];

                //phone
                $location_phone = $location_contact_info['phone'];

                //email
                $location_email = $location_contact_info['email'];

                //website - some formatting necessary to handle the inclusion/exclusion of 'HTTPS://' 
                if ($location_contact_info['website_url']) {
                    $location_website = $location_contact_info['website_url'];                    
                    $location_website = str_replace('http://', '', $location_website);
                    if (!str_contains($location_website, 'https://')) {
                        $location_website = 'https://'.$location_website;
                    }
                } else {
                    $location_website = false;
                }

                //hours
                $location_hours = $location_contact_info['hours'];

                //if the location is using a category(s), grab an array of the category IDs
                $location_category_array = get_the_terms($location_id,'location_category');
                
                //push the info you grabbed to a returnable array, that will later be pushed to a returnable array that contains the data for all locations
                $location_data = [];

                //Push location info to the location array
                $location_data['wp_id'] = $location_id;
                $location_data['name'] = $location_name;
                $location_data['wp_link'] = $location_link;

                $location_data['address'] = $location_address;
                $location_data['street_number'] = $location_street_number;
                $location_data['street_name'] = $location_street_name;
                $location_data['street_name_short'] = $location_street_name_short;
                $location_data['city'] = $location_city;
                $location_data['state'] = $location_state;
                $location_data['state_short'] = $location_state_short;
                $location_data['zip'] = $location_post_code;
                $location_data['latitude'] = $location_lat;
                $location_data['longitude'] = $location_lng;

                $location_data['place_id'] = $location_place_id;

                $location_data['phone'] = $location_phone; 
                $location_data['email'] = $location_email;
                $location_data['website'] = $location_website;                
                $location_data['hours'] = $location_hours;

                $location_data['categories'] = $location_category_array;

                $location_data['icon_default'] = $icon_default;
                $location_data['icon_active'] = $icon_active;
                
                //at this point, we're ready to push the location's data into the return array
                array_push($locations_return,$location_data); 
            }
        }  

        wp_reset_postdata();

        return $locations_return;      
    }

    function get_all_locations_via_api() {
        //
    }

    //We need a function to pull the search string from the URL's query parameters. This gets passed to the locations map vue app, and is used to trigger a search on load:
    function get_locations_search_term() {
        //declare return variable as empty string:
        $search_term = '';

        //grab current full URL string via PHP server variable
        $url = $_SERVER['REQUEST_URI'];

        //use parse_url to separate the query string parameter
        $parts = parse_url($url);
        
        //if the query string parameter exists, separate the actual search term from it & assign it to the return variable:
        if (array_key_exists('query', $parts)) {         
            //replace query key with nothing, '+' with a space, & '%2C+' with a comma & spacing
            $search_term = str_replace(['search=', '%2C+', '+'] ,['',', ', ' '],$parts['query']);
        }
        
        return $search_term;
    }
?>
