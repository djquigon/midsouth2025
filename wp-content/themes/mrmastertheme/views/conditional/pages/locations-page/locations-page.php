<?php
    //grab the global title area module
    get_template_part('views/global/title-area/title-area'); 
                                
    //spit out all the individual page sections (modules)
    get_template_part( 'views/global/modules/modules' ); 

    //the actual locations map feature: 
    echo do_shortcode('[locations-map]');
?> 