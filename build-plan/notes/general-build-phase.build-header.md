---
id: 4arhs3ey5z4krcdik1ca0b2
title: Build out the site Header & Menu(s)
desc: ''
updated: 1736519581257
created: 1736287388588
---

-   create new or use existing WordPress menu locations

    -   these are handled in [[..\wp-content\themes\mrmastertheme\library\custom-theme\php\initialization.php]]
    -   reference these menu locations in the appropriate PHP file:
        -   e.g. [[..\wp-content\themes\mrmastertheme\views\global\header\navigation\primary-menu\primary-menu.php]]

-   in the WP-Admin settings, create the pages &/or posts and populate the menu(s) with them
    -   for sites that have a lot of pages, consider using the WP All Import plugin to quickly bulk-create pages and include their meta titles & descriptions
-   incorporate any necessary widgets: search forms, social media links, etc.
    -   e.g. [[..\wp-content\themes\mrmastertheme\views\global\widgets\social-media-icons\social-media-icons.php]]
