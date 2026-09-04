<?php
// get all team members, ordered by date created ascending
$team_members = get_posts(array(
    'post_type' => 'mandr_team_member',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC'
));

//manually set the bio options here depending on what the design calls for
$bio_options = array(
    'display_full_bio_or_view_bio_button' => false,
    'bio_button_options' => 'single'
);
if (!empty($team_members)) :
?>
    <section class="team-members" data-layout="cards">
        <div class="container">
            <div class="team-members-grid" data-grid="grid" data-column-count="four" data-column-gap="small" data-row-gap="large">
                <?php foreach ($team_members as $member) :
                    echo get_template_part('views/global/modules/team-members/components/team-member', null, array(
                        'member' => $member,
                        'display_type' => 'card',
                        'bio_options' => $bio_options,
                    ));
                endforeach; ?>
            </div>
            <span class="container-settings" aria-hidden="true" data-container-width="standard">
                <span class="validator-text">settings</span>
            </span>
        </div>
        <span class="module-settings" aria-hidden="true" data-nosnippet>
            <span class="padding" data-top-padding-desktop="double" data-bottom-padding-desktop="double" data-top-padding-mobile="single" data-bottom-padding-mobile="single">
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
        </span>
    </section>
<?php
endif;
?>