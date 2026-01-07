---
id: 209ktjc0vkfor0xwk7cynbi
title: Styling
desc: ''
updated: 1736524729907
created: 1736287903243
---

A significant portion of your web build will be spent here. We have a modular approach to styling in the current M&R Master Theme. This means that module-specific styling will take place in the same directory as any HTML / PHP / JS work.

Any necessary styling changes that need to apply across a wider portion of the site, i.e. a change to the flex &/or container system, adjustments to the breakpoints, etc.; these will take place in the /library/scss folder.

-   using Sass, make each module's styling match the design
    -   aim for a 'pixel-perfect' recreation of the design file
        -   i.e. match the font sizes, line-heights, letter-spacing, margins, paddings, widths, heights, border-radius, colors, etc.
-   use a modularized .scss file structure
-   aim for efficient use of CSS selections, [here is a useful guide](https://www.w3schools.com/cssref/css_selectors.php)
-   efficient use of SCSS syntax is encouraged
    -   SCSS syntax can save you a lot of time, but it can also quickly make your code convoluted and hard to follow for another developer who may be unfamiliar with your personal conventions
    -   keep this balance of speed and future maintainability in mind
    -   https://sass-lang.com/guide/
    -   https://sass-lang.com/documentation/syntax/
-   your styling code should be as light and general as possible
    -   this means that you’re aiming to be implicit with your CSS selectors, which means that child elements will inherit properties without you creating explicit rules for them
-   there will be outlier cases that require hyper-specific selections and CSS rules
    -   keep these to an absolute minimum
    -   we have a dedicated file for these cases: [[..\wp-content\themes\mrmastertheme\library\custom-theme\scss\exceptions\_exceptions.scss]]
-   **!important** is not illegal, but if you’re finding yourself having to use it, there is probably a better way to restructure your HTML and CSS

### Some useful styling-related tools:

-   [CSS Hex & RGBA Converter Tool](http://hex2rgba.devoth.com/)
-   [CSS Gradient Tool](https://www.cssmatic.com/gradient-generator)
-   [CSS Triangle Tool](http://apps.eky.hk/css-triangle-generator/)
-   [CSS Clip-Path Tool](https://bennettfeely.com/clippy/)
-   [CSS Selectors Reference](https://www.w3schools.com/cssref/css_selectors.php)
-   [IcoMoon - Free Icons](https://icomoon.io/app/#/select)

## Read this: [[code-commentary]]
