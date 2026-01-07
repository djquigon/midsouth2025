(function () {
    initializeToggledMenu(); 
})(); 

function initializeToggledMenu(){
    //if all the necessary elements exist: 
    if (document.getElementById('menu-toggle-trigger') && document.getElementById('toggled-nav') && document.getElementById('close-toggled-menu')) {

        //declare constants for the elements:
        const menu_toggle_trigger = document.getElementById('menu-toggle-trigger');
        const toggled_nav = document.querySelector('#toggled-nav'); 
        const menu_close_trigger = document.getElementById('close-toggled-menu');

        //add click functionality to the toggle-menu trigger button:
        menu_toggle_trigger.addEventListener('click', function(e) {
            
            //if closed, toggle the menu open. Or vice-versa:
            if (e.target.ariaExpanded === "false") {

                //toggle the button & menu to it's "open" state:
                e.target.ariaExpanded = "true";
                toggled_nav.setAttribute('aria-hidden', false);

                //ensure the body element can't scroll:
                document.body.classList.add('modal-open');
            } else if (e.target.ariaExpanded === "true") {

                //toggle the button & menu to it's "closed" state:
                e.target.ariaExpanded = "false";
                toggled_nav.setAttribute('aria-hidden', true);

                //remove the class that disables <body> scrolling:
                document.body.classList.remove('modal-open');
            }
        });

        //add click functionality to the close menu button:
        menu_close_trigger.addEventListener('click', function(e) {
            //reset the menu toggle trigger:
            menu_toggle_trigger.setAttribute('aria-expanded',false);

            //hide the toggled nav:
            toggled_nav.setAttribute('aria-hidden', true);

            //remove the class that disables <body> scrolling:
            document.body.classList.remove('modal-open');
        });

        //add focusout event listener. so when you leave the menu from tabbing, everything resets properly
        menu_close_trigger.addEventListener('focusout', function(e) {
            //reset the menu toggle trigger:
            menu_toggle_trigger.setAttribute('aria-expanded',false);

            //hide the toggled nav:
            toggled_nav.setAttribute('aria-hidden', true);

            //remove the class that disables <body> scrolling:
            document.body.classList.remove('modal-open');
        });  
    } 
}