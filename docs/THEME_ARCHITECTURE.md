# Theme Architecture – Falcon Truck Bodies (Child Theme)

This document defines how category pages and SCSS are structured.
It exists to prevent duplication, styling conflicts, and layout drift.

---

## Category Page Philosophy

Each product category (Service Bodies, Contractor Bodies, Mechanics Bodies, etc.)
shares the same layout structure but has unique branding (hero imagery and copy).

To support this, styles are split into two layers:

---

## 1. Page-Level SCSS (Identity Only)

Location:
assets/scss/pages/

Examples:
- _service-bodies.scss
- _contractor-bodies.scss
- _mechanics-bodies.scss

Purpose:
These files may ONLY contain:
- Hero background images
- Hero text styling
- Very small, page-specific tweaks

They MUST NOT contain:
- Features section styles
- Options section styles
- Accessories section styles
- Product list styles
- CTA styles

If a style applies to more than one category, it does not belong here.

---

## 2. Shared Category Sections (Structure)

Location:
assets/scss/components/_category-sections.scss

Purpose:
This file contains ALL reusable section styling for category pages.

This includes:
- Features sections
- Options sections
- Accessories sections
- Product list sections
- CTA sections

Selectors are grouped using category prefixes.

Example:
.sb-features,
.cb-features,
.mechanics-features {
  ...
}

When a new category is added, its prefix (e.g. .eb- for Enclosed Bodies)
MUST be added to these selector groups.

This file is the ONLY place where category section layout and styling may live.

---

## Adding a New Category (Checklist)

When adding a new category page:

1. Create a taxonomy template:
   taxonomy-product_cat-{category}.php

2. Create a page SCSS file:
   assets/scss/pages/_{category}.scss  
   (Hero styles only)

3. Import the page SCSS in custom.scss

4. Add the new category prefix to selector groups in:
   assets/scss/components/_category-sections.scss

No category-specific section styling should be duplicated.

---

## Product Loop Layout (Category Pages)

All category templates use a unified product loop layout inside `#product-line`.

Pattern (matches Mechanics Bodies reference implementation):
- Row: `row g-0 align-items-stretch overflow-hidden max-w-1500 mx-auto` (no `.container` wrapper)
- Image column: `col-lg-6 p-0 d-flex` with `image-frame w-100` wrapper, `data-aos="fade-right"`
- Image size: `'full'` with classes `img-fluid w-100`
- Content column: `col-lg-6 d-flex align-items-center` with `feature-content-wrap` wrapper, `data-aos="fade-left"`
- Alternating left/right image placement per product (even/odd logic)
- Variables escaped with `esc_attr()`

When adding a new category, the product loop in the taxonomy template MUST follow this pattern.

---

## WooCommerce Custom Tabs

Custom tab content is stored in Molla post meta fields (`tab_content_1st`, `tab_content_2nd`).
Rendering is handled by `functions.php` via a `woocommerce_product_tabs` filter at priority 98.

The callback runs `do_shortcode()` on the raw meta content.

Known issue: WordPress or WP All Import can inject `<p>` and `<br>` tags into stored HTML during import or save. This breaks Bootstrap grid layouts inside tabs. If tab grids break, check the raw post meta in wp-admin (Code tab view) for injected tags. The source data must be clean HTML — the theme does not sanitize tab content at render time.

---

## Rule of Thumb

If a section appears on more than one category page,
its styling belongs in _category-sections.scss — not in page SCSS files.