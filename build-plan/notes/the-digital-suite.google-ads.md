---
id: a1j4n6cx9uyq3clqrxlczyg
title: Google Ads
desc: ''
updated: 1736734834626
created: 1736733934643
---

The M&R Digital Dept is responsible for the setup of the client's Google Ads account. They are also responsible for the strategy & setup of [Conversion Tags in Google Ads](https://support.google.com/google-ads/answer/1722022?hl=en). In the [[pre-build-phase]] of the project, they will deliver to you a list that describes any user actions that they wish to be recorded as conversions.

You as the developer are responsible for the setup & testing of these Conversion Tags.

-   the Conversion Linker tag & some basic conversion actions are set up in our M&R GTM Container template, but are paused by default
    -   Contact Form Submission, Email link click, etc.
-   For each Ads Conversion Tag in a GTM Container, you will need an **ID** & **Label** to plug in so that it connects to Google Ads
-   Each [Ads Conversion Tag](https://support.google.com/tagmanager/answer/6105160?hl=en) will need to have a valid [GTM trigger](https://support.google.com/tagmanager/answer/7679316?hl=en)
    -   setting these up may require some creativity, depending on the situation
    -   these are also difficult to test because of the nature of conversions not being counted unless triggered by the actions of a legit ad viewer
        -   [Here's Google's guide for testing Ads Conversion Tags](https://support.google.com/google-ads/answer/12215725?hl=en)
        -   In Google Ads, if a conversion's status is **'No Recent Activity'**:
            -   this could mean that the tag is set up correctly, but hasn't been triggered recently
        -   If the status however is **'Tag inactive'**, something is configured incorrectly
