---
id: xpj8yk0g9iql64xn6ourdst
title: Security Settings
desc: ''
updated: 1737493784983
created: 1736796069533
---

At the time of my writing this, our Dev Dept has a pretty steep learning curve to get past when it comes to Information Security as a general topic, but especially how it applies to our websites. We are working to make progress on this learning curve.

## Here are a few things to consider when it comes to the security of a website:

-   Using WP Engine's Advanced Network is now a standard practice on all of our websites going forward. This means that SSL certificates will be automatically managed by WP Engine, and in most web builds will be one less thing to worry about.
-   WordFence is the default security plugin that we use on our sites. This plugin, combined with the security measures automatically put in place on WP Engine's side of things, will cover a lot of our basic security concerns.
    -   consider whitelisting IPs to prevent future issues:
        -   M&R office IP
        -   any machines you do remote work on
        -   the client's IP(s)
-   the [[general-build-phase.contact-forms]] document has notes on mitigating spam
-   a quick way to mitigate a lot of spam is to block traffic to the site from outside of the United States. Discuss this with the Project Manager before doing so.

## Custom Web Rules

Custom Web Rules configured in a site's WPE panel is where we put in place additional security measures

-   The WPE panel allows you to copy Web Rules & apply them to other site environments
-   On all sites, we have an Access Rule set up that blocks Amazonbot
    -   this is because we ran into a scenario where Amazonbot was effectively DDOS-ing any of our sites with a Calendar feature
    -   this overloaded one of our servers on WPE and took down almost 100 websites.
    -   **copy & apply this Access Rule to all sites moving forward**

### A lot of the following information comes from the use of [this very helpful tool](https://securityheaders.com/).

There are 4 Header Rules that we have that can be copied to every site:

-   [Referrer Policy](https://scotthelme.co.uk/a-new-security-header-referrer-policy/)
-   [Strict-Transport-Security](https://scotthelme.co.uk/hsts-the-missing-link-in-tls/)
-   [X-Content-Type-Options](https://scotthelme.co.uk/hardening-your-http-response-headers/#x-content-type-options)
-   [X-Frame-Options](https://scotthelme.co.uk/hardening-your-http-response-headers/#x-frame-options)

There are 2 more Header Rules that we ideally would have set up on every site, but there's an inherent conflict in them that I'll explain:

-   [Content-Security-Policy](https://scotthelme.co.uk/content-security-policy-an-introduction/)
    -   This is effectively a 'whitelist' of all the 3rd party domains that our website will load content / resources from.
        -   e.g. Web Fonts, APIs, JavaScript libraries loaded over CDN (like jQuery), etc.
    -   Because Content Security Policies are domain-specific, we can't simply copy this Header Rule from one site to the other
    -   Our websites differ from site to site in how much 3rd party content / resources they use. This is another reason that a Content Security Policy has to be made on a per-site basis
    -   The client may intend to add more 3rd party content to their site, which would require us to adjust the Content Security Policy for each instance
    -   If a client's site is relatively simple in functionality & scope, it would be worth including a Content Security Policy for them
    -   If security is top-of-mind for the Client, then we certainly should spend the extra time developing a Content Security Policy for them
-   [Permissions-Policy](https://scotthelme.co.uk/goodbye-feature-policy-and-hello-permissions-policy/)
    -   This header rule dictates which of the browser's features the site will allow
        -   e.g. camera, vibrate, geolocation, etc.
    -   Here we have similar concerns as the Content Security Policy implementation, & this is why this should be dealt with on a per-site basis

At the time of my writing this, we haven't yet set up any Rewrite Rules for a site.
