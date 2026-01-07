---
id: qua0dpc3i7v1vtge3ds8q9c
title: Contact Forms
desc: ''
updated: 1747425604151
created: 1736727759094
---

### On the topic of Contact Forms, here are some things to always consider:

-   Are the contact forms going to the correct recipient(s)?
-   How is the UX of each form?
    -   Does it work well _**and**_ look good on all screen sizes?
    -   When a validation error occurs, is the messaging clear?
-   Are there any measure in place to mitigate spam?
    -   by default our [Akismet](https://akismet.com/account/) key is set up in the M&R Theme
        -   Akismet integration is enabled in the general Gravity Forms settings
    -   activate the Google reCAPTCHA Gravity Forms add-on
        -   set up API keys for the client's domain(s) in [Google's reCAPTCHA Admin](https://www.google.com/recaptcha/admin/create)
            -   use reCAPTCHA v3
            -   ensure that _**all domains**_ associated with the website are also associated with the API key(s)
        -   plug the keys into the Gravity Forms add-on's settings
        -   it's best-practice to exempt a page from cache if it's using any type of reCAPTCHA
            -   there can be exceptions to this, e.g. a form with reCAPTCHA is used in a site's header/footer & is therefore on every page on the site
    -   enable the 'Anti-spam honeypot' in the individual settings of each form
-   Are the forms configured correctly to use our [Postmark](https://account.postmarkapp.com/servers) account?
    -   If a dedicated mail server isn't yet created for the Client, create one
    -   plug the API Key it creates into the settings of the WordPress SMTP plugin that we are using on the site
        -   use the same key for Username & Password
        -   SMTP Host: **smtp.postmarkapp.com**
        -   Encryption: **TLS**
        -   Port: **2525**
-   Is the '**From**' name set up to be the client's name?
-   Is the **Subject** line relevant to the form?
-   Are we using a [verified sender](https://postmarkapp.com/developer/user-guide/managing-your-account/managing-sender-signatures) email address that's specific to the client?
    -   i.e. the form is sent by something like **noreply@clientdomain.com**
    -   this requires we verify the domain with Postmark, & that requires DNS adjustments
-   ensure that Gravity Form's Ajax setting is activated on each contact form
    -   i.e. **ajax="true"** is set in the shortcode for each form
    -   _our method of tracking Form Submissions in Google Analytics doesn't work without this_
-   Have you tested the forms thoroughly?
    -   add yourself as a BCC or CC recipient the form(s)
    -   purposefully fill out an unnsuccessful form to trigger the validation error & test the messaging
    -   fill out a successful contact form & follow up with the recipient(s) to make sure it was received
    -   for forms that feed user info into an eNewsletter service like MailChimp or Constant Contact, log into the account and make sure the integration is working as expected
    -   is the contact form fully functional when navigated with only a keyboard?
        -   use our [[go-live-phase.accessibility-guidelines]] to evaluate each form
