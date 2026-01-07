<?php
    $location_id = get_the_id();

    //use the location ID to get the featured image ID
    $location_image_id = get_post_thumbnail_id($location_id); 

    //based on if we actually have an image, configure the settings we'll use later:
    if ($location_image_id) {
        $location_listing_column_count = 'two';

        //assign a post image size, these are set up in library/custom-theme/php/initialization.php
        $location_image_size_name = 'medium-portrait';

        //use featured image ID & size name to grab all the relevant info:
        $location_image_url = wp_get_attachment_image_url($location_image_id, $location_image_size_name);
        $location_image_width = wp_get_attachment_image_src($location_image_id, $location_image_size_name)[1];
        $location_image_height = wp_get_attachment_image_src($location_image_id, $location_image_size_name)[2];
        $location_image_alt = get_post_meta($location_image_id, '_wp_attachment_image_alt', TRUE);
    } else {
        $location_listing_column_count = 'one';
    }

    if (get_field('location_info')) :
        $location_info = get_field('location_info');
        
        $geolocation = $location_info['geolocation'];
        $contact_information = $location_info['contact_information']; 

        $phone = $contact_information['phone'];
        $email = $contact_information['email'];
        $website_url = $contact_information['website_url'];
        $hours = $contact_information['hours'];
?>
        <section class="location-info">
            <div class="content-row">
                <div class="columns">
                    <?php
                        if ($location_image_id) :
                            //if image exists, 2 column layout for listing:
                    ?>
                            <div class="column one-half">
                                <h2>Location Information</h2>
                                <ul class="location-information">
                                <?php
                                    if ($geolocation) :
                                        $address = $geolocation['address']
                                ?>
                                        <li class="address">
                                            <span class="label">
                                                <strong>Address: </strong>
                                            </span>
                                            <a 
                                                href="https://www.google.com/maps/search/<?= $address ?>" target="_blank"
                                            >
                                                <?= $address ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($phone) : 
                                ?>
                                        <li class="phone">
                                            <span class="label">
                                                <strong>Phone: </strong>
                                            </span>
                                            <a href="tel:<?= $phone ?>">
                                                <?= $phone ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($email) : 
                                ?>
                                        <li class="email">
                                            <span class="label">
                                                <strong>Email: </strong>
                                            </span>
                                            <a href="mailto:<?= $email ?>">
                                                <?= $email ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($website_url) : 
                                        //do some additional formatting before printing:
                                        $website_url = str_replace('http://', '', $website_url);

                                        if (!str_contains($website_url, 'https://')) {
                                            $website_url = 'https://'.$website_url;
                                        }
                                ?>
                                        <li class="website">
                                            <span class="label">
                                                <strong>Website: </strong>
                                            </span>
                                            <a 
                                                href="<?= $website_url ?>" 
                                                target="_blank"
                                            >
                                                <?= $website_url ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($hours) :
                                ?> 
                                        <li class="hours">
                                            <span class="label">
                                                <strong>Hours: </strong>
                                            </span>
                                            <?= $hours ?>
                                        </li>
                                <?php
                                    endif;
                                ?>
                                </ul>
                            </div>
                            <div class="column one-half">
                                <figure>
                                    <img 
                                        src="<?= $location_image_url ?>" 
                                        height="<?= $location_image_height ?>" 
                                        width="<?= $location_image_width ?>" 
                                        alt="<?= $location_image_alt ?>"
                                    > 
                                </figure>                 
                            </div>
                    <?php
                        else: 
                            //if there's no image, just a single column:
                    ?>
                            <div class="column">
                                <h2>Location Information</h2>
                                <ul class="location-information">
                                <?php
                                    if ($geolocation) :
                                        $address = $geolocation['address']
                                ?>
                                        <li class="address">
                                            <span class="label">
                                                <strong>Address: </strong>
                                            </span>
                                            <a 
                                                href="https://www.google.com/maps/search/<?= $address ?>" target="_blank"
                                            >
                                                <?= $address ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($phone) : 
                                ?>
                                        <li class="phone">
                                            <span class="label">
                                                <strong>Phone: </strong>
                                            </span>
                                            <a href="tel:<?= $phone ?>">
                                                <?= $phone ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($email) : 
                                ?>
                                        <li class="email">
                                            <span class="label">
                                                <strong>Email: </strong>
                                            </span>
                                            <a href="mailto:<?= $email ?>">
                                                <?= $email ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($website_url) : 
                                        //do some additional formatting before printing:
                                        $website_url = str_replace('http://', '', $website_url);

                                        if (!str_contains($website_url, 'https://')) {
                                            $website_url = 'https://'.$website_url;
                                        }
                                ?>
                                        <li class="website">
                                            <span class="label">
                                                <strong>Website: </strong>
                                            </span>
                                            <a 
                                                href="<?= $website_url ?>" 
                                                target="_blank"
                                            >
                                                <?= $website_url ?>
                                            </a>
                                        </li>
                                <?php
                                    endif;

                                    if ($hours) :
                                ?> 
                                        <li class="hours">
                                            <span class="label">
                                                <strong>Hours: </strong>
                                            </span>
                                            <?= $hours ?>
                                        </li>
                                <?php
                                    endif;
                                ?>
                                </ul>
                            </div>
                    <?php
                        endif;
                    ?>
                </div>
                <span 
                    class="row-settings" 
                    data-container-width="standard"
                    data-column-count="<?= $location_listing_column_count ?>"  
                >
                    <span class="validator-text" data-nosnippet>row settings</span>
                </span>
            </div> 
            <span class="module-settings" data-nosnippet="">
                <span 
                    class="padding" 
                    data-top-padding-desktop="none" 
                    data-bottom-padding-desktop="double" 
                    data-top-padding-mobile="none" 
                    data-bottom-padding-mobile="single"
                >
                    <span class="validator-text" data-nosnippet="">padding settings</span>
                </span>                                
                <span class="validator-text">module settings</span>
            </span>
        </section>
<?php
    endif;
?>