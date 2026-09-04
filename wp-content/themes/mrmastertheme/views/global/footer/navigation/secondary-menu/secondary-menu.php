<?php
//Optional secondary footer links:
?>
<?php
if (has_nav_menu('footer_menu_secondary')) {
    wp_nav_menu(array(
        'container'      => 'ul',
        'menu_class'     => 'secondary-menu',
        'menu_id'        => '',
        'depth'          => 0,
        'theme_location' => 'footer_menu_secondary'
    ));
}
?>
