<?php
//Previously, we handled all custom post type initialization in the mu-plugins folder & file. For convenience, we've moved those functions here.

add_action('after_setup_theme', 'mandr_custom_post_type_initialization');
function mandr_custom_post_type_initialization()
{
    //Our most frequently occurring custom post types can be toggled on/off in our ACF Options tab:

    //FAQs
    if (get_field('mandr_cpt_faqs', 'options')) {
        add_action('init', 'mandr_create_faq_cpt');
    }

    //Galleries (Photo &/ Video)
    if (get_field('mandr_cpt_galleries', 'options')) {
        add_action('init', 'mandr_create_gallery_cpt');
    }

    //Locations
    if (get_field('mandr_cpt_locations', 'options')) {
        add_action('init', 'mandr_create_location_cpt');

        //also initialize the locations map feature:
        require_once TEMPLATEPATH . '/views/conditional/pages/locations-page/modules/locations-map/vue-starter.php';
    }

    //Portfolio Projects
    if (get_field('mandr_cpt_projects', 'options')) {
        add_action('init', 'mandr_create_project_cpt');
    }

    //Resources
    if (get_field('mandr_cpt_resources', 'options')) {
        add_action('init', 'mandr_create_resource_cpt');
    }

    //Services
    if (get_field('mandr_cpt_services', 'options')) {
        add_action('init', 'mandr_create_service_cpt');
    }

    //Locations
    if (get_field('mandr_cpt_team_members', 'options')) {
        add_action('init', 'mandr_create_team_cpt');
    }

    //Testimonials
    if (get_field('mandr_cpt_services', 'options')) {
        add_action('init', 'mandr_create_testimonial_cpt');
    }

    //Popups
    if (get_field('mandr_cpt_popups', 'options')) {
        add_action('init', 'mandr_create_popup_cpt');
    }
}

//All the functions for registering custom post types, their settings, and their taxonomies:

//FAQs
function mandr_create_faq_cpt()
{

    $post_type_singular = 'FAQ';
    $post_type_plural = 'FAQs';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-status', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'editor'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => false,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Gallery (Photo &/ Video)
function mandr_create_gallery_cpt()
{

    $post_type_singular = 'Gallery';
    $post_type_plural = 'Galleries';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-gallery', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'thumbnail', 'excerpt'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Locations
function mandr_create_location_cpt()
{
    $post_type_singular = 'Location';
    $post_type_plural = 'Locations';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-location', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'thumbnail'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => false,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        'query_var'                => false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Portfolio Projects
function mandr_create_project_cpt()
{
    $post_type_singular = 'Project';
    $post_type_plural = 'Projects';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-portfolio', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'thumbnail', 'excerpt'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Resources
function mandr_create_resource_cpt()
{
    $post_type_singular = 'Resource';
    $post_type_plural = 'Resources';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-archive', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'thumbnail', 'excerpt'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Services
function mandr_create_service_cpt()
{
    $post_type_singular = 'Service';
    $post_type_plural = 'Services';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-hammer', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'thumbnail'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Team Members
function mandr_create_team_cpt()
{

    $post_type_singular = 'Team Member';
    $post_type_plural = 'Team Members';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-groups', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'thumbnail'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => 'team',
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    // Register Department taxonomy
    $department_taxonomy_single = 'Department';
    $department_taxonomy_plural = 'Departments';
    $department_taxonomy_name = 'department';

    $department_taxonomy_labels = array(
        'name'                       => $department_taxonomy_plural,
        'singular_name'              => $department_taxonomy_single,
        'search_items'               => 'Search ' . $department_taxonomy_plural,
        'popular_items'              => 'Popular ' . $department_taxonomy_plural,
        'all_items'                  => 'All ' . $department_taxonomy_plural,
        'parent_item'                => 'Parent ' . $department_taxonomy_single,
        'parent_item_colon'          => 'Parent ' . $department_taxonomy_single . ':',
        'edit_item'                  => 'Edit ' . $department_taxonomy_single,
        'update_item'                => 'Update ' . $department_taxonomy_single,
        'add_new_item'               => 'Add New ' . $department_taxonomy_single,
        'new_item_name'              => 'New ' . $department_taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $department_taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $department_taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $department_taxonomy_plural,
        'not_found'                  => 'No ' . $department_taxonomy_plural . ' found.',
        'menu_name'                  => $department_taxonomy_plural
    );

    $department_taxonomy_args = array(
        'hierarchical'      => true,
        'labels'            => $department_taxonomy_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'         => 'department',
            'with_front'   => false
        )
    );

    register_taxonomy($department_taxonomy_name, $post_type_name, $department_taxonomy_args);
}

//Popups
function mandr_create_popup_cpt()
{
    $post_type_singular = 'Popup';
    $post_type_plural = 'Popups';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-warning', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'editor'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);
}

//Testimonials
function mandr_create_testimonial_cpt()
{

    $post_type_singular = 'Testimonial';
    $post_type_plural = 'Testimonials';
    $post_type_name = 'mandr_' . strtolower(str_replace(' ', '_', $post_type_singular));

    $post_type_labels = array(
        'name'                => $post_type_plural,
        'singular_name'       => $post_type_singular,
        'menu_name'           => $post_type_plural,
        'name_admin_bar'      => $post_type_plural,
        'parent_item_colon'   => $post_type_singular . ':',
        'all_items'           => 'All ' . $post_type_plural,
        'add_new_item'        => 'Add New ' . $post_type_singular,
        'add_new'             => 'Add New ' . $post_type_singular,
        'new_item'            => 'New ' . $post_type_singular,
        'edit_item'           => 'Edit ' . $post_type_singular,
        'update_item'         => 'Update ' . $post_type_singular,
        'view_item'           => 'View ' . $post_type_singular,
        'search_items'        => 'Search ' . $post_type_singular,
        'not_found'           => $post_type_singular . ' not found',
        'not_found_in_trash'  => $post_type_singular . ' not found in Trash',
        'item_published'      => $post_type_singular . ' published',
        'item_published_privately' => $post_type_singular . ' published privately.',
        'item_reverted_to_draft' => $post_type_singular . ' reverted to draft.',
        'item_scheduled'      => $post_type_singular . ' scheduled.',
        'item_updated'        => $post_type_singular . ' updated.'
    );

    $args = array(
        'label'                  => $post_type_plural,
        'labels'              => $post_type_labels,
        //'description'		  => '',
        'public'              => true,
        //'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => true,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-testimonial', // https://developer.wordpress.org/resource/dashicons/
        //'capability_type'     => 'post', 
        //'capabilities'		  => array( ),
        //'map_meta_cap'		  => null,
        //'hierarchical'		  => false,
        'supports'            => array('title', 'editor'),
        //'register_meta_box_cb'	=> '',
        //'taxonomies'		  => '',
        'has_archive'         => true,
        //'permalink_epmask'	  => EP_PERMALINK,
        'rewrite'              => array(
            'slug'         => strtolower($post_type_plural),
            'with_front' => false,
            'feeds'        => false,
            //'ep_mask'	=> EP_PERMALINK
        ),
        //'query_var'				=> false
        //'can_export'          => true, // (boolean) (optional) Can this post_type be exported.
    );

    register_post_type($post_type_name, $args);

    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = strtolower($post_type_singular) . '_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, $post_type_name, $taxonomy_args);
}

//Apply a custom 'category' taxonomy to the 'page' post type. This will allow us to circumvent the default 'page template' functionality, & use 'page category' in our ACF field group creation & page.php conditionals. This allows for more consistency with this custom theme's directory structure:
function mandr_create_page_category_taxonomy()
{
    $taxonomy_single = 'Category';
    $taxonomy_plural = 'Categories';
    $taxonomy_name = 'page_' . strtolower($taxonomy_single);

    $taxonomy_labels = array(
        'name'                       => $taxonomy_single,
        'singular_name'              => $taxonomy_single,
        'search_items'               => 'Search ' . $taxonomy_plural,
        'popular_items'              => 'Popular ' . $taxonomy_plural,
        'all_items'                  => 'All ' . $taxonomy_plural,
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => 'Edit ' . $taxonomy_single,
        'update_item'                => 'Update ' . $taxonomy_single,
        'add_new_item'               => 'Add New ' . $taxonomy_single,
        'new_item_name'              => 'New ' . $taxonomy_single . ' Name',
        'separate_items_with_commas' => 'Separate ' . $taxonomy_plural . ' with commas',
        'add_or_remove_items'        => 'Add or remove ' . $taxonomy_plural,
        'choose_from_most_used'      => 'Choose from the most used ' . $taxonomy_plural,
        'not_found'                  => 'No ' . $taxonomy_plural . ' found.',
        'menu_name'                  => $taxonomy_plural
    );
    $taxonomy_args = array(
        'hierarchical'    => false,
        'labels'    => $taxonomy_labels,
        'show_ui'    => true,
        'show_admin_column' => true,
        'query_var'    => false
    );
    register_taxonomy($taxonomy_name, 'page', $taxonomy_args);
}
add_action('init', 'mandr_create_page_category_taxonomy');
