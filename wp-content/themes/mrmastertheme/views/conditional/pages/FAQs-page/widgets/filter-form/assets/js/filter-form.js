(function () { 
    initializeFAQCategoryFilterForm(); 
})();

function initializeFAQCategoryFilterForm() {
    //only proceed if the FAQ filter form's <select> element exists:
    if (document.querySelector('form#faq-filters select#faq-categories')) {
        //declare a variable to hold the filter form's <select>
        var faq_filter_select = document.querySelector('form#faq-filters select#faq-categories');

        //declare a variable to hold the FAQ toggles:
        if (document.querySelectorAll('dl.faqs-list div.toggle')) {
            var faq_toggles = document.querySelectorAll('dl.faqs-list div.toggle');

            //define a function that is triggered by the <select>'s change event:
            faq_filter_select.onchange = function() {
                //grab the value of the filter select form
                var selected_category = faq_filter_select.value;

                //loop through the FAQ toggles:
                for (let i = 0; i < faq_toggles.length; i++) {
                    //immediately hide all FAQs:
                    faq_toggles[i].setAttribute('aria-hidden', 'true');
                    
                    //if we're selecting the default 'all' <option>
                    if (selected_category === 'all') {
                        //'un-hide' all the toggles:
                        faq_toggles[i].setAttribute('aria-hidden', 'false');
                    } else {
                        //grab the FAQ toggle's category IDs & convert to string:
                        var faq_categories = faq_toggles[i].getAttribute('data-category-ids').toString();
                        
                        //if the string contains the selected category ID, toggle its visibility:
                        if (faq_categories.includes(selected_category)) {
                            faq_toggles[i].setAttribute('aria-hidden', 'false');
                        } else {
                            faq_toggles[i].setAttribute('aria-hidden', 'true');
                        }
                    }
                }
            }
        }
    }
}