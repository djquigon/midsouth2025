<?php
//if an ID is passed as an argument to this file, use it
if (isset($args['id'])) {
    $ID = $args['id'];
} else {
    $ID = false;
}

if (have_rows('modules', $ID)) :

    while (have_rows('modules', $ID)) : the_row();

        //Standard Content Module 
        if (get_row_layout() == 'standard_content') :
            get_template_part('views/global/modules/standard-content/standard-content');

        //Callout
        elseif (get_row_layout() == 'callout') :
            get_template_part('views/global/modules/callout/callout');

        //FAQs
        elseif (get_row_layout() == 'faqs') :
            get_template_part('views/global/modules/faqs/faqs');
        
        //Galleries - List
        elseif (get_row_layout() == 'gallery_list') :
            get_template_part('views/global/modules/gallery-list/gallery-list'); 

        //History timeline
        elseif (get_row_layout() == 'history_timeline') :
            get_template_part('views/global/modules/history-timeline/history-timeline');    
        
        //Locations - Map & Cards
        elseif (get_row_layout() == 'locations_map_cards') :
            get_template_part('views/global/modules/locations-map-cards/locations-map-cards');

        //Locations - Search Form
        elseif (get_row_layout() == 'locations_search_form') :
            get_template_part('views/global/modules/locations-search-form/locations-search-form');

        //Media Gallery
        elseif (get_row_layout() == 'media_gallery') :
            get_template_part('views/global/modules/media-gallery/media-gallery');

        //Projects - List
        elseif (get_row_layout() == 'project_list') :
            get_template_part('views/global/modules/project-list/project-list');    

        //Team - Featured
        elseif (get_row_layout() == 'team_featured_member') :
            get_template_part('views/global/modules/team-featured-member/team-featured-member');

        //Team - Multiple Members
        elseif (get_row_layout() == 'team_multiple_members') :
            get_template_part('views/global/modules/team-multiple-members/team-multiple-members');            

        //Testimonials 
        elseif (get_row_layout() == 'testimonials') :
            get_template_part('views/global/modules/testimonials/testimonials');            

        //Video - Full-Width
        elseif (get_row_layout() == 'video_full_width') :
            get_template_part('views/global/modules/video-full-width/video-full-width');

        //Video - Cards
        elseif (get_row_layout() == 'video_cards') :
            get_template_part('views/global/modules/video-cards/video-cards');

        //Resources - List
        elseif (get_row_layout() == 'resource_list') :
            get_template_part('views/conditional/resources/single/modules/resource-list/resource-list');

        endif;

    endwhile;

endif;
