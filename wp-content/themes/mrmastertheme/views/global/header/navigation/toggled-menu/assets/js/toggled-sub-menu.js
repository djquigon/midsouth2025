(function () {
    initializeSubMenuToggles(); 
    initializeSubMenuBackButtons();
})(); 

function initializeSubMenuToggles() {
    //if we're able to grab parent menu items that have a sub-menu
    if (document.getElementsByClassName('has-sub-menu').length > 0) {
        var sub_menu_toggles = document.getElementsByClassName('has-sub-menu');
        
        //loop through all of those parent menu items
        for (let i = 0; i < sub_menu_toggles.length; i++) {
            var toggle_button = sub_menu_toggles[i].querySelector('button');
            
            //add click event function
            toggle_button.addEventListener('click', function() {

                //toggle the 'aria-expanded' attribute of the dropdown button
                if (this.getAttribute('aria-expanded') === 'false') {
                    this.setAttribute('aria-expanded', 'true');
                } else if (this.getAttribute('aria-expanded') === 'true') {
                    this.setAttribute('aria-expanded', 'false');
                }

                //toggle the 'aria-hidden' attribute of the target sub-menu (it will always be the next sibling)
                if (this.nextElementSibling.getAttribute('aria-hidden') === 'false') {
                    this.nextElementSibling.setAttribute('aria-hidden', 'true');
                } else if (this.nextElementSibling.getAttribute('aria-hidden') === 'true') {
                    this.nextElementSibling.setAttribute('aria-hidden', 'false');
                }
            });
        }
    }
}

function initializeSubMenuBackButtons() {
    //these buttons only get generated for the 'paginated' sub-menu style:
    var sub_menu_back_buttons = document.getElementsByClassName('sub-menu-back');
    if (sub_menu_back_buttons) {

        //loop through all of those back buttons
        for (let i = 0; i < sub_menu_back_buttons.length; i++) {
            
            //add click event function
            sub_menu_back_buttons[i].addEventListener('click', function() {
                //grab the sub-menu this 'back' button belongs to
                var corresponding_sub_menu = this.parentNode.parentNode; 
                //and grab the toggle trigger for that sub-menu
                var corresponding_sub_menu_toggle = corresponding_sub_menu.previousElementSibling;

                //toggle the 'aria-hidden' attribute of the corresponding sub-menu 
                if (corresponding_sub_menu.getAttribute('aria-hidden') === 'false') {
                    corresponding_sub_menu.setAttribute('aria-hidden', 'true');
                } else if (corresponding_sub_menu.getAttribute('aria-hidden') === 'true') {
                    corresponding_sub_menu.setAttribute('aria-hidden', 'false');
                }

                //toggle the 'aria-expanded' attribute of the corresponding sub-menu's toggle button
                if (corresponding_sub_menu_toggle.getAttribute('aria-expanded') === 'false') {
                    corresponding_sub_menu_toggle.setAttribute('aria-expanded', 'true');
                } else if (corresponding_sub_menu_toggle.getAttribute('aria-expanded') === 'true') {
                    corresponding_sub_menu_toggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }
}
