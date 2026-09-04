<?php
    // We'll only print this info when the current page has the required Service schema fields set.
    if (!function_exists('get_field') || !is_singular()) {
        return;
    }

    $post_id = get_queried_object_id();

    if (!$post_id || !get_field('schema_service_enabled', $post_id)) {
        return;
    }

    $service_type = get_field('schema_service_type', $post_id);
    $description = get_field('schema_service_description', $post_id);
    $area_served_rows = get_field('schema_service_area_served', $post_id);

    if (!$service_type || !$description || empty($area_served_rows)) {
        return;
    }

    $service_name = get_field('schema_service_name', $post_id) ?: get_the_title($post_id);
    $service_url = get_permalink($post_id);
    $service_image = get_field('schema_service_image', $post_id);
    $service_audience = get_field('schema_service_audience', $post_id);
    $offer_name = get_field('schema_service_offer_name', $post_id);
    $offer_url = get_field('schema_service_offer_url', $post_id);
    $offer_description = get_field('schema_service_offer_description', $post_id);

    $contact_point = get_field('schema_contactpoint', 'options');
    $organization_names = get_field('schema_names', 'options');
    $organization_url = get_field('schema_url', 'options');
    $logo = get_field('schema_logo', 'options');

    $service_phone = get_field('schema_service_phone', $post_id) ?: ($contact_point['telephone'] ?? '');
    $service_email = get_field('schema_service_email', $post_id) ?: ($contact_point['email'] ?? '');

    $area_served = array();

    foreach ($area_served_rows as $area_served_row) {
        $area_name = $area_served_row['area_name'] ?? '';
        $area_type = $area_served_row['area_type'] ?? 'AdministrativeArea';

        if (!$area_name) {
            continue;
        }

        if ($area_type === 'Text') {
            $area_served[] = $area_name;
            continue;
        }

        $area_served[] = array(
            '@type' => $area_type,
            'name' => $area_name,
        );
    }

    if (empty($area_served)) {
        return;
    }

    $service_schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        '@id' => trailingslashit($service_url) . '#service',
        'name' => $service_name,
        'serviceType' => $service_type,
        'description' => wp_strip_all_tags($description),
        'url' => $service_url,
        'mainEntityOfPage' => array(
            '@type' => 'WebPage',
            '@id' => $service_url,
        ),
        'areaServed' => $area_served,
    );

    if ($organization_url) {
        $service_schema['provider'] = array(
            '@type' => 'LocalBusiness',
            '@id' => trailingslashit($organization_url) . '#localbusiness',
            'url' => $organization_url,
        );

        if (isset($organization_names['name']) && $organization_names['name']) {
            $service_schema['provider']['name'] = $organization_names['name'];
        }
    }

    if ($service_audience) {
        $service_schema['audience'] = array(
            '@type' => 'Audience',
            'audienceType' => $service_audience,
        );
    }

    if ($service_image && isset($service_image['url'])) {
        $service_schema['image'] = $service_image['url'];
    } else if (get_the_post_thumbnail_url($post_id, 'full')) {
        $service_schema['image'] = get_the_post_thumbnail_url($post_id, 'full');
    } else if ($logo && isset($logo['url'])) {
        $service_schema['image'] = $logo['url'];
    }

    if ($offer_name || $offer_url || $offer_description) {
        $service_schema['offers'] = array(
            '@type' => 'Offer',
        );

        if ($offer_name) {
            $service_schema['offers']['name'] = $offer_name;
        }

        if ($offer_url) {
            $service_schema['offers']['url'] = $offer_url;
        }

        if ($offer_description) {
            $service_schema['offers']['description'] = wp_strip_all_tags($offer_description);
        }
    }

    if ($service_phone || $service_email) {
        $service_schema['availableChannel'] = array(
            '@type' => 'ServiceChannel',
            'serviceUrl' => $offer_url ?: $service_url,
            'servicePhone' => array(
                '@type' => 'ContactPoint',
            ),
        );

        if ($service_phone) {
            $service_schema['availableChannel']['servicePhone']['telephone'] = $service_phone;
        }

        if ($service_email) {
            $service_schema['availableChannel']['servicePhone']['email'] = $service_email;
        }
    }
?>
        <script type="application/ld+json">
            <?= wp_json_encode($service_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); ?>
        </script>
