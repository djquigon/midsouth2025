<?php
    //Set up our data from the arguments passed to this template file:
    $background = $args['background']; 

    $content = $background['content'];
    $container_width = $args['container_width'];
    $text_color_attribute = $args['text_color_attribute'];
    
    //For this layout, background image HTML is handled in: /components/background-image.php 
    if ($content) :
?>
        <div 
            class="content-row"
            data-flex="flex"
            data-justify-content="center"
            data-align-items="center"
        >
            <div class="container">
                <div 
                    class="content"
                    <?= $text_color_attribute ?>
                >
                    <?= $content ?>
                </div>
                <span 
                    class="container-settings"
                    data-container-width="<?= $container_width ?>" 
                >
                    <span class="validator-text" data-nosnippet>container settings</span>
                </span>
            </div>
        </div>
<?php
    endif;
?>