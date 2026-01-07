<?php
    //grab the color settings from the Resource category's (taxonomy term) ACF:
    $resource_category_term_id = $args['resource_type_term_id'];
    $default_icon_background = $args['default_icon_background'];
    $default_icon_stroke_fill = $args['default_icon_stroke_fill'];

    if ($default_icon_background) {
        $style_string = ' style="--default-icon-background: '.$default_icon_background.'"';
    } else {
        $style_string = '';
    }
?>
<figure class="default-icon"<?= $style_string ?>>
    <a 
        href="/resources/?resource-search=&resource-category=<?= $resource_category_term_id ?>"
        data-flex="flex"
        data-justify-content="center"
        data-align-items="center"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="52" viewBox="0 0 42 52">
            <g id="Group_1164" data-name="Group 1164" transform="translate(-337 -453.07)">
                <g id="Group_1049" data-name="Group 1049" transform="translate(116 -8911.93)">
                <g id="Rectangle_174" data-name="Rectangle 174" transform="translate(221 9365)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2">
                    <rect width="42" height="52" stroke="none"/>
                    <rect x="1" y="1" width="40" height="50" fill="none"/>
                </g>
                <line id="Line_7" data-name="Line 7" x2="25" transform="translate(229.5 9377.5)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_8" data-name="Line 8" x2="25" transform="translate(229.5 9384)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_9" data-name="Line 9" x2="25" transform="translate(229.5 9391)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                </g>
                <text id="PDF" transform="translate(348 496.071)" fill="<?= $default_icon_stroke_fill ?>" font-size="12" font-family="CenturyGothic-Bold, Century Gothic" font-weight="700"><tspan x="0" y="0">PDF</tspan></text>
            </g>
        </svg>
    </a>
</figure>
