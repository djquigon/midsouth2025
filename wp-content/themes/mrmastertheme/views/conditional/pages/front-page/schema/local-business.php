<?php
    // We'll only print this info if we have the required LocalBusiness schema fields set in the ACF Options tab.
    $names = get_field('schema_names', 'options');
    $address = get_field('schema_address', 'options');
    $contactPoint = get_field('schema_contactpoint', 'options');
    $URL = get_field('schema_url', 'options');

    if (
        isset($names['name']) &&
        isset($address['streetaddress']) &&
        isset($address['addresslocality']) &&
        isset($address['addressregion']) &&
        isset($address['postalcode']) &&
        isset($address['addresscountry']) &&
        isset($contactPoint['telephone']) &&
        isset($contactPoint['email']) &&
        $URL
    ) :
        $logo = get_field('schema_logo', 'options');

        $local_business_schema = array(
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => trailingslashit($URL) . '#localbusiness',
            'name' => $names['name'],
            'url' => $URL,
            'telephone' => $contactPoint['telephone'],
            'email' => $contactPoint['email'],
            'address' => array(
                '@type' => 'PostalAddress',
                'streetAddress' => $address['streetaddress'],
                'addressLocality' => $address['addresslocality'],
                'addressRegion' => $address['addressregion'],
                'postalCode' => $address['postalcode'],
                'addressCountry' => $address['addresscountry'],
            ),
        );

        if (isset($names['legalname']) && $names['legalname']) {
            $local_business_schema['legalName'] = $names['legalname'];
        }

        if (get_field('schema_description', 'options')) {
            $local_business_schema['description'] = get_field('schema_description', 'options');
        }

        if ($logo && isset($logo['url'])) {
            $local_business_schema['logo'] = $logo['url'];
            $local_business_schema['image'] = $logo['url'];
        }
?>
        <script type="application/ld+json">
            <?= wp_json_encode($local_business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
        </script>
<?php
    endif;
?>
