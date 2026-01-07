<?php
    //this file holds any functions related to WP-Admin customization:

    function custom_admin_style() {
        echo '<style>
            /* restricting the width of all module reference images: */
            .wp-admin img.module-reference {
                max-width: 100%;
            }
        </style>';
    }
    add_action( 'admin_head', 'custom_admin_style' );
?>