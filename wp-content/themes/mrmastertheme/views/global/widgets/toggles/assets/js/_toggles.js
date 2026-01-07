(function () { 
    initializeToggles(); 
})();

function initializeToggles() {
    //check first for an element using the toggle trigger class. It should be a <button>
    if (document.getElementsByClassName('toggle-trigger').length > 0) {
        var toggle_triggers = document.getElementsByClassName('toggle-trigger');

        //loop through all toggle triggers:
        for (let i = 0; i < toggle_triggers.length; i++) {
            //attach a click event:
            toggle_triggers[i].addEventListener('click', function() {

                //toggle the 'aria-expanded' attribute of the dropdown button
                if (this.getAttribute('aria-expanded') === 'false') {
                    this.setAttribute('aria-expanded', 'true');
                } else if (this.getAttribute('aria-expanded') === 'true') {
                    this.setAttribute('aria-expanded', 'false');
                }

                //grab the ID of the 'answer'
                var answer_id = this.getAttribute('aria-controls');
                
                //declare a variable to hold the answer
                var answer = document.getElementById(answer_id.toString());

                //toggle the 'aria-hidden' attribute of the target 'answer'
                if (answer.getAttribute('aria-hidden') === 'false') {
                    answer.setAttribute('aria-hidden', 'true');
                } else if (answer.getAttribute('aria-hidden') === 'true') {
                    answer.setAttribute('aria-hidden', 'false');
                }
            });
        }
    }
}