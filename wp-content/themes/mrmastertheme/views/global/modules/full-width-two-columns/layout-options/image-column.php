<?php
    //we pass the column data to this template file as an argument
    $column = $args['column'];

    $column_width = $column['width']; 
    $column_background_image = $column['column_background_image']; 
    

    if ($column) :
?>
        <div 
            class="column"
            data-column-type="image"
            style="--column-width:<?= $column_width ?>%;background-image:url('<?= $column_background_image['url'] ?>')"
        >
            <picture data-desktop-hide="true">
                <img 
                    src="<?= $column_background_image['url'] ?>" 
                    width="<?= $column_background_image['width'] ?>" 
                    height="<?= $column_background_image['height'] ?>" 
                    alt="<?= $column_background_image['alt'] ?>"
                >
            </picture>
        </div>
<?php
    endif;
?>
