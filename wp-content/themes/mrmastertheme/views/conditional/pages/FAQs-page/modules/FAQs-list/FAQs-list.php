<section class="faqs-directory">
    <div class="container">
        <?php
            //set up the arguments to grab the FAQ posts:
            $args = array(
                'post_type' => 'mandr_faq', 
                'posts_per_page' => -1,
                'fields' => 'ids'
            );

            //grab them:
            $FAQs = get_posts($args);

            if ($FAQs) :
        ?>
            <span id="faqs-list-loading-animation" aria-hidden="true"></span>
            <dl class="faqs-list">
                <?php
                    //we need to initialize a random number to use as a base value for the ID that we will assign to each answer. Basically, this random number will apply to THIS list of FAQs. This is all good HTML semantics & accessibility practice to avoid duplicate IDs
                    $random_integer = rand(0,999);

                    $FAQ_count = 0;

                    //loop through the FAQs:
                    foreach($FAQs as $FAQ) {
                        //by default, our post title & content serve as question & answer: 
                        $question = get_the_title($FAQ);
                        $answer = get_the_content(null, false, $FAQ);

                        $aria_controls_value = 'answer-'.$random_integer.'-'.$FAQ_count; 

                        //In order to use the global toggle widget, the above 3 arguments must be passed to the template file. The category IDs is optional, & mainly used for this FAQs list feature:
                        $category_terms = get_the_terms($FAQ, 'faq_category');

                        //initialize empty array to push category IDs to:
                        $category_ids = [];
                        
                        if ($category_terms) {
                            foreach ($category_terms as $category) {
                                array_push($category_ids, $category->term_id);
                            }
                        } 

                        //if we've got all 3 required arguments:
                        if ($question && $answer && $aria_controls_value) {

                            $template_args = array(
                                'question' => $question,
                                'answer' => $answer,
                                'aria_controls_value' => $aria_controls_value,
                                //this optional argument is specific to any use-case with filterable toggles:
                                'category_ids' => $category_ids
                            );

                            //pass the arguments to the global toggle widget template file:
                            echo get_template_part('views/global/widgets/toggles/toggle', null, $template_args);
                            
                            //increment the counter
                            $FAQ_count++;  
                        }
                    }
                ?>
            </dl>
        <?php
            endif;
        ?>
        <span 
            class="container-settings"
            data-container-width="standard"
        >
            <span class="validator-text" data-nosnippet>settings</span>
        </span>
    </div>
    <span 
        class="padding"
        data-top-padding-desktop="double"
        data-bottom-padding-desktop="double"
        data-top-padding-mobile="single"
        data-bottom-padding-mobile="single"
    >
        <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
</section>