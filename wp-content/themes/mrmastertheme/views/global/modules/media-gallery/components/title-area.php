<?php
    //first we set up the arguments passed from the Project List module's main php file:
    $module_title = $args['module_title'];

    $include_intro_content = $args['include_intro_content'];
    $intro_content = $args['intro_content'];
    
    $text_color_attribute = $args['text_color_attribute'];

    if ($module_title) : 
?>
        <div class="title-row">
            <div class="container"<?= $text_color_attribute ?>>
                <?php
                    if ($module_title) :
                ?>
                        <h2 class="title"><?= $module_title ?></h2>
                <?php
                    endif;
                ?>
                <span 
                    class="container-settings" 
                    data-container-width="standard"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php 
    endif; 

    if ($include_intro_content && $intro_content) :
?>
        <div class="intro-content-row">
            <div class="container"<?= $text_color_attribute ?>>
                <?= $intro_content ?>
                <span 
                    class="container-settings" 
                    data-container-width="standard"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php 
    endif; 
?>