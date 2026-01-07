(function () {
    initializeBlogFilterForm(); 
})();

function initializeBlogFilterForm() {
    if (document.getElementById('tags-filter-toggle')) {
        var tags_filter_toggle = document.getElementById('tags-filter-toggle');
        
        tags_filter_toggle.addEventListener('click', function() {
            //toggle the 'aria-expanded' attribute of the button
            if (this.getAttribute('aria-expanded') === 'false') {
                this.setAttribute('aria-expanded', 'true');
            } else if (this.getAttribute('aria-expanded') === 'true') {
                this.setAttribute('aria-expanded', 'false');
            }

            //toggle the 'aria-hidden' attribute of the tags filter multi-select
            if (tags_filter_toggle.nextElementSibling.getAttribute('aria-hidden') === 'false') {
                tags_filter_toggle.nextElementSibling.setAttribute('aria-hidden', 'true');
            } else if (tags_filter_toggle.nextElementSibling.getAttribute('aria-hidden') === 'true') {
                tags_filter_toggle.nextElementSibling.setAttribute('aria-hidden', 'false');
            }
        });
    }
}