<?php
//title area specific to the Projects archive, mostly because of the search & category form:
echo get_template_part('views/conditional/projects/archive/title-area/title-area');

//featured project block shown above the filters and archive listings:
get_template_part('views/conditional/projects/archive/modules/featured-project/featured-project');

//the list of posts, filtered or otherwise:
get_template_part('views/conditional/projects/archive/modules/project-list/project-list');

$projects_page_outro_content = get_field('case_studies_page_outro_content',  'option');

$projects_page_outro_image = get_field('case_studies_page_outro_image',  'option');

if ($projects_page_outro_content && $projects_page_outro_image) :
    $padding_settings_tag = '<span class="padding" data-padding-desktop="double" data-padding-mobile="single"><span class="validator-text" data-nosnippet>padding settings</span></span>';
    $text_color_attribute = '';

    $left_column = array(
        'width' => 50,
        'column_content' => $projects_page_outro_content,
    );

    $right_column = array(
        'width' => 50,
        'column_background_image' => $projects_page_outro_image,
    );
?>
    <section class="full-width-two-columns">
        <div class="columns-row">
            <div class="columns">
                <?php
                echo get_template_part(
                    'views/global/modules/full-width-two-columns/layout-options/content-column',
                    null,
                    array(
                        'column' => $left_column,
                        'text_color_attribute' => $text_color_attribute,
                        'padding_settings_tag' => $padding_settings_tag,
                    )
                );

                echo get_template_part(
                    'views/global/modules/full-width-two-columns/layout-options/image-column',
                    null,
                    array(
                        'column' => $right_column,
                    )
                );
                ?>
            </div>
            <span
                class="row-settings"
                data-column-count="2"
                data-column-gap="none"
                data-column-width="variable"
                data-row-gap="none">
                <span class="validator-text" data-nosnippet>padding settings</span>
            </span>
        </div>
    </section>
<?php
endif;
