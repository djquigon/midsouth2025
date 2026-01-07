---
id: ftwp4qn8j8ekny9fy2g7itk
title: Build out the Modules
desc: ''
updated: 1736524618250
created: 1736287496676
---

This is where your [[pre-build-phase.functionality-map]] will come into play.

-   create the modules in the WordPress back-end using the ACF plugin & populate them with the necessary fields
-   properly label the modules, fields, and sub-fields
    -   keep UX in mind:
        -   somebody who did not build the site should be able to come in and easily make changes
        -   field descriptions, instructions, and message fields can be used to create clear and descriptive distinctions
        -   _e.g. include the recommended dimensions in the description of an image field in any module_
-   follow the existing template file structure in the M&R Theme to associate your module with a .php file
    -   e.g. [[..\wp-content\themes\mrmastertheme\views\global\modules\standard-content\standard-content.php]]
-   in your module’s .php file, reference appropriate field names and render/echo their field data using a combination of PHP and HTML
    -   appropriately identify each element with classes or IDs
    -   keep in mind how this will tie into your CSS styling or any JavaScript functionality
    -   appropriately use any needed html attributes for accessibility
        -   aria-label
        -   aria-hidden
        -   aria-expanded
        -   [View our additional accessibility guidelines](https://i.mandr-group.com/process/accessibility-checklist-dev/)

## Read this: [[code-commentary]]

### A reminder: [[modules-defined]]
