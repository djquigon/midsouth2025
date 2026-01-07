<?php
if (have_rows('modules')) :
    while (have_rows('modules')) :
        the_row();

        //Standard Content Module 
        if (get_row_layout() == 'standard_content') :
            get_template_part('views/global/modules/standard-content/standard-content');

        //Callout
        elseif (get_row_layout() == 'callout') :
            get_template_part('views/global/modules/callout/callout');

        //FAQs
        elseif (get_row_layout() == 'faqs') :
            get_template_part('views/global/modules/faqs/faqs');

        //Full Width - Two Columns
        elseif (get_row_layout() == 'full_width_two_columns') :
            get_template_part('views/global/modules/full-width-two-columns/full-width-two-columns');

        //Blogs - List
        elseif (get_row_layout() == 'blog_post_list') :
            get_template_part('views/global/modules/blog-post-list/blog-post-list');

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
        
        //Team Members
        elseif (get_row_layout() == 'team_members') :
            get_template_part('views/global/modules/team-members/team-members');

        //Testimonials 
        elseif (get_row_layout() == 'testimonials') :
            get_template_part('views/global/modules/testimonials/testimonials');

        //Video - Full-Width
        elseif (get_row_layout() == 'video_full_width') :
            get_template_part('views/global/modules/video-full-width/video-full-width');

        //Video - Cards
        elseif (get_row_layout() == 'video_cards') :
            get_template_part('views/global/modules/video-cards/video-cards');                    
           

        endif; // end if switching statement over layout types
    endwhile; // end while(layouts) loop
endif; // end have(layouts) check