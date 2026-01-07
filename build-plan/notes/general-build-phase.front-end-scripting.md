---
id: s6i15bnpj59165l7utkkm9l
title: Front-End Scripting
desc: ''
updated: 1736517490725
created: 1736289141668
---

For the majority of our web projects, custom JavaScript implementation tends to play a minor role and the overwhelming majority of your time will be spent using PHP, HTML, and CSS. Some major components of a website’s functionality (ex. header & navigation) will feature JavaScript at it’s core, and at times your knowledge of JavaScript will be tested.

Here are some suggestions to keep in mind:

-   be knowledgeable of:
    -   the DOM
    -   nodes
    -   data types
    -   objects, attributes, events, and all of their relationships
-   be comfortable using the browser inspector tool’s JavaScript console for debugging and testing functionality
    -   **console.log()** is your friend
-   take your time and walk yourself through the logical flow of any issue you’re debugging
    -   although the code syntax may be daunting, the logic of how something should work rarely changes across languages
-   ensure any 3rd party scripts/libraries you weave into the theme are properly enqueued, watched, linted, compiled, & minified
    -   Relevant files:
        -   [[..\wp-content\themes\mrmastertheme\library\custom-theme\php\enqueues.php]]
        -   [[..\wp-content\themes\mrmastertheme\gulpfile.js]]
-   when considering using a 3rd party library, opt for one that has quality documentation to reference
-   often you may be tempted to use JavaScript to quickly solve issues that are more difficult to solve with PHP
    -   opt to solve issues with PHP, and use JavaScript as your last resort
        -   e.g. adding/removing elements with JavaScript instead of using PHP hooks/filters

<!-- (come back and add vue.js – specific notes, create an entirely different linked file) -->

## Read this: [[code-commentary]]
