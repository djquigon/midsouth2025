<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="dns-prefetch" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

<?php
    //Put your Favicon meta tags here (outside of the PHP delimeter):
?>

<?php
    //GTM Container Script pt 1.
    get_template_part('views/global/widgets/google-tag-manager/container-script-head');

    //Structured Data Schema - Organization Info
    if (is_front_page() || is_page()) {
        //this info will only appear on the Homepage by default. If a dedicated 'About' page is set in the ACF Options Tab, it will appear on that page too.
        echo get_template_part('views/conditional/pages/front-page/schema/organization');
    } else if (get_field('schema_about_page','options') && is_page(get_field('schema_about_page','options'))) {
        echo get_template_part('views/conditional/pages/front-page/schema/organization');
    }
    wp_head();
?>
</head>

<body <?php body_class(); ?>>
<?php
    //GTM Container Script pt 2.
    get_template_part('views/global/widgets/google-tag-manager/container-script-body');
    wp_body_open();

    //Include loading animation on homepage if it's toggled on in ACF Options tab
    if (is_front_page() && is_loading_animation_enabled()) {
        echo get_template_part('views/global/widgets/loading-animation/loading-animation');
    }
?>

    <header id="header" class="header">
        <?php
        //Include emergency message if it's toggled on in ACF Options tab
        if (is_emergency_message_enabled()) {
            echo get_template_part('views/global/widgets/emergency-message/emergency-message');
        }
        ?>

        <?php
        //This is here for accessibility, & allows the user to skip the menu(s) if 'tabbing' through the site
        ?>
        <a class="skip-content" href="#main" title="Skip navigation menu links to go to main content of page" tabindex="0" data-visually-hidden="true">Skip navigation menu links to go to main content of page</a>


        <?php
            //If a secondary menu is created AND assigned to the appropriate menu location:
            if (has_nav_menu('secondary_menu')) {
                get_template_part('views/global/header/navigation/secondary-menu/secondary-menu');
            }
        ?>

        <?php
            //You're always going to have a primary nav area that includes a site logo with a link to the homepage. 
            //You'll find included in this file, the trigger for the toggled nav(s) (Mobile or Desktop)
            //Move this stuff around as needed.
            get_template_part('views/global/header/navigation/primary-menu/primary-menu');
        ?>

        <?php
            //We're almost always going to have a toggle nav. Mobile, desktop, or both.
            get_template_part('views/global/header/navigation/toggled-menu/toggled-menu');
        ?>

        <?php
            //If the Popup post type is activated, include our Popup widget here:
            if (post_type_exists('mandr_popup')) {
                get_template_part('views/global/widgets/popup/popup');
            }
        ?>
    </header>
    <?php
    //The Events Calendar plugin's options for customizing their templates creates a conflict with our new M&R theme directory structure. So, we'd like to avoid customizing templates their way unless absolutely necessary. By default, their views lack a <main> tag, which is essential for our <header>'s fixed styling. We call a function based on post type that will open the <main> here, & close it in footer.php:
    if (get_post_type() === 'tribe_events') {
        mandr_open_semantic_main_tag();
    }
    ?>