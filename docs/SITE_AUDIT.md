# Falcon Truck Bodies — Full Theme Audit

**Date:** March 20, 2026
**Branch:** `dev`
**Theme:** Molla Child (Falcon Truck Bodies)

---

## Summary

| Category | Critical | Warning | Info |
|----------|----------|---------|------|
| Structure & Code Quality | 0 | 2 | 8 |
| SEO | 4 | 2 | 0 |
| Performance | 3 | 2 | 1 |
| Accessibility | 2 | 3 | 1 |
| Deployment | 2 | 3 | 4 |
| **Totals** | **11** | **12** | **14** |

---

## 1. Structure & Code Quality

### WARNING — Unused SCSS Files Not Imported

The following files exist in `assets/scss/pages/` but are **not imported** in `custom.scss`:

| File | Size | Notes |
|------|------|-------|
| `_saw-trucks.scss` | 667 B | Duplicate `.st-hero` selector (also in `_saw-bodies.scss`) |
| `_water-trucks.scss` | 663 B | `.wt-hero` — may not be used |
| `_old-categories.scss` | 7.7 KB | Duplicate `.sb-hero`, `.mechanics-hero`, old feature styles |
| `_old-service-bodies.scss` | 10 KB | Duplicate `.sb-hero`, large amounts of commented-out code |

No functional impact (they don't compile), but they add confusion and version control bloat.

**Fix:** Delete these files. Git history preserves them if ever needed.

---

### WARNING — Dead Code in JavaScript

**File:** `assets/js/custom.js:37-41`

```javascript
function initCustomInteractions() {
    $('.custom-element').on('click', function() {
        $(this).toggleClass('active');
    });
}
```

`.custom-element` does not exist anywhere in the codebase. The function is called on line 16 but does nothing.

**Fix:** Remove the function and its call.

---

### INFO — Backup Files in Repository (10+ files)

These files should be removed — Git history serves as the backup:

| File | Size |
|------|------|
| `functions-backup.php` | 10.4 KB |
| `functions-backup-120325.php` | 9.7 KB |
| `package-backup-120325.json` | 539 B |
| `assets/scss/base/_colors-backup-120325.scss` | 8 KB |
| `assets/scss/base/_colors-backup-122125.scss` | 8 KB |
| `assets/scss/custom-backup120325.scss` | — |
| `assets/js/custom-backup-120325.js` | 8 KB |
| `assets/js/custom-backup-121925.js` | 4 KB |
| `template-parts/hero/hero-home-backup-122225.php` | — |
| `assets/scss/z-old-files/` (entire directory, 19 files) | ~188 KB |

---

### INFO — Console Debug Statement

**File:** `assets/js/custom.js:13`

```javascript
console.log('Custom JS loaded')
```

Remove for production. The `console.error` calls on lines 126 and 144 (Swiper error handlers) are appropriate to keep.

---

### INFO — Commented-Out CSS Block

**File:** `assets/scss/custom.scss:103-170`

~68 lines of commented-out footer/dark mode CSS. Dead weight — delete it.

---

### INFO — Unused `rellax` Dependency

**File:** `package.json`

`rellax@^1.12.1` is listed as a dependency but not imported, enqueued, or used anywhere. Only referenced in the backup `functions-backup.php`.

**Fix:** `npm uninstall rellax`

---

### INFO — CDN vs node_modules Redundancy

`aos`, `bootstrap-icons`, and `swiper` are in `package.json` dependencies but loaded via CDN in `functions.php`. The node_modules copies are unused at runtime. This is not a bug (Bootstrap SCSS is imported from node_modules correctly), but the other three could be removed from `dependencies` if not needed for SCSS imports.

---

### INFO — Duplicate Selectors Across Old/New Files

These selectors exist in both active and unimported files (no functional conflict since old files aren't compiled):

- `.sb-hero` — `_old-categories.scss`, `_old-service-bodies.scss`, `_service-bodies.scss`
- `.mechanics-hero` — `_old-categories.scss`, `_mechanics-bodies.scss`
- `.st-hero` — `_saw-trucks.scss`, `_saw-bodies.scss`

Resolved by deleting the unimported files.

---

### INFO — Unused `nodemon` Dev Dependency

**File:** `package.json`

`nodemon` is in `devDependencies` but not referenced in any npm script.

---

## 2. SEO

### CRITICAL — No Schema Markup / Structured Data

Zero JSON-LD or microdata found across the entire theme. Missing:

- **Product schema** (critical for WooCommerce product categories)
- **Organization schema** (footer / site-wide)
- **BreadcrumbList schema** (navigation)
- **LocalBusiness schema** (contact info)
- **FAQPage schema** (FAQ sections)

Completely dependent on Yoast SEO or similar plugin. If plugin is deactivated, search engines get zero structured data.

**Fix:** Add JSON-LD blocks to templates or ensure Yoast SEO is always active with proper configuration.

---

### CRITICAL — No Canonical URL Tags

Zero `rel="canonical"` tags in any template. Relies entirely on `wp_head()` and Yoast.

**Risk:** Duplicate content issues, pagination authority dilution, faceted navigation indexing problems.

**Fix:** Verify Yoast is outputting canonicals, or add theme-level fallback.

---

### CRITICAL — No Open Graph / Social Meta Tags

Zero `og:` or `twitter:` meta tags in the theme. Missing: `og:title`, `og:description`, `og:image`, `og:type`, `og:url`, `twitter:card`, etc.

**Impact:** Social shares display generic/ugly previews instead of branded content.

**Fix:** Verify Yoast Social tab is configured, or implement in `wp_head()`.

---

### CRITICAL — Heading Hierarchy Violations

All 12 category taxonomy templates have the same structural issue:

```
H1 (Hero) ✓
  H2 (Intro) ✓
  H5 (Features tagline) ✗ — skips H3, H4
  H2 (Features headline) ✗ — back to H2 after H5
    H4 (Feature items) ✗ — skips H3
  H5 (Options tagline) ✗
  H2 (Options headline) ✗
  H5 (Accessories tagline) ✗
  H2 (Accessories headline) ✗
  H2 (Product names in loop) ✗ — multiple H2s
  H3 (CTA) ✗
```

**Issues:**
- H5 → H2 jumps skip hierarchy levels
- Multiple H2s on a single page (product names in loop)
- H4 items appear without parent H3

**Fix:** Restructure to: H1 (hero) → H2 (section titles) → H3 (subsections) → H4 (items). Use CSS classes for visual sizing instead of wrong heading levels.

---

### WARNING — Meta Titles/Descriptions Depend on Plugin

`header.php` has no hardcoded meta — relies entirely on `wp_head()` and presumably Yoast SEO. No theme-level fallback exists.

**Risk:** If Yoast is deactivated, pages have no meta descriptions.

---

### WARNING — Unescaped Alt Text in Product Loop

**Files:** All `taxonomy-product_cat-*.php` templates (~line 270)

```php
<img src="..." alt="<?php the_title(); ?>" class="img-fluid w-100">
```

Should be:

```php
alt="<?php echo esc_attr( get_the_title() ); ?>"
```

`the_title()` echoes directly without escaping, which could break HTML if a product title contains quotes.

---

## 3. Performance

### CRITICAL — Missing Lazy Loading on Images

Only 1 image across all templates has `decoding="async"` (in `taxonomy-product_cat-mechanics-bodies.php`). All other `<img>` tags lack `loading="lazy"`.

**Impact:** All images load eagerly, increasing initial page weight and LCP time.

**Fix:** Add `loading="lazy"` to all below-the-fold images. Keep hero images eager.

---

### CRITICAL — No Responsive Images (srcset)

Zero `srcset` or `<picture>` elements found. All template images are single-source, fixed-size.

**Impact:** Mobile users download full-size desktop images. No art direction for different viewports.

**Fix:** Generate responsive image sets. Use `<picture>` with WebP + JPG fallback.

---

### CRITICAL — Large Monolithic CSS File

**File:** `assets/css/custom.css` — **168 KB** (7,817 lines)

Includes full Bootstrap utilities, all page styles, and all component styles in a single file loaded on every page.

**Fix:** Consider critical CSS extraction or per-page CSS splitting for category-specific styles.

---

### WARNING — Missing Font Preconnect Hints

**File:** `functions.php:45`

Google Fonts loaded without preconnect hints:

```php
'https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700&display=swap'
```

`font-display=swap` is correctly used, but missing:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
```

---

### WARNING — Bootstrap Icons Loaded Unconditionally

**File:** `functions.php:58`

Bootstrap Icons CSS is loaded on every page but only used on pages, singles, and frontpage. Should be conditional like AOS.

---

### INFO — Good JS Loading Practices

All custom scripts are correctly loaded in the footer with the `true` (in_footer) parameter. AOS is conditionally loaded only on pages that need it. No render-blocking JS issues found.

---

## 4. Accessibility

### CRITICAL — No Skip Navigation Link

No skip-to-content link found anywhere in the theme. This violates **WCAG 2.1 Level A** requirement 2.4.1 (Bypass Blocks).

**Fix:** Add to `header.php`:

```html
<a href="#main-content" class="skip-to-content sr-only sr-only-focusable">Skip to content</a>
```

---

### CRITICAL — Gallery Modal Image Missing Alt Text

**File:** `functions.php:247`

```html
<img id="galleryModalImage" src="" class="img-fluid mx-auto d-block" alt="">
```

The JS that populates this modal sets `src` but never sets `alt`. Screen readers announce nothing.

**Fix:** Pass alt text from the source image when opening the modal:

```javascript
$('#galleryModalImage').attr('src', imageSrc).attr('alt', imageAlt);
```

---

### WARNING — Color Contrast Issues

**File:** `assets/scss/base/_colors.scss`

| Token | Value | Background | Ratio | Status |
|-------|-------|-----------|-------|--------|
| `--text-secondary` | `#777777` | `#f4f7f6` | ~4.5:1 | Marginal (barely AA) |
| `--text-muted` | `#adb5bd` | `#f4f7f6` | ~3.5:1 | **Fails WCAG AA** |

Also: theme toggle border `rgba(0,0,0,0.1)` in light mode is nearly invisible.

---

### WARNING — Missing ARIA Attributes

- No `aria-expanded` on mobile menu toggle
- No `aria-pressed` on toggle buttons
- FAQ toggle (`custom.js:156-164`) uses click handler on `h3` — no explicit keyboard support for Enter/Space
- Swiper carousels lack custom ARIA roles

**Good ARIA found:** Video play button, modal close buttons, SVG icons (`aria-hidden`), gallery modal (`role="dialog"`), theme toggle (`aria-label`).

---

### WARNING — Focus Styles Use `:focus` Not `:focus-visible`

**File:** `assets/scss/components/_buttons.scss:18-22`

Custom button focus styles use `:focus` which shows outlines on mouse click (annoying for sighted users). Should use `:focus-visible` to only show on keyboard navigation.

---

### INFO — Prefers-Reduced-Motion Respected

`assets/js/about-video-section.js:7` correctly checks `prefers-reduced-motion: reduce` before applying animations. Good practice.

---

## 5. Deployment

### CRITICAL — Backup Files Tracked in Git

10+ backup files and a 19-file `z-old-files/` archive directory are tracked. These are deployed to staging/production via rsync, wasting bandwidth and exposing old code.

See the full list in [Structure & Code Quality > Backup Files](#info--backup-files-in-repository-10-files).

**Fix:** Delete files, add `*-backup*` pattern to `.gitignore`.

---

### CRITICAL — CSS Sourcemap Tracked

**File:** `assets/css/custom.css.map` (34 KB)

Sourcemap is tracked in git and deployed to production. Exposes full SCSS source structure to anyone who opens DevTools.

**Fix:** Add `*.css.map` to `.gitignore`, then `git rm --cached assets/css/custom.css.map`.

---

### WARNING — Incomplete `.gitignore`

Current `.gitignore` (4 lines):

```
.DS_Store
node_modules/
*.log
.env
```

**Missing patterns:**
- `*.css.map` — sourcemaps
- `*-backup*` — backup files
- `.vscode/`, `.idea/` — editor configs
- `.env.*`, `.env.local` — env variants
- `Thumbs.db` — Windows

---

### WARNING — No Production Deploy Workflow

Only `staging` branch has a GitHub Actions workflow. Per `WORKFLOW.md`: "main → auto-deploys to production — not yet wired."

**Fix:** Create `.github/workflows/deploy-production.yml` targeting the `main` branch and production server.

---

### WARNING — Workflow Only on `staging` Branch

The deploy workflow file (`.github/workflows/deploy-staging.yml`) only exists on the `staging` branch. The `dev` branch has no copy. This is technically correct (workflow only triggers on staging push), but means the workflow file isn't reviewed in normal dev PRs.

**Consider:** Adding the workflow file to `dev` and `main` branches so changes are tracked across all branches.

---

### INFO — Hardcoded Dev Domain in package.json

**File:** `package.json`

```json
"dev": "browser-sync start --proxy 'http://falconlocaldev2026v2.local' ..."
```

Environment-specific. Document this or use an env variable.

---

### INFO — Version Never Incremented

`package.json` version is `1.0.0` and has never been bumped. Not critical for a child theme but loses changelog value.

---

### INFO — No Sensitive Data Found

No API keys, passwords, or tokens in source files. SSH credentials properly stored in GitHub Secrets. Hostinger connection details only in the workflow file (not exposed in theme source).

---

### INFO — rsync `--delete` Flag

The staging deploy uses `rsync --delete`, which removes files from the server that aren't in the repo. This is correct behavior but means any server-side uploads in the theme directory would be wiped. Ensure uploads go to `/wp-content/uploads/`, not the theme directory.

---

## Recommended Priority Order

### Immediate (before next deploy)
1. Fix heading hierarchy in all 12 category templates
2. Add `loading="lazy"` to below-the-fold images
3. Add skip-to-content navigation link
4. Fix gallery modal alt text handling
5. Escape `the_title()` in product loop alt attributes
6. Add `*.css.map` to `.gitignore`

### Short-term
7. Delete all backup files and `z-old-files/` directory
8. Delete unused SCSS files (`_saw-trucks`, `_water-trucks`, `_old-categories`, `_old-service-bodies`)
9. Remove dead `initCustomInteractions()` function from `custom.js`
10. Remove `console.log('Custom JS loaded')` from `custom.js`
11. Fix `--text-muted` color contrast (fails WCAG AA)
12. Add font preconnect hints
13. Verify Yoast SEO handles schema, canonicals, and OG tags

### Medium-term
14. Create production deploy workflow for `main` branch
15. Implement responsive images with srcset
16. Consider CSS code splitting
17. Update `.gitignore` with comprehensive patterns
18. Remove unused dependencies (`rellax`, `nodemon`)
19. Add `:focus-visible` to button focus styles
20. Add ARIA attributes to mobile menu and FAQ toggles
