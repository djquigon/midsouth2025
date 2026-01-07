<?php
$team_members = $args['team_members'];
$container_width = $args['container_width'];
$column_count = $args['column_count'];
$text_color_attribute = $args['text_color_attribute'];
$module_title = $args['module_title'];
$intro_content = $args['intro_content'];
$bio_options = $args['bio_options'];

$all_team_members_button = $args['all_team_members_button'];
$all_team_members_button_text = $all_team_members_button['button_text'];
$all_team_members_button_link = $all_team_members_button['button_link'];

//initialize a random number that we'll use to ensure unique IDs get plugged into the slick slider script. This is just in case we're using multiple sliders on a page
$random_integer = rand(0, 999);

if ($module_title || ($all_team_members_button_text && $all_team_members_button_link)) :
?>
    <header class="title-all-button-row">
        <div class="container" <?= $text_color_attribute ?>>
            <?php
            if ($module_title) :
            ?>
                <h2 class="title"><?= $module_title ?></h2>
            <?php
            endif;

            if ($all_team_members_button_text && $all_team_members_button_link) :
            ?>
                <a href="<?= $all_team_members_button_link ?>" class="button" data-mobile-hide="true" aria-label="View all team members"><?= $all_team_members_button_text ?></a>
            <?php
            endif;
            ?>
            <span
                class="container-settings"
                data-flex="flex"
                data-justify-content="space-between"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </header>
<?php
endif;

if ($intro_content) :
?>
    <div class="intro-content-row">
        <div class="container" <?= $text_color_attribute ?>>
            <?= $intro_content ?>
            <span
                class="container-settings"
                data-container-width="<?= $container_width ?>">
                <span class="validator-text">settings</span>
            </span>
        </div>
    </div>
<?php
endif;
?>
<div class="container">
    <ul id="team-members-slider-<?= $random_integer ?>" class="team-members-slider" data-column-count="<?= $column_count; ?>">
        <?php foreach ($team_members as $member) :
            $template_args = array(
                'member' => $member,
                'display_type' => 'slide',
                'bio_options' => $bio_options,
            );
            echo get_template_part('views/global/modules/team-members/components/team-member', null, $template_args);
        endforeach; ?>
    </ul>
    <div id="append-arrows-<?= $random_integer ?>" class="container arrows-row">
        <span
            class="container-settings"
            data-container-width="standard"
            data-arrows-position="edges">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <div id="append-dots-<?= $random_integer ?>" class="container dots-row">
        <span
            class="container-settings"
            data-container-width="standard"
            data-dots-position="center">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span
        class="container-settings"
        data-container-width="<?= $container_width ?>">
        <span class="validator-text">settings</span>
    </span>
</div>
<?php
if ($all_team_members_button_text && $all_team_members_button_link) :
?>
    <div class="all-button-row" data-desktop-hide="true">
        <div class="container">
            <a href="<?= $all_team_members_button_link ?>" class="button"><?= $all_team_members_button_text ?></a>
            <span
                class="container-settings"
                data-container-width="<?= $container_width ?>">
                <span class="validator-text">settings</span>
            </span>
        </div>
    </div>
<?php
endif;
?>