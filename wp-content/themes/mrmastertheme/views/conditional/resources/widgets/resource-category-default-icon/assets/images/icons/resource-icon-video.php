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
        <svg xmlns="http://www.w3.org/2000/svg" width="52" height="42" viewBox="0 0 52 42">
            <g id="Group_1166" data-name="Group 1166" transform="translate(-332 -784.071)">
                <g id="Group_1053" data-name="Group 1053" transform="translate(9749 563.071) rotate(90)">
                <g id="Rectangle_174" data-name="Rectangle 174" transform="translate(221 9365)" fill="none" stroke="<?= $default_icon_stroke_fill ?>" stroke-width="2">
                    <rect width="42" height="52" stroke="none"/>
                    <rect x="1" y="1" width="40" height="50" fill="none"/>
                </g>
                </g>
                <text id="Video" transform="translate(344 820.071)" fill="<?= $default_icon_stroke_fill ?>" font-size="10" font-family="CenturyGothic-Bold, Century Gothic" font-weight="700"><tspan x="0" y="0">Video</tspan></text>
                <g id="Polygon_11" data-name="Polygon 11" transform="translate(367 790.071) rotate(90)" fill="none">
                <path d="M9,0l9,16H0Z" stroke="none"/>
                <path d="M 9 4.079453468322754 L 3.419692039489746 14 L 14.58030700683594 14 L 9 4.079453468322754 M 9 0 L 18 16 L 0 16 L 9 0 Z" stroke="none" fill="<?= $default_icon_stroke_fill ?>"/>
                </g>
            </g>
        </svg>
    </a>
</figure>