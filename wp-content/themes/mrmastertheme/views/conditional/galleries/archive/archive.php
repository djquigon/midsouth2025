<?php
    //title area specific to the Galleries archive, mostly because of the search & category form:
    echo get_template_part('views/conditional/galleries/archive/title-area/title-area');           
    
    //the list of posts, filtered or otherwise:
    get_template_part('views/conditional/galleries/archive/modules/gallery-list/gallery-list');
?>