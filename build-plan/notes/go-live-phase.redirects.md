---
id: cbxwnfrewe8okejb783zzgl
title: Redirects
desc: ''
updated: 1736891366519
created: 1736727914790
---

### This document really only applies when we are building a new site to replace a client's old site

The problem that we aim to solve is any dead links lingering from the old site after the new site goes live. The idea is to have a fitting redirect set up for each link on the old site.

It is the Copywriter's responsibility to provide a redirect map to the developer. Ideally, this is ready for you in the [[pre-build-phase]]. They will likely provide you with this in the form of an Excel spreadsheet.

Contact WP Engine's support team and have them bulk-import the redirect rules, but they will require a .txt file. You're able to generate one from an Excel file.

**After the bulk-import**, review the redirect rules and test for any potential conflicts / loops.

For convenience & tradition, manually add a redirect for `/gotologin/ -> /wp-login.php/`. We previously used a plugin to manage this, but it interferes with WordPress's default 'Lost Password' functionality that every client will need at some point.
