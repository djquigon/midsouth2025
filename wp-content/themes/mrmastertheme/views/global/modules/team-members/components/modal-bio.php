<?php
$member = $args['member'];
$featured_image = get_the_post_thumbnail_url($member->ID, 'full');
$featured_image_alt = get_post_meta(get_post_thumbnail_id($member->ID), '_wp_attachment_image_alt', true);
$first_name = get_field('first_name', $member->ID);
$last_name = get_field('last_name', $member->ID);
$position = get_field('position', $member->ID);
$email = get_field('email', $member->ID);
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
        <div class="team-member-modal-content">
            <div class="team-member-modal-top-content">
                <?php if ($featured_image) : ?>
                    <div class="team-member-modal-image">
                        <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
                    </div>
                    <div class="team-member-modal-image-caption">
                        <h4><?= $first_name . ' ' . $last_name; ?></h4>
                        <h6><?= $position; ?></h6>
                        <?php if ($email) : ?>
                            <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="team-member-modal-bottom-content">
                <div class="team-member-bio"><?= $bio; ?></div>
            </div>
        </div>
    </div>
</div>