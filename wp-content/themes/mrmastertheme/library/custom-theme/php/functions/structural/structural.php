<?php
    //The Events Calendar plugin's options for customizing their templates creates a conflict with our new M&R theme directory structure. So, we'd like to avoid customizing templates their way unless absolutely necessary. By default, their views lack a <main> tag, which is essential for our <header>'s fixed styling. We call a function based on post type that will open the <main> in header.php, & close it in footer.php:
    function mandr_open_semantic_main_tag() {
        echo '<main id="main" class="primary-content">';
    }

    function mandr_close_semantic_main_tag() {
        echo '</main>';
    }   
?>