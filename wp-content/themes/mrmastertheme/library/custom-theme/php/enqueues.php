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

	// BaconPay embed (for loanpay-button): load only on pages that do NOT use the calculator shortcodes,
	// so Practical Money Skills calculators (auto_calculator_interest, personal_calculator) can run without conflict.
	$load_baconpay = true;
	if (is_singular()) {
		$content = get_post()->post_content ?? '';
		if (has_shortcode($content, 'auto_calculator_interest') || has_shortcode($content, 'personal_calculator')) {
			$load_baconpay = false;
		}
	}
	if ($load_baconpay) {
		wp_enqueue_script('baconpay-embed', 'https://web.baconpay.com/embed.js', [], null, true);
	}

	//Font(s) 
	wp_enqueue_style('google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400,700', false, NULL);
    //wp_enqueue_style('adobe-fonts', 'INSERT_ADOBE_FONTS_URL_HERE', false, NULL);

	//CSS 
	wp_enqueue_style('style', get_stylesheet_uri(), false, filemtime(get_stylesheet_directory() . '/style.css'));
    
    //Vimeo SDK — only the homepage video hero uses the Vimeo Player API (title-area.js -> new Vimeo.Player).
    //Content pages that reference Vimeo only fetch oembed thumbnails (server-side) or open Magnific iframe
    //popups, neither of which needs player.js. Scoping this to the homepage(s) removes an unused third-party
    //request from every other page while leaving the hero untouched. (Perf remediation item C.)
	if (is_front_page() || (is_page() && has_term('secondary-homepage', 'page_category'))) {
		wp_enqueue_script('vimeo-sdk', 'https://player.vimeo.com/api/player.js', null, null, false);
	}
}
add_action('wp_enqueue_scripts', 'my_script');

// Perf remediation (item F): Gravity Forms reCAPTCHA v3 enqueues its scripts on EVERY front-end page
// (for cross-page interaction scoring), even on pages with no form — a ~344KB third-party payload.
// Flag when a Gravity Form actually renders, then dequeue reCAPTCHA in the footer when none did.
// Form pages (contact-us, loan-application, and any page/popup that renders a GF form) are untouched:
// gform_enqueue_scripts fires during form render, before wp_footer, so the flag is set in time.
add_action('gform_enqueue_scripts', function () {
	$GLOBALS['mr_gravity_form_rendered'] = true;
});
add_action('wp_footer', function () {
	if (empty($GLOBALS['mr_gravity_form_rendered'])) {
		wp_dequeue_script('gforms_recaptcha_recaptcha');        // https://www.google.com/recaptcha/api.js
		wp_dequeue_script('gforms_recaptcha_frontend');         // GF >= 2.9
		wp_dequeue_script('gforms_recaptcha_frontend-legacy');  // older GF
	}
}, 1);

//M&R Branding Styles - include only if toggled on in ACF Options tab:
if (get_field('enable_mandr_theme_styling','options')) {
    add_action('wp_enqueue_scripts', function(){
        wp_enqueue_style('mandr-styling', '/wp-content/themes/mrmastertheme/library/mandr/mandr-style.css', false, filemtime(get_stylesheet_directory() . '/library/mandr/mandr-style.css'));
        wp_enqueue_style('mandr-fonts', '//use.typekit.net/jro3hnx.css', false, NULL);  
    },999);
}