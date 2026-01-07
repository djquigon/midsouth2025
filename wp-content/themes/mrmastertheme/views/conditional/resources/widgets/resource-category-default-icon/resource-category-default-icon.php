<?php
    //we'll use this file to grab the background & stroke/fill colors from the resource category term's ACF fields. 
    $resource_category_term_id = $args['resource_type_term_id'];

    $default_icon_background = get_field('default_icon_background','resource_category_'.$resource_category_term_id);

    $default_icon_stroke_fill = get_field('default_icon_stroke_fill','resource_category_'.$resource_category_term_id);

    //declare array to be passed to the icon file as arguments:
    $icon_arguments = [
        'resource_type_term_id' => $resource_category_term_id,
        'default_icon_background' => $default_icon_background,
        'default_icon_stroke_fill' => $default_icon_stroke_fill,
    ];

    //We'll also determine exactly which default icon to grab, and pass those colors to it so that they can be plugged into the SVG & passed to the CSS as a variable
    if ($resource_category_term_id === 36) {
        //Video
        echo get_template_part('views/conditional/resources/widgets/resource-category-default-icon/assets/images/icons/resource-icon-video', null, $icon_arguments);
    } elseif ($resource_category_term_id === 38) {
        //PDF
        echo get_template_part('views/conditional/resources/widgets/resource-category-default-icon/assets/images/icons/resource-icon-pdf', null, $icon_arguments);
    } elseif ($resource_category_term_id === 40) {
        //Excel
        echo get_template_part('views/conditional/resources/widgets/resource-category-default-icon/assets/images/icons/resource-icon-excel', null, $icon_arguments);
    } elseif ($resource_category_term_id === 37) {
        //Word
        echo get_template_part('views/conditional/resources/widgets/resource-category-default-icon/assets/images/icons/resource-icon-word', null, $icon_arguments);
    }
?>