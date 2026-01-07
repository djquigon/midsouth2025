<?php

//jQuery include, allowing auto select of http or https 
function my_jquery_enqueue()
{
	wp_deregister_script('jquery');
	wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js", false, NULL);
	wp_enqueue_script('jquery');
}
if (!is_admin()) {
	add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
}

//Enqueue JS and CSS 
function my_script()
{

	//Javascript 
	wp_enqueue_script('header-scripts', get_stylesheet_directory_uri() . '/header.min.js', array('jquery'), filemtime(get_template_directory() . '/header.min.js'));
    wp_enqueue_script('footer-scripts', get_stylesheet_directory_uri() . '/footer.min.js', '', filemtime(get_template_directory() . '/footer.min.js'), true);

	//Font(s) 
	wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700', false, NULL);
    //wp_enqueue_style('adobe-fonts', 'INSERT_ADOBE_FONTS_URL_HERE', false, NULL);

	//CSS 
	wp_enqueue_style('style', get_stylesheet_uri(), false, filemtime(get_stylesheet_directory() . '/style.css'));
    
    //Vimeo SDK
	wp_enqueue_script('vimeo-sdk', 'https://player.vimeo.com/api/player.js', null, null, false);
}
add_action('wp_enqueue_scripts', 'my_script');

//M&R Branding Styles - include only if toggled on in ACF Options tab:
if (get_field('enable_mandr_theme_styling','options')) {
    add_action('wp_enqueue_scripts', function(){
        wp_enqueue_style('mandr-styling', '/wp-content/themes/mrmastertheme/library/mandr/mandr-style.css', false, filemtime(get_stylesheet_directory() . '/library/mandr/mandr-style.css'));
        wp_enqueue_style('mandr-fonts', '//use.typekit.net/jro3hnx.css', false, NULL);  
    },999);
}