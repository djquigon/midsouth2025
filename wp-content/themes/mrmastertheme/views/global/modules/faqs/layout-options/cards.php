<?php
//first we set up the arguments passed from the FAQs module's main php file:
$module_title = $args['module_title'];

$faqs = $args['faqs'];

$column_count = $args['column_count'];

$text_color_attribute = $args['text_color_attribute'];

$container_width = $args['container_width'];

$all_faqs_button = $args['all_faqs_button'];
$all_faqs_button_text = $all_faqs_button['button_text'];
$all_faqs_button_link = $all_faqs_button['button_link'];

//if a title is set, print it:
if ($module_title) :
?>
    <div class="title-view-all-row">
        <div class="container" <?= $text_color_attribute ?>>
            <?= '<h2>' . $module_title . '</h2>'; ?>
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
                data-justify-content="space-between">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </div>
<?php
endif;

if ($faqs) :
?>
    <div class="faqs-row">
        <dl class="faqs-list columns" <?= $text_color_attribute ?>>
            <?php
            //we're using the <dl>, <dt>, & <dd> tags because they fit here, semantically

            foreach ($faqs as $faq) :
                $question = $faq['question'];
                $answer = $faq['answer'];
            ?>
                <div class="faq column">
                    <dt>
                        <h3 class="question"><?= $question ?></h3>
                    </dt>
                    <dd class="answer"><?= $answer ?></dd>
                </div>
            <?php
            endforeach;
            ?>
        </dl>
        <span
            class="row-settings"

            data-container-width="<?= $container_width ?>"
            data-column-count="<?= $column_count ?>">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
<?php
endif;

//if we've got both fields set for the button, print it (mobile view only)
if ($all_faqs_button_text && $all_faqs_button_link) :
?>
    <div class="all-button-row" data-desktop-hide="true">
        <div class="container">
            <a href="<?= $all_faqs_button_link ?>" class="button"><?= $all_faqs_button_text ?></a>
            <span
                class="container-settings"
                data-container-width="<?= $container_width ?>"
                data-flex="flex"
                data-justify-content="center">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </div>
<?php
endif;
?>