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
            <g id="Group_1165" data-name="Group 1165" transform="translate(-1019 -779.07)">
                <g id="Group_1055" data-name="Group 1055" transform="translate(798 -8585.93)">
                <g id="Rectangle_174" data-name="Rectangle 174" transform="translate(221 9365)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2">
                    <rect width="42" height="52" stroke="none"/>
                    <rect x="1" y="1" width="40" height="50" fill="none"/>
                </g>
                <line id="Line_7" data-name="Line 7" x2="25" transform="translate(229.5 9380.5)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_126" data-name="Line 126" x2="25" transform="translate(229.5 9374.5)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_8" data-name="Line 8" x2="25" transform="translate(229.5 9386.5)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_9" data-name="Line 9" x2="25" transform="translate(229.5 9393.5)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_122" data-name="Line 122" y2="18.948" transform="translate(230.5 9374.052)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_123" data-name="Line 123" y2="18.948" transform="translate(253.5 9374.052)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_124" data-name="Line 124" y2="18.948" transform="translate(245.5 9374.052)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                <line id="Line_125" data-name="Line 125" y2="18.948" transform="translate(238.5 9374.052)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2"/>
                </g>
                <text id="Excel" transform="translate(1027 821.071)" fill="<?= $default_icon_stroke_fill ?>" font-size="10" font-family="CenturyGothic-Bold, Century Gothic" font-weight="700"><tspan x="0" y="0">Excel</tspan></text>
            </g>
        </svg>
    </a>
</figure>