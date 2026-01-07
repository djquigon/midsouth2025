---
id: ya7g42rs5jqebjpuqsl28km
title: Build the Footer
desc: ''
updated: 1736287854333
created: 1736287832072
---

-   if necessary, create new or use existing WordPress menu locations
    -   these are handled in [[..\wp-content\themes\mrmastertheme\library\custom-theme\php\initialization.php]]
-   reference any necessary module/widget template files in the footer template
    -   perhaps an e-newsletter signup, social media links, etc.
    -   e.g. [[..\wp-content\themes\mrmastertheme\views\global\widgets\social-media-icons\social-media-icons.php]]
-   ensure any footer content that is likely to change is easily manageable from WordPress back-end (/wp-admin/)
    -   likely from the ACF Options tab
-   using the options tab fields and any appropriate shortcodes, include the following if needed:
    -   phone number(s)
    -   physical address(s) with link(s) to Google maps
    -   email address(s)
    -   social media account links
-   be sure to change the copyright info to fit the client’s business name
-   ensure that there are links to both the Privacy Policy & ADA Compliance Statement somewhere in the footer
