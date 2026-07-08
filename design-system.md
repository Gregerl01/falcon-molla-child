# Falcon Truck Bodies — Design System

Reference documentation for the **Molla Child** WordPress theme (Falcon Truck Bodies).
Everything below is extracted directly from the theme source — no values are invented. Where a
value comes from a specific file it is cited so you can trace it back.

> **Theme:** Molla Child · **Version:** 1.0 · **Parent template:** `molla` · **Author:** D-THEMES
> (`style.css`)

---

## Table of Contents

1. [Architecture & Build](#1-architecture--build)
2. [Color Palette](#2-color-palette)
3. [Design Tokens (CSS Custom Properties)](#3-design-tokens-css-custom-properties)
4. [Typography](#4-typography)
5. [Spacing Scale](#5-spacing-scale)
6. [Breakpoints & Grid](#6-breakpoints--grid)
7. [Buttons](#7-buttons)
8. [Component Patterns](#8-component-patterns)
9. [Category Prefix Naming Convention](#9-category-prefix-naming-convention)
10. [Utility & Helper Classes](#10-utility--helper-classes)
11. [Mixins & Functions](#11-mixins--functions)
12. [Light / Dark Theming](#12-light--dark-theming)

---

## 1. Architecture & Build

The SCSS is compiled (Dart Sass) from a single entry point to one output file:

| | |
|---|---|
| **Entry point** | `assets/scss/custom.scss` |
| **Compiled output** | `assets/css/custom.css` |
| **CSS framework** | Bootstrap 5 (SCSS, imported from `node_modules/bootstrap/scss/*`) |
| **Slider** | Swiper 11 (SCSS import + CDN JS) |

### Import order (`custom.scss`)

```
base/design-tokens          ← imported FIRST (type scale, weights, line-heights)
Bootstrap (functions → variables → maps → mixins → utilities → root/reboot/type/grid/buttons/containers/modal)
Swiper
base/variables → base/colors → base/typography → base/mixins → base/global
base/molla-overrides        ← after base vars, before layout/components
layout/ (header, navigation, footer)
components/ (17 partials)
pages/ (22 partials)
woocommerce/ (product-lists, product-single, tabs, gallery)
blog/blog
utilities/helpers
```

### Externally loaded assets (`functions.php`)

| Asset | Source | Notes |
|---|---|---|
| Google Fonts | `fonts.googleapis.com/css2?family=Orbitron:wght@400…900&family=Inter:wght@300…700` | Preconnect hints added in `wp_head` at priority 1 |
| Bootstrap Icons 1.11.3 | jsDelivr CDN | Not compiled into CSS |
| AOS 2.3.4 (animate-on-scroll) | jsDelivr CDN | Conditionally enqueued on pages / front page / product categories |
| Swiper 11 | jsDelivr CDN | CSS + JS |
| `assets/js/custom.js` | local | depends on jquery + swiper |
| `assets/js/hero-parallax.js` | local | front page only |
| `assets/js/configurations.js` | local | single product pages only |

> **Fonts note:** Two families are loaded (Orbitron + Inter), but the active design tokens set
> **only Inter** as `--font-body` and `--font-heading`. Orbitron is loaded but not wired into the
> token system.

---

## 2. Color Palette

### SCSS source map (`base/_colors.scss` → `$colors`)

These are the base Sass values. Utility classes and CSS custom properties are generated from them.

| Token | Hex | Swatch |
|---|---|---|
| `primary` | `#208bf4` | 🟦 brand blue |
| `primary-dark` | `darken(#208bf4, 10%)` → `#0d78e8`* | — |
| `primary-light` | `lighten(#208bf4, 10%)` → `#51a5f7`* | — |
| `white` | `#ffffff` | ⬜ |
| `black` | `#060606` | ⬛ |
| `gray-100` | `#f4f7f6` | page background |
| `gray-200` | `#e9ecef` | |
| `gray-300` | `#dee2e6` | border color |
| `gray-400` | `#ced4da` | |
| `gray-500` | `#adb5bd` | muted text |
| `gray-600` | `#777777` | |
| `gray-700` | `#52565e` | secondary text (~7:1 on white) |
| `gray-800` | `#343a40` | dark surfaces |
| `gray-900` | `#252525` | primary text / footer-top |
| `success` | `#28a745` | |
| `warning` | `#ffc107` | |
| `danger` | `#dc3545` | |
| `info` | `#17a2b8` | |

\* `primary-dark` / `primary-light` are computed by Sass `darken()` / `lighten()`; the exact hex is
resolved at compile time — values shown are the standard results.

### Brand accent (text-safe)

| Token | Hex | Usage |
|---|---|---|
| `--accent-color` | `= --color-primary` (`#208bf4`) | Decorative / non-text blue (dividers, icons, hovers) |
| `--accent-strong` | `#1A6FCC` | **Text-bearing blue** — filled UI with white text (WCAG AA ~5:1). Buttons, pagination current, in-content links |

### Legacy / overridden colors

- Molla's original gold **`#fcb941`** is force-overridden to `--accent-color` anywhere it appears
  (class or inline style) — see `base/_molla-overrides.scss`.
- `--contrast-color` appears only in **backup/old** color files (`z-old-files/`, `_colors-backup-*`);
  it is **not** defined in the active token set, though a few component rules still reference it.

---

## 3. Design Tokens (CSS Custom Properties)

Defined on `:root` in `base/_colors.scss` (light mode default) with `[data-theme="dark"]` overrides.

### Brand & primary

| Variable | Light value |
|---|---|
| `--color-primary` | `#208bf4` (from `$colors.primary`) |
| `--accent-color` | `var(--color-primary)` |
| `--accent-strong` | `#1A6FCC` |
| `--color-primary-rgb` | `32, 139, 244` (r,g,b of primary) |

### Page & sections

| Variable | Light | Dark (`[data-theme="dark"]`) |
|---|---|---|
| `--bg-page` | `gray-100` `#f4f7f6` | `black` `#060606` |
| `--section-primary` | `white` `#ffffff` | `black` `#060606` |
| `--section-secondary` | `gray-100` `#f4f7f6` | `gray-800` `#343a40` |

### Surfaces (`base/_colors.scss`, second `:root` block)

| Variable | Light | Dark |
|---|---|---|
| `--surface` | `#f1f1f1` | `#151616` |
| `--surface-1` | `#e3e3e3` | `#111315` |
| `--surface-2` | `#e4e4e4` (subtle lift) | `#1d1e1f` |
| `--surface-hover` | `#eef1f5` | `#22262a` |
| `--surface-border` | `rgba(0,0,0,0.06)` | `rgba(255,255,255,0.08)` |
| `--bg-card` | `var(--surface-1)` | `gray-800` `#343a40` |
| `--bg-card-subtle` | `var(--surface-2)` | `gray-700` `#52565e` |

### Text

| Variable | Light | Dark |
|---|---|---|
| `--text-primary` | `gray-900` `#252525` | `white` `#ffffff` |
| `--text-secondary` | `gray-700` `#52565e` | `gray-300` `#dee2e6` |
| `--text-muted` | `gray-500` `#adb5bd` | `gray-500` `#adb5bd` |
| `--heading-color` | `var(--text-primary)` | `var(--text-primary)` |

### Borders, shadows, overlays

| Variable | Light | Dark |
|---|---|---|
| `--border-color` | `gray-300` `#dee2e6` | `rgba(255,255,255,0.08)` |
| `--shadow-card` | `0 6px 18px rgba(0,0,0,0.08)` | `0 8px 24px rgba(0,0,0,0.6)` |
| `--overlay-image` | `rgba(0,0,0,0.55)` | `rgba(0,0,0,0.65)` |
| `--text-on-image` | `white` `#ffffff` | — |

### Header & footer — **locked dark** (never themed)

| Variable | Value |
|---|---|
| `--header-bg` | `#111111` |
| `--header-text` | `#ffffff` |
| `--header-border` | `rgba(255,255,255,0.08)` |
| `--footer-bg` | `#111111` |
| `--footer-top-bg` | `gray-900` `#252525` |
| `--footer-bottom-bg` | `#111111` |
| `--footer-text` | `#ffffff` |
| `--footer-border` | `rgba(255,255,255,0.08)` |

### Navigation

| Variable | Value |
|---|---|
| `--nav-color` | `rgba(255,255,255,1)` |
| `--nav-hover-color` | `white` |
| `--nav-mobile-background-color` | `white` |
| `--nav-dropdown-background-color` | `white` |
| `--nav-dropdown-color` | `gray-900` `#252525` |
| `--nav-dropdown-hover-color` | `primary` `#208bf4` |

### Transitions

| Variable | Value |
|---|---|
| `--transition-base` | `all 0.3s ease` |
| `--transition-fast` | `all 0.15s ease` |
| `--transition-slow` | `all 0.5s ease` |

---

## 4. Typography

Source of truth: **`base/_design-tokens.scss`** (tokens) + **`base/_typography.scss`** (element
mapping). Uses **flat `px` values** deliberately — Molla's root font-size is `10px`, so `rem` would
compute wrong; `px` is immune. No `clamp()` / fluid type. Headings are targeted as `body h1…h6`
(specificity 0,0,2) to beat Molla's bare-tag styles without `!important`.

### Font families

| Token | Value |
|---|---|
| `--font-body` | `'Inter', sans-serif` |
| `--font-heading` | `'Inter', sans-serif` |
| `$font-heading` / `$font-body` (SCSS) | `'Inter', sans-serif` (still referenced by some page partials) |

### Heading scale

| Element | Token | Size | Weight | Letter-spacing |
|---|---|---|---|---|
| `h1` | `--fs-h1` | **40px** | `--fw-display` 700 | `--ls-display` -0.02em |
| `h2` | `--fs-h2` | **32px** | `--fw-heading` 500 | `--ls-heading` -0.01em |
| `h3` | `--fs-h3` | **24px** | 500 | -0.01em |
| `h4` | `--fs-h4` | **20px** | 500 | -0.01em |
| `h5` | `--fs-h5` | **18px** | 500 | -0.01em |
| `h6` | `--fs-h6` | **16px** | 500 | -0.01em |

- Heading line-height: `--lh-heading` **1.15**
- Headings are `text-transform: none` (preserves sentence-case brand).

### Body & text scale

| Token | Size | Notes |
|---|---|---|
| `--fs-body` | **14px** | `body`, `p` — weight `--fw-body` 400, line-height `--lh-body` 1.6 |
| `--fs-lead` | **16px** | `.lead` |
| `--fs-small` | **13px** | |
| `--fs-caption` | **12px** | |

### Component text tokens

| Token | Size |
|---|---|
| `--fs-eyebrow` | 18px |
| `--fs-card-title` | 18px |
| `--fs-card-title-large` | 20px |
| `--fs-card-body` | 14px |
| `--fs-benefit-title` | 20px |
| `--fs-benefit-body` | 14px |
| `--fs-product-title` | 24px |

### Weights

| Token | Value |
|---|---|
| `--fw-body` | 400 |
| `--fw-heading` | 500 |
| `--fw-heading-strong` | 700 |
| `--fw-display` | 700 |
| `--fw-card-title` | 600 |
| `--fw-benefit-title` | 700 |

### Line heights

| Token | Value |
|---|---|
| `--lh-heading` | 1.15 |
| `--lh-body` | 1.6 |
| `--lh-card-title` | 1.25 |

### Letter spacing (tracking)

| Token | Value |
|---|---|
| `--ls-display` | -0.02em |
| `--ls-heading` | -0.01em |
| `--ls-eyebrow` | 0.08em |

### Typography utilities (`_typography.scss`)

| Class | Effect |
|---|---|
| `.text-uppercase` | `text-transform: uppercase !important` |
| `.text-capitalize` | `text-transform: capitalize !important` |
| `.letter-spacing-sm` | `0.5px` |
| `.letter-spacing-md` | `1px` |
| `.letter-spacing-lg` | `2px` |

---

## 5. Spacing Scale

### CSS custom properties (`base/_colors.scss` `:root`)

| Token | Value |
|---|---|
| `--spacing-xs` | 0.25rem |
| `--spacing-sm` | 0.5rem |
| `--spacing-md` | 1rem |
| `--spacing-lg` | 1.5rem |
| `--spacing-xl` | 2rem |
| `--spacing-2xl` | 3rem |

### SCSS layout variables (`base/_variables.scss`)

| Variable | Value | Purpose |
|---|---|---|
| `$max-width-1500` | 1500px | Custom container max-width (`.max-w-1500`) |
| `$section-padding` | 80px | Desktop section padding |
| `$section-padding-md` | 60px | Tablet (768–991px) |
| `$section-padding-sm` | 40px | Mobile (<768px) |
| `$section-scroll-margin` | 92px | `scroll-margin-top` for anchored sections |
| `$header-offset` | 100px | |
| `$border-radius-pill` | 50px | |
| `$border-radius-none` | 0 | |
| `$transition-default` | 0.3s ease | |
| `$transition-smooth` | 0.25s ease-out | |

### Z-index scale

| Variable | Value |
|---|---|
| `$z-index-overlay` | 50 |
| `$z-index-header` | 100 |
| `$z-index-modal` | 200 |

---

## 6. Breakpoints & Grid

The grid is **Bootstrap 5** (imported), so the standard tiers apply: `sm 576`, `md 768`,
`lg 992`, `xl 1200`, `xxl 1400`. In addition, the theme's own SCSS uses these **custom media
query breakpoints**:

| Breakpoint | Used for |
|---|---|
| `min-width: 768px` | Tablet+ section padding (`60px → 80px`) |
| `min-width: 992px` | Desktop section padding (`80px → 100px`) |
| `max-width: 768px` | `.hide-mobile`, section-title decoration removal |
| `min-width: 769px` | `.hide-desktop` |
| `max-width: 1500px` | Custom container cap (`.max-w-1500`) |

> Note: `.section` padding is defined in two places — `base/_global.scss` (40/60/80 responsive)
> and `components/_sections.scss` (flat 80px). Because of import order, `components/_sections.scss`
> loads later. The design-token `.section` in `_colors.scss` uses 60/80/100 responsive padding.

Custom container helpers (`base/_global.scss`): `.custom-container` (`@include make-container()`),
`.custom-row` (`@include make-row()`), `.max-w-1500`.

---

## 7. Buttons

Defined in `components/_buttons.scss`. Base radius is pill (`50px`).

### Base `.btn`

```
padding: 1.2rem 3rem · font-size: 1.4rem · font-weight: 700
border-radius: 50px · border: 2px solid transparent · transition: all 0.3s ease
hover/focus: translateY(-2px)
```

### Variants

| Class | Fill | Border | Text | Hover |
|---|---|---|---|---|
| `.btn-primary` | `--accent-strong` `#1A6FCC` | same | white | darken 10%, blue glow shadow |
| `.btn-secondary` | transparent | `2px --accent-color` | `--accent-color` | fill `--accent-strong`, white text |
| `.btn-outline` | transparent | `2px --text-primary` | `--text-primary` | fill `--text-primary`, text `--bg-page` |

### Shape modifiers

| Class | Radius |
|---|---|
| `.btn-pill` | 999px |
| `.btn-rounded` | 8px |
| `.btn-square` | 0 |

### Size modifiers

| Class | Padding | Font-size |
|---|---|---|
| `.btn-sm` | 0.8rem 2rem | 1.2rem |
| (default) | 1.2rem 3rem | 1.4rem |
| `.btn-lg` | 1.5rem 4rem | 1.6rem |
| `.btn-block` | full width (`display:block; width:100%`) | — |

### Focus (accessibility)

Filled CTAs (`.btn-primary`, WooCommerce buttons, `.wpcf7-submit`) get a white inner outline +
blue halo (`box-shadow 0 0 0 5px rgba(--color-primary-rgb, 0.45)`) on `:focus-visible`.

### WooCommerce buttons (`base/_molla-overrides.scss`)

`.woocommerce a.button`, `button.button`, `.add_to_cart_button`, `.single_add_to_cart_button`,
`.btn-cart` → background & border `--accent-strong`, white text, hover `opacity 0.9`.

---

## 8. Component Patterns

All component partials live in `assets/scss/components/`. Several components are **styled here but
their markup lives in the page-builder / database** (Home & About page content) — noted below.

| Component | File | Root selector(s) | Notes |
|---|---|---|---|
| **Sections** | `_sections.scss` | `.section`, `.section--alt`, `.section--tight` (60px), `.section--wide` (120px) | Section rhythm modifiers |
| **Cards** | `_cards.scss` | `.card`, `.card-surface` | radius 12px, `--shadow-card`, `--bg-card` surface, themed text |
| **Category cards** | `_category-cards.scss` | `.category-card`, `.category-content` | Image tile w/ `.overlay-gradient`, hover lift + zoom; text locked `#fff`; homepage pins text to top |
| **Hero (home)** | `_hero-banner.scss` | `.hero--home` | Left-anchored. BG image via `--hero-bg-desktop` / `--hero-bg-mobile` set inline by `hero-home.php` |
| **Featured cards** | `_featured-cards.scss` | `.featured-card`, `.services-slider`, `.swiper-*` | Image-on-top slider cards; markup in DB; icon/arrow/number hidden via `display:none` |
| **Feature split** | `_feature-split.scss` | `.feature-split` (`&__media`, `&__content`) | Flex 50/50 media + content, gap `--spacing-xl` |
| **Benefits** | `_benefits.scss` | `.benefit-item` | Flex row, bottom-bordered list items |
| **Testimonials** | `_testimonials.scss` | `.testimonials`, `.testimonial-item` | Slider/quote section |
| **FAQ** | `_faq.scss` | `.faq`, `.faq-tabs .nav-pills` | Pill tab nav (radius 50px) + accordion |
| **Call to action** | `_call-to-action.scss` | `.call-to-action` (largely commented) | CTA actions wrapper |
| **Category sections** | `_category-sections.scss` | `.{prefix}-cta/-features/-options/-products/-accessories` | Shared per-category section blocks (see §9) |
| **About video** | `_about-video-section.scss` | `.about-video-section`, `.about-video-modal` | Full-bleed video band, min-height 55vh / max 500px, modal |
| **About us** | `_about-us.scss` | `#about-us` | Homepage About block; overrides inline image stretch (markup in DB) |
| **Configurations** | `_configurations.scss` | `.falcon-configurations` | Product config toggles (single-product; JS-driven), max-width 900px |
| **Images** | `_images.scss` | `.image-section`, `.main-image` | Framed image w/ deep shadow |
| **Parallax** | `_parallax.scss` | — | Placeholder/stub file |

### Scoped "falcon-" blocks

Falcon-specific content blocks use a `falcon-` prefix so they control their own colors by
specificity (they opt out of the generic `.section` text force-paint):
`.falcon-feature-block`, `.falcon-bodies-showcase`, `.falcon-headline`, `.falcon-intro`,
`.falcon-configurations`.

### Section title / intro helpers (`base/_global.scss`)

- `.section-title h2` — centered, uppercase, with `50px × 2px` accent flanks (hidden < 768px).
- `.section-intro p.eyebrow` — 26px; `.section-intro p` — 16px / line-height 1.6.
- `.gradient-divider` — 1px radial-gradient accent rule (`base/_colors.scss`).
- `#scroll-top` — 38×38 dark translucent scroll-to-top button, accent border on hover.

---

## 9. Category Prefix Naming Convention

Each WooCommerce category template uses a **unique CSS class prefix** on its sections, following the
pattern `.{prefix}-hero`, `.{prefix}-intro`, `.{prefix}-features`, `.{prefix}-options`,
`.{prefix}-products`, `.{prefix}-accessories`, `.{prefix}-cta` (see `components/_category-sections.scss`
and the per-page partials in `pages/`).

| Category | Prefix | Page partial |
|---|---|---|
| Service Bodies | `sb` | `_service-bodies.scss` |
| Contractor Bodies | `cb` | `_contractor-bodies.scss` |
| Mechanics Bodies | `mechanics` | `_mechanics-bodies.scss` |
| Enclosed Bodies | `eb` | `_enclosed-bodies.scss` |
| Saw Bodies / Saw Trucks | `st` | `_saw-bodies.scss` / `_saw-trucks.scss` |
| Hauler Bodies | `hb` | `_hauler-bodies.scss` |
| Landscape Bodies | `lb` | `_landscape-bodies.scss` |
| Chipper Bodies | `chb` | `_chipper-bodies.scss` |
| Welder Bodies | `wb` | `_welder-bodies.scss` |
| Box Trucks | `bt` | `_box-trucks.scss` |
| Water Trucks | `wt` | `_water-trucks.scss` |
| Platform Bodies | `pb` | `_platform-bodies.scss` |
| Dump Trucks | `dt` | `_dump-trucks.scss` |
| Line Bodies | `lineb` | `_line-bodies.scss` |

> **Common layout pattern:** `.{prefix}-hero .container .row { justify-content: flex-start | flex-end }`
> controls hero left/right alignment.
> **Legacy:** `pages/_old-categories.scss` and `_old-service-bodies.scss` hold the older `.sb-` styles.

Other non-category page partials use descriptive (non-abbreviated) prefixes, e.g. About page:
`.team-`, `.cta-`, `.card-`, `.page-`; Contact page: `.form-`, `.info-`, `.map-`, `.icon-`;
Legal/templates: `.terms-`, `.tos-`, `.legal-`, `.alert-`.

---

## 10. Utility & Helper Classes

### Generated from `$colors` (`base/_colors.scss`)

For **every** color name in the `$colors` map:

```scss
.bg-{name}      { background-color: {color} !important; }
.text-{name}    { color: {color} !important; }
.border-{name}  { border-color: {color} !important; }
```

e.g. `.bg-primary`, `.text-gray-700`, `.border-danger`.

Opacity utilities (10–90): `.opacity-10` … `.opacity-90`.

### `utilities/_helpers.scss`

| Class | Effect |
|---|---|
| `.text-center` / `.text-left` / `.text-right` | text alignment |
| `.mt-0` / `.mb-0` / `.pt-0` / `.pb-0` | zero margin/padding (`!important`) |
| `.d-none` / `.d-block` | display (`!important`) |
| `.hide-mobile` | `display:none` at `max-width: 768px` |
| `.hide-desktop` | `display:none` at `min-width: 769px` |

### Surface helpers (`base/_colors.scss`)

| Class | Effect |
|---|---|
| `.surface` | `background: var(--surface)` |
| `.surface--subtle` | `background: var(--surface-2)` |
| `.surface--hoverable:hover` | color-mix lift + `0 12px 32px` shadow |
| `.muted` | `color: var(--text-muted)` |

> Bootstrap 5's full utility API and grid are also available (imported in `custom.scss`).

---

## 11. Mixins & Functions

### Mixins (`base/_mixins.scss`)

| Mixin | Purpose |
|---|---|
| `accent-border($opacity: 85%)` | `1px` border via `color-mix(accent, transparent $opacity)` |
| `accent-background($opacity: 95%)` | accent background via `color-mix` |
| `button-primary-hover` | primary button hover state (color-mix fills, white text) |
| `smooth-transition($property: all, $duration: 0.3s)` | transition shorthand |
| `theme-colors` *(in `_colors.scss`)* | applies `--bg-page` + `--text-secondary` |

### Functions (`base/_colors.scss`)

| Function | Purpose |
|---|---|
| `color-contrast($color)` | Returns black or white based on YIQ luminance (threshold 128) |

---

## 12. Light / Dark Theming

The theme is **token-driven** via `[data-theme]` on a root element (see MEMORY: `data-theme` attr +
CSS vars in `_colors.scss`).

- **Light mode** = default `:root` tokens.
- **Dark mode** = `[data-theme="dark"]` overrides (page/section/surface/text/border/shadow/overlay,
  plus a mobile-menu dark override for Molla's `.mobile-menu-light`).
- **Header & footer are permanently dark** regardless of theme — `--header-bg` / `--footer-bg` are
  hardcoded `#111111` and forced with `!important` in `base/_molla-overrides.scss`.
- `base/_molla-overrides.scss` neutralizes Molla's hardcoded gold (`#fcb941`), routes `.text-primary`
  / `.bg-primary` to the accent token, and adds accessible `:focus-visible` rings and distinguishable
  in-content links (`--accent-strong`, underlined).

---

*Generated from theme source. Files referenced: `style.css`, `functions.php`, `assets/scss/custom.scss`,
`assets/scss/base/*`, `assets/scss/components/*`, `assets/scss/pages/*`, `assets/scss/utilities/_helpers.scss`,
`assets/css/custom.css`.*
