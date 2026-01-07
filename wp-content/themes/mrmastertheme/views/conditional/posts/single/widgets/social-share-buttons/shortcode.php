<?php
    //my intention when naming the files in this directory was to keep everything "plugin-agnostic". The plugin we are currently using is: https://wordpress.org/plugins/add-to-any/
?>
<div 
    class="social-share-buttons" 
    data-flex="flex" 
    data-align-items="center"
>
    <span class="label">Share this post:</span>
    <?= do_shortcode('[addtoany]') ?>
</div>
