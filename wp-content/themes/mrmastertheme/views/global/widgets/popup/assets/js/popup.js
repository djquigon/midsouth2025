class PopupManager {
    constructor() {
        //Popup Manager constructor:
        this.popups = window.mrPopupData || [];
        this.currentPageId = window.mrCurrentPageId;
        this.init();
    }

    init() {
        // Filter popups that should be shown on current page
        const relevantPopups = this.popups.filter((popup) => {
            // If no pages specified, show on all pages
            if (!popup.pages || popup.pages.length === 0) return true;
            // Otherwise check if current page is in the list
            return popup.pages.includes(this.currentPageId);
        });
        // Create and show popups
        relevantPopups.forEach((popup) => {
            this.createPopup(popup);
        });
    }

    createPopup(popupData) {
        // Check if popup should only show once and has been shown before
        if (popupData.only_show_once && this.hasPopupBeenShown(popupData)) {
            return;
        }

        //create the HTML for the element:
        const popup = document.createElement('dialog');
        popup.className = 'popup';
        popup.innerHTML = popupData.html; 

        // Add close button event listener
        const closeBtn = popup.querySelector('.close-popup');
        if (closeBtn) {
            closeBtn.addEventListener('click', () =>
                this.closePopup(popup, popupData)
            );
        }

        // Allow for user to use 'ESC' key to close popup: 
        document.addEventListener('keydown', (event) => {
            if (event.keyCode === 27) {
                this.closePopup(popup, popupData);
            }
        });

        // Add background click event listener to close popup
        popup.addEventListener('click', (e) => {
            // Only close if clicking on the background (not the popup content)
            if (e.target === popup) {
                this.closePopup(popup, popupData);
            }
        });

        // Try to find article element first, fallback to body
        const articleElement = document.querySelector('article');
        const targetElement = articleElement || document.body;

        // Add to article element (or body if no article found)
        targetElement.prepend(popup);

        // Show popup after a short delay
        setTimeout(() => {
            popup.setAttribute('aria-hidden', 'false'); 
        }, 1500);

        //accessibility thing - set the focus to be within the popup content:
        if (!this.hasPopupBeenShown(popupData)) {
            setTimeout(() => {
            //this has to use a timeout function too because of the one that precedes it
            popup.focus();
        }, 1600);
        }
    }

    closePopup(popup, popupData) {
        //remove focus from the element first:
        popup.blur();
        
        //then toggle its aria-hidden attribute:
        popup.setAttribute('aria-hidden', 'true');
        
        // If popup should only show once, set cookie
        if (popupData.only_show_once) {
            this.setPopupShown(popupData);
        }
    }

    hasPopupBeenShown(popupData) {
        const cookieName = `popup_${popupData.id}_shown`;
        return document.cookie.includes(cookieName);
    }

    setPopupShown(popupData) {
        const cookieName = `popup_${popupData.id}_shown`;
        const expiryDate = new Date();
        expiryDate.setFullYear(expiryDate.getFullYear() + 1); // Cookie expires in 1 year
        document.cookie = `${cookieName}=true; expires=${expiryDate.toUTCString()}; path=/`;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    //we only proceed if a page ID has been passed as a JS object, & we only pass it if a popup exists for that page:
    if (window.mrCurrentPageId) {
        //call the popup constructor:
        new PopupManager();
    }
});
