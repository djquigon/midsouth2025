<?php
    $resource = $args['resource']; 
        
    //first determine which kind of resource we're working with, video or file. We're using a boolean field for the cleaner UX. 'True/Checked' = 'File'. 'False/Un-Checked' = Video.
    if ($resource['resource_type']) {
        $resource_type = 'file';
        if ($resource['file_upload']) {
            //if file, grab the filename:
            $resource_filename = $resource['file_upload']['filename'];
    
            //next, determine exactly which kind of file type it is by looking at the uploaded file extension:
            if (
                str_contains($resource_filename, 'xlsx') || 
                str_contains($resource_filename, 'csv')) {
                //if it's an excel file:
                $resource_category_term_id = 40;
                $resource_category_name = 'Excel';
            } elseif (
                str_contains($resource_filename, 'docx') || 
                str_contains($resource_filename, 'doc') || 
                str_contains($resource_filename, 'rtf') ) {
                //if it's a word doc:
                $resource_category_term_id = 37;
                $resource_category_name = 'Word';
            } elseif (str_contains($resource_filename, 'pdf')) {
                //if it's a PDF:
                $resource_category_term_id = 38;
                $resource_category_name = 'PDF';
            } 
        } else {
            $resource_category_term_id = false;
        }
    } else {
        //if it's a video:    
        $resource_type = 'video';    
        $resource_category_term_id = 36;
        $resource_category_name = 'Video';
    }    

    //resource title
    $resource_title = $resource['resource_title'];
    
    //based on if we actually have an image, set up the image data for later use:
    if ($resource['resource_image']) {
        //declare a variable to hold the Resource image ID
        $resource_image_id = $resource['resource_image']['ID'];

        //assign a post image size, these are set up in library/custom-theme/php/initialization.php
        $resource_image_size_name = 'medium-square';

        //use featured image ID & size name to grab all the relevant info:
        $resource_image_url = wp_get_attachment_image_url($resource_image_id, $resource_image_size_name);
        $resource_image_width = wp_get_attachment_image_src($resource_image_id, $resource_image_size_name)[1];
        $resource_image_height = wp_get_attachment_image_src($resource_image_id, $resource_image_size_name)[2];
        $resource_image_alt = get_post_meta($resource_image_id, '_wp_attachment_image_alt', TRUE);
    }

    //excerpt:
    $resource_excerpt = $resource['resource_excerpt'];

    //if the resource type is file, grab the file for download button usage:
    if ($resource['file_upload']) {
        $resource_file_link = $resource['file_upload']['url']; 
    } else {
        $resource_file_link = '';
    }
    

    //if the resource type is a video, grab the video link for modal lightbox usage:
    $resource_video_link = $resource['video_link'];

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
                        if ($resource['resource_image']) :
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
                                    <a href="<?= $resource_file_link ?>">
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
                            <h3><a href="<?= $resource_file_link ?>"><?= $resource_title ?></a></h3>
                        <?php
                            //post the excerpt if it exists:                            
                            if ($resource_excerpt) :
                        ?>
                                <blockquote 
                                    class="excerpt" 
                                >
                                    <?= $resource_excerpt ?>
                                </blockquote>
                        <?php
                            endif;

                            //include a link to the Resource category, based on resource type & file type:
                        ?>
                            <ul 
                                class="resource-categories"
                                data-flex="flex"
                            >
                                <li>
                                    <a href="/resources/?resource-search=&resource-category=<?= $resource_category_term_id ?>"><?= $resource_category_name ?></a>
                                </li>
                            </ul>
                        <?php

                            if ($resource_file_link) : 
                        ?>
                                <a 
                                    href="<?= $resource_file_link ?>" 
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
                            ?>
                            <ul 
                                class="resource-categories"
                                data-flex="flex"
                            >
                                <li>
                                    <a href="/resources/?resource-search=&resource-category=<?= $resource_category_term_id ?>"><?= $resource_category_name ?></a>
                                </li>
                            </ul>

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