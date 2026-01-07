<?php
// get all team members
$team_members = get_posts(array(
    'post_type' => 'mandr_team_member',
    'posts_per_page' => -1,
));
//get all departments
$departments = get_terms(array(
    'taxonomy' => 'department',
    'hide_empty' => true,
));

//sort team members by department using taxonomy
usort($team_members, function ($a, $b) {
    $a_departments = get_the_terms($a->ID, 'department');
    $b_departments = get_the_terms($b->ID, 'department');

    $a_dept_name = '';
    $b_dept_name = '';

    if ($a_departments && !is_wp_error($a_departments)) {
        $a_dept_name = $a_departments[0]->name;
    }
    if ($b_departments && !is_wp_error($b_departments)) {
        $b_dept_name = $b_departments[0]->name;
    }

    return strcmp($a_dept_name, $b_dept_name);
});

//manually set the bio options here depending on what the design calls for
$bio_options = array(
    'display_full_bio_or_view_bio_button' => false,
    'bio_button_options' => 'single'
);

// Group team members by department using the taxonomy
$team_by_department = array();
foreach ($team_members as $member) {
    $member_departments = get_the_terms($member->ID, 'department');
    if ($member_departments && !is_wp_error($member_departments)) {
        foreach ($member_departments as $dept) {
            if (!isset($team_by_department[$dept->term_id])) {
                $team_by_department[$dept->term_id] = array(
                    'department' => $dept,
                    'members' => array()
                );
            }
            $team_by_department[$dept->term_id]['members'][] = $member;
        }
    }
}

// Display team members by department
if (!empty($team_by_department)) :
    foreach ($team_by_department as $dept_data) :
        $department = $dept_data['department'];
        $members = $dept_data['members'];
?>
        <section class="team-members" data-layout="cards">
            <header class="intro-content-row">
                <div class="container">
                    <h2><?php echo esc_html($department->name); ?></h2>
                    <span
                        class="container-settings"
                        data-container-width="standard">
                        <span class="validator-text" data-nosnippet>settings</span>
                    </span>
                </div>
            </header>

            <div class="container">
                <?php if (!empty($members)) : ?>
                    <div class="team-members-grid" data-grid="grid" data-column-count="three" data-column-gap="small" data-row-gap="small">
                        <?php foreach ($members as $member) :
                            echo get_template_part('views/global/modules/team-members/components/team-member', null, array(
                                'member' => $member,
                                'display_type' => 'card',
                                'bio_options' => $bio_options,
                            ));
                        endforeach; ?>
                    </div>
                <?php endif; ?>
                <span class="container-settings" data-container-width="standard">
                    <span class="validator-text">settings</span>
                </span>
            </div>
            <span class="module-settings" data-nosnippet>
                <span class="padding" data-top-padding-desktop="double" data-bottom-padding-desktop="double" data-top-padding-mobile="single" data-bottom-padding-mobile="single">
                    <span class="validator-text" data-nosnippet>padding settings</span>
                </span>
            </span>
        </section>
<?php
    endforeach;
endif;
?>