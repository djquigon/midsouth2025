---
id: ysbq4n769j549zrcg316ko0
title: Incorporate site-wide Features & Variables
desc: ''
updated: 1736524563986
created: 1736287261500
---

-   import & enqueue any necessary fonts
    -   follow the existing code structure here: [[..\wp-content\themes\mrmastertheme\library\custom-theme\php\enqueues.php]]
    -   [Google Fonts](https://fonts.google.com/) &/or [Adobe Fonts](https://fonts.adobe.com/) are used in 9/10 cases
    -   if a font is not available on either platform, a manual import of the font files is required
        -   these files will need to be dropped in the folder here: wp-content/themes/mrmastertheme/library/custom-theme/fonts
        -   be sure to enqueue these files as well in this file: [[..\wp-content\themes\mrmastertheme\library\custom-theme\php\enqueues.php]]
        -   you'll need to apply your font-family CSS in these 2 files:
            -   [[..\wp-content\themes\mrmastertheme\library\custom-theme\scss\branding\_headings.scss#^dk5v47pjkdha]]
            -   [[..\wp-content\themes\mrmastertheme\library\custom-theme\scss\branding\_body-text.scss#^8v75rfz51p0n]]
-   include all colors from the client's branding
    -   grab the color hex codes used in the design files
    -   plug them into the appropriate variable names here: [[..\wp-content\themes\mrmastertheme\library\custom-theme\scss\variables\_colors.scss]]
        -   create any new variables or change the existing names if you feel that's necessary
-   import & enqueue any necessary script libraries
    -   whether you're using a CDN or importing & compiling JavaScript files, enqueue them here: [[..\wp-content\themes\mrmastertheme\library\custom-theme\php\enqueues.php]]
    -   be sure to include any imported JavaScript files in the gulpfile.js: [[..\wp-content\themes\mrmastertheme\gulpfile.js]]
        -   follow the existing code structure and include the files in the **watch** and **compile** tasks
