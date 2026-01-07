<?php
//first we set up the arguments passed from the testimonial module's main php file:
$module_title = $args['module_title'];
$intro_content = $args['intro_content'];

$testimonials = $args['testimonials'];

$text_color_attribute = $args['text_color_attribute'];

$column_count = $args['column_count'];

$all_testimonials_button = $args['all_testimonials_button'];
$all_testimonials_button_text = $all_testimonials_button['button_text'];
$all_testimonials_button_link = $all_testimonials_button['button_link'];

if ($module_title || $intro_content) :
?>
    <div class="intro-content-row">
        <div class="container" <?= $text_color_attribute ?>>
            <?php
            if ($module_title) {
                echo '<h2>' . $module_title . '</h2>';
            }
            ?>
            <?php
            if ($intro_content) {
                echo $intro_content;
            }
            ?>
            <span
                class="container-settings"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </div>
<?php
endif;
?>
<div class="testimonials-row">
    <div class="columns">
        <?php
        foreach ($testimonials as $testimonial) :
            $testimonial_content = $testimonial['testimonial'];
            $testimonial_author_name = $testimonial['author_name'];
            $testimonial_author_title = $testimonial['author_title'];
        ?>
            <div class="testimonial column" <?= $text_color_attribute ?>>
                <div class="content">
                    <?= $testimonial_content ?>
                </div>
                <div class="author">
                    <span class="name"><?= $testimonial_author_name ?></span>
                    <?php
                    if ($testimonial_author_title) :
                    ?>
                        <span class="title"><?= $testimonial_author_title ?></span>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
    <span
        class="row-settings"
        data-container-width="standard"
        data-column-count="<?= $column_count ?>">
        <span class="validator-text" data-nosnippet>settings</span>
    </span>
</div>
<?php
if ($all_testimonials_button_text && $all_testimonials_button_link) :
?>
    <div class="all-button-row">
        <div class="container">
            <a href="<?= $all_testimonials_button_link ?>" class="button"><?= $all_testimonials_button_text ?></a>
            <span
                class="container-settings"
                data-container-width="standard"
                data-text-align="center">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </div>
<?php
endif;
?>