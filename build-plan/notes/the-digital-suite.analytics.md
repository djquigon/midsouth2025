---
id: d1540l4yuiuv5dce3vw5ppu
title: Analytics
desc: ''
updated: 1738618221511
created: 1736731894491
---

### If an Analytics Account doesn't yet exist for the client, create one

-   create this account while logged in as the M&R Google Account
-   make sure that it is linked to our M&R Marketing [Organization](https://support.google.com/marketingplatform/answer/9024856?hl=en)
-   ensure that the Digital Dept also has access to this account
    -   there is a [user group](https://support.google.com/marketingplatform/answer/9013855?hl=en#zippy=%2Cin-this-article) set up for them

### Create a GA4 Property

##### Follow the established naming conventions

-   Name the property one of the following, depending on the situation:
    -   “CLIENT NAME – Main Site & Landing Pages”
    -   “CLIENT NAME – Landing Pages”
        -   we push all data we collect to the same property and use [audiences](https://support.google.com/analytics/answer/12799087?hl=en) to sort through the details
-   carefully follow the setup prompts. the key information we need from this setup is the _**Data Stream Measurement ID**_
    -   we use this ID to connect a [GTM Container](https://developers.google.com/tag-platform/tag-manager/api/v1/reference/accounts/containers) to a GA4 Property

### Create the Audiences

-   In a situation in which we are tracking data from _**both**_ a main website and landing page(s), create an audience for:
    -   All Website & Landing Page traffic
        -   include users where domain name **contains** the domain name
        -   omit any subdomains in the setup so that they are implicitly included
    -   Website Only Traffic
        -   _**exclude**_ users from the landing page subdomain(s)
    -   All Landing Page Traffic
        -   include users from the landing page subdomain(s)
        -   at any point in time
            -   this is so that we can know these users’ activity on the main site if they end up there
    -   Traffic to each individual landing page
        -   include users from the landing page subdirectory/slug

The situations will vary, but generally what you’re doing is **creating a distinction** in the traffic using the conditions provided by Google Analytics during the audience creation. You'll do this by using any combination of:

-   subdomains
-   page slugs
-   URL query string parameters

##### If the website has a blog, create an audience for the users that interacted with it

-   In a situation in which we are tracking data from only landing page(s), create an audience for:
    -   All Landing Page traffic
        -   include users from the landing page subdomain(s)
    -   Traffic to each individual landing page
        -   include users from the landing page subdirectory / slug

##### Keep the following in mind:

-   be wary of using filter conditions that include language like _**exactly matches.**_ Instead, opt for something that’s less explicit, like _**contains**_
-   once an audience is created, it can not be edited later, only deleted and replaced
-   make a note to check the traffic numbers a few days after the audience(s) are created

### [Create and enable an internal traffic filter](https://support.google.com/analytics/answer/10104470?hl=en)

Filter out the M&R Office IP & any other relevant IP(s), like your personal computer(s) at home. Always keep in mind that this will affect your ability to test things if toggled on.

### [Enable Google Signals and Acknowledge Data Collection](https://support.google.com/analytics/answer/9445345?hl=en#zippy=%2Cin-this-article)

This enables Google to collect additional information on the users to more personalize their ad experience.

---

Now that you've got your Analytics property set up, grab your _**Data Stream Measurement ID**_ and start setting up the next service: [[the-digital-suite.tag-manager]]
