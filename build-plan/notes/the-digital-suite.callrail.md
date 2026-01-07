---
id: cl2n0peozx3vdei6qcjtsyh
title: Callrail
desc: ''
updated: 1736776561435
created: 1736775471493
---

For some situations, we'll use CallRail’s JavaScript snippet to track contact form submissions, regardless of whether or not dynamic phone number swap is needed on the website / landing page(s).

During the [[pre-build-phase]], check with the M&R Digital Dept on the necessity to set up CallRail.

### If a CallRail account doesn't yet exist for the client, create one

-   CallRail will prompt you to associate a phone number with the account
    -   Use the main phone number from the client’s website, or confirm with the Project Manager &/or Digital Dept what number should be used if it is otherwise unclear
-   Ensure that form tracking is enabled in the [CallRail settings](https://support.callrail.com/hc/en-us/articles/5712075728013-Set-up-external-form-tracking/#form-submit-error)
-   Install the CallRail script on every page of the site
    -   you'll likely place it in the header: [[..\wp-content\themes\mrmastertheme\header.php]]
