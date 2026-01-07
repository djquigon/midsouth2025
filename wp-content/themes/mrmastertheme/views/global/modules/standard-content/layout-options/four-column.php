<?php
    //all the data for THIS row
    $content_row = $args['content_row'];

    //colors are set in the module's settings
    $text_color_attribute = $args['text_color_attribute'];

    //grab the settings for this row
    if (isset($content_row['container_width'])) {
        $container_width = $content_row['container_width'];
    } else {
        $container_width = false;
    }

    if (isset($content_row['include_lr_padding'])) {
        $widest_container_padding = $content_row['include_lr_padding'];
    } else {
        $widest_container_padding = false;
    }
    
    $column_count = $content_row['column_count'];

    //grab the content for each column
    $column_content_fourths_one = $content_row['column_content_fourths_one'];
    $column_content_fourths_two = $content_row['column_content_fourths_two'];
    $column_content_fourths_three = $content_row['column_content_fourths_three'];
    $column_content_fourths_four = $content_row['column_content_fourths_four'];
?>
<div class="content-row">
    <div class="columns">
        <div class="column one"<?= $text_color_attribute ?>>
            <?= $column_content_fourths_one ?>
        </div>
        <div class="column two"<?= $text_color_attribute ?>>
            <?= $column_content_fourths_two ?>
        </div>
        <div class="column three"<?= $text_color_attribute ?>>
            <?= $column_content_fourths_three ?>
        </div>
        <div class="column four"<?= $text_color_attribute ?>>
            <?= $column_content_fourths_four ?>
        </div>
    </div>
    <span 
        class="row-settings" 
        data-column-count="<?= $column_count ?>" 
        <?php
            if ($container_width) :
        ?>
                data-container-width="<?= $container_width ?>"
        <?php
            endif;
        
            if ($widest_container_padding) : 
        ?> 
                data-container-padding="true"
        <?php 
            endif; 
        ?>
    >
        <span class="validator-text" data-nosnippet>row settings</span>
    </span>
</div>