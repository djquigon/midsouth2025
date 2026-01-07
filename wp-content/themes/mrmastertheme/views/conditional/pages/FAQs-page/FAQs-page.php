<?php
    //title area specific to the FAQs page, mostly because of the filter form:
    echo get_template_part('views/conditional/pages/FAQs-page/title-area/title-area');
    
    //the FAQs list feature:
    get_template_part('views/conditional/pages/FAQs-page/modules/FAQs-list/FAQs-list');

    //perhaps you'll end with some additional modules:
    get_template_part( 'views/global/modules/modules' ); 
?>