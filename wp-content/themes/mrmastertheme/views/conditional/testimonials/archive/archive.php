<?php
//title area specific to the Resources archive, mostly because of the search & category form:
echo get_template_part('views/conditional/testimonials/archive/title-area/title-area');

//the list of posts, filtered or otherwise:
get_template_part('views/conditional/testimonials/archive/modules/testimonials/testimonials');
