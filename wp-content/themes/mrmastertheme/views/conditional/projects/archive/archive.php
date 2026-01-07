<?php
    //title area specific to the Projects archive, mostly because of the search & category form:
    echo get_template_part('views/conditional/projects/archive/title-area/title-area');           
    
    //the list of posts, filtered or otherwise:
    get_template_part('views/conditional/projects/archive/modules/project-list/project-list');
?>