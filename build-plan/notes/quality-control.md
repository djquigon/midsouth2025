---
id: 4b1ar0obh3w9t9no6nc23ap
title: Quality Control
desc: ''
updated: 1750863219759
created: 1736535331117
---

This list is meant to be used heavily in the [[go-live-phase]], & the [[post-live-phase]]. To be proactive, consider taking care of many of the list at earlier points in the web build, like the [[general-build-phase]].

-   Ensure that a loading animation is applied to any pages that need it
    -   there should at least be one used on the homepage
    -   relevant file: `..\wp-content\themes\mrmastertheme\views\global\widgets\loading-animation\loading-animation.php`
-   [There needs to be a favicon on the site](https://realfavicongenerator.net/)
-   Review the ACF usage throughout the site:
    -   Meta field naming conventions should be intuitive
    -   Descriptions are used effectively
    -   all image fields include a note on recommended dimensions for upload
-   Ensure that WP shortcode usage is minimal in any WYSIWYG field
-   If the site is using a feature that requires an API key, make sure that _**all domains**_ associated with the site are also associated with the API key(s)
    -   i.e. any site that features a custom Google Map
    -   sites with [[general-build-phase.contact-forms]] will almost always require some sort of API key:
        -   Google reCAPTCHA key
        -   [Postmark](https://account.postmarkapp.com/servers) API key
-   Use our [[go-live-phase.accessibility-guidelines]] to evaluate the site
    -   among other things, this will require that the site be error-free after run through these tools:
        -   [HTML Validator](https://validator.w3.org/)
        -   [WAVE Accessibility Validator](https://wave.webaim.org/)
-   Turn on the 'Query Monitor' plugin and test every page for errors
-   Check the WP Engine error log and resolve anything problematic
-   Ensure there are both a Privacy Policy & ADA Compliance Policy available on the site and that the client’s correct business name & contact information are in them
-   Update all plugins to the most recent version
-   if necessary, change the theme version number to 1.0.0 in this file: `..\wp-content\themes\mrmastertheme\library\custom-theme\php\initialization.php`
-   If the site does not include a search feature, disable WordPress's default search functionality
    -   we have a plugin in the M&R theme that does this

## Sweep the site & evaluate every page

-   resolve any errors reported in the browser inspector tool console
    -   warnings are fine, depending on exactly what they say
    -   remove all console.log() usage
-   confirm all links work & none are broken
    -   i.e. buttons, inline links, menu links, links to files, etc.
    -   hover & focus states work
    -   internal links open in the same tab
    -   external links open in new tab
-   ensure each page responds well to every screen size
    -   if necessary, revisit this note file: [[general-build-phase.responsive-design]]
    -   use mutiple browsers, devices, & OS(s)
        -   we have a [LambdaTest](https://www.lambdatest.com/) account to emulate any browsers, Operating Systems, or devices you don’t have normal access to
-   check the back-end of each page to be sure that the Meta Titles & Descriptions are set via the SEO plugin we use
-   review the 404 page, it should look good on all screen sizes

## Triple-check the:

-   **The site is being indexed properly**
    -   this means that the site's _no-index_ setting is turned off
        -   do this only during the [[go-live-phase]]
        -   ** check this during [[post-live-phase.peer-review]], every time**
    -   this also means that post types &/ pages that do _**not**_ need to be crawled by search engines are excluded from the sitemap
-   Configuration of [[the-digital-suite]] of services
-   [[general-build-phase.contact-forms]]

## Review the WP Engine Environment's panel

-   Are there [[go-live-phase.redirects]] in place?
    -   does /gotologin/ FWD to /wp-login.php/ ?
-   Are there [[go-live-phase.security-settings]] in place?
-   Are bots being redirected via [WPE's setting?](https://wpengine.com/support/redirecting-bots-how-this-benefits-you/)
-   Are appropriate pages being exempt from cache?
