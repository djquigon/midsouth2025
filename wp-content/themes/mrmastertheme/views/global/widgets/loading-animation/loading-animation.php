<?php
    if (get_field('loading_animation_background_color','options')) {
        $background_color = get_field('loading_animation_background_color','options');
    } else {
        $background_color = '#FFFFFF';
    }

    if (get_field('loading_animation_logo_color','options')) {
        $logo_color = 'full-color';
    } else {
        $logo_color = 'white';
    }
?>
<div id="loading-delay" style="background-color: <?= $background_color ?>">
    <div id="animation-wrap" class="clearfix">
        <div id="logo-wrap">
            <img src="<?php bloginfo('template_url') ?>/library/custom-theme/images/logos/logo.png" alt="<?= bloginfo('name') ?> Logo">
        </div>
    </div>  
</div>
<script>
    $(document).ready(function(){
        $('#loading-delay').delay(1000).fadeOut(1500);
    });	
</script>