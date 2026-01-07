<?php
    //Remove Gravity Forms secure URL hash
    add_filter( 'gform_permission_granted_pre_download', 'mandr_permissions_override', 10, 3);
    function mandr_permissions_override($permission_granted, $form_id, $field_id ) {	
        $permission_granted = true;
        
        return $permission_granted;
    }

    //Grab referrer url for form hidden field 'immrefurl'
    add_filter( 'gform_field_value_immrefurl', 'mandr_immediate_referral_url');
    function mandr_immediate_referral_url( $form ){
        $url = $_SERVER['HTTP_REFERER'];

        return esc_url_raw($url);
    }

    //editors can see entries, notes
    add_action( 'admin_init', 'mr_grav_editing_caps' );
    function mr_grav_editing_caps() {
        $editor = get_role('editor');

        /*
        if( $editor->has_cap('') ) {
            $editor->remove_cap('');
        }
        if( !$editor->has_cap('') ) {
            $editor->add_cap('');
        }
        */

        // gravity forms add
        if( !$editor->has_cap('gravityforms_view_entries') ) {
            $editor->add_cap('gravityforms_view_entries');
        }
        if( !$editor->has_cap('gravityforms_edit_entry_notes') ) {
            $editor->add_cap('gravityforms_edit_entry_notes');
        }
        if( !$editor->has_cap('gravityforms_view_entry_notes') ) {
            $editor->add_cap('gravityforms_view_entry_notes');
        }

        // gravity forms remove
        if( $editor->has_cap('gform_full_access') ) {
            $editor->remove_cap('gform_full_access');
        }
    }

    //Downloads require login
	add_filter( 'gform_require_login_pre_download', 'mandr_require_login', 10, 3 );
	function mandr_require_login( $require_login, $form_id, $field_id ) {
		return true;
	}

    //Append header + footer to all emails
	//add_filter( 'gform_notification', 'form_notification_email', 10, 3 );
	function form_notification_email($notification, $form, $entry) {
		
		$notification['message'] = email_header().$notification['message'];
		
		return $notification;
	}

	function email_header() {
		return '<div style="margin-top:14pt;margin-bottom:14pt;"><img style="border-width: 0px;" _src="https://www.bikethomson.com/wp-content/themes/bike_thomson/images/logo-dark.png" src="https://www.bikethomson.com/wp-content/themes/bike_thomson/images/logo-dark.png" alt="Bike Thomson"></div>';
	}

    //Remove tab indexes
	add_filter( 'gform_tabindex', '__return_false' ); 

    /*
    Adjusting the HTML of the submit button to match design
    @param $button string required The text string of the button we're editing
    @param $form array required The whole form object
    @return string The new HTML for the button
    */
	add_filter( 'gform_submit_button', 'mandr_form_submit_button', 10, 5 );
	function mandr_form_submit_button ( $button, $form ){
		$button = str_replace( "input", "button", $button );
		$button = str_replace( "/", "", $button );
		$button .= "{$form['button']['text']}</button>";
		return $button;
	}

    //Ensure that only valid form submissions are reported to GA4 (via GTM) and spam is left out
    add_filter('gform_confirmation', 'inject_valid_submission_marker', 10, 4);
    function inject_valid_submission_marker($confirmation, $form, $entry, $ajax) {
        // Only for non-spam entries
        if (rgar($entry, 'status') === 'spam') {
            return $confirmation;
        }
    
        $marker = '<div id="gf_valid_submission_marker" style="display:none;"></div>';
    
        // Handle redirect confirmation
        if (is_array($confirmation) && isset($confirmation['redirect'])) {
            $redirect_url = $confirmation['redirect'];
    
            // Add query param to indicate valid submission
            $redirect_url = add_query_arg('gf_submitted', '1', $redirect_url);
            $confirmation['redirect'] = $redirect_url;
    
            return $confirmation;
        }
    
        // Handle inline confirmation
        if (is_array($confirmation)) {
            $confirmation['message'] .= $marker;
        } else {
            $confirmation .= $marker;
        }
    
        return $confirmation;
    } 