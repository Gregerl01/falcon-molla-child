# Falcon Truck Bodies — Design System

Source of truth: `assets/scss/base/_colors.scss`, `_variables.scss`, `_typography.scss`, `_mixins.scss`, `_global.scss`.
Compiled output: `assets/css/custom.css`.

All visual styling flows from a single set of CSS custom properties exposed on `:root` (light mode default) and overridden under `[data-theme="dark"]`. SCSS variables exist for non-themable structural values (breakpoints, padding scales, z-index).

---

## 1. Brand

| Token | Value | Role |
|---|---|---|
| `--color-primary` | `#208bf4` | Brand blue — accent, CTAs, links, focus rings |
| `--accent-color` | `var(--color-primary)` | Alias used everywhere components reference accent |
| `--color-primary-rgb` | `32, 139, 244` | RGB triplet for `rgba()` glow/shadow effects |

Brand blue is the **only** accent. Every interactive accent (button background, eyebrow rule, icon box, slider arrows, focus outline) resolves to `var(--accent-color)`.

---

## 2. Color Palette

Base SCSS map (`$colors` in `_colors.scss`) — used to generate `.bg-*`, `.text-*`, `.border-*` utilities for every token.

| Token | Hex | Use |
|---|---|---|
| `primary` | `#208bf4` | Brand |
| `primary-dark` | `darken(primary, 10%)` | Hover states |
| `primary-light` | `lighten(primary, 10%)` | Tints |
| `white` | `#ffffff` | Surfaces, text on dark |
| `black` | `#060606` | Dark-mode page bg |
| `gray-100` | `#f4f7f6` | Light-mode page bg |
| `gray-200` | `#e9ecef` | — |
| `gray-300` | `#dee2e6` | Light borders |
| `gray-400` | `#ced4da` | — |
| `gray-500` | `#adb5bd` | Muted text |
| `gray-600` | `#777777` | Secondary text |
| `gray-700` | `#52565e` | Dark surface 2 |
| `gray-800` | `#343a40` | Dark surface 1 |
| `gray-900` | `#252525` | Primary text (light mode) |
| `success` | `#28a745` | Positive states |
| `warning` | `#ffc107` | Caution |
| `danger`  | `#dc3545` | Error |
| `info`    | `#17a2b8` | Info |

---

## 3. Semantic Tokens (CSS Custom Properties)

Components should reference these, **not** the raw palette.

### Page & Sections

| Token | Light | Dark |
|---|---|---|
| `--bg-page` | `gray-100` | `black` |
| `--section-primary` | `white` | `black` |
| `--section-secondary` | `gray-100` | `gray-800` |

### Text

| Token | Light | Dark |
|---|---|---|
| `--text-primary` | `gray-900` | `white` |
| `--text-secondary` | `gray-600` | `gray-300` |
| `--text-muted` | `gray-500` | `gray-500` |
| `--heading-color` | `var(--text-primary)` | `var(--text-primary)` |

Heading and body color defaults are applied globally:
- `h1–h6` → `var(--text-primary)`
- `p, li, span` → `var(--text-secondary)`
- `.muted` → `var(--text-muted)`

### Surfaces (cards, panels)

| Token | Light | Dark |
|---|---|---|
| `--surface` | `#f1f1f1` | `#151616` |
| `--surface-1` (`--bg-card`) | `#e3e3e3` | `#111315` |
| `--surface-2` (`--bg-card-subtle`) | `#e4e4e4` | `#1d1e1f` |
| `--surface-hover` | `#eef1f5` | `#22262a` |
| `--surface-border` | `rgba(0,0,0,0.06)` | `rgba(255,255,255,0.08)` |

Helper classes: `.surface`, `.surface--subtle`, `.surface--hoverable`.

### Borders, Shadows, Overlays

| Token | Light | Dark |
|---|---|---|
| `--border-color` | `gray-300` | `rgba(255,255,255,0.08)` |
| `--shadow-card` | `0 6px 18px rgba(0,0,0,0.08)` | `0 8px 24px rgba(0,0,0,0.6)` |
| `--overlay-image` | `rgba(0,0,0,0.55)` | `rgba(0,0,0,0.65)` |
| `--text-on-image` | `white` | `white` |

### Header & Footer — Locked Dark

The header and footer do **not** flip with theme — they remain dark on both modes by design.

```
--header-bg:      #111111
--header-text:    #ffffff
--header-border:  rgba(255,255,255,0.08)
--footer-bg:      #111111
--footer-top-bg:  #252525
--footer-text:    #ffffff
```

### Navigation

```
--nav-color:                         #ffffff
--nav-hover-color:                   #ffffff
--nav-mobile-background-color:       #ffffff
--nav-dropdown-background-color:     #ffffff
--nav-dropdown-color:                #252525
--nav-dropdown-hover-color:          #208bf4
```

---

## 4. Typography

Font stack defined once in `_typography.scss`:

```scss
$font-heading: 'Inter', sans-serif;
$font-body:    'Inter', sans-serif;
```

### Scale

| Element | Size | Weight | Tracking | Case |
|---|---|---|---|---|
| `h1` | `3.5rem` (mobile `2.5rem`) | `900` | `2px` | UPPERCASE |
| `h2` | `2.25rem` (mobile `2rem`) | `600` | `2px` | UPPERCASE |
| `h3, h4, h6` | inherits 700 / 1px / UPPERCASE | `700` | `1px` | UPPERCASE |
| `h5` | `1.25rem` | `600` | — | UPPERCASE |
| `body` | 16px | `400` | — | — |
| `p` | inherits | `200` (light) | — | — |

### Line Height
- Headings: `1.1` – `1.2`
- Body: `1.6`

### Hero Headline
Fluid: `clamp(3rem, 6vw, 8.5rem)`, weight `900`, tracking `-0.02em`, line-height `1.02`.

### Utility classes
`.text-uppercase`, `.text-capitalize`, `.letter-spacing-sm` (0.5px), `.letter-spacing-md` (1px), `.letter-spacing-lg` (2px).

---

## 5. Spacing

Scale exposed as CSS variables:

| Token | Value |
|---|---|
| `--spacing-xs` | `0.25rem` (4px) |
| `--spacing-sm` | `0.5rem` (8px) |
| `--spacing-md` | `1rem` (16px) |
| `--spacing-lg` | `1.5rem` (24px) |
| `--spacing-xl` | `2rem` (32px) |
| `--spacing-2xl` | `3rem` (48px) |

### Section Rhythm (vertical)

| Breakpoint | Padding |
|---|---|
| `< 768px` | `40px 0` |
| `768–991px` | `60px 0` |
| `≥ 992px` | `80px 0` (`100px` for `.section` color rule) |

SCSS vars: `$section-padding: 80px`, `$section-padding-md: 60px`, `$section-padding-sm: 40px`, `$section-scroll-margin: 92px`.

---

## 6. Layout

| Token | Value | Notes |
|---|---|---|
| `$max-width-1500` | `1500px` | Wide-container util: `.max-w-1500` |
| `$header-offset` | `100px` | Used for scroll offsets |
| `.custom-container` | Bootstrap container mixin | |
| `.custom-row` | Bootstrap row mixin | |

### Section Classes
- `.section` — base, theme-aware via `--section-primary`
- `.section--alt` — uses `--section-secondary`
- `.section--image` — background image + `--overlay-image` pseudo-element

### Section Title Pattern
`.section-title h2` renders flanked by 50×2px accent rules (`::before` and `::after`), hidden below 768px.

---

## 7. Borders, Radius, Shadows, Transitions, Z-index

### Radius
| Token | Value | Use |
|---|---|---|
| `$border-radius-pill` | `50px` | Buttons (default) |
| `$border-radius-none` | `0` | Cards, icon boxes |
| `.btn-pill` | `999px` | Override |
| `.btn-rounded` | `8px` | Override |
| `.btn-square` | `0` | Override |

Cards (`.featured-card`) and icon boxes use **square corners (radius 0)** by design.

### Shadows
- `--shadow-card` — see semantic tokens above.
- Card hover: `0 2px 12px rgba(0,0,0,0.25)`.
- CTA hover glow: `0 4px 12px rgba(var(--color-primary-rgb), 0.3)`.

### Transitions
| Token | Value |
|---|---|
| `--transition-base` | `all 0.3s ease` |
| `--transition-fast` | `all 0.15s ease` |
| `--transition-slow` | `all 0.5s ease` |
| `$transition-default` | `0.3s ease` |
| `$transition-smooth` | `0.25s ease-out` |

### Z-index Scale
```
$z-index-header:   100
$z-index-modal:    200
$z-index-overlay:  50
```

---

## 8. Components

### 8.1 Buttons (`components/_buttons.scss`)

Base `.btn`: pill, `1.2rem 3rem`, `1.4rem` / weight `700`, lift `-2px` on hover.

| Variant | Bg | Border | Text | Hover |
|---|---|---|---|---|
| `.btn-primary` | `--accent-color` | `--accent-color` | white | accent + 10% black, blue glow |
| `.btn-outline` | transparent | `--text-primary` | `--text-primary` | inverts to fill |
| `.btn-secondary` | transparent | `--accent-color` | `--accent-color` | inverts to fill |

Sizes: `.btn-sm` (0.8rem×2rem / 1.2rem), `.btn-lg` (1.5rem×4rem / 1.6rem), `.btn-block` (full width).

### 8.2 Featured Cards (`components/_featured-cards.scss`)

```
.featured-card {
  padding: 40px;
  background: var(--surface);
  border: 1px solid var(--surface-border);
  border-radius: 0;
  shadow: 0 2px 12px rgba(0,0,0,0.08);
}
.featured-card:hover { translateY(-6px); shadow heavier; bg → --surface-hover; }
```

Composition:
- **Icon box** (`70×70`, accent bg, square) anchored top-left.
- **Arrow link** (`44×44` circle, accent, rotated -45°) flies in from off-card on hover.
- **Image** (`220px` height, `object-fit: cover`).
- **Service number** with 70px accent rule (`.service-number::after`).

### 8.3 Hero — Homepage (`components/_hero-banner.scss`)

`.hero--home`:
- Full-bleed (`100dvh`), background image set via inline `--hero-bg-desktop` / `--hero-bg-mobile`.
- L→R dark gradient overlay (55% → 20%) for left-column legibility; mobile swaps to top-down 65% → 0%.
- Parallax via `assets/js/hero-parallax.js`; disabled `≤768px` and for `prefers-reduced-motion`.

Children:
- `.hero__eyebrow` — `1.75rem` / weight 700 / tracking 3px / UPPERCASE / accent color, with leading `4rem × 3px` rule via `::before`.
- `.hero__title` — `clamp(3rem, 6vw, 8.5rem)` / weight 900 / `-0.02em` / line-height 1.02.
- `.hero__title-muted` — opacity 0.5 inline span for de-emphasized fragments.
- `.hero__lead` — `1.75rem` / weight 300 / `rgba(255,255,255,0.78)`.
- `.hero__actions` — flex wrap, single CTA uses global `.btn.btn-primary.btn-pill`.

### 8.4 Header (`layout/_header.scss`)

- Locked-dark bar (`--header-bg`), no theme flip.
- Logo capped at `100px`.
- `.theme-toggle-btn` — 38×38 circle (34×34 mobile), focus ring `--color-primary`, scale 0.95 on press.

### 8.5 Other Components Available

`components/`: `_about-video-section`, `_benefits`, `_call-to-action`, `_cards`, `_category-cards`, `_category-sections`, `_configurations`, `_faq`, `_feature-split`, `_images`, `_parallax`, `_sections`, `_testimonials`.

`layout/`: `_navigation`, `_footer`.

---

## 9. Mixins & Functions (`_mixins.scss`, `_colors.scss`)

```scss
@include accent-border($opacity: 85%);   // 1px border tinted via color-mix
@include accent-background($opacity: 95%);
@include button-primary-hover;
@include smooth-transition($property: all, $duration: 0.3s);
@include theme-colors;                    // bg + text from current theme
@function color-contrast($color);         // returns black/white for legibility
```

Utility generators (loops over `$colors`):
- `.bg-{name}`, `.text-{name}`, `.border-{name}` for every palette token.
- `.opacity-10` through `.opacity-90`.

`.gradient-divider` — 1px radial accent fade for soft dividers.

---

## 10. Theming Mechanism

Theme is toggled by setting `data-theme="dark"` on a root element (currently controlled via JS toggle in the header).

Pattern:
```css
:root { --token: light-value; }
[data-theme="dark"] { --token: dark-value; }
```

**Locked-dark elements** (`header.header`, `footer`) ignore the toggle by using fixed `--header-bg` / `--footer-bg` values that are not redefined under `[data-theme="dark"]`.

When adding new components, always:
1. Reference semantic tokens, not raw palette colors.
2. If a token doesn't exist for the role you need, add it to `:root` and `[data-theme="dark"]` in `_colors.scss` before using it.

---

## 11. SCSS Architecture

```
assets/scss/
├── custom.scss              # main entry — imports everything
├── base/
│   ├── _variables.scss      # SCSS structural vars (breakpoints, padding scale, z-index)
│   ├── _colors.scss         # palette + CSS custom properties (light/dark)
│   ├── _typography.scss     # font stack, heading scale, text utilities
│   ├── _global.scss         # .section, .section-title, scroll-to-top
│   ├── _mixins.scss         # accent-border, button hovers, transitions
│   └── _molla-overrides.scss # parent theme corrections
├── layout/                  # header, navigation, footer
├── components/              # buttons, hero, cards, faq, testimonials…
├── pages/                   # per-page styles (home, contractor-bodies, …)
├── woocommerce/             # product-lists, product-single, tabs, gallery
├── blog/                    # blog list & single
└── utilities/               # helpers
```

### Category Page Prefixes
Each truck-body page scopes its styles with a short prefix (e.g. `.sb` service bodies, `.cb` contractor bodies, `.chb` chipper bodies, etc.). See `assets/scss/pages/*`.

---

## 12. Vendor Stack

- **Bootstrap 5** — selectively imported (`functions`, `variables`, `maps`, `mixins`, `utilities`, `root`, `reboot`, `type`, `grid`, `buttons`, `containers`, `modal`).
- **Swiper** — sliders (featured-cards, testimonials, hero variants).
- **Bootstrap Icons** — loaded via CDN in `functions.php`, not compiled in.
- **Parent theme** — Molla; overrides live in `base/_molla-overrides.scss`.

---

## 13. Build

```
sass assets/scss/custom.scss assets/css/custom.css
```

Dart Sass; legacy `@import` syntax (not the modular `@use`/`@forward` system). Sourcemap committed alongside CSS.
