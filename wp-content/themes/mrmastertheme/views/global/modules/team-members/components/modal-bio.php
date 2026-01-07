<?php
$member = $args['member'];
$featured_image = get_the_post_thumbnail_url($member->ID, 'full');
$featured_image_alt = get_post_meta(get_post_thumbnail_id($member->ID), '_wp_attachment_image_alt', true);
$first_name = get_field('first_name', $member->ID);
$last_name = get_field('last_name', $member->ID);
$position = get_field('position', $member->ID);
$bio = get_field('bio', $member->ID);
?>
<div id="team-member-modal-<?= $member->ID; ?>" class="team-member-modal">
    <div class="team-member-modal-inner">
        <div class="team-member-modal-close">
            <button class="team-member-modal-close-button">
                X
                <span class="screenreader-only">Close</span>
            </button>
        </div>
        <?php if ($featured_image) : ?>
            <div class="team-member-modal-image">
                <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
            </div>
        <?php endif; ?>
        <div class="team-member-modal-content">
            <h2><?= $first_name . ' ' . $last_name; ?></h2>
            <h4><?= $position; ?></h4>
            <div class="team-member-bio"><?= $bio; ?></div>
        </div>
    </div>
</div>