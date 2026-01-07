<?php
    //we're using a title-area specific to the project post type:
    echo get_template_part('views/conditional/projects/single/title-area/title-area');

    //If there are images in the project gallery, then display that module:
    if (get_field('project_media_gallery')) {
        echo get_template_part('views/global/modules/media-gallery/media-gallery', null, array('media_gallery' => get_field('project_media_gallery')));
    }

    //spit out all the individual page sections (modules)
    echo get_template_part('views/global/modules/modules'); 

    //always close out the page with the similar projects, followed by post navigation
    echo get_template_part('views/conditional/projects/single/modules/similar-projects/similar-projects');

    echo get_template_part('views/global/widgets/single-post-navigation/single-post-navigation');
?> 
