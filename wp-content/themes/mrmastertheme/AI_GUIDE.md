# AI_GUIDE.md
### Custom WordPress Theme – Modular ACF + Structural CSS System

## 1. Core Mental Model (Read This First)

This theme is built around **modular page sections**, designed in Figma and implemented in WordPress using **ACF Flexible Content**.

Each page is composed of a vertical stack of **modules**.  
Each module may contain one or more **content rows**, which define column layouts.

**Styling is declarative**, not class-driven:
- PHP outputs **DOM annotations** (via `data-*` attributes and settings spans)
- A shared **structural SCSS library** interprets those annotations using `:has()`
- Individual modules should *not* reimplement layout logic

Think in this order:

```
Figma sections
→ ACF Flexible Content layouts
→ PHP module templates
→ DOM annotations (data-* attributes + settings spans)
→ Structural SCSS systems (layout, spacing, background)
```

## 2. Directory Responsibilities

### Shared, reusable systems
```
library/custom-theme/scss/
  variables/
  tools/
  structural/
    _column-system.scss
    _container-system.scss
    _flex-system.scss
    _grid-system.scss
    _padding-system.scss
    _background-system.scss
```

These files form the **layout engine** of the theme.

- They control columns, containers, spacing, backgrounds, and responsiveness
- They rely on DOM structure + `data-*` attributes
- They should **not** be casually modified
- Modules depend on them being stable

### Project-specific views and modules
```
views/
  global/
    modules/
    widgets/
  conditional/
    pages/
    posts/
    resources/
    projects/
```

- Modules and widgets live alongside their templates
- Module SCSS is **scoped styling only**, not layout logic
- Layout behavior comes from the structural SCSS library

## 3. Build Rules (CRITICAL)

- **Only `style.scss` is a Sass entrypoint**
- Everything else is a partial
- Module SCSS files must **never** be compiled directly

Rules:
- SCSS in `views/**/assets/scss/` is always a partial
- Module SCSS files should start with `_`
- All layout systems are imported into `style.scss`

## 4. Standard Module Contract

Every module follows the same high-level structure.

### 4.1 Module wrapper
- Wrapper tag is configurable (`section`, `div`, `aside`, etc.)
- Wrapper has a base module class (e.g. `standard-content`)
- Optional ID and extra class names come from ACF

### 4.2 Content rows
Modules may contain one or more `.content-row` elements.

Each row:
- Outputs a `.columns` container
- Outputs column elements (`.column`)
- Outputs **one** `span.row-settings` immediately after the row

### 4.3 Module settings (required)
Each module outputs **exactly one** `.module-settings` span, placed **after all rows**.

This span contains:
- `span.padding` (required)
- `span.background` (optional)
- a `.validator-text` marker

⚠️ **Do not move, rename, or remove these spans.**  
The CSS library depends on them.

## 5. Settings Systems (Do Not Break)

### Padding system
Defined in: `_padding-system.scss`

Allowed values:
- `double`
- `single`
- `none`

### Column & container systems
Defined across:
- `_column-system.scss`
- `_container-system.scss`
- `_flex-system.scss`
- `_grid-system.scss`

Controlled via `span.row-settings`.

### Background system
Defined in: `_background-system.scss`

## 6. AI Safety Rules (Strict)

- Propose a **minimal diff** before applying changes
- Touch **one module or system at a time**
- Never invent new `data-*` attributes
- Never replace the `:has()`-based layout system
- Never compile module SCSS directly

## 7. Recommended Codex Session Prompt

> Read `AI_GUIDE.md` and follow it strictly.  
> This theme uses ACF Flexible Content modules with declarative layout controlled by `data-*` attributes and `:has()` selectors.  
> Only `style.scss` is a Sass entrypoint.  
> Always propose a minimal diff and verification steps before applying changes.
