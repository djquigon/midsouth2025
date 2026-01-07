---
id: ij6xcve3qxstjfhrowhjr9t
title: Accessibility Checklist
desc: ''
updated: 1736533006703
created: 1736525257196
---

Use the following list of prompts to evaluate the accessibility of the site you're working on. These questions are pulled directly from the [Web Content Accessibility Guidelines (WCAG)](https://www.w3.org/WAI/standards-guidelines/wcag/).

## [Rule 1.1.1](https://www.w3.org/WAI/WCAG21/quickref/#non-text-content) – Text Alternatives for ‘non-text’ Content

-   Does all non-text content that is presented to the user have a text alternative that serves the equivalent purpose?
    -   Does all pre-recorded video and/or audio in use on the site feature text captions, a text transcript, or at least a corresponding text description for the video?
    -   Is an image used for more than merely decorative purposes or does the image convey information?
        -   If the image is used to convey information, does it have alt text, a caption, or a corresponding block of text that at least describes the image?
-   Does every element that collect user input have a thorough description of its purpose?
    -   e.g. `<label>` element, aria-label attributes for all form inputs and navs
-   Are any purely decorative elements/images/icons implemented in a way that can be ignored by assistive technology?
    -   instead of using an `<img>` or `<picture>` tag, are decorative images being loaded via CSS?
-   Rules [1.2.1](https://www.w3.org/WAI/WCAG21/quickref/#audio-only-and-video-only-prerecorded), [1.2.2](https://www.w3.org/WAI/WCAG21/quickref/#captions-prerecorded), [1.2.3](https://www.w3.org/WAI/WCAG21/quickref/#audio-description-or-media-alternative-prerecorded), [1.2.4](https://www.w3.org/WAI/WCAG21/quickref/#captions-live), [1.2.5](https://www.w3.org/WAI/WCAG21/quickref/#audio-description-prerecorded) are all follow-ups on this

---

## [Rule 1.3.1](https://www.w3.org/WAI/WCAG21/quickref/#info-and-relationships) - Info & Relationships

-   Are we using aria & roles effectively through the site?
    -   `<header>`, `<nav>`, `<section>`, & `<form>` roles are built in and redundant if added
    -   if it is a form and is a search form, does it use a role=”search” attribute?
    -   Consider using **aria-describedby** if we’re consistently using an image or video that features a corresponding block of text that describes it
        -   Example: We’re building a page for a client that features an image/video gallery. Each item in the gallery features a corresponding block of text that we can apply an **ID** to. We plug in **aria-describedby="ID"** on the image/video

---

## [Rule 1.3.2](https://www.w3.org/WAI/WCAG21/quickref/#meaningful-sequence) – Meaningful Sequence

-   When the sequence in which content is presented affects its meaning, can a correct reading sequence can be programmatically determined?
    -   Is the content positioned structurally in the HTML to read correctly from top to bottom?
        -   despite the design’s layout of columns & tables, content should be in the correct order from top of a page to bottom.
    -   Is the tab-index correct?
        -   use the tab key to navigate through each page of a site and make any necessary adjustments

---

## Rules [1.3.3](https://www.w3.org/WAI/WCAG21/quickref/#sensory-characteristics) & [1.4.1](https://www.w3.org/WAI/WCAG21/quickref/#use-of-color) – Sensory Characteristics

-   Is any information on the site being conveyed by visual or auditory means only?
    -   i.e. only via color, shape, size, visual location, or sound?

---

## [Rule 1.4.2](https://www.w3.org/WAI/WCAG21/quickref/#audio-control) – Autoplay

-   If a page features audio that autoplays, or a video that with it’s audio plays automatically, is a mechanism available to pause or stop the audio?
    -   can this mechanism be accessed by the keyboard?

---

## [Rule 1.4.3](https://www.w3.org/WAI/WCAG21/quickref/#contrast-minimum) – Contrast

-   The visual presentation of text and images of text has a contrast ratio of at least 4.5:1, except for the following:
    -   Large Text: Large-scale text and images of large-scale text have a contrast ratio of at least 3:1;
    -   Incidental: Text or images of text that are part of an inactive user interface component, that are pure decoration, that are not visible to anyone, or that are part of a picture that contains significant other visual content, have no contrast requirement.
    -   Logotypes: Text that is part of a logo or brand name has no contrast requirement.
-   [If necessary, use this contrast checker tool](https://webaim.org/resources/contrastchecker/)
-   The design department will handle this for you, but it’s worth double-checking in our site reviews
-   When you’re using a background-image via CSS, also set a background-color, even though it’s never seen.
    -   The [WAVE validator tool](https://wave.webaim.org/) will pick up the background-color as opposed to what’s actually visible on the page

---

## [Rule 1.4.4](https://www.w3.org/WAI/WCAG21/quickref/#resize-text) – Resize Text

-   Except for captions and images of text, can text be resized without assistive technology up to 200 percent without loss of content or functionality?
-   While testing the responsive design of a page, also zoom up to 200 percent and make adjustments if any components break

---

## [Rule 1.4.5](https://www.w3.org/WAI/WCAG21/quickref/#images-of-text) – Images of Text

-   Are any images being used in which the majority of the image’s composition is text?
-   logos don’t count, they’re fair game
-   there are unavoidable situations in which text is some small portion of an image’s composition. This is fine. The thing to avoid is where the image primarily conveys information via text

---

## Rules [2.1.1](https://www.w3.org/WAI/WCAG21/quickref/#keyboard) & [2.1.2](https://www.w3.org/WAI/WCAG21/quickref/#no-keyboard-trap) – Keyboard Accessible

-   Can all content & functionality can be accessed and navigated using only the keyboard via tab key, arrow keys, & esc key?
-   If an area of content can’t be entered/exited otherwise, is the user instructed on how?
-   Can any ‘lightbox’ or ‘modal window’ be exited via the esc key and maintain the proper tab-index?

---

## Rules [2.2](https://www.w3.org/WAI/WCAG21/quickref/#timing-adjustable) & [2.3](https://www.w3.org/WAI/WCAG21/quickref/#three-flashes-or-below-threshold) – Time Limited Content & Seizure-inducing Flashing

-   Do all areas of content that update automatically (sliders, etc.) have controls?
    -   arrows & dots
    -   a play / pause button
-   Does any of the visual content flash more than 3 times in a second?

---

## [Rules 2.4.X](https://www.w3.org/WAI/WCAG21/quickref/#bypass-blocks) – Navigability

-   Can the purpose of each link can be determined from the link text alone?
    -   For example, does the link say ‘learn more’ or ‘learn more about our services’
-   Can repeated content can be bypassed with a ‘skip to main’ button like we have on the header?
    -   For SEO purposes we want to avoid repeated content in general, or at least limit it to something like an ‘intro paragraph’
-   Are web page Titles, Headings, & Labels descriptive of their Topic & purpose?
-   Is focus order correct for elements that can receive focus?
    -   This is same as tab-index mentioned before
-   Is more than one way available to locate a web page within a set of web pages?
    -   This type of internal linking is handled by the Copy dept.
        -   if you see anywhere in the content where it would make sense to link to another page, get the copywriter’s feedback before adding a link
    -   This excludes ‘thank you’ pages or pages that are the result of, or a step in, a process

---

## Rules [3.1.1](https://www.w3.org/WAI/WCAG21/quickref/#language-of-page) & [3.1.2](https://www.w3.org/WAI/WCAG21/quickref/#language-of-parts) – Language

-   we already programmatically determine the default human language of our web pages in the HTML tag

---

## [Rules 3.2.X](https://www.w3.org/WAI/WCAG21/quickref/#on-focus) – Predictability

-   Hover & focus of an element can and should change it’s appearance, but not it’s context or functionality
-   Is the user given advanced warning before a link opens a new tab or window?
    -   this is kind of ‘buried’ in the WCAG guidelines, but was something that was specifically mentioned in the [Stuckey’s lawsuit](https://mrmarketinggroup.teamwork.com/app/messages/1210413)
    -   we implemented in the starter theme a script that applies an aria-label for any external link
-   We want to avoid changes of context from user interfaces. A change of content is not always a change of context
    -   example: a search feature where the results change on-page. This is fine.
-   Navigations remain consistent across all pages, unless a change is initiated by the user
    -   example: a user logs into a portal and is now presented with new navigation options. this is fine
-   Are we using labels, names, and text alternatives consistently for content that has the same functionality?
    -   e.g. contact form fields and their inputs’ labels
    -   e.g. ‘add to cart’ buttons

---

## [Rules 3.3.X](https://www.w3.org/WAI/WCAG21/quickref/#error-identification) (Input Assistance)

Plugins like WooCommerce & GravityForms do most if not all of this for us:

-   If an input error is automatically detected, the item that is in error is identified and the error is described to the user in text.
-   Are labels or instructions provided when content requires user input?
-   If an input error is automatically detected and suggestions for correction are known, then the suggestions are provided to the user, unless it would jeopardize the security or purpose of the content
-   For web pages that cause legal commitments or financial transactions for the user to occur, that modify or delete user-controllable data in data storage systems, or that submit user test responses, at least one of the following is true:
    -   Reversible: Submissions are reversible.
    -   Checked: Data entered by the user is checked for input errors and the user is provided an opportunity to correct them.
    -   Confirmed: A mechanism is available for reviewing, confirming, and correcting information before finalizing the submission.

---

## [Rule 4.1.1](https://www.w3.org/WAI/WCAG21/quickref/#parsing) – Parsing

-   [Is your HTML fully valid?](https://validator.w3.org/)
    -   free of _**errors**_ from the validator
    -   warnings tend to be ok depending on the situation
-   Is your HTML semantically accurate?
    -   are you using `<div>` or `<span>` when another element is appropriate?
    -   e.g. instead a series of nested `<div>`(s), could `<ul>` be used?
    -   e.g. a `<div>` containing an excerpt could use `<blockquote>` with the **cite=""** attribute pointing to the full article
-   **a note on HTML semantics:**

    > To determine whether something is semantically correct and useful in HTML, ask yourself a few questions. Are you using each element for its intended purpose? For instance, it’s not semantically correct if you use an `<a>` element for a button, as `<a>` is for hyperlinks, `<button>` is for buttons. Do you need each element you are using in order to convey all of the semantic information about your content (sections, headings, links, etc)? Is there anything meaningful that you intend to convey that isn’t expressed by use of appropriate elements? Having lots of extra meaningless elements usually isn’t harmful, but it adds clutter, and it may mean that there are semantic distinctions you are conveying visually but not encoding in a way that a screen reader or automated bot or browser that presented the information in a different format could make sense of.

    _[source](https://stackoverflow.com/questions/4331975/is-it-semantically-correct-to-nest-an-article-element-within-a-li-element)_

---

## [Rule 4.1.2](https://www.w3.org/WAI/WCAG21/quickref/#name-role-value) – Name, Role, Value

For all user interface components (including but not limited to: form elements, links and components generated by scripts), the name and role can be programmatically determined; states, properties, and values that can be set by the user can be programmatically set; and notification of changes to these items is available to user agents, including assistive technologies.

-   this is basically an extension of rule 1.3.1 but specifically for user input fields.
    -   buttons, links, form inputs, navs, etc.

---

## Extra things:

-   don’t use the default Gravity Forms date-picker field
    -   text fields are fine or a custom-built calendar date picker option
-   don’t use the built in ‘name’ field for gravity forms
    -   it generates an extra closing tag and throws an error in the validator
    -   instead use 2 separate text fields
-   we need to find a fix for the **[spacer]** short-code
-   CAPTCHA
    -   we want to always opt for invisible CAPTCHA V3
    -   the V2 where the user is prompted to click images is not good for anybody
