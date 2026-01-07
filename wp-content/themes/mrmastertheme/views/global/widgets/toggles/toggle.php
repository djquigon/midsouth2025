 <?php
    //in order to use the global toggle widget, the following 3 arguments must be passed to this template file:

    //1. a 'question'
    if (isset($args['question'])) {
        $question = $args['question'];
    }

    //2. an 'answer'
    if (isset($args['answer'])) {
        $answer = $args['answer'];
    }
    
    //3. a unique identifier to apply to the toggle trigger (question) and toggled content (answer)
    if ($args['aria_controls_value']) {
        $aria_controls_value = $args['aria_controls_value'];
    }

    //Category IDs are an optional argument, & mainly used for situations in which we need to filter a list of toggles by category or some other taxonomy. (e.g. FAQs Directory feature)
    $category_ids_attribute_string = '';
    if (isset($args['category_ids'])) {
        //if we can grab the category IDs,
        $category_ids = $args['category_ids'];
        
        //initialize the data-attribute string:
        $category_ids_attribute_string = 'data-category-ids="';
        
        //initialize the category ID count
        $category_id_count = 1;

        //loop through the category IDs
        foreach ($category_ids as $category_id) {
            //append each to the data-attribute string
            $category_ids_attribute_string.=$category_id;

            //if we're not on the last array item, add some spacing:
            if ($category_id_count < count($category_ids)) {
                $category_ids_attribute_string.=' ';
            }

            //increment the counter
            $category_id_count++;
        }

        //close out the data-attribute 
        $category_ids_attribute_string .= '"';
    }

    if ($question && $answer && $aria_controls_value) :
 ?> 
        <div class="toggle" aria-hidden="false" <?= $category_ids_attribute_string ?>>
            <dt class="question">
                <h3>
                    <button 
                        class="toggle-trigger" 
                        aria-expanded="false"   
                        aria-controls="<?= $aria_controls_value ?>"
                    >
                        <?= $question ?>
                        <span class="icon"></span>
                    </button>
                </h3>
            </dt>
            <dd 
                class="answer" 
                id="<?= $aria_controls_value ?>" aria-hidden="true"
            >
                <?= $answer ?>
            </dd>      
        </div>
<?php
    endif;
?>