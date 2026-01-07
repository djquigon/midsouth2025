<?php
    //we'll only print this info if we've got info for all of the recommended schema properties set in the ACF Options tab; a name, complete address, telephone AND email, URL
    
    if (
        isset(get_field('schema_names','options')['name']) &&
        isset(get_field('schema_address','options')['streetaddress']) &&
        isset(get_field('schema_address','options')['addresslocality']) &&
        isset(get_field('schema_address','options')['addressregion']) &&
        isset(get_field('schema_address','options')['postalcode']) &&
        isset(get_field('schema_address','options')['addresscountry']) &&
        isset(get_field('schema_contactpoint','options')['telephone']) &&
        isset(get_field('schema_contactpoint','options')['email']) &&
        get_field('schema_url','options')
    ) :

        $names = get_field('schema_names','options');
        $default_name = $names['name'];
        $alternateName = $names['alternatename'];
        $legalName = $names['legalname'];

        $address = get_field('schema_address','options');
        $streetAddress = $address['streetaddress'];
        $addressLocality = $address['addresslocality'];
        $addressRegion = $address['addressregion'];
        $postalCode = $address['postalcode'];
        $addressCountry = $address['addresscountry'];

        $contactPoint = get_field('schema_contactpoint','options');
        $telephone = $contactPoint['telephone'];
        $email = $contactPoint['email'];

        $description = get_field('schema_description','options');

        $foundingDate = get_field('schema_foundingdate','options');

        $logo = get_field('schema_logo','options');

        $numberOfEmployees = get_field('schema_numberofemployees','options');

        $URL = get_field('schema_url','options');
?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Organization",
                "name": "<?= $default_name ?>",
                <?php 
                    if ($alternateName) : 
                ?>
                        "alternateName": "<?= $alternateName ?>",
                <?php 
                    endif; 

                    if ($legalName) : 
                ?>
                        "legalName": "<?= $legalName ?>",
                <?php 
                    endif; 

                    if ($description) :
                ?>
                        "description": "<?= $description ?>",
                <?php
                    endif;

                    if ($foundingDate) :
                ?>
                        "foundingDate": "<?= $foundingDate ?>",
                <?php
                    endif;

                    if ($numberOfEmployees) :
                ?>
                        "numberOfEmployees": "<?= $numberOfEmployees ?>",
                <?php
                    endif;

                    if ($logo) :
                ?>
                        "logo": "<?= $logo['url'] ?>",
                <?php
                    endif;
                ?>
                "url": "<?= $URL ?>",                
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "<?= $streetAddress ?>",
                    "addressLocality": "<?= $addressLocality ?>",
                    "addressCountry": "<?= $addressCountry ?>",
                    "addressRegion": "<?= $addressRegion ?>",
                    "postalCode": "<?= $postalCode ?>"
                },
                "contactPoint": {
                    "contactType": "ContactPoint",
                    "email": "<?= $email ?>",
                    "telephone": "<?= $telephone ?>"
                }
            }
        </script>
<?php
    endif;
?>