---
id: bqthjmh3rhnm29bpdrkftcq
title: Domain & DNS Adjustments
desc: ''
updated: 1747423157475
created: 1736803137053
---

We're finally here at the point where we 'flip the switch' and Go-Live with our new website. You will only proceed with what's in this document after you've gotten full approval by our team & the client to Go-Live.

## BEFORE DOING ANYTHING ELSE:

### Turn on search engine visibility in the WP Admin Settings -> Reading

All of your hard work up to this point is meaningless if the site doesn't get indexed immediately after going live.

### CREATE A BACK-UP POINT FOR THE SITE BEFORE PROCEEDING

---

## Add the client's domain to the WP Engine environment

Do this in the domain settings of the WPE panel.

The exact domain that the client wants the new site to live on is something that should've been sorted out in the [[pre-build-phase]].

## Change the primary domain

Up to this point, your primary domain on the WPE Environment is something default that contains **wpenginepowered.com**.

-   Change the primary domain in the WPE settings to be the live domain
-   Configure the remaining domains to all redirect to the new primary domain

## The Search & Replace & wp-config.php file

After changing the primary domain in the settings, WPE will automatically conduct a search & replace in the database and make changes to the wp-config.php file to reflect the domain change. This does however take some time.

If you want/need this process to go faster, you also have the option of manually doing this via the [[go-live-phase.domain-dns-adjustments.legacy-search-replace]].

After changing the primary domain and adjustments are made in the database & wp-config.php file, you may notice that the site you built is forwarding to the client's old site. This is because we've yet to make any DNS changes at this point.

---

### If any of the above goes horribly wrong, revert to your aforementioned back-up point & start over.

Get some help from a fellow Dev Dept member & / or WP Engine's support team

---

##### If all of the above is done correctly, you're ready to move to the next step:

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

## If all of the above has been executed perfectly, your website is now live!

This means you're ready to move on to the [[post-live-phase]], but only _**after**_ you've ensured that the website is being indexed properly.
