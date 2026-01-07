<?php
    //we pass the column data to this template file as an argument
    $column = $args['column'];
    $padding_settings_tag = $args['padding_settings_tag'];
    $text_color_attribute = $args['text_color_attribute'];

    $column_width = $column['width']; 
    $column_content = $column['column_content']; 
     

    //establish the background settings 
    $column_background = $column['content_background'];   
    $background_type = $column_background['background_type'];  

    //we're using a boolean ACF field. True = Image, False = Color
    if ($background_type) {
        $background_image = $column_background['background_image'];
        $background_image_url = $background_image['url'];

        //use an overlay if it's set up:
        if ($column_background['background_image_overlay']) {
            $background_image_overlay = $column_background['background_image_overlay'];

            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" ><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')"><span class="validator-text" data-nosnippet>background settings</span></span>';
        }
        
    } else if (!$background_type) {
        $background_color = $column_background['background_color'];

        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            //transparent background, so no need for settings <span> HTML:
            $background_settings_tag = '';
    }


    if ($column) :
?>
        <div 
            class="column"
            data-column-type="content"
            data-flex="flex"
            data-justify-content="center"
            data-align-items="center"
            style="--column-width:<?= $column_width ?>%;"
        >
            <div class="content"<?= $text_color_attribute ?>>
                <?= $column_content ?>
            </div>
            <span class="column-settings">
                <?= $padding_settings_tag ?>
                <?= $background_settings_tag ?>
                <span class="validator-text" data-nosnippet>column settings</span>
            </span>
        </div>
<?php
    endif;
?>
