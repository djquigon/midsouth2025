<?php
//In this particular case, we're using a title-area.php file that is customized for the Team archive because the M&R Master Theme's design calls for the inclusion of a category form here.
$team_page_intro_content = get_field('team_page_intro_content', 'option');
?>
<section class="title-area">
    <div class="container">
        <?php if ($team_page_intro_content) : ?>
            <?= $team_page_intro_content ?>
        <?php endif; ?>
        <span
            class="container-settings" aria-hidden="true"
            data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single">
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</section>