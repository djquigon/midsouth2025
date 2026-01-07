<?php
    //grab all of the terms in the FAQ CPT's 'Category' taxonomy:
    $categories = get_terms( array(
        'taxonomy'   => 'faq_category',
        'hide_empty' => true,
    ) );

    if ($categories) :
?>
        <form 
            role="search" 
            action="javascript:void(0);" 
            id="faq-filters" 
        >
            <ul
                class="form-fields"
                data-flex="flex" 
                data-flex-wrap="wrap" 
                data-justify-content="space-between"
                data-align-items="center"
            >
                <li class="categories-filter">
                    <label for="faq-categories" class="visually-hidden">Select an FAQ category</label>
                    <select name="faq-categories" id="faq-categories">
                        <option value="all" selected>All Categories</option>
                        <?php
                            foreach($categories as $category):
                        ?>
                                <option value="<?= $category->term_id ?>">
                                    <?= $category->name ?>
                                </option>
                        <?php
                            endforeach;
                        ?>
                    </select>
                </li>
            </ul>
        </form>
<?php
    endif;
?>