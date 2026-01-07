<?php
$member = $args['member'];
$display_type = $args['display_type'];
if (isset($args['bio_options'])) {
    $bio_options = $args['bio_options'];
    // bio options
    $display_full_bio = $bio_options['display_full_bio_or_view_bio_button']; //true = display full bio, false = display view bio button
    $display_view_bio_button = !$bio_options['display_full_bio_or_view_bio_button']; //false = display full bio, true = display view bio button
    $bio_button_options = $bio_options['bio_button_options']; // single, modal
} else {
    $display_full_bio = false;
    $display_view_bio_button = true;
    $bio_button_options = 'modal';
}

$permalink = get_the_permalink($member->ID);
$featured_image = get_the_post_thumbnail_url($member->ID, 'full');
$featured_image_alt = get_post_meta(get_post_thumbnail_id($member->ID), '_wp_attachment_image_alt', true);
$first_name = get_field('first_name', $member->ID);
$last_name = get_field('last_name', $member->ID);
$position = get_field('position', $member->ID);
$department = get_field('department', $member->ID);
$email = get_field('email', $member->ID);
$phone_number = get_field('phone_number', $member->ID);
$bio = get_field('bio', $member->ID);
$fax_number = get_field('fax_number', $member->ID);

?>
<li id="<?= $first_name . '-' . $last_name; ?>" class="team-member-<?= $display_type ?>">
    <figure class="team-member-image">
        <?php if ($featured_image) : ?>
            <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
        <?php endif; ?>
    </figure>
    <article class="team-member-content">
        <?php if ($first_name && $last_name) : ?>
            <h3 class="team-member-name"><?= $first_name . ' ' . $last_name; ?></h3>
        <?php endif; ?>

        <?php if ($position) : ?>
            <p class="team-member-position"><?= $position; ?></p>
        <?php endif; ?>

        <?php if ($department) : ?>
            <p class="team-member-department"><?= $department; ?></p>
        <?php endif; ?>

        <?php if ($email) : ?>
            <address class="team-member-email">
                <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
            </address>
        <?php endif; ?>

        <?php if ($phone_number) : ?>
            <address class="team-member-phone">
                <a href="tel:<?= preg_replace('/[^0-9]/', '', $phone_number); ?>"><?= $phone_number; ?></a>
            </address>
        <?php endif; ?>

        <?php if ($fax_number) : ?>
            <address class="team-member-fax">
                <a href="tel:<?= preg_replace('/[^0-9]/', '', $fax_number); ?>"><?= $fax_number; ?></a>
            </address>
        <?php endif; ?>

        <?php if ($bio) : ?>
            <?php if ($display_full_bio) : ?>
                <div class="team-member-bio"><?= $bio; ?></div>
            <?php endif; ?>
            <?php if ($display_view_bio_button) : ?>
                <?php if ($bio_button_options === 'single') : ?>
                    <a href="<?= $permalink; ?>" class="button">View Bio</a>
                <?php elseif ($bio_button_options === 'modal') : ?>
                    <button data-modal-id="team-member-modal-<?= $member->ID; ?>" class="button">View Bio</button>
                    <?php echo get_template_part('views/global/modules/team-members/components/modal-bio', null, array(
                        'member' => $member
                    )); ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </article>
</li>