<?php
    //Set up our data from the arguments passed to this template file:
    $background_image_url = $args['background_image']['url'];
    $background_image_position = $args['background_image_position'];
?>
<span class="module-settings" data-nosnippet>
    <span 
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single"
    >
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
    <span 
        class="background" 
        style="background-image:url('<?= $background_image_url ?>')" 
        data-background-image-position="<?= $background_image_position ?>"
    >
        <span class="validator-text" data-nosnippet>background settings</span>
    </span> 
    <span class="validator-text">module settings</span>
</span>
