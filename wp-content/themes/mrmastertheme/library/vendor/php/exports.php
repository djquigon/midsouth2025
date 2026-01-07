<?php
    //We're always going to be using ACF
    require_once TEMPLATEPATH . '/library/vendor/php/advanced-custom-fields/functions.php';

    //Other Plugin-specific hooks.php files are only imported if the plugin is active:

    //Gravity Forms:
    if (class_exists('GFCommon')) {
        require_once TEMPLATEPATH . '/library/vendor/php/gravity-forms/hooks.php';
    }

    //WooCommerce:
    if( class_exists( 'WooCommerce' ) ) {
        require_once TEMPLATEPATH . '/library/vendor/php/woocommerce/archive/hooks.php';
        require_once TEMPLATEPATH . '/library/vendor/php/woocommerce/single/hooks.php';
    }

    //Tribe Events Calendar:
    if( class_exists( 'Tribe__Events__Main' ) ) {
        require_once TEMPLATEPATH . '/library/vendor/php/tribe-events-calendar/archive/hooks.php';
        require_once TEMPLATEPATH . '/library/vendor/php/tribe-events-calendar/single/hooks.php';
    }
?>