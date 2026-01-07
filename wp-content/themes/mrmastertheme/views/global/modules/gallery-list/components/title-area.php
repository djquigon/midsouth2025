<?php
    //first we set up the arguments passed from the Gallery List module's main php file:
    $module_title = $args['module_title'];

    $include_intro_content = $args['include_intro_content'];
    $intro_content = $args['intro_content'];

    $all_galleries_button_text = $args['all_galleries_button_text'];
    $all_galleries_button_link = $args['all_galleries_button_link'];

    $text_color_attribute = $args['text_color_attribute'];

    if ($module_title || ($all_galleries_button_text && $all_galleries_button_link)) : 
?>
        <div class="title-all-button-row">
            <div class="container"<?= $text_color_attribute ?>>
                <?php
                    if ($module_title) :
                ?>
                        <h2 class="title"><?= $module_title ?></h2>
                <?php
                    endif;

                    if ($all_galleries_button_text && $all_galleries_button_link) :
                ?>
                        <a 
                            href="<?= $all_galleries_button_link ?>" 
                            class="button" 
                            data-mobile-hide="true"
                            aria-label="View All Galleries"
                        >
                            <?= $all_galleries_button_text ?>
                        </a>
                <?php
                    endif;
                ?>
                <span 
                    class="container-settings" 
                    data-flex="flex" 
                    data-justify-content="space-between" 
                    data-align-items="center"
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