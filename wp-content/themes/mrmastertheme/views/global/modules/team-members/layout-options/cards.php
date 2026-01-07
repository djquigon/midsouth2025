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

// Map column count values to grid system format
$grid_column_count = '';
switch ($column_count) {
    case 'one-col':
        $grid_column_count = 'one';
        break;
    case 'two-col':
        $grid_column_count = 'two';
        break;
    case 'three-col':
        $grid_column_count = 'three';
        break;
    case 'four-col':
        $grid_column_count = 'four';
        break;
    default:
        $grid_column_count = 'three'; // default fallback
}

if ($module_title || $intro_content) :
?>
    <header class="intro-content-row">
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
                data-container-width="<?= $container_width ?>">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
    </header>
<?php
endif;
?>

<div class="container">
    <ul class="team-members-grid" data-grid="grid" data-column-count="<?= $grid_column_count; ?>" data-column-gap="small" data-row-gap="small">
        <?php foreach ($team_members as $member) :
            $template_args = array(
                'member' => $member,
                'display_type' => 'card',
                'bio_options' => $bio_options,
            );
            echo get_template_part('views/global/modules/team-members/components/team-member', null, $template_args);
        endforeach; ?>
    </ul>
    <span class="container-settings" data-container-width="<?= $container_width ?>">
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