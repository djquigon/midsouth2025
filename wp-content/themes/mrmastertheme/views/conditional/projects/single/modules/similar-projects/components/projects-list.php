<?php
    $this_post_id = get_the_id();
    $projects = $args['projects'];
    $text_color_attribute = $args['text_color_attribute'];
    $container_width = $args['container_width'];

    //assign a post image size, these are set up in library/custom-theme/php/initialization.php
    $project_image_size_name = 'medium-square';
?>
<div class="projects-row">
    <ul 
        class="projects columns"
        data-flex="flex"
        data-column-count="three"
        data-column-gap="small"
        <?= $text_color_attribute ?>
    >
        <?php
            foreach ($projects as $similar_post) :
                $similar_post_id = $similar_post->ID;
                
                $similar_post_link = get_permalink($similar_post_id);
                $title = $similar_post->post_title;
                $categories = get_the_terms($similar_post_id, 'project_category');
                $category_string = '';
                $project_media_is_video = false;
                $video_link = get_field('video_link', $similar_post_id);
                $video_description = get_field('video_description', $similar_post_id);
                $poster_image = get_field('poster_image', $similar_post_id);
                $default_project_image = get_stylesheet_directory_uri() . '/library/custom-theme/images/featured.jpg';

                //use the project ID to get the featured image ID, if it's set. 
                if (get_post_thumbnail_id($similar_post_id)) {
                    $project_image_id = get_post_thumbnail_id($similar_post_id);

                    //use featured image ID & size name to grab all the relevant info:
                    $project_image_url = wp_get_attachment_image_url($project_image_id, $project_image_size_name);
                    $project_image_width = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[1];
                    $project_image_height = wp_get_attachment_image_src($project_image_id, $project_image_size_name)[2];
                    $project_image_alt = get_post_meta($project_image_id, '_wp_attachment_image_alt', TRUE);
                } elseif ($poster_image) {
                    $project_image_url = $poster_image['url'];
                    $project_image_width = $poster_image['width'];
                    $project_image_height = $poster_image['height'];
                    $project_image_alt = $poster_image['alt'];

                    if ($video_link) {
                        $project_media_is_video = true;
                    }
                } elseif ($video_link && str_contains($video_link, 'youtube')) {
                    $youtube_id = youtube_video_id($video_link);

                    $project_image_url = 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
                    $project_image_width = 480;
                    $project_image_height = 360;
                    $project_image_alt = 'default video thumbnail image supplied by YouTube';
                    $project_media_is_video = true;
                } elseif ($video_link && str_contains($video_link, 'vimeo')) {
                    $oembed_endpoint = 'http://vimeo.com/api/oembed';
                    $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_link) . '&width=640&byline=false&title=false';
                    $oembed = simplexml_load_string(curl_get($xml_url)); 

                    if ($oembed && !empty($oembed->thumbnail_url)) {
                        $project_image_url = html_entity_decode($oembed->thumbnail_url);
                        $project_image_width = 640;
                        $project_image_height = 360;
                        $project_image_alt = 'default video thumbnail image supplied by Vimeo';
                        $project_media_is_video = true;
                    }
                } else {
                    $project_image_url = $default_project_image;
                    $project_image_width = 1024;
                    $project_image_height = 1024;
                    $project_image_alt = $title;
                }  

                $poster_image_array = [
                    'poster_image_url' => $project_image_url,
                    'poster_image_width' => $project_image_width,
                    'poster_image_height' => $project_image_height,
                    'poster_image_alt' => $project_image_alt
                ];

                $video_aria_id = 'video-widget-'.rand(0, 999);
        ?>
                <li>
                    <article>
                        <?php
                            if (!$project_media_is_video) :
                        ?>
                                <figure>
                                    <a href="<?= $similar_post_link ?>">
                                        <img 
                                            src="<?= $project_image_url ?>" 
                                            height="<?= $project_image_height ?>" 
                                            width="<?= $project_image_width ?>" 
                                            alt="<?= $project_image_alt ?>"
                                        > 
                                    </a>
                                </figure>
                        <?php
                            //if neither of the above 2 situations are true, we may be using a video as the project's 'thumbnail', so call the function with the appropriate parameters passed: 
                            else :       
                        ?>
                                <figure>
                                    <?php
                                        echo mandr_video_player(
                                            $video_link,
                                            $poster_image_array, 
                                            $video_description, 
                                            $video_aria_id
                                        );
                                    ?>
                                </figure>
                        <?php
                            endif;
                        ?>
                        <h3>
                            <a href="<?= $similar_post_link; ?>">
                                <?= $title; ?>
                            </a>
                        </h3>
                        <?php 
                            //print the list of project categories (conditional widget - project post type)
                            echo get_template_part('views/conditional/projects/widgets/project-category-list/project-category-list', null, array('id' => $similar_post_id));
                        ?>
                        <a href="<?= $similar_post_link; ?>" class="button">Learn More</a>
                    </article>
                </li>
        <?php
            endforeach;
            wp_reset_postdata();
        ?>
    </ul> 
    <span 
        class="row-settings" 
        data-container-width="standard"
    >
        <span class="validator-text" data-nosnippet="">settings</span>
    </span>
</div>