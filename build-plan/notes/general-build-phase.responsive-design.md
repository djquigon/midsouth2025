---
id: r38dczwqrew3y6g43iemwwh
title: Responsive Design
desc: ''
updated: 1736524799108
created: 1736518206622
---

Using the browser inspector tool, scale your website down from a huge 2560 X 1440 to a standard 1920 x 1080 desktop size, & then all the way down through various laptop & tablet sizes to a 320px width phone size and debug any styling/scripting related issues.

**Keep the following in mind:
**

-   don’t test only for screen width, but test multiple heights as well
-   you may need to add custom break points for CSS media queries to account for outlier design issues
    -   [[..\wp-content\themes\mrmastertheme\library\custom-theme\scss\variables\_breakpoints.scss]]
-   you never want your font sizing to go lower than 16px
    -   in some extreme cases you may need to go to 14px, but avoid it if possible
    -   an example of this is crowded header areas on mobile screen sizes
-   account or designs of content being laid out in columns on desktop that have a 'reverse order' but still need to flow in a consistent direction on mobile screen sizes
    -   often this in the form columned content layouts that pair with an image
    -   on mobile screen sizes, the flow of content generally needs to be:
        -   heading
        -   content / excerpt / description / paragraph text
        -   supplemental image
-   in areas that feature a lot of clickable links in a smaller space, keep in mind the size of the average adult thumb
-   be aware of long strings of text that won’t “word-wrap” on smaller screens
    -   often these are long email addresses
-   account for desktop hover & focus states whose behavior will change on mobile screen sizes
-   it may be that certain elements just have to disappear on mobile screen sizes
    -   be conservative with removing elements completely from the mobile view
-   ensure to use both an actual mobile device and the browser inspector tool to check the site for responsive design issues
    -   often there will be issues / bugs that can be seen on one and not the other
-   if possible, use multiple mobile browsers, Operating Systems, and devices
    -   we have a [LambdaTest](https://www.lambdatest.com/) account to emulate any browsers, Operating Systems, or devices you don’t have normal access to

### It may be helpful to familiarize yourself with screen resolution statistics:

-   https://gs.statcounter.com/screen-resolution-stats
-   https://www.w3schools.com/browsers/browsers_display.asp
-   https://www.ios-resolution.com/
