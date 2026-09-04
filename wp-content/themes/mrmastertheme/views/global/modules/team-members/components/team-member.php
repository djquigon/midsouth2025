<?php
$member = $args['member'];
$display_type = $args['display_type'];
$full_page_or_popup_for_bio = (bool) get_field('full_page_or_popup_for_bio', $member->ID);

$permalink = get_the_permalink($member->ID);
$featured_image = get_the_post_thumbnail_url($member->ID, 'full');
$featured_image_alt = get_post_meta(get_post_thumbnail_id($member->ID), '_wp_attachment_image_alt', true);
$first_name = get_field('first_name', $member->ID);
$last_name = get_field('last_name', $member->ID);
$position = get_field('position', $member->ID);
$email = get_field('email', $member->ID);
$bio = get_field('bio', $member->ID);

?>
<li id="<?= $first_name . '-' . $last_name; ?>" class="team-member-<?= $display_type ?>">
    <figure class="team-member-image">
        <?php if ($featured_image) : ?>
            <?php if ($bio && $full_page_or_popup_for_bio) : ?>
                <a href="<?= $permalink; ?>" class="team-member-image-trigger">
                    <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
                </a>
            <?php elseif ($bio) : ?>
                <button type="button" data-modal-id="team-member-modal-<?= $member->ID; ?>" class="team-member-image-trigger">
                    <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
                </button>
            <?php else : ?>
                <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
            <?php endif; ?>
        <?php endif; ?>
    </figure>
    <article class="team-member-content">
        <?php if ($first_name && $last_name) : ?>
            <h3 class="team-member-name"><?= $first_name . ' ' . $last_name; ?></h3>
        <?php endif; ?>

        <?php if ($position) : ?>
            <h6 class="team-member-position"><?= $position; ?></h6>
        <?php endif; ?>

        <?php if ($bio) : ?>
            <?php if (!$full_page_or_popup_for_bio) : ?>
                <?php echo get_template_part('views/global/modules/team-members/components/modal-bio', null, array(
                    'member' => $member
                )); ?>
            <?php endif; ?>
        <?php endif; ?>
    </article>
</li>