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

    //if we're using a 2-column layout, determine what the widths of the columns will be 
    $column_widths = $content_row['column_widths']; 

    if ($column_widths['dual_column_width_selection'] === 'variable') {

        $left_column_width = $column_widths['left_column_width']; 
        $right_column_width = $column_widths['right_column_width']; 
    } else {
        $left_column_width = 'one-half'; 
        $right_column_width = 'one-half';
    }

    //we also need to factor in the possibility of reverse ordering a 2-column layout for mobile UX:
    $mobile_reverse_order = $content_row['reverse_order_mobile'];
    
    if ($mobile_reverse_order) {
        $mobile_reverse_order_attribute = ' data-mobile-reverse-order="true"';
    } else {
        $mobile_reverse_order_attribute = '';
    }

    //grab the content 
    $column_content_left = $content_row['column_content_halves_left'];
    $column_content_right = $content_row['column_content_halves_right'];
?>
<div class="content-row">
    <div class="columns"<?= $mobile_reverse_order_attribute ?>>
        <div class="column left <?= $left_column_width ?>"<?= $text_color_attribute ?>>
            <?= $column_content_left ?>
        </div>
        <div class="column right <?= $right_column_width ?>"<?= $text_color_attribute ?>>
            <?= $column_content_right ?>
        </div>
    </div>
    <span 
        class="row-settings" 
        data-column-count="<?= $column_count ?>" 
        data-column-width="<?= $column_widths['dual_column_width_selection'] ?>" 
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