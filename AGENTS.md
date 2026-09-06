# AGENTS.md — Mid-South CU (M&R Master Theme) AI Agent Instructions

## Overview

This repository is a **Mid-South Financial Credit Union** WordPress site built on M&R Marketing's
custom `mrmastertheme`, using ACF Pro flexible-content layouts. The install has **diverged
significantly** from the base M&R Master Theme — different modules, custom post types, plugin
stack, and front-end features. `CLAUDE.md` is the actionable quick-reference (module inventory,
field keys, per-module schemas); this file covers architecture, conventions, and how this site
differs from the base.

> **Calibrated against the live code on 2026-09-04** (performance-remediation §1). Where this
> file and the base Master-Theme docs disagree, the code is the source of truth:
> `views/global/modules/modules.php` (module router) and `views/global/modules/module-acf.json`
> (layout schemas).

---

## How this site differs from the base Master Theme

- **No MCP.** No `wordpress-mcp` plugin, no `.mcp.json`. There is no `run_api_function` tool.
  ACF content is edited in wp-admin or via WP-CLI. Ignore any "MCP setup" instructions from the
  base docs.
- **No child theme.** `mrmastertheme` is the only theme; client-specific styling lives in the
  theme's own SCSS (`library/custom-theme/scss/branding/`) plus an optional M&R branding stylesheet
  toggled by an ACF option (`enable_mandr_theme_styling`).
- **16 flexible-content module layouts** (see `CLAUDE.md`), not the base theme's set. The base
  modules (faqs, blog_post_list, gallery_list, locations_map_cards, locations_search_form,
  media_gallery, project_list, team_members, testimonials, video_cards, video_full_width) are
  **not** page-builder layouts here.
- **`background_start` / `background_stop`** replace the base `background_start`/`background_end`
  shared-wrapper system — see "Background Span Pair" below.
- **Large plugin & feature stack** — WooCommerce, The Events Calendar, Gravity Forms suite,
  financial widgets (BaconPay, Practical Money Skills calculators, auto-loan calculator), a Vue
  locations map. See "Plugin Stack" below.

---

## Theme Architecture

### Stack
- WordPress + ACF Pro (Flexible Content layouts) + ACF Extended
- PHP templates (one per module)
- SCSS compiled via **Gulp** (autoprefixer, pxtorem, minification) — only `style.scss` compiles
- jQuery (3.7.1 via Google CDN), Slick slider, Magnific Popup
- WooCommerce, The Events Calendar, Gravity Forms
- Site-specific front-end: BaconPay loan-pay embed, Practical Money Skills calculator shortcodes
  (`auto_calculator_interest`, `personal_calculator`), auto-loan-calculator widget,
  emergency-message bar, external-link popup, Vue app for the locations map

### Build model (important)
- **PHP changes deploy as-is — no build step.**
- **SCSS / asset changes require a Gulp recompile of `style.css`** before they take effect. If you
  edit SCSS, say so explicitly and tell the human to run the theme's `gulp` build before deploying.
- Sass entry: `style.scss` only. Everything with a leading `_` is a partial. Gulp globs
  `library/custom-theme/scss/**`, `library/vendor/scss/**`, and `views/**/*.scss` (the
  locations-page Vue module SCSS is excluded from the main pipeline).

### Directory Structure (actual)
```
wp-content/themes/mrmastertheme/
├── style.scss / style.css                       # Sass entry + compiled output
├── gulpfile.js / package.json                    # Build pipeline
├── header.php / footer.php
├── header.min.js / footer.min.js                 # Compiled JS bundles (enqueued header/footer)
├── functions.php
├── acf-json/                                      # ACF field-group JSON (per page type)
│   ├── group_696e888cc4aa6.json                   # Homepage Fields  (modules key field_678fc6d8cbe1e)
│   ├── group_6973d68b9deae.json                   # Standard Fields  (modules key field_6973d68ba6a50)
│   ├── group_6976a60e7cf52.json                   # Location Fields  (modules key field_6976a60e8414b)
│   ├── group_69bab10a2d18e.json                   # Post Fields      (modules key field_69bab10a34683)
│   └── … (Options, Newsletter, Post Archive/Author groups)
├── library/
│   ├── custom-theme/
│   │   ├── php/
│   │   │   ├── enqueues.php                        # scripts / styles / fonts
│   │   │   └── custom-post-types.php               # registers the mandr_* CPTs
│   │   ├── scss/
│   │   │   ├── branding/   (_headings, _body-text, _buttons, _forms, …)
│   │   │   ├── variables/  (_breakpoints, _colors, _spacing, _widths, _durations, _exports)
│   │   │   └── defaults/
│   │   └── images/                                 # theme-baked images (see Perf note)
│   ├── mandr/                                      # optional M&R branding stylesheet (ACF-toggled)
│   └── vendor/scss/                                # structural column/container/padding/flex systems
└── views/
    ├── global/
    │   ├── modules/
    │   │   ├── modules.php                          # module router (source of truth)
    │   │   ├── module-acf.json                      # all-layout schema reference
    │   │   ├── standard-content/  callout/  toggles/
    │   │   ├── background-start/   background-stop/
    │   │   ├── cards/  cards-links/  cards-images-hover/
    │   │   ├── curved-top-slider/  blog-slider/
    │   │   ├── full-width-card-icons/  full-width-two-columns/
    │   │   ├── history-timeline/  locations/  rates-list/  table/
    │   │   └── (stats-list/, slider/, cards-masonry/, content-video/, team-members/,
    │   │        testimonials/  — present but NOT page-builder layouts; see note)
    │   ├── header/  footer/  title-area/  widgets/
    └── conditional/                                 # CPT archive/single templates
        └── galleries/ locations/ posts/ projects/ resources/ team/ testimonials/
```

---

## Module System

### How It Works
1. Pages use an ACF flexible-content field named `modules`. The field **key differs per page
   type** — Homepage `field_678fc6d8cbe1e`, Standard `field_6973d68ba6a50`, Location
   `field_6976a60e8414b`, Post `field_69bab10a34683`.
2. `modules.php` loops the layouts and `get_template_part()`s the matching module template.
3. PHP templates read ACF data via `get_sub_field()` and output semantic HTML.
4. CSS uses `:has()` selectors on hidden data-attribute `<span>`s to apply styles.

### Available Layouts
16 layouts — see the table and per-module schemas in `CLAUDE.md`:
`standard_content`, `callout`, `background_start`, `background_stop`, `toggles`, `cards`,
`cards_links`, `cards_images_hover_effect`, `slider_curved_top`, `slider_blog`,
`full_width_card_icons`, `full_width_two_columns`, `history_timeline`, `locations`, `rates_list`,
`table`.

> `modules.php` also branches on `stats_list` (template `stats-list/`), but `stats_list` is
> **not** an available ACF layout — treat it as a dead/legacy branch. The template dirs `slider/`,
> `cards-masonry/`, `content-video/`, `team-members/`, `testimonials/` are used by title-areas and
> CPT archives, not the page-builder router. When handing this repo off, treat the current ACF
> JSON + router as the authoritative layout list, not any older module count.

---

## Background Span Pair (`background_start` / `background_stop`)

- Purpose: let several consecutive modules render inside one shared background.
- `background-start/background-start.php` prints an **opening `<span class="background-start"
  style="…">`** with the background applied **inline** from its `module_background` group (color,
  or image + optional overlay via `--overlay-color` + `data-background-overlay="true"`). It also
  supports `unique_identifiers` (id / class_names). It does **not** close the tag.
- `background-stop/background-stop.php` prints the matching **closing `</span>`** and has **no
  fields**.
- This is a literal open/close span pair — there is **no** wrapper-tracking / auto-close logic in
  `modules.php`, and no `.shared-background` class. An unmatched `background_start` with no
  `background_stop` will leave an open span. Keep them paired.

---

## HTML Output Pattern

PHP templates output semantic HTML with hidden `<span>` elements carrying data attributes; CSS
reads them via `:has()`. **Do not remove or restructure these spans.**

### Module-Level Pattern
```html
<section class="standard-content optional-class" id="optional-id">
  <!-- content rows here -->
  <span class="module-settings" data-nosnippet>
    <span class="padding"
      data-top-padding-desktop="double"
      data-bottom-padding-desktop="double"
      data-top-padding-mobile="single"
      data-bottom-padding-mobile="single">
      <span class="validator-text" data-nosnippet>padding settings</span>
    </span>
    <span class="background" style="background-color:#1a3d5c">
      <span class="validator-text" data-nosnippet>background settings</span>
    </span>
    <span class="validator-text">module settings</span>
  </span>
</section>
```

---

## CSS Architecture

### Key Principles
- **Data-attribute driven:** layout behavior is controlled by data attributes on span elements,
  read by parent `:has()` selectors — not by adding/removing CSS classes.
- **CSS custom properties for text colors:** `--headings-color`, `--body-text-color`,
  `--link-color`, `--link-hover-color` are set inline on column elements.

### SCSS Variables (verified — `library/custom-theme/scss/variables/`)
**Spacing (`_spacing.scss`):**
- `$global_module_padding_double`: 64px, `$global_module_padding_single`: 32px
- `$global_gap_between_columns_small/medium/large`: 24 / 48 / 64px
  (`$global_gap_between_columns` = **large** = 64px)
- `$global_gap_between_rows_small/medium/large`: 24 / 48 / 64px (`$global_gap_between_rows` = small = 24px)
- `$global_margin_between_content_rows`: 48px (responsive 32px); `$global_margin_between_paragraphs`: 24px

**Container Widths (`_widths.scss`):**
- `$global_container_width_slim`: 1000px, `standard`: 1200px, `wide`: 1350px, `widest`: 100%

**Fonts:** the site renders in **Open Sans** (all `branding/*.scss` declare `'Open Sans', sans-serif`).

---

## Fonts (perf-relevant — Open Sans is loaded three ways)

1. `header.php` — Google Fonts `css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap`
   (full 300–800 range, italics).
2. `library/custom-theme/php/enqueues.php` — a **second** Google Fonts request
   `css?family=Open+Sans:400,700` (v1 API).
3. `header.php` — a **Font Zone** JS loader (`thefontzone.com/v4/w/fonts/…`, obfuscated
   `font_fam_*` function).

Open Sans is genuinely used, so it is **not** a dead font — but the triple-load is redundant and a
font-trimming target (playbook items A/B). Verify which source actually supplies the rendered glyphs
before removing any request; test headings/body/buttons after changes.

---

## Custom Post Types

Registered in `library/custom-theme/php/custom-post-types.php` (slug = `mandr_` + singular):
`mandr_faq`, `mandr_gallery`, `mandr_location`, `mandr_project`, `mandr_resource`,
`mandr_service`, `mandr_team_member`, `mandr_popup`, `mandr_testimonial`.
Plus plugin CPTs: `product` (WooCommerce), `tribe_events` (The Events Calendar), and core `post`.

Modules that reference CPTs by ID: `locations.locations` → `mandr_location`;
`slider_blog.articles` → `post`. Look up real IDs before writing.

---

## Plugin Stack (installed)

acf-extended, advanced-custom-fields-pro, acf front-end, add-to-any, akismet, alttext-ai,
autodescription (The SEO Framework), autoupdater, better-search-replace, disable-gutenberg,
disable-search, duplicate-page, duplicate-post, easy-wp-smtp, gravityforms (+ WCAG fields,
+ Mailchimp, + reCAPTCHA), imagify, plugin-groups, **query-monitor (dev — confirm inactive in
production)**, regenerate-thumbnails, safe-svg, svg-support, tables-generator-pro,
the-events-calendar, tinymce-advanced, user-role-editor, woocommerce, wordfence, wordpress-importer,
wp-all-export-pro, wp-all-import-pro, wp-cerber, wp-schema-pro.

Perf-relevant: **Imagify** optimizes the media library only (never theme-baked images).
**Gravity Forms reCAPTCHA** loads on every front-end page (scope it off non-form pages — playbook
item F; there is no WP Simple Pay / Stripe enqueue here, so the Stripe half of item F is N/A).

---

## Coding Conventions

### PHP
- Use `get_sub_field()` / `get_field()` for ACF data (never `$_POST` or `wp_postmeta` directly).
- Template parts load via `get_template_part()` with a `$args` array.
- Alternative syntax for control flow (`if/endif`, `foreach/endforeach`).

### SCSS
- Global variables are prefixed `$global_`; breakpoints use `em()`.
- Module SCSS lives in `views/global/modules/[module-name]/assets/scss/`.
- Never hardcode pixel layout values — use the variable system.
- **Never modify** `library/vendor/scss/` structural systems.

### JavaScript
- jQuery is global. Scripts split into `header.min.js` (enqueued in `<head>`) and `footer.min.js`.
- Some module templates print **bare, immediately-executing** inline `.slick()` / `.magnificPopup()`
  inits (blog-slider, slider, testimonials slider, front-page title-area slider, similar-articles).
  These run mid-parse and are the reason the header bundle **cannot** simply be `defer`red — see
  the performance note.

---

## Performance Remediation Status

Tracking the `performance-remediation-prompt.md` playbook.

- **§1 context files** — reconciled `AGENTS.md` + `CLAUDE.md` to this site. Left for human review + commit.
- **§2 baseline (production, median-of-3):** MOBILE median **35** / DESKTOP median **90**. Worst mobile:
  auto-loans 23 (TBT 1962ms), contact-us 25 (LCP 13.9s), locations 30 (LCP 22.0s), home 31 (LCP 17.0s).
  Site-wide **CLS 0.306** on mobile (0.148 desktop). Reports in the perf batch runner's output dir.
  The real mobile driver is unoptimized `/uploads` images (500–629KB location photos, a 1.7MB home hero),
  not the theme-baked images — the 12MB mask isn't loaded on the representative pages.

### Fixes applied (step 2 — PHP only, no recompile; validated HTTP 200 + no fatals on local)
  - **Item F (reCAPTCHA scoping)** — `enqueues.php`: flag `gform_enqueue_scripts`, dequeue
    `gforms_recaptcha_recaptcha` / `_frontend` / `_frontend-legacy` in `wp_footer` when no GF form rendered.
    Verified: kept on `/contact-us/` (form), removed from home + `/locations/`.
  - **Item C (Vimeo SDK scoping)** — `enqueues.php`: only enqueue `player.js` on `is_front_page()` /
    secondary homepages (the only place `new Vimeo.Player` runs). Verified removed from content pages.
  - **Item D (responsive/lazy images)** — swapped raw full-size `<img>` for `wp_get_attachment_image()` /
    `get_the_post_thumbnail()` (srcset + width/height + lazy) in: `modules/locations/locations.php`,
    `modules/content-video/content-video.php`, `modules/history-timeline/history-timeline.php`,
    `modules/blog-slider/blog-slider.php` (blog slider kept eager). `cards-images-hover` was already responsive.

### Still to do
  - **Item E (theme-baked images — asset/SCSS, NEEDS GULP RECOMPILE):** `library/custom-theme/images/`
    `team-member-mask.svg` (~12 MB → shape-only `<path fill="#fff">`), `secondary-heaader-bg.png`
    (~1.66 MB → WebP), `gradient-bg.png` (~1.64 MB → CSS `linear-gradient`); inspect `dec.svg` (~436 KB),
    `featured.jpg` (~448 KB). Lower impact on the measured pages but keep for team pages / where used.
  - **Site-wide CLS 0.306** — a global cause on every page (unsized hero image or font swap). Investigate.
  - **Items A/B (fonts):** Open Sans requested three ways — trim/dedupe with testing.
  - **Item G (render-blocking header JS — PROPOSE ONLY):** `header.min.js` in `<head>`; bare inline
    slider/popup inits prevent a naive `defer`. Human-approved refactor only.
  - Remaining item-D cases left intentionally: CSS `background-image:url()` module backgrounds (srcset can't
    help; Imagify covers compression), small card/slide icons, and the `team-members` component (ties to
    the item-E mask work).
- **Do not** `git push`. Item E and any SCSS/asset change require a Gulp recompile of `style.css`.
- **§6 re-measure** is on hold until the human's Imagify bulk-optimize finishes (it changes the `/uploads`
  image baseline), then re-run the identical Lighthouse set.

---

## What AI Agents Should NOT Do

- Do not modify `library/vendor/scss/` structural systems or SCSS variable files.
- Do not restructure the data-attribute span pattern or remove `validator-text` / `data-nosnippet`.
- Do not use `<h1>` in module content (reserved for the page title).
- Do not hardcode pixel values for padding/gaps/widths — use the variable/data-attribute system.
- Do not overwrite existing ACF `modules` without reading the current value first.
- Do not invent new module layouts — use the existing 16.
- Do not run `git push` unless explicitly asked.
- Do not deploy SCSS/asset changes without flagging that a Gulp recompile is required.
