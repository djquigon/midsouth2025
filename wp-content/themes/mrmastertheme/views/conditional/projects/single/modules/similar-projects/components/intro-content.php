<?php
    $module_title = $args['module_title'];
    $intro_content = $args['intro_content'];
    $text_color_attribute = $args['text_color_attribute'];
    $container_width = $args['container_width'];
?>
<div class="intro-content-row">
    <div class="container" <?= $text_color_attribute ?>>
        <?php
            if ($module_title) {
                echo '<h2 class="module-title">'.$module_title.'</h2>';
            }
        
            if ($intro_content) {
                echo $intro_content; 
            }
        ?>
        <span
            class="container-settings"
            data-container-width="<?= $container_width ?>">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
</div>