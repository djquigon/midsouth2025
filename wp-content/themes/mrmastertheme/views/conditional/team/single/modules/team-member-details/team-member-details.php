<?php
// Get current team member data
$member_id = get_the_ID();
$featured_image = get_the_post_thumbnail_url($member_id, 'full');
$featured_image_alt = get_post_meta(get_post_thumbnail_id($member_id), '_wp_attachment_image_alt', true);
$first_name = get_field('first_name', $member_id);
$last_name = get_field('last_name', $member_id);
$position = get_field('position', $member_id);
$department = get_field('department', $member_id);
$email = get_field('email', $member_id);
$phone_number = get_field('phone_number', $member_id);
$bio = get_field('bio', $member_id);
$fax_number = get_field('fax_number', $member_id);

// Get department taxonomy terms
$department_terms = get_the_terms($member_id, 'department');
?>

<section class="team-member-details">
    <div class="container">
        <div class="team-member-profile">
            <div class="team-member-info">
                <?php if ($first_name && $last_name) : ?>
                    <h1 class="team-member-name"><?= $first_name . ' ' . $last_name; ?></h1>
                <?php endif; ?>

                <?php if ($position) : ?>
                    <h2 class="team-member-position"><?= $position; ?></h2>
                <?php endif; ?>
                <!-- Uncomment this if you need to display these fields
                <?php if ($department_terms && !is_wp_error($department_terms)) : ?>
                    <p class="team-member-department">
                        <?= $department_terms[0]->name; ?>
                    </p>
                <?php elseif ($department) : ?>
                    <p class="team-member-department"><?= $department; ?></p>
                <?php endif; ?>

                <div class="team-member-contact">
                    <?php if ($email) : ?>
                        <div class="contact-item">
                            <strong>Email:</strong>
                            <a href="mailto:<?= $email; ?>"><?= $email; ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if ($phone_number) : ?>
                        <div class="contact-item">
                            <strong>Phone:</strong>
                            <a href="tel:<?= preg_replace('/[^0-9]/', '', $phone_number); ?>"><?= $phone_number; ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if ($fax_number) : ?>
                        <div class="contact-item">
                            <strong>Fax:</strong>
                            <a href="tel:<?= preg_replace('/[^0-9]/', '', $fax_number); ?>"><?= $fax_number; ?></a>
                        </div>
                    <?php endif; ?>
                </div> -->
            </div>
        </div>
        <div class="team-member-image-and-bio" data-flex="flex" data-flex-direction="row" data-column-count="two" data-justify-content="space-between">
            <?php if ($bio) : ?>
                <div class="team-member-bio">
                    <div class="bio-content">
                        <?= $bio; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($featured_image) : ?>
                <div class="team-member-image">
                    <img src="<?= $featured_image; ?>" alt="<?= $featured_image_alt; ?>">
                </div>
            <?php endif; ?>
        </div>
        <span class="container-settings" data-container-width="standard">
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>

    <span class="module-settings" data-nosnippet>
        <span class="padding" data-top-padding-desktop="double" data-bottom-padding-desktop="double" data-top-padding-mobile="single" data-bottom-padding-mobile="single">
            <span class="validator-text" data-nosnippet>padding settings</span>
        </span>
    </span>
</section>