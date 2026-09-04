<?php
    $resource_id = $args['id'];

    //first determine which kind of resource we're working with, video or file. We're using a boolean field for the cleaner UX. 'True/Checked' = 'File'. 'False/Un-Checked' = Video.
    if (get_field('resource_type', $resource_id)) {
        $resource_type = 'file';

        //next, determine exactly which kind of file type it is by grabbing the resource's category terms & looking for the correct ID:
        $resource_categories = get_the_terms($resource_id, 'resource_category');
        
        //loop through each category & use a series of if statements to determine which type of file we're working with, then grab the term ID, & break the loop:
        foreach ($resource_categories as $category) {            
            if ($category->name === 'Word') {
                $resource_category_term_id = 37;
                break;
            } elseif ($category->name === 'Excel') {
                $resource_category_term_id = 40;
                break;
            } elseif ($category->name === 'PDF') {
                $resource_category_term_id = 38;
                break;
            } else {
                $resource_category_term_id = false;
            }
        }
    } else {
        $resource_type = 'video';
        
        $resource_category_term_id = 36;
    }

    //resource permalink, & we'll only use this for the resources that aren't videos
    $resource_permalink = get_the_permalink($resource_id);

    //resource title
    $resource_title = get_the_title($resource_id);

    //use the resource ID to get the featured image ID, if it's set. If it's not set, we'll use a default image based on resource type 
    $resource_image_id = get_post_thumbnail_id($resource_id); 

    //based on if we actually have an image, set up the image data for later use:
    if ($resource_image_id) {

        //assign a post image size, these are set up in library/custom-theme/php/initialization.php
        $resource_image_size_name = 'medium-square';

        //use featured image ID & size name to grab all the relevant info:
        $resource_image_url = wp_get_attachment_image_url($resource_image_id, $resource_image_size_name);
        $resource_image_width = wp_get_attachment_image_src($resource_image_id, $resource_image_size_name)[1];
        $resource_image_height = wp_get_attachment_image_src($resource_image_id, $resource_image_size_name)[2];
        $resource_image_alt = get_post_meta($resource_image_id, '_wp_attachment_image_alt', TRUE);
    }

    //excerpt:
    $resource_excerpt = get_the_excerpt($resource_id);       

    //if the resource type is file, grab the file for download button usage:
    $resource_file = get_field('file_upload', $resource_id);

    //if the resource type is a video, grab the video link for modal lightbox usage:
    $resource_video_link = get_field('video_link', $resource_id);

    //we'll need to determine which platform the video is hosted on and formulate an appropriate link:
    if (str_contains($resource_video_link, 'youtube')) {
        $youtube_video_id = youtube_video_id($resource_video_link);
        $formatted_video_link = 'https://www.youtube.com/watch?v='.$youtube_video_id;
    } elseif (str_contains($resource_video_link, 'vimeo')) {
        $formatted_video_link = $resource_video_link;
    } else {
        //to prevent critical errors:
        $formatted_video_link = '#';
    }
?>
<li>
    <article>
        <div class="content-row">
            <div class="columns">
                <div 
                    class="column one-fifth icon"
                    data-mobile-hide="true"
                >
                    <?php
                        //if a featured image is set for the Resource, we use it:
                        if ($resource_image_id) :
                    ?>
                        <figure>
                            <?php
                                //but the functionality is dependant on the file type. Videos will use a lightbox, Files will use a permalink to single view
                                if ($resource_type === 'video') :
                            ?>
                                    <a href="<?= $resource_video_link ?>" class="popup-video">
                                        <img src="<?= $resource_image_url ?>" height="<?= $resource_image_height ?>" width="<?= $resource_image_width ?>" alt="<?= $resource_image_alt ?>"> 
                                    </a>
                            <?php
                                elseif ($resource_type === 'file') :
                            ?>
                                    <a href="<?= $resource_permalink ?>">
                                        <img src="<?= $resource_image_url ?>" height="<?= $resource_image_height ?>" width="<?= $resource_image_width ?>" alt="<?= $resource_image_alt ?>"> 
                                    </a>
                            <?php
                                endif;
                            ?>
                        </figure>
                    <?php
                        else: 
                            //based on the Resource's type (Video/File) and file type, grab the appropriate default icon:
                            get_template_part('views/conditional/resources/widgets/resource-category-default-icon/resource-category-default-icon', null, array('resource_type_term_id' => $resource_category_term_id));
                    ?>
                    <?php
                        endif;
                    ?>
                </div>
                <div class="column four-fifths text">
                    <?php 
                        //slightly different HTML based on resource type:
                        if ($resource_type === 'file') :
                    ?>
                            <h3><a href="<?= $resource_permalink ?>"><?= $resource_title ?></a></h3>
                        <?php
                            //post the excerpt if it exists:                            
                            if ($resource_excerpt) :
                        ?>
                                <blockquote 
                                    class="excerpt" 
                                    cite="<?= $resource_permalink ?>"
                                >
                                    <?= $resource_excerpt ?>
                                </blockquote>
                        <?php
                            endif;

                            //spit out the widgetized resource category list:
                            echo get_template_part('views/conditional/resources/widgets/resource-category-list/resource-category-list', null, array('id' => $resource_id));

                            if ($resource_file) : 
                        ?>
                                <a 
                                    href="<?= $resource_file['url'] ?>" 
                                    class="button" 
                                    download
                                >
                                    Download
                                </a>
                        <?php
                            endif;
                        ?>
                    <?php
                        elseif ($resource_type === 'video') :
                            //we're using vendor code (magnific.me) to handle the modal video lightbox functionality, hence the 'popup-video' class:
                    ?>
                            <h3>
                                <a href="<?= $resource_video_link ?>" class="popup-video">
                                    <?= $resource_title ?>
                                </a>
                            </h3>
                            <?php
                                //post the excerpt if it exists:                            
                                if ($resource_excerpt) :
                            ?>
                                    <blockquote class="excerpt">
                                        <?= $resource_excerpt ?>
                                    </blockquote>
                            <?php
                                endif;

                                //spit out the widgetized resource category list:
                                echo get_template_part('views/conditional/resources/widgets/resource-category-list/resource-category-list', null, array('id' => $resource_id));
                            ?>
                            <a href="<?= $resource_video_link ?>" class="popup-video button">Watch Video</a>
                    <?php
                        endif;
                    ?>                
                </div> 
            </div>
            <span 
                class="row-settings" 
                data-column-count="two" 
                data-column-width="variable" 
            >
                <span class="validator-text" data-nosnippet>row settings</span>
            </span>
        </div>
    </article>
</li>
