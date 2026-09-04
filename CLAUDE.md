# CLAUDE.md — Mid-South CU (M&R Master Theme) Quick Reference

This is a **Mid-South Financial Credit Union** site built on M&R Marketing's custom
WordPress theme (`mrmastertheme`). Pages are built with ACF Pro flexible-content modules.
This install has **diverged significantly** from the base M&R Master Theme — the module set,
custom post types, and plugin stack are all site-specific. Full architecture documentation is
in `AGENTS.md`.

**Theme path:** `wp-content/themes/mrmastertheme/` (no child theme — client styles live in the theme's SCSS)
**Module router:** `views/global/modules/modules.php`
**ACF schema reference (all layouts):** `views/global/modules/module-acf.json`
**Active `modules` field, per page type:**

| Page type | Field group JSON | `modules` field key |
|---|---|---|
| Homepage | `acf-json/group_696e888cc4aa6.json` | `field_678fc6d8cbe1e` |
| Standard pages / category | `acf-json/group_6973d68b9deae.json` | `field_6973d68ba6a50` |
| Location (`mandr_location`) | `acf-json/group_6976a60e7cf52.json` | `field_6976a60e8414b` |
| Post | `acf-json/group_69bab10a2d18e.json` | `field_69bab10a34683` |

---

## How this site differs from the base Master Theme

- **No `wordpress-mcp` plugin and no `.mcp.json`.** MCP is **not** available here. There is no
  `run_api_function` tool. Edit ACF content in **wp-admin**, or with **WP-CLI** (`wp acf`, or
  `update_field()` via `wp eval`) against the Local site. The base CLAUDE.md's "MCP Setup"
  workflow does not apply — ignore it.
- **Different module set** — 16 flexible-content layouts (below), not the base theme's ~17.
  The base modules (faqs, blog_post_list, gallery_list, locations_map_cards,
  locations_search_form, media_gallery, project_list, team_members, testimonials, video_cards,
  video_full_width) **do not exist** as page-builder layouts here.
- **`background_stop`** (not `background_end`) is the closing marker, and the shared background
  is a **raw open/close `<span class="background-start">` pair** (see below) — not a
  `.shared-background` wrapper with tracking logic in `modules.php`.
- **Large plugin stack:** WooCommerce, The Events Calendar, Gravity Forms (+ reCAPTCHA,
  Mailchimp, WCAG add-ons), ACF Pro + ACF Extended, Imagify, Wordfence, WP Cerber, Safe SVG,
  SVG Support, WP All Import/Export Pro, The SEO Framework, Schema Pro, Query Monitor (dev), etc.
- **Financial-site features:** BaconPay loan-pay embed, Practical Money Skills calculator
  shortcodes (`auto_calculator_interest`, `personal_calculator`), an auto-loan-calculator
  widget, an emergency-message bar, an external-link-popup, and a Vue app for the locations map.
- **Custom post types (theme-registered):** `mandr_faq`, `mandr_gallery`, `mandr_location`,
  `mandr_project`, `mandr_resource`, `mandr_service`, `mandr_team_member`, `mandr_popup`,
  `mandr_testimonial` — plus `product` (WooCommerce) and `tribe_events` (Events Calendar).

---

## Claude Code Permissions

`.claude/settings.local.json` (gitignored) grants autonomy for this local dev environment
(Bash, Read, Edit, Write, `Skill(update-config)`). There is **no MCP tool** on this site, so no
`mcp__wordpress-mcp__*` permission is relevant.

**Hard rules that apply regardless of permissions:**
- Never run `git push` unless explicitly asked in that message.
- Only `style.scss` is a Sass entrypoint; everything else is a partial. **PHP changes deploy
  as-is (no build). SCSS/asset changes require a Gulp recompile of `style.css`** before they
  take effect — say so explicitly when you touch SCSS.
- Never modify the structural SCSS systems (`library/vendor/scss/`), the data-attribute span
  pattern in module templates, or plugin internals.

---

## All Available Modules (16 layouts)

Source of truth: `views/global/modules/modules.php` + `views/global/modules/module-acf.json`.

| `acf_fc_layout` value | Label | Template dir |
|---|---|---|
| `standard_content` | Standard Content | `standard-content/` |
| `callout` | Callout | `callout/` |
| `background_start` | Background Start | `background-start/` |
| `background_stop` | Background Stop | `background-stop/` |
| `toggles` | Toggles | `toggles/` |
| `cards` | Cards | `cards/` |
| `cards_links` | Cards Links | `cards-links/` |
| `cards_images_hover_effect` | Cards Images w/ Hover Effect | `cards-images-hover/` |
| `slider_curved_top` | Slider: Curved Top | `curved-top-slider/` |
| `slider_blog` | Slider: Blog | `blog-slider/` |
| `full_width_card_icons` | Full Width: Card Icons | `full-width-card-icons/` |
| `full_width_two_columns` | Full-Width: 2 Columns | `full-width-two-columns/` |
| `history_timeline` | History Timeline | `history-timeline/` |
| `locations` | Locations | `locations/` |
| `rates_list` | Rates List | `rates-list/` |
| `table` | Table | `table/` |

> **Note:** `modules.php` also has a branch for `stats_list` (template `stats-list/`), but
> `stats_list` is **not** an available layout in the ACF flexible-content field — it's a
> dead/legacy branch. Do not offer it when authoring page content. Template dirs `slider/`,
> `cards-masonry/`, `content-video/`, `team-members/`, `testimonials/` also exist but are used
> by title-areas / CPT archives, not the page-builder router.

---

## Editing ACF Module Content (no MCP)

1. **Always read the page's current `modules` value before writing.** ACF flexible content is
   stored as a single field — writing replaces the entire array. Read → append/edit → write the
   full array back.
2. **Use `acf_fc_layout` on every module object** — this is how ACF identifies the layout type.
3. **Do not populate conditional fields that don't apply** — e.g. don't send
   `column_content_halves_left` when `column_count` is `"one"`.
4. **Image fields in ACF groups/repeaters expect WordPress media attachment IDs** (integers).
   WYSIWYG fields accept raw `<img src="URL">` HTML.
5. **Do not use `<h1>` in module content** — reserved for the page title area.
6. **WYSIWYG fields accept HTML** — `<h2>`–`<h6>`, `<p>`, `<ul>`, `<ol>`,
   `<a href="" class="button">`, `<img>`.

Practical edit paths on this Local site: wp-admin page editor, or WP-CLI, e.g.
`wp eval 'update_field("field_6973d68ba6a50", $modules_array, $post_id);'` (prefer the field
**key** for flexible content). After any programmatic write, re-read to confirm the row count
and representative layouts persisted.

---

## Shared Field Reference

These fields appear on nearly every module. Defaults shown.

### `padding` (or `module_padding`)
```json
{
  "top_padding_desktop":    "double",
  "bottom_padding_desktop": "double",
  "top_padding_mobile":     "single",
  "bottom_padding_mobile":  "single"
}
```
Valid values: `"double"` (64px) | `"single"` (32px) | `"none"`

### `background` (or `module_background`)
```json
{
  "background_type":           "transparent",
  "background_color":          "",
  "background_image":          null,
  "background_image_position": "center",
  "include_overlay":           false,
  "overlay_color":             ""
}
```
`background_type` values: `"transparent"` | `"color"` | `"image"`
`background_image_position`: `"center"` | `"top"` | `"bottom"` | `"left"` | `"right"`

### `text_color`
```json
{ "headings_color": "", "body_text_color": "", "link_color": "", "link_hover_color": "" }
```
Leave empty to inherit theme defaults. Values are hex strings.

### `unique_identifiers`
```json
{ "id": "", "class_names": "" }
```

### `tag_type`
`"section"` (default) | `"aside"` | `"div"`

### `container_width`
`"slim"` (1000px) | `"standard"` (1200px) | `"wide"` (1350px) | `"widest"` (100%)

---

## Module Field Schemas

Verified against `module-acf.json`. Select `choices` are injected at runtime via PHP; the option
lists below follow theme convention — confirm against the rendered ACF field if a value is rejected.

### `standard_content`
```json
{
  "acf_fc_layout": "standard_content",
  "rows": [
    {
      "container_width": "standard",
      "include_lr_padding": false,
      "column_count": "one",
      "column_content_single": "<p>HTML — used when column_count is one</p>",
      "column_widths": {
        "dual_column_width_selection": "variable",
        "left_column_width":  "one-half",
        "right_column_width": "one-half"
      },
      "column_content_halves_left":  "<p>Used when column_count is two</p>",
      "column_content_halves_right": "<p>Used when column_count is two</p>",
      "reverse_order_mobile": false,
      "column_content_thirds_left":   "<p>Used when column_count is three</p>",
      "column_content_thirds_center": "<p>Used when column_count is three</p>",
      "column_content_thirds_right":  "<p>Used when column_count is three</p>",
      "column_content_fourths_one":   "<p>Used when column_count is four</p>",
      "column_content_fourths_two":   "<p>Used when column_count is four</p>",
      "column_content_fourths_three": "<p>Used when column_count is four</p>",
      "column_content_fourths_four":  "<p>Used when column_count is four</p>"
    }
  ],
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... },
  "text_color": { ... }
}
```
`column_count`: `"one"` | `"two"` | `"three"` | `"four"`
`dual_column_width_selection`: `false` (equal halves) | `"variable"` (use left/right widths)
Width options: `"one-half"` | `"one-third"` | `"two-thirds"` | `"one-quarter"` | `"three-quarters"` | `"two-fifths"` | `"three-fifths"`
`include_lr_padding`: only meaningful when `container_width` is `"widest"`

---

### `callout`
```json
{
  "acf_fc_layout": "callout",
  "content": "<h2>Heading</h2><p>Body copy.</p>",
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "module_background": { "background_type": "transparent", ... },
  "module_padding": { "top_padding_desktop": "double", ... },
  "container_width": "slim",
  "container_background": { "background_type": "transparent", "background_color": "", "background_image": null, "background_image_position": "center" },
  "container_padding": { "top_padding_desktop": "double", ... },
  "text_color": { ... }
}
```
Uses `module_background`/`module_padding` for the outer section plus a second layer
`container_background`/`container_padding` for the inner content box.

---

### `background_start` / `background_stop`
```json
{ "acf_fc_layout": "background_start",
  "unique_identifiers": { "id": "", "class_names": "" },
  "module_background": { "background_type": "color", "background_color": "#123456", "background_image": null, "background_image_position": "center", "include_overlay": false, "overlay_color": "" }
}
{ "acf_fc_layout": "background_stop" }
```
`background_start` prints an **opening `<span class="background-start" style="…">`** with the
background applied inline (color or image + optional overlay). `background_stop` prints the
matching **closing `</span>`**. Everything between the two renders inside that background span.
`background_stop` has **no fields**.

---

### `toggles`
```json
{
  "acf_fc_layout": "toggles",
  "add_toggle_sections": false,
  "intro_content": "",
  "toggles": [ { "title": "Question / heading", "content": "<p>Answer HTML</p>" } ],
  "toggles_sections": [
    { "title": "Section title", "intro_content": "", "toggles": [ { "title": "", "content": "" } ] }
  ],
  "tag_type": "section",
  "container_width": "standard",
  "column_count": "one",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "text_color": { ... },
  "background": { ... }
}
```
`add_toggle_sections`: `false` = flat `toggles` list; `true` = grouped `toggles_sections`
(each with its own nested `toggles`).

---

### `cards` / `cards_links` / `cards_images_hover_effect`
```json
{
  "acf_fc_layout": "cards",
  "intro_content": "",
  "cards": [ { "content": "<h3>Card</h3><p>Body.</p>" } ],
  "tag_type": "section",
  "container_width": "standard",
  "column_count": "three",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "text_color": { ... },
  "background": { ... }
}
```
Card repeater differs by layout:
- `cards` → `{ "content": "<wysiwyg>" }`
- `cards_links` → `{ "content": "<wysiwyg>", "link": "https://…" }`
- `cards_images_hover_effect` → `{ "content": "plain text", "link": "https://…", "image": 1234 }` (`image` = attachment ID)

---

### `full_width_card_icons`
```json
{
  "acf_fc_layout": "full_width_card_icons",
  "intro_content": "",
  "cards": [
    { "content": "<h3>Icon Card</h3><p>Body.</p>", "add_link_to_card": true, "link": "https://…", "link_text": "Learn more" }
  ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "text_color": { ... },
  "background": { ... }
}
```

---

### `slider_curved_top`
```json
{
  "acf_fc_layout": "slider_curved_top",
  "slides": [ { "title": "", "link": 1234, "header": "Slide headline", "subtext": "Supporting copy" } ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... }
}
```
`slides[].link` is an **image** field (attachment ID), not a URL.

---

### `slider_blog`
```json
{
  "acf_fc_layout": "slider_blog",
  "intro_content": "",
  "articles": [ 101, 102, 103 ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... }
}
```
`articles`: `post_object` — array of post IDs (empty = automatic/latest, depending on template).

---

### `full_width_two_columns`
```json
{
  "acf_fc_layout": "full_width_two_columns",
  "left_column": {
    "width": 50,
    "content_type": "background-image",
    "column_background_image": 1171,
    "column_content": "",
    "offset_content": false,
    "content_background": { "background_type": false, "background_image": null, "background_image_overlay": "rgba(0,0,0,.7)", "background_color": "" }
  },
  "right_column": {
    "width": 50,
    "content_type": "content",
    "column_background_image": null,
    "column_content": "<h2>Heading</h2><p>Copy.</p>",
    "offset_content": false,
    "content_background": { "background_type": false, "background_image": null, "background_image_overlay": "rgba(0,0,0,.7)", "background_color": "#f5f5f5" }
  },
  "tag_type": "section",
  "unique_identifiers": { "id": "", "class_names": "" },
  "reverse_order_mobile": false,
  "column_content_padding": { "padding_desktop": "double", "padding_mobile": "single" },
  "text_color": { ... }
}
```
`content_type`: `"content"` | `"background-image"`
`content_background.background_type` is a **boolean**: `false` = color mode, `true` = image mode.
`width`: integer, left + right should sum to 100.

---

### `history_timeline`
```json
{
  "acf_fc_layout": "history_timeline",
  "eras": [
    {
      "era_title": "1970s",
      "dates": [
        { "date_title": "1971", "add_an_image": false, "layout": false, "image_left": null, "content": "<h2>Event</h2><p>Description.</p>", "image_right": null }
      ]
    }
  ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... },
  "background": { ... }
}
```
`dates[].layout`: `false` (no image) | `"image-left"` | `"image-right"`
`dates[].image_left` / `image_right`: attachment ID (integer)

---

### `locations`
```json
{
  "acf_fc_layout": "locations",
  "intro_content": "",
  "locations": [ 1117, 1136 ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... }
}
```
`locations`: `post_object` — array of `mandr_location` post IDs.

---

### `rates_list`
```json
{
  "acf_fc_layout": "rates_list",
  "intro_content": "",
  "rates": [
    { "pretext": "As low as", "rate_#": 4.99, "rate_type": "APR", "link_text": "Apply", "link": "/apply/" }
  ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... }
}
```
The rate number sub-field name is literally `rate_#`.

---

### `table`
```json
{
  "acf_fc_layout": "table",
  "table_header": "Optional caption",
  "columns": [
    { "column_header": "Term", "rows": [ { "cell": "12 mo" }, { "cell": "24 mo" } ] },
    { "column_header": "APY",  "rows": [ { "cell": "4.50%" }, { "cell": "4.75%" } ] }
  ],
  "tag_type": "section",
  "container_width": "standard",
  "unique_identifiers": { "id": "", "class_names": "" },
  "padding": { ... }
}
```
Column-major: each `columns` entry is a column with its own `rows` repeater of `cell` values.

---

## Data Flow Summary

```
WordPress DB (ACF fields)
    ↓  wp-admin editor / WP-CLI (no MCP on this site)
modules.php  ←  loops have_rows('modules')
    ↓  get_row_layout() matches acf_fc_layout value
[module-name].php  ←  reads fields via get_sub_field()
    ↓  outputs semantic HTML + hidden <span> settings tags
CSS :has() selectors  ←  read data-attributes on spans
    ↓  apply padding, backgrounds, column widths, colors
Rendered page
```

PHP templates: `views/global/modules/[module-name]/[module-name].php`
The data-attribute span pattern must never be modified — CSS depends on it.

---

*Full architecture, CSS system, SCSS variables, coding conventions, and the performance-remediation
status: see `AGENTS.md`.*
