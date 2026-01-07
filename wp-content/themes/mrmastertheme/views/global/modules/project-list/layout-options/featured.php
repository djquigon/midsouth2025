<?php
    //first we set up the arguments passed from the Project List module's main php file:
    $featured_project = $args['featured_project'];
    $text_color_attribute = $args['text_color_attribute'];
    $featured_manual_selection_or_automatic = $args['featured_manual_selection_or_automatic'];
    $all_projects_button_text = $args['all_projects_button_text'];
    $all_projects_button_link = $args['all_projects_button_link'];

    //we use a random integer to prevent duplicate IDs, in the case of any other slider instances on the same page:
    $random_integer = rand(0, 999);

    if ($featured_project) :
        //If user chose to manually select the featured project, pull that post object
        if ($featured_manual_selection_or_automatic == true) {
            $featured_project_post_object = $featured_project;
        } else {
            //Otherwise, get the featured project as the most recent project post:
            $featured_project_post_object = $featured_project[0];
        }

        //Get list of images from the featured project post
        $project_id = $featured_project_post_object->ID;
        $project_media_gallery = get_field('project_media_gallery', $project_id);

        //Grab the featured project title:
        $project_title = get_the_title($project_id);

        //Grab the excerpt, custom or otherwise:
        if (get_sub_field('featured_custom_excerpt')) {
            $project_excerpt = get_sub_field('featured_custom_excerpt');
        } elseif (get_the_excerpt($project_id)) {
            $project_excerpt = '<p>'.get_the_excerpt($project_id).'</p>';
        } else {
            $project_excerpt = false;
        }
?>
        <div class="project-row">
            <div class="columns">
                <div class="column" <?= $text_color_attribute ?>>
                    <h3 data-desktop-hide="true"><?= $project_title; ?></h3>
                    <?php 
                        if ($project_excerpt) :
                    ?>
                            <blockquote 
                                class="excerpt" 
                                cite="<?= get_the_permalink($project_id) ?>"
                                data-desktop-hide="true"
                            >
                                <?= $project_excerpt ?>
                            </blockquote>
                    <?php
                        endif;
                    ?>
                    <?php
                        //set up arguments to pass to the featured project component:
                        $template_args = array(
                            'project_media_gallery' => $project_media_gallery,
                            'random_integer' => $random_integer,
                        );
                        // Featured project List Loop component
                        echo get_template_part('views/global/modules/project-list/components/featured-project-list', null, $template_args);
                    ?>
                </div>
                <div class="column" <?= $text_color_attribute ?>>
                    <h3 data-mobile-hide="true"><?= $project_title; ?></h3>
                    <?php 
                        if ($project_excerpt) :
                    ?>
                            <blockquote 
                                class="excerpt" 
                                cite="<?= get_the_permalink($project_id) ?>"
                                data-mobile-hide="true"
                            >
                                <?= $project_excerpt ?>
                            </blockquote>
                    <?php 
                        endif;

                        //print the list of project categories (conditional widget - project post type)
                        echo get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => $project_id));
                    ?>
                        <a 
                            href="<?= get_the_permalink($project_id) ?>" 
                            class="button"
                            data-mobile-hide="true"
                        >
                            View Project
                        </a>
                        <div id="append-arrows-<?= $random_integer ?>">
                            <span
                                class="arrow-settings" 
                                data-arrows-position="left">
                                <span class="validator-text" data-nosnippet>settings</span>
                            </span>
                        </div>  
                        <div id="append-dots-<?= $random_integer ?>">
                            <span 
                                class="dots-settings" 
                                data-container-width="standard"
                                data-dots-position="left"
                            >
                                <span class="validator-text" data-nosnippet>settings</span>
                            </span>
                        </div>
                        <a 
                            href="<?= get_the_permalink($project_id) ?>" 
                            class="button"
                            data-desktop-hide="true"
                        >
                            View Project
                        </a>
                </div>
            </div>
            <?php
                if ($project_media_gallery) :
            ?>
                    <span class="slider-settings">
                        <script>  
                            jQuery('#featured-project-gallery-slider-<?= $random_integer; ?>').slick({
                                //accessibility: true,
                                //adaptiveHeight: false,
                                appendArrows: $('#append-arrows-<?= $random_integer ?>'),
                                appendDots: $('#append-dots-<?= $random_integer ?>'),
                                arrows: true,
                                //asNavFor: $(element)
                                //autoplay: true,
                                autoplay: 5000,
                                //centerMode: false,
                                //centerPadding: '50px',
                                //cssEase: 'ease',
                                //customPaging: function(slider, i) {
                                //    return '<button type="button" data-role="none">' + (i + 1) + '</button>';
                                //},
                                dots: true,
                                //dotsClass: 'slick-dots',
                                //draggable: true,
                                //easing: 'linear',
                                //edgeFriction: 0.15,
                                //fade: false,
                                //focusOnSelect: false,
                                //focusOnChange: false,
                                //infinite: true,
                                //initialSlide: 0,
                                //lazyLoad: 'ondemand',
                                //mobileFirst: false,
                                //nextArrow: '<button type="button" data-role="none" class="slick-next" aria-label="next">Next</button>',
                                //pauseOnDotsHover: false,
                                //pauseOnFocus: true,
                                //pauseOnHover: true,
                                //prevArrow: '<button type="button" data-role="none" class="slick-prev" aria-label="previous">Previous</button>',
                                //respondTo: 'window',
                                //responsive: [ 
                                //    {
                                //        breakpoint: 768,
                                //        settings: {
                                //            slidesToShow: 1
                                //        },
                                //    },
                                //],
                                // You can unslick at a given breakpoint now by adding:
                                // settings: "unslick"
                                // instead of a settings object 
                                rows: 0, //Setting this to 1 adds more divs that will require style changes, and setting this to more than 1 initializes grid mode. Use slidesPerRow to set how many slides should be in each row.
                                //rtl: false,
                                slide: '.featured-project-gallery-slide',
                                //slidesPerRow: 1,
                                slidesToScroll: 1,
                                slidesToShow: 1,
                                //speed: 300,
                                //swipe: true,
                                //swipeToSlide: false,
                                //touchMove: true,
                                //touchThreshold: 5,
                                //useCSS: true,
                                //useTransform: true,
                                //variableWidth: false,
                                //vertical: false,
                                //verticalSwiping: false,
                                //waitForAnimate: true
                                //zIndex: 1000
                            }); 
                        </script>
                        <span class="validator-text" data-nosnippet>slider settings</span>
                    </span>
            <?php
                endif;
            ?>
            <span
                class="row-settings"
                data-column-count="two"
                data-column-gap="large"
                data-container-width="standard">
                <span class="validator-text" data-nosnippet>settings</span>
            </span>
        </div>
<?php
    endif;
