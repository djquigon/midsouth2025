<?php
    //only proceed if we've got 'Locations' registered as a post type:
    if (post_type_exists('mandr_location')) :

        //we may not always want to use <section>, and instead opt for <aside> or <div>
        $tag_type = get_sub_field('tag_type');

        //in case we need an ID or additional class names:
        $unique_identifiers = get_sub_field('unique_identifiers');
        $module_id = $unique_identifiers['id'];
        $module_class_names = $unique_identifiers['class_names'];

        //build out the opening tag HTML:
        if ($module_id && $module_class_names) {
            $opening_tag = '<'.$tag_type.' id="'.$module_id.'" class="locations-map-cards '.$module_class_names.'">';
        } else if ($module_id && !$module_class_names) {
            $opening_tag = '<'.$tag_type.' id="'.$module_id.'" class="locations-map-cards">';
        } else if (!$module_id && $module_class_names) {
            $opening_tag = '<'.$tag_type.' class="locations-map-cards '.$module_class_names.'">';
        } else {
            $opening_tag = '<'.$tag_type.' class="locations-map-cards">';
        }
        
        //build out the closing tag HTML
        $closing_tag = '</'.$tag_type.'>';

        //grab the container width from settings
        $container_width = get_sub_field('container_width');

        //grab the top & bottom padding settings values, for both desktop & mobile
        $padding_settings = get_sub_field('padding');
        $top_padding_desktop = $padding_settings['top_padding_desktop'];
        $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
        $top_padding_mobile = $padding_settings['top_padding_mobile'];
        $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

        //build out the padding settings <span> HTML:
        $padding_settings_tag = '<span class="padding" data-top-padding-desktop="'.$top_padding_desktop.'" data-bottom-padding-desktop="'.$bottom_padding_desktop.'" data-top-padding-mobile="'.$top_padding_mobile.'" data-bottom-padding-mobile="'.$bottom_padding_mobile.'"><span class="validator-text" data-nosnippet>padding settings</span></span>';


        //establish the background settings
        $background_settings = get_sub_field('background');
        $background_type = $background_settings['background_type'];

        if ($background_type === 'color') {
            $background_color = $background_settings['background_color'];

            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-color:'.$background_color.'"><span class="validator-text" data-nosnippet>background settings</span></span>';

        } else if ($background_type === 'image') {
            $background_image = $background_settings['background_image'];
            $background_image_url = $background_image['url'];
            $background_image_position = $background_settings['background_image_position'];

            //use an overlay if it's set up:
            if ($background_settings['include_overlay']) {
                $background_image_overlay = $background_settings['overlay_color'];

                //build out the background settings <span> HTML:
                $background_settings_tag = '<span class="background" style="background-image:url('.$background_image_url.'); --overlay-color:'.$background_image_overlay.'" data-background-overlay="true" data-background-image-position="'.$background_image_position.'"><span class="validator-text" data-nosnippet>background settings</span></span>';
            } else {
                //build out the background settings <span> HTML:
                $background_settings_tag = '<span class="background" style="background-image:url('.$background_image_url.')" data-background-image-position="'.$background_image_position.'"><span class="validator-text" data-nosnippet>background settings</span></span>';
            }
        } else {
            //transparent background, so no need for settings <span> HTML:
            $background_settings_tag = '';
        }

        //text color settings - these affect the entire module but are applied at the column level
        $text_color_settings = get_sub_field('text_color');

        //if any of these color fields are used, we'll use them to build out CSS variables to add to each row, at the column level
        if ($text_color_settings['headings_color'] || $text_color_settings['body_text_color'] || $text_color_settings['link_color'] || $text_color_settings['link_hover_color']) {
            $text_color_attribute = 'style="';

            if ($text_color_settings['headings_color']) {
                $text_color_attribute .= '--headings-color:'.$text_color_settings['headings_color'].';';    
            }

            if ($text_color_settings['body_text_color']) {
                $text_color_attribute .= '--body-text-color:'.$text_color_settings['body_text_color'].';';    
            }

            if ($text_color_settings['link_color']) {
                $text_color_attribute .= '--link-color:'.$text_color_settings['link_color'].';';    
            }

            if ($text_color_settings['link_hover_color']) {
                $text_color_attribute .= '--link-hover-color:'.$text_color_settings['link_hover_color'].';';    
            }

            $text_color_attribute .= '"';
        } 
        
        if (
            empty($text_color_settings['headings_color']) &&
            empty($text_color_settings['body_text_color']) &&
            empty($text_color_settings['link_color']) &&
            empty($text_color_settings['link_hover_color'])
        ) {
            $text_color_attribute = '';
        }

        //declare a function that will pass the relevant locations data as a JSON object to our Google Maps JavaScript:
        function mandr_build_json_from_locations($locations) {
            //declare an array to return as JSON object:
            $locations_return_object = [];

            //check if the 'M&R Branding' ACF Option is enabled from the WP Admin. Based on this, determine which default & active icons we'll use. These can be changed per client, just replace the SVG(s)
            if (get_field('enable_mandr_theme_styling','options')) {
                $icon_default = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/mandr-location-marker-default.svg';
                
                $icon_active = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/mandr-location-marker-active.svg';
            } else {
                $icon_default = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/default-icon.svg';
                
                $icon_active = get_bloginfo('url').'/wp-content/themes/mrmastertheme/views/conditional/pages/locations-page/modules/locations-map/vendor/mandr-vue-app/src/assets/icons/default-icon-active.svg';
            }

            //loop through the locations, we set up the ACF field to return an ID instead of a whole object, to keep things lite:
            foreach ($locations as $location_id) {
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

                $location_data['icon_default'] = $icon_default;
                $location_data['icon_active'] = $icon_active;
                
                //at this point, we're ready to push the location's data into the return array
                array_push($locations_return_object,$location_data); 
            }

            return $locations_return_object;
        }
?>
<?php
        //grab our module title, locations, & button fields:
        $module_title = get_sub_field('module_title');
        $locations = get_sub_field('locations');
        $all_locations_button = get_sub_field('all_locations_button');
        $all_locations_button_text = $all_locations_button['button_text'];
        $all_locations_button_link = $all_locations_button['button_link'];


        if ($locations) :   
            //call the previously declared function that loops through the locations & builds a JSON object to pass to the Google Maps script. We're referencing 'footer-scripts' here because this module's javascript file will be compiled into it:
            wp_localize_script('footer-scripts', 'the_locations', mandr_build_json_from_locations($locations));

            echo $opening_tag;
    ?>      
                <?php
                    if ($module_title) :
                ?>
                        <div class="content-row">
                            <div class="columns">
                                <div class="column">
                                    <h2><?= $module_title ?></h2>
                                </div>
                            </div>
                            <span 
                                class="row-settings" 
                                data-column-count="one"
                                data-container-width="<?= $container_width ?>"
                            >
                                <span class="validator-text" data-nosnippet>row settings</span>
                            </span>
                        </div>
                <?php
                    endif;
                ?>
                <div class="content-row">
                    <div class="columns" data-mobile-reverse-order="true">
                        <div class="column map"<?= $text_color_attribute ?>>
                            <div id="map-module"></div>
                            <?php
                                if ($all_locations_button_text && $all_locations_button_link) : 
                            ?>
                                    <a href="<?= $all_locations_button_link ?>" class="button all-locations"><?= $all_locations_button_text ?></a>
                            <?php
                                endif;
                            ?>
                        </div>
                        <div class="column cards"<?= $text_color_attribute ?>>
                            <ul 
                                class="cards-list"
                                data-flex="flex"
                                data-flex-wrap="wrap"
                                data-column-gap="large"
                                data-row-gap="large"
                            >
                                <?php
                                    //loop through the locations, spit out all the relevant info:
                                    foreach ($locations as $location_id) :
                                        //name
                                        $location_name = get_the_title($location_id);

                                        //link
                                        $location_link = get_post_permalink($location_id);

                                        //grab the google location info (for map)
                                        $location_info = get_field('location_info',$location_id);
                                        $location_geolocation_info = $location_info['geolocation'];
                                        
                                        $location_address = $location_geolocation_info['address'];
                                        
                                        //we'll need to format the address string so that it reads correctly:
                                        $location_address_string = $location_geolocation_info['name'] . '<br>' . $location_geolocation_info['city'] . ', ' . $location_geolocation_info['state_short'] . ' ' . $location_geolocation_info['post_code'];

                                        
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
                                ?>
                                        <li>
                                            <h3><?= $location_name ?></h3>
                                            <?php
                                                //address link:
                                                if ($location_address && $location_place_id) :
                                            ?>
                                                    <a href="https://www.google.com/maps/place/?q=place_id:<?= $location_place_id ?>" target="_blank"><?= $location_address_string ?></a>
                                            <?php
                                                endif;

                                                //hours
                                                if ($location_hours) {
                                                    echo $location_hours;
                                                }

                                                //phone
                                                if ($location_phone) :
                                            ?>
                                                    <span class="phone">
                                                        <a href="tel:<?= $location_phone ?>"><?= $location_phone ?></a>
                                                    </span>
                                            <?php
                                                endif;
                                                
                                                //email
                                                if ($location_email) :
                                            ?>
                                                    <span class="email">
                                                        <a href="mailto:<?= $location_email ?>"><?= $location_email ?></a>
                                                    </span>
                                            <?php
                                                endif;
                                            
                                                //website
                                                if ($location_website) :
                                            ?>
                                                    <span class="website">
                                                        <a href="<?= $location_website ?>" target="_blank">View Website</a>
                                                    </span>
                                            <?php
                                                endif;
    
                                                //permalink
                                                if ($location_link) :
                                            ?>
                                                    <span class="permalink">
                                                        <a href="<?= $location_link ?>">View Location</a>
                                                    </span>
                                            <?php
                                                endif;
                                            ?>
                                        </li>
                                <?php
                                    endforeach;
                                ?>
                            </ul>
                        </div>
                    </div>
                    <span 
                        class="row-settings" 
                        data-column-count="two"
                        data-column-gap="large"
                        data-container-width="<?= $container_width ?>"
                    >
                        <span class="validator-text" data-nosnippet>row settings</span>
                    </span>
                </div>
                <span class="module-settings" data-nosnippet>
                    <?= $padding_settings_tag ?>
                    <?= $background_settings_tag ?>
                    <span class="validator-text">module settings</span>
                </span>
    <?php
            echo $closing_tag;
        endif;
    endif;
?>