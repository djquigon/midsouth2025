---
id: lkh7il9906nka4gbb2icdq8
title: Initial Setup Phase
desc: ''
updated: 1736872212484
created: 1735933871233
---

## Proceed with this phase only _**after**_ you've put together a [[pre-build-phase.functionality-map]]

In this phase of the project, you are setting up your actual build environment.

## Hosting Environment Setup

[WP Engine](https://identity.wpengine.com/signin) is our hosting environment of choice. Although most of a web build will take place in a local environment on your machine, we _**start**_ by ensuring everything is set up correctly on the web server.

-   create a WP Engine site environment
    -   add site to ‘Not Live’ site group
    -   enable smart plugin manager
    -   copy from the most recent backup of the M&R Master Theme
-   add your SSH key to the environment for git command usage later
    -   this will be primarily for pushing any code changes to WP Engine
-   _**allow everything to propagate**_

---

## GitHub Repository Initialization

We use [GitHub](https://github.com/MandRMarketing) to archive & track all changes made to a website's code. If you're working on a site build or update, by the end of the workday, everything you've worked on should be reflected on GitHub. This helps to ensure that the entire dev team has access, just in case somebody else needs to pick up where you left off.

-   in the M&R organization on GitHub, create a repository for the website
-   be sure to include the full name of the client and any acronyms used on teamwork in the repository’s description
    -   this makes future searches easier for both yourself and other team members

---

## Local Environment Setup

The majority of the build process will take place in a local environment on your machine. We use [Local by Flywheel](https://localwp.com/) to quickly connect to WP Engine, pull a copy of the site down, and spin up a local environment.

-   After the WPE environment has fully propagated, use Local to connect to it and pull it down to your machine
    -   files AND database

### From here, you'll take the initial steps to change parts of the M&R Master Theme to fit the client's brand

-   after WPE environment is fully propagated, pull it down to your local machine using Local by Flywheel
-   include a screenshot.png file in root of the client's theme directory
    -   crop the site design file’s homepage to be 1200 X 900 and save as screenshot.png
-   change the site title to fit the client in the site's WP Admin -> Settings -> General
-   there will be one last step that's described in the next section:

---

## Node Package Installation

We use [Node Package Manager](https://www.npmjs.com/) to download packages that allow us to watch our files for changes as we work, and recompile when the files are saved. This is especially useful when working with SCSS & front-end JavaScript frameworks like Vue.js

-   In your Visual Studio Code project, open a new terminal & `CD` into the custom theme directory
    -   i.e. /wp-content/themes/client-custom-theme-name
-   run the command, `npm install`
    -   this will use the **package.json** file to connect to Node Package Manager
    -   e.g. [[..\wp-content\themes\mrmastertheme\package.json]]
-   debug any errors thrown

    -   this would likely come from deprecated packages that need updating to their version number
        -   find new package versions on [NPM’s website](https://www.npmjs.com/)
        -   this can potentially be very time consuming. pay close attention to what the terminal reports in the error log(s)
        -   other likely errors come from package dependency issues
            -   Google it, you’re likely not the first to encounter it

-   after successful install, run the gulp command and test the stylesheet(s) and scripts file(s) compiling
    -   initiate gulp by running the command `npx gulp`
    -   open a scss file, make a change, save, and keep an eye on the Terminal
-   change the theme name in the comments at the top of [[..\wp-content\themes\mrmastertheme\style.scss]] to fit the name of the client, then recompile stylesheet
    -   this change can be seen as the name of the custom theme from the site’s WP Admin -> Appearance options

---

## Local Git Repository

-   initialize local git repository in the website’s _**root**_ directory
-   add and edit .gitignore file
    -   it’s easiest to copy a recent website’s .gitignore file
-   do an initial commit of the current files
-   add remote repositories
    -   github
        -   `git remote add github [paste github repo URL]`
    -   WPE environment(s)
        -   `git remote add production [paste WPE repo URL]`
        -   `git remote add staging [paste WPE repo URL]` (if necessary)
        -   `git remote add dev [paste WPE repo URL]` (if necessary)
-   set the upstream branches
    -   `git push -u github master`
    -   `git push -u production master`
    -   etc.

---

## Swap out the logo files & customize the login page

-   replace the M&R Logo file with the client's logo
    -   always use an SVG file
-   make sure that this logo change is reflected on the login page, & add an appropriate background color
    -   [[..\wp-content\mu-plugins\login-logo\login-logo.php]]

---

## Remove any unnecessary components of M&R Master Theme

At this point, you've already put together a [[pre-build-phase.functionality-map]], so you should use it to remove any part of the starter theme you won't need. This may include:

-   module field groups & meta fields
    -   corresponding PHP / SCSS / JS files
-   plugins
-   default pages
-   etc.

At this point, you should have a version of the M&R Theme that is a sort of 'clean slate'. It has all of the necessary plugins added, the settings have been adjusted to fit the client's name & brand, & you've removed anything that will get in your way during the build.

**You're free to move on to the next phase of the web build:** [[general-build-phase]]
