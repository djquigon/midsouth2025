---
id: 6k2vw34hs7mcs99grseua6d
title: Legacy Search & Replace Method
desc: ''
updated: 1747423189002
created: 1747422193087
---

We need to search the entire database for any instance of the default domain, something like **client_name.wpenginepowered.com** and replace it with the live domain **www.client-domain.com**

The exact domain that the client wants the new site to live on is something that should've been sorted out in the [[pre-build-phase]].

The legacy method of conducting the search-replace is through using the [WP CLI](https://wpengine.com/resources/on-demand-webinar-developers-bada-wp-cli/). The only pre-requisite is your SSH key being associated with the WPE environment, which is certainly done by this point.

### CREATE A BACK-UP POINT FOR THE SITE BEFORE PROCEEDING

-   Open up a command prompt / terminal & connect to the WPE environment's database via the WP CLI
    -   at the time of my writing this, the M&R Office computers require a command preface before you paste in the WPE environment's SSH login:
        -   `ssh -i ~/.ssh/wpengine_ed25519 -o IdentitiesOnly=yes`
    -   so let's use the Stuckey's site as a practical example:
        -   `ssh -i ~/.ssh/wpengine_ed25519 -o IdentitiesOnly=yes stuckeyslogs@stuckeyslogs.ssh.wpengine.net`
        -   copying the above command and running it in a terminal will connect you to the WPE environment's WP CLI.
-   Now that you're connected to the WP CLI, run a dry run of the search-replace command
    -   `wp search-replace client_name.wpenginepowered.com www.client-domain.com --dry-run`
    -   you should be given a list & count of instances in the database that will change. If the list is empty & the count is 0, something is wrong.
    -   if everything looks correct, run the live search-replace command by omitting `--dry-run`
        -   `wp search-replace client_name.wpenginepowered.com www.client-domain.com`
    -   to be extra thorough, run a second search-replace to make sure only HTTPS is referenced on the site and not HTTP
        -   `wp search-replace http://www.client-domain.com https://www.client-domain.com --dry-run`
        -   `wp search-replace http://www.client-domain.com https://www.client-domain.com`

---

##### If all of the above is done correctly, you're ready to move to the next step:

## Change the primary domain

Up to this point, your primary domain on the WPE Environment is something default that contains **wpenginepowered.com**. You just ran the search-replace to make this change in the site's database. Now this change must be reflected in the WPE panel's settings.

-   Change the primary domain in the settings to be the live domain
-   Configure the remaining domains to all redirect to the new primary domain
    -   After changing this setting, you may notice that the site you built is forwarding to the client's old site. This is because we've yet to make any DNS changes at this point
-   You can expedite the process by using SFTP to access the live wp-config.php file and changing the primary domain set up in it

---

## Change the DNS

The ideal situation is we have full control over the DNS, or at least full access to make changes. This should all have been sorted out by this point, preferrably in the [[pre-build-phase]].

In order for the new site to 'Go-Live', the DNS needs to change so that the primary A / CNAME record points to the website we built on WP Engine. The same change needs to apply to any WWW records that exist.

**At this point in the process, your website is already pointing to the client's domain. You basically need to point the domain back to the site.**

-   Screencap / export the client's current DNS configuration because you may need it for reference later
-   Before changing any records, pay attention to which records reference each other
    -   e.g. in some cases, a mail record will point to the IP address on the primary A record. This means if you change the primary A record without changing the mail record, you'll break their email services.
-   In the domain settings of the WPE Panel, get the DNS details for the primary domain
    -   you'll be given at least one IP Address for the A record and a single domain for the CNAME
    -   The two types of DNS records that we deal with in this scenario are [A records](https://www.cloudflare.com/learning/dns/dns-records/dns-a-record/) & [CNAME records](https://www.cloudflare.com/learning/dns/dns-records/dns-cname-record/).
    -   You should use 1 type of record or the other. Avoid using a combination of the 2 when it comes to the primary & WWW records.
-   In the client's DNS settings change the primary A / CNAME record(s) to whatever the aforementioned DNS Details told you in the domain settings of the WPE panel
    -   if CloudFlare is being used to manage the DNS, keep the 'Proxy' setting disabled for these records

**In addition to our outline above, here's [WP Engine's Guide](https://wpengine.com/support/point-domain/) on how all this works.**

### Be extremely cautious & a little paranoid

While DNS changes propagate, redirect loops are normal, _**to an extent**_. Try different browsers & devices. However, _if the website goes down_ for any longer than 10 mins, **something is wrong** and you need to re-evaluate the setup.

Use [MX ToolBox](https://mxtoolbox.com/SuperTool.aspx), a command prompt / terminal, or whatever your preferred tool is to ping the domain and monitor the DNS changes you just made.

### Additional DNS changes to consider:

-   Pay attention to their mail-related records, and if any of them are pointing to the primary A record, make the changes to preserve their emails first before touching the other records
-   If you haven't by this point & need to, follow the steps in the [[general-build-phase.contact-forms]] documentation to set up a [verified sender](https://postmarkapp.com/developer/user-guide/managing-your-account/managing-sender-signatures)
-   Go ahead and add any records needed to verify ownership of the site on [[the-digital-suite.search-console]]

---
