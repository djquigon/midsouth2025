<?php
    //title area specific to the posts archive, mostly because of the filter form:
    echo get_template_part('views/conditional/posts/archive/title-area/title-area');
            
    //featured post module
    get_template_part('views/conditional/posts/archive/modules/featured-post/featured-post');

    //the list of posts, filtered or otherwise
    get_template_part('views/conditional/posts/archive/modules/post-list/post-list');
?>