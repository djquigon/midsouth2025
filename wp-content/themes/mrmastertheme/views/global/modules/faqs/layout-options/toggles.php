<?php
    //first we set up the arguments passed from the FAQs module's main php file:
    $module_title = $args['module_title'];
    
    $faqs = $args['faqs'];
    
    $text_color_attribute = $args['text_color_attribute'];

    $container_width = $args['container_width'];
    
    $all_faqs_button = $args['all_faqs_button'];
    $all_faqs_button_text = $all_faqs_button['button_text'];
    $all_faqs_button_link = $all_faqs_button['button_link']; 

    //if a title is set, print it:
    if ($module_title) :
?>
        <div class="title-view-all-row">
            <div class="container"<?= $text_color_attribute ?>>
                <?= '<h2>'.$module_title.'</h2>'; ?>
                <?php 
                    //if we've got both fields set for the button, print it (desktop view only)
                    if ($all_faqs_button_text && $all_faqs_button_link) :
                ?>
                        <a href="<?= $all_faqs_button_link ?>" class="button" data-mobile-hide="true"><?= $all_faqs_button_text ?></a>
                <?php
                    endif;
                ?>
                <span 
                    class="container-settings"
                    
                    data-container-width="<?= $container_width ?>"
                    data-flex="flex"
                    data-justify-content="space-between"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;

    if ($faqs) :
        //we need to initialize a random number to use as a base value for the ID that we will assign to each answer. Basically, this random number will apply to THIS list of FAQs. This is all good HTML semantics & accessibility practice to avoid duplicate IDs
        $random_integer = rand(0,999);

        //then we'll initialize an index to increment for each answer
        $faq_count = 0; 
?>
        <div class="faqs-row">
            <div class="container"<?= $text_color_attribute ?>>
                <dl class="faqs-list">
                    <?php
                        foreach ($faqs as $faq) {
                            $question = $faq['question'];
                            $answer = $faq['answer'];   
                            $aria_controls_value = 'answer-'.$random_integer.'-'.$faq_count; 

                            //in order to use the global toggle widget, the following 3 arguments must be passed to the template file
                            $template_args = array(
                                'question' => $question,
                                'answer' => $answer,
                                'aria_controls_value' => $aria_controls_value
                            );

                            echo get_template_part('views/global/widgets/toggles/toggle', null, $template_args);

                            $faq_count++; 
                        }
                    ?>
                </dl>
                <span 
                    class="container-settings"
                    data-container-width="<?= $container_width ?>"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;

    //if we've got both fields set for the button, print it (mobile view only)
    if ($all_faqs_button_text && $all_faqs_button_link) :
?>
        <div class="all-button-row" data-desktop-hide="true">
            <div class="container">
                <a href="<?= $all_faqs_button_link ?>" class="button" ><?= $all_faqs_button_text ?></a> 
                <span 
                    class="container-settings"                     
                    data-container-width="<?= $container_width ?>"
                    data-flex="flex"
                    data-justify-content="center"
                >
                    <span class="validator-text" data-nosnippet>settings</span>
                </span>
            </div>
        </div>
<?php
    endif;
?>