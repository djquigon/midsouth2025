---
id: c7yhr3ukt05p8mri2ocnh7w
title: Tag Manager
desc: ''
updated: 1738618221508
created: 1736732330321
---

### Export the M&R container template

-   Log into [Google Tag Manager](https://tagmanager.google.com/#/home) & select the container named '**AAA - Tag Manager Template**'
-   click the admin settings and ‘export container’
-   select the default workspace and click ‘export’ once again with all tags selected

### If a GTM Account does not yet exist for the client, create one

##### Follow the established naming conventions

-   name the account ‘CLIENT NAME – Main site & Landing Pages’ if applicable
    -   just ‘CLIENT NAME – Main site’ if not
-   click the admin settings and **import the M&R GTM container template**
    -   choose the container file you previously exported
    -   choose the existing default workspace
    -   choose to overwrite the existing default workspace
-   once you return to the container's workspace tab, you'll see that there will be a significant number of changes added to the workspace

### Change the default variables

-   In our current setup, there is a '**GA4 Data Stream ID**' variable
    -   change this to be the **Data Stream Measurement ID** we mentioned in the [[the-digital-suite.analytics]] setup

In most cases, this will be the only variable you'll change. Some clients may have a Meta Pixel ID that they would like to use. You would change this in a very similar manner.

### Be sure to 'publish' the changes to your now configured GTM Container

Now that your changes are published, you need to ensure that the GTM Container script is on the website.

### Plug the GTM Container ID into the WP 'Options' tab

To be clear, this is the ID from the GTM Container, and will be formatted like: **GTM-ABCD123**

The following files will pull it from the WP 'Options' tab: - [[..\wp-content\themes\mrmastertheme\views\global\widgets\google-tag-manager\container-script-head.php]] - [[..\wp-content\themes\mrmastertheme\views\global\widgets\google-tag-manager\container-script-body.php]]

### Confirm that the connection works by checking the Google Analytics Realtime Report

-   Remember to check if an Internal Traffic filter is toggled on / off in the Analytics property.
-   try visiting a few different pages, triggering some event tags to fire, etc.
