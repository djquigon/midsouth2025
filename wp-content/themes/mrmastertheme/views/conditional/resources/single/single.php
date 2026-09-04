<?php
    //title area specific to the Resources single view:
    echo get_template_part('views/conditional/resources/single/title-area/title-area');           
    
    //the list of posts, filtered or otherwise:
    get_template_part('views/conditional/resources/single/modules/modules');
?>