# Falcon Truck Bodies — Type System Spec (Design Tokens)

Status: **proposal for review. Nothing has been implemented.**
Goal: one canonical size/weight/line-height per role, defined once as tokens, inherited everywhere. No per-page font sizes for the same tag.

---

## 1. Why this exists (audit evidence)

Live audit of homepage, category, and product pages (local). Same tag, different size per page:

| Tag | Homepage | Category | Product |
|-----|----------|----------|---------|
| h2  | 36, 24 | 36, 30 | 24, 30, 16 |
| h3  | 11.25, 13, 14, 15 | 26, 13, 14 | 16, 13, 14 |
| h4  | 22 | 18 | 15 |
| h5  | 20, 9 | 20 | 20 |
| p   | 10, 12.5, 13, 14, 15, 16, 17.5 | 12.5, 13, 14, 14.5, 15, 16 | 13, 14, 15, 16.8 |

`h4` is three sizes across three pages. Paragraphs span 10–17.5px site-wide. There is an `h3` at 11.25px and an `h5` at 9px. Sizing currently comes from four competing layers with no token in between:

1. Bare tag rules (`h2`, `h3` styled directly and differently per stylesheet block)
2. Bootstrap / Molla component classes hardcoding sizes (`.icon-box-title` 13, `.widget-title` 14, `.hero__title` 85, `.product_title` 24, `.lead` 16)
3. Custom classes (`.falcon-headline`, `.falcon-intro`, `.subhead` 9, `.config-subtitle` 16.8)
4. Inline `style` attributes in markup, which override all CSS

The token layer fixes layers 1–3. Layer 4 must be removed from markup or it keeps winning.

---

## 2. Principles

- One token per role. Every `h3` resolves to `--fs-h3`, everywhere.
- Tokens are `clamp()` so they are uniform **and** fluid-responsive (folds in the earlier-approved small-breakpoint scaling).
- A small set of **named exceptions** (hero display, product title, eyebrow) are deliberate, not accidental.
- Tokens live in one base partial. Component/page SCSS references tokens; it never hardcodes px.
- `rem` units, 16px root.

---

## 3. Token definitions

Defined as CSS custom properties on `:root`. Clamp values are starting points to tune visually; min ≈ 360px viewport, max ≈ 1280px+.

| Token | Size (min → max) | clamp() | Weight | Line-height |
|-------|------------------|---------|--------|-------------|
| `--fs-display` | 40 → 80px | `clamp(2.5rem, 1.52rem + 4.35vw, 5rem)` | 800 | 1.05 |
| `--fs-h1` | 30 → 44px | `clamp(1.875rem, 1.53rem + 1.52vw, 2.75rem)` | 600 | 1.1 |
| `--fs-h2` | 28 → 36px | `clamp(1.75rem, 1.55rem + 0.87vw, 2.25rem)` | 600 | 1.1 |
| `--fs-h3` | 22 → 26px | `clamp(1.375rem, 1.28rem + 0.43vw, 1.625rem)` | 600 | 1.15 |
| `--fs-h4` | 17 → 20px | `clamp(1.0625rem, 0.99rem + 0.33vw, 1.25rem)` | 600 | 1.2 |
| `--fs-h5` | 16 → 18px | `clamp(1rem, 0.95rem + 0.25vw, 1.125rem)` | 600 | 1.25 |
| `--fs-lead` | 16 → 18px | `clamp(1rem, 0.95rem + 0.25vw, 1.125rem)` | 400 | 1.6 |
| `--fs-body` | 16px | `1rem` | 400 | 1.6 |
| `--fs-small` | 14px | `0.875rem` | 400 | 1.5 |
| `--fs-eyebrow` | 14px | `0.875rem` (uppercase, letter-spacing 0.08em) | 600 | 1.2 |
| `--fs-product-title` | 24px | `1.5rem` | 600 | 1.2 |

Supporting tokens: `--fw-heading: 600`, `--fw-display: 800`, `--fw-body: 400`, `--lh-heading: 1.15`, `--lh-body: 1.6`.

---

## 4. Base element mapping

Set once on the bare elements so untagged content is correct by default:

- `h1 → --fs-h1` · `h2 → --fs-h2` · `h3 → --fs-h3` · `h4 → --fs-h4` · `h5 → --fs-h5` · `h6 → --fs-small`
- `p → --fs-body` · `li → --fs-body`
- `.lead, .falcon-intro → --fs-lead`
- `small, .text-small, figcaption → --fs-small`

---

## 5. Named exceptions (deliberate, kept distinct)

| Selector | Token | Reason |
|----------|-------|--------|
| `.hero__title` | `--fs-display` | Marketing hero, intentionally oversized |
| `.product_title.entry-title` | `--fs-product-title` | WooCommerce summary layout depends on ~24px |
| `h5.text-uppercase` (eyebrows) | `--fs-eyebrow` | Small uppercase label, not a heading |
| `.logo` (header brand `h1`) | leave as-is | Header brand sizing, not body type |

---

## 6. Override repoint / kill list

Every current size source and its disposition. "Repoint" = replace hardcoded px with a token. "Retire" = delete the size rule, let it inherit the base element token.

| Current selector | Now | Action | Target |
|------------------|-----|--------|--------|
| bare `h2`/`h3`/`h4`/`h5` rules in `_category-sections.scss`, page SCSS | 36/26/18/20 | Retire hardcoded px | base token |
| `.falcon-headline` | 36 (cat) / 16 (product) | Retire size; it's an `h2` | `--fs-h2` |
| `.falcon-intro` | 14–14.5 | Repoint | `--fs-lead` |
| benefit-content `h3` / `p` | 26 / 14.5 | Retire | `--fs-h3` / `--fs-body` |
| `.lead` | 16 | Repoint | `--fs-lead` |
| `.icon-box-title` (Molla) | 13 | Repoint (verify component) | `--fs-h5` |
| `.icon-box-desc` (Molla) | 13 | Repoint (verify component) | `--fs-small` |
| `.widget-title` (footer) | 14 | Repoint | `--fs-h5` |
| `.subhead` | 9 | Retire (likely a bug) | `--fs-eyebrow` |
| `.config-subtitle` | 16.8 | Repoint | `--fs-body` |
| `.tagline` | 14 | Repoint | `--fs-small` |
| `.hero__lead` | 17.5 | Repoint | `--fs-lead` |

Molla parent-theme component classes (`.icon-box-*`, `.widget-title`) are compact-UI components; verify each renders correctly after repointing rather than assuming.

---

## 7. Inline styles to strip from markup (templates)

Inline `style` beats every stylesheet, so these must move to classes:

- `#about-us` image: `style="height:auto; min-height:100%; max-height:none; object-position:center"` → remove, use the shared feature-image class
- `#about-us` content column: `style="max-width:620px; margin-right:auto; padding:3rem 2rem"` → move to a class
- Homepage hero: audit for inline sizing and strip
- `#about-us` markup should also be repointed to the feature-block classes (`.falcon-headline`, `.falcon-intro`, `.falcon-benefits`, benefit `h3`) so it inherits the system instead of approximating it with bare tags

---

## 8. SCSS file plan

- New: `assets/scss/base/_design-tokens.scss` — the `:root` custom properties (Section 3). Imported first.
- New or updated: `assets/scss/base/_typography.scss` — base element rules (Section 4) referencing tokens.
- Edit: `_category-sections.scss`, `_product-lists.scss`, `_featured-cards.scss`, page partials, `_configurations.scss` — remove hardcoded font sizes, reference tokens.
- Compiled output stays `assets/css/custom.css` via `npm run sass`.

---

## 9. Phasing (do not do in one commit)

1. Add tokens + base element styles. Change nothing else. Observe what shifts.
2. Repoint the high-value custom classes (`.falcon-headline`, `.falcon-intro`, `.lead`, eyebrow). Remove their hardcoded sizes.
3. Repoint/retire Molla component classes one at a time, verifying each component.
4. Strip inline styles from templates; repoint `#about-us` to feature-block classes.
5. Full test pass, then deploy.

---

## 10. Risk and deploy path

- Standardizing will shift every page that secretly relied on a one-off size. Some shifts are the fix; some need eyeballing.
- This touches global elements, Molla parent classes, WooCommerce defaults, and template markup. It is not CSS-only.
- **This is too broad to hot-SCP to production file-by-file.** It needs a staging review surface, which makes the deferred git reconciliation a prerequisite to a clean deploy.

---

## 11. Test matrix

Pages: homepage, one category page, a product page, the showcase, one generic page (About/Contact), one blog single.
Widths: ~390, 768, 1100, 1500.
Check per page: heading sizes uniform across pages, no element below ~14px in body content, hero/product-title intact, no inline-style overrides remaining, dark/light mode unaffected.

---

## 12. Open decisions (defaults already chosen, confirm on review)

- h4 → 20px max ✓ (your call)
- body/li → 16px ✓
- hero kept large as `--fs-display` ✓
- eyebrow kept at 14px uppercase ✓
- Outstanding: whether to sort git reconciliation before deploying this (recommended).
