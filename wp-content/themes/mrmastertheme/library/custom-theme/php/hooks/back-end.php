<?php
 //Hide styling things from editors 
add_action('admin_head', 'mandr_hide_acf_styling_fields');
function mandr_hide_acf_styling_fields()
{
    if (!current_user_can('administrator')) : ?>
        <style>
            .acf-field[data-name="section_class"],
            .acf-field[data-name="toggle_id"] {
                display: none;
            }
        </style>
    <?php endif;
    ?>
    <style>
        .acf-postbox>.inside {
            width: 960px;
            max-width: 100%;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .acf-flexible-content .layout .acf-fc-layout-handle {
            background-color: #676767;
            color: #fff;
        }

        .acf-row:nth-child .acf-row-handle.order,
        .acf-row:nth-child .acf-row-handle.remove {
            background-color: #ebebeb;
            color: #777;
        }

        .acf-row:nth-child(2n) .acf-row-handle.order,
        .acf-row:nth-child(2n) .acf-row-handle.remove {
            background-color: #ccc;
            color: #fff;
        }

        .acf-fields>.acf-field.new-tab-link {
            border-top: none;
            padding-top: 0;
        }

        .acf-fields>.acf-field.new-tab-link .acf-label {
            width: 0;
            height: 0;
            margin: 0;
            padding: 0;
            visibility: hidden;
            overflow: hidden;
        }

        .clearfield {
            clear: both !important;
        }
    </style>
    <?php
}

//Make it easier to identify M&R Custom Post Types
add_action('admin_head', 'mandr_style_cpt_icons');
function mandr_style_cpt_icons()
{
    //but only do it if the M&R Branding is enabled:
    if (get_field('enable_mandr_theme_styling', 'options')) {
    ?>
        <style>
            ul#adminmenu li[id*="mandr"] a div.wp-menu-image:before {
                color: #FEDB00;
            }
        </style>
<?php
    }
}

//Remove wp version from wp_head output 
remove_action('wp_head', 'wp_generator');

//By default, in Add/Edit Post, WordPress moves checked categories to the top of the list, and unchecked to the bottom. When you have subcategories that you want to keep below their parents at all times, this makes no sense. This function removes that automatic reordering so the categories widget retains its order regardless of checked state.
//Thanks to https://stackoverflow.com/a/12586404
add_filter('wp_terms_checklist_args', 'taxonomy_checklist_checked_ontop_filter');
function taxonomy_checklist_checked_ontop_filter($args)
{
    $args['checked_ontop'] = false;
    return $args;
}

// Gallery Default settings
add_filter('media_view_settings', 'mandr_gallery_defaults');
function mandr_gallery_defaults($settings)
{
    $settings['galleryDefaults']['link'] = 'file';
    $settings['galleryDefaults']['columns'] = 4;
    $settings['galleryDefaults']['size'] = 'thumbnail';
    return $settings;
}

//Add SEO description from custom field. Will only show inside source <meta>
//Also pull custom field into description textarea field

//add_filter('the_seo_framework_custom_field_description', 'generate_acf_description_meta', 10, 2);
//add_filter('the_seo_framework_fetched_description_excerpt', 'generate_acf_description_meta', 10, 2);
function generate_acf_description_meta($desc, $args)
{
    // If description already set, just return that
    if ($desc !== '') {
        return $desc;
    }

    // Grab custom field information
    $custom_field = get_field('update_with_custom_field_name');
    if ($custom_field) {
        $desc = filter_var($custom_field, FILTER_SANITIZE_STRING) ?: $desc;
        return $desc;
    }
}

// Add shortcode to SEO Framework descriptions
//add_filter( 'the_seo_framework_custom_field_description', 'enable_seo_framework_shortcode', 10, 2 );
function enable_seo_framework_shortcode($description, $args)
{
    return do_shortcode($description);
}

// Hide the 'Attachment Page' option for the link-to part.
add_action('print_media_templates', function () {
    echo '
            <style>       
                .post-php select.link-to option[value="post"],
                .post-php select[data-setting="link"] option[value="post"] 
                { display: none; }
            </style>';
});

//Change the image attachment "link to" none by default
//https://wordpress.org/support/topic/insert-image-default-to-no-link
update_option('image_default_link_type', 'none');

// Adds access to 'Edit Theme Options' for 'Editors'
// Restricts capabilities to only 'Menu' access
add_action('admin_init', 'get_editor_role');
function get_editor_role()
{
    /* Get 'Editor' role and add capabilities */
    $roleObject = get_role('editor');

    if (!$roleObject->has_cap('edit_theme_options')) {
        $roleObject->add_cap('edit_theme_options');
    }
}

add_action('admin_menu', 'mandr_editor_capability_access');
function mandr_editor_capability_access()
{
    //Remove menu access if user does not have ability to create users, i.e. not an Administrator

    // Uncomment to debug menu items
    // global $menu, $submenu;
    // echo '<pre>'; print_r( $menu ); echo '</pre>'; // TOP LEVEL MENUS
    // echo '<pre>'; print_r( $submenu ); echo '</pre>'; // SUBMENUS

    remove_menu_page('edit-comments.php');

    if (!current_user_can('create_users')) {

        // ** Main Menus **
        //remove_menu_page( 'edit.php' );					//Posts
        //remove_menu_page( 'index.php' );                  //Dashboard
        //remove_menu_page( 'upload.php' );                 //Media
        //remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page('edit-comments.php');          //Comments
        remove_menu_page('themes.php');                 //Appearance
        //remove_menu_page( 'plugins.php' );                //Plugins
        //remove_menu_page( 'users.php' );                  //Users
        remove_menu_page('tools.php');                  //Tools
        //remove_menu_page( 'options-general.php' );        //Settings

        // ** Submenus **
        //global $submenu;
        remove_submenu_page('themes.php', 'themes.php');
        //remove_submenu_page( 'themes.php', 'widgets.php' );
        remove_submenu_page('themes.php', 'theme-editor.php');

        //Add new menu item. This one links to the custom menu
        //https://developer.wordpress.org/reference/functions/add_menu_page/
        add_menu_page('Page Title', 'Menus', 'edit_others_posts', 'nav-menus.php', '', 'dashicons-menu', 72);
        //add_menu_page( 'Page Title', 'Widgets', 'edit_others_posts', 'widgets.php', '', 'dashicons-screenoptions', 73 );
    }
}

// Adjust what shows up on the New part of Admin Bar
add_action('admin_bar_menu', 'mandr_admin_bar_editing', 999);
function mandr_admin_bar_editing()
{
    global $wp_admin_bar;
    //$wp_admin_bar->remove_node( 'new-post' );
}

//WP dashboard menu ids to removeChild(about, wporg, documentation, support-forums, feedback)
add_action('wp_before_admin_bar_render', 'mytheme_admin_bar_render');
function mytheme_admin_bar_render()
{
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('comments');
}

//Completely Disable Comments_link:
//https://www.dfactory.eu/wordpress-how-to/turn-off-disable-comments/

// Disable support for comments and trackbacks in post types
add_action('admin_init', 'df_disable_comments_post_types_support');
function df_disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}

// enable shortcodes in sidebar
add_filter('widget_text', 'do_shortcode');

//Remove 'Preview Changes' button
add_action('admin_head', 'removePreviewButtonFromPages');
function removePreviewButtonFromPages()
{
    // $pt = get_current_screen()->post_type;
    // if ( $pt != 'post') {
    echo '<style>
                #post-preview{
                    display:none !important;
                    }               
                } 
            </style>';
    // } 
}

// Remove default 'About Yourself' fields from User Profiles, replaced by ACF fields
add_action('admin_head', 'removeDefaultAboutYourself');
function removeDefaultAboutYourself()
{
    //only print this hacky CSS if we're on a user profile page:
    if (get_current_screen()->id == 'profile') {
        echo '<style>
                    form#your-profile h2:nth-of-type(4) ,
                    form#your-profile h2:nth-of-type(4) + table {
                        display: none;
                    }
                </style>';
    }
}

// Redirect any user trying to access comments page
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
function df_disable_comments_admin_menu_redirect()
{
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(home_url());
        exit;
    }
}


//	Disable Emojis
//http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
add_action('init', 'disable_wp_emojicons');
function disable_wp_emojicons()
{
    // all actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');

    // filter to remove TinyMCE emojis
    add_filter('tiny_mce_plugins', 'disable_emojicons_tinymce');
}
function disable_emojicons_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}


//For Resource Post Types, force an association with the resource file type with a corresponding category
add_action('save_post', 'mandr_resource_force_file_type_category');
function mandr_resource_force_file_type_category($post_id)
{
    // If this is a revision, get real post ID.
    $parent_id = wp_is_post_revision($post_id);

    if (false !== $parent_id) {
        $post_id = $parent_id;
    }

    //unhook this function so it doesn't loop infinitely
    remove_action('save_post', 'set_object_terms');

    //First, evaluate the resource type (Video/File) :
    if (get_field('resource_type', $post_id) === false) {
        //if this ACF boolean field returns false, we know it's a Video type Resource post:
        wp_set_object_terms($post_id, 'video', 'resource_category', true);
    } else {
        //we know it's a File type Resource post. Based on the uploaded file type, we'll assign a corresponding resource_category taxonomy term:
        if (get_field('file_upload', $post_id)) {
            $uploaded_file_name = get_field('file_upload', $post_id)['filename'];

            if (
                str_contains($uploaded_file_name, 'xlsx') ||
                str_contains($uploaded_file_name, 'csv')
            ) {
                //if it's an excel file:
                wp_set_object_terms($post_id, 'excel', 'resource_category', true);
            } elseif (
                str_contains($uploaded_file_name, 'docx') ||
                str_contains($uploaded_file_name, 'doc') ||
                str_contains($uploaded_file_name, 'rtf')
            ) {
                //if it's a word doc:
                wp_set_object_terms($post_id, 'word', 'resource_category', true);
            } elseif (str_contains($uploaded_file_name, 'pdf')) {
                //if it's a PDF:
                wp_set_object_terms($post_id, 'pdf', 'resource_category', true);
            } else {
                //some other unrecognizable file type:
                return;
            }
        } else {
            //if there's no uploaded file:
            return;
        }
    }

    //re-hook this function.
    add_action('save_post', 'set_object_terms');
}