<?php
    //we may not always want to use <section>, and instead opt for <aside> or <div>
    $tag_type = get_sub_field('tag_type');


    //in case we need an ID or additional class names:
    $unique_identifiers = get_sub_field('unique_identifiers');
    $module_id = $unique_identifiers['id'];
    $module_class_names = $unique_identifiers['class_names'];

    //build out the closing tag HTML
    $closing_tag = '</' . $tag_type . '>';

    //grab the container width from settings
    $container_width = get_sub_field('container_width');


    //build out the opening tag HTML:
    if ($module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="history-timeline ' . $module_class_names . '">';
    } else if ($module_id && !$module_class_names) {
        $opening_tag = '<' . $tag_type . ' id="' . $module_id . '" class="history-timeline">';
    } else if (!$module_id && $module_class_names) {
        $opening_tag = '<' . $tag_type . ' class="history-timeline ' . $module_class_names . '">';
    } else {
        $opening_tag = '<' . $tag_type . ' class="history-timeline">';
    }


    //grab the top & bottom padding settings values, for both desktop & mobile
    $padding_settings = get_sub_field('padding');
    $top_padding_desktop = $padding_settings['top_padding_desktop'];
    $bottom_padding_desktop = $padding_settings['bottom_padding_desktop'];
    $top_padding_mobile = $padding_settings['top_padding_mobile'];
    $bottom_padding_mobile = $padding_settings['bottom_padding_mobile'];

    //build out the padding settings <span> HTML:
    $padding_settings_tag = '<span class="padding" data-top-padding-desktop="' . $top_padding_desktop . '" data-bottom-padding-desktop="' . $bottom_padding_desktop . '" data-top-padding-mobile="' . $top_padding_mobile . '" data-bottom-padding-mobile="' . $bottom_padding_mobile . '"><span class="validator-text" data-nosnippet>padding settings</span></span>';


    //establish the background settings
    $background_settings = get_sub_field('background');
    $background_type = $background_settings['background_type'];

    if ($background_type === 'color') {
        $background_color = $background_settings['background_color'];

        //build out the background settings <span> HTML:
        $background_settings_tag = '<span class="background" style="background-color:' . $background_color . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
    } else if ($background_type === 'image') {
        $background_image = $background_settings['background_image'];
        $background_image_url = $background_image['url'];
        $background_image_position = $background_settings['background_image_position'];

        //use an overlay if it's set up:
        if ($background_settings['include_overlay']) {
            $background_image_overlay = $background_settings['overlay_color'];

            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . '); --overlay-color:' . $background_image_overlay . '" data-background-overlay="true" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        } else {
            //build out the background settings <span> HTML:
            $background_settings_tag = '<span class="background" style="background-image:url(' . $background_image_url . ')" data-background-image-position="' . $background_image_position . '"><span class="validator-text" data-nosnippet>background settings</span></span>';
        }
    } else {
        //transparent background, so no need for settings <span> HTML:
        $background_settings_tag = '';
    }

    //declare variable to hold timeline eras:
    $eras = get_sub_field('eras');
?>

<?php
    //we're only generating HTML if the module has timeline info to print
    if ($eras) :
        echo $opening_tag;
?>
        <div class="container">
            <ol 
                class="history-timeline-wrapper"
                data-flex="flex"
                data-flex-direction="column"
                data-row-gap="large"
                data-justify-content="center"
                data-align-items="center"
            >
                <?php 
                    foreach ($eras as $era) :
                        $era_title = $era['era_title'];
                        $dates = $era['dates'];
                ?>
                    <li class="history-timeline-era">
                        <header class="history-timeline-era-label">
                            <h2><?= $era_title ?></h2>
                        </header>
                        <ol 
                            class="history-timeline-era-items" 
                            data-flex="flex"
                            data-flex-direction="column"
                            data-row-gap="large"
                            data-justify-content="center"
                            data-align-items="center"
                        >
                            <?php 
                                foreach ($dates as $date) :
                                    $date_title = $date['date_title'];
                                    $content = $date['content'];
                                    $add_an_image = $date['add_an_image'];

                                    if ($add_an_image) {
                                        if ($date['image_left']) {
                                            $image = $date['image_left'];
                                        } else if ($date['image_right']) {
                                            $image = $date['image_right'];
                                        }
                                    } else {
                                        $image = null; //makes sure it doesn't carry over from previous loop
                                    }

                                    $layout = $date['layout'];
                            ?>
                                    <li 
                                        class="history-timeline-item <?= $layout ?>"
                                        data-flex="flex"
                                        data-flex-direction="column"
                                        data-justify-content="center"
                                        data-align-items="center"
                                        data-row-gap="small"
                                    >
                                        <header class="history-timeline-item-label">
                                            <h3><?= $date_title ?></h3>
                                        </header>
                                        <div 
                                            class="history-timeline-item-content-wrapper"
                                            data-flex="flex"
                                            data-align-items="center"
                                            <?= $layout ? 'data-column-count="two"' : '' ?>
                                        >
                                            <div class="history-timeline-item-content">
                                                <?= $content ?>
                                            </div>
                                            <?php 
                                                if ($image) : 
                                            ?>
                                                <figure class="history-timeline-item-image">
                                                    <img src="<?= $image['url'] ?>" alt="<?= $image['alt'] ?>">
                                                </figure>
                                            <?php 
                                                endif; 
                                            ?>
                                        </div>
                                    </li>
                            <?php 
                                endforeach; 
                            ?>
                        </ol>
                    </li>
                <?php 
                    endforeach; 
                ?>
            </ol>
            <span 
                class="container-settings" 
                data-container-width="<?= $container_width ?>"
            >
                <span class="validator-text">settings</span>
            </span>
        </div>
        <span class="module-settings" data-nosnippet>
            <?= $padding_settings_tag ?>
            <?= $background_settings_tag ?>
            <span class="validator-text">module settings</span>
        </span>
<?php
        echo $closing_tag;
    endif;
?>