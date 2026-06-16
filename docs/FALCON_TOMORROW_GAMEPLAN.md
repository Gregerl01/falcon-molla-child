# Falcon Site — Tomorrow's Game Plan

**North star:** every "featured section" (category intro, product feature blocks, `#about-us`, showcase) uses ONE shared pattern + ONE design-token type scale. Build and style it once, inherit everywhere. Stop maintaining look-alike copies. This is the DRY fix for the whole thing we fought tonight.

Pairs with `FALCON_TYPE_SYSTEM_SPEC.md` (the token spec) — this plan executes it and extends it to component structure.

---

## Already done — do not redo

Live and verified on production:
- Chipper product + meta (tabs render, temp files cleaned off server)
- `configurations.js` static-product fix
- Showcase image `contain` fix *(verify it actually SCP'd to prod)*
- Dump + water category images (all 14, confirmed resolving)

Local only, uncommitted:
- Homepage category-card fixes (removed fixed height, kept `overflow:hidden`, `align-items:flex-start`, `object-fit:contain`)
- `#about-us` scoped overrides (image contain + clamp type) — **throwaway. These get deleted and replaced by the repoint in Phase C. Do not keep them.**

Not built yet: the design tokens. The spec exists; implementation is Phase A.

---

## Step 0 — Git reconciliation (GATE, do first) · ~30–45 min

Why first: this work is too broad to hot-SCP file-by-file. It needs a staging review surface, which needs a clean git baseline. It also buys per-phase rollback for the rest of the day.

1. Precondition: add `_*-meta.json`, `_save-*.php`, `_fix-*.php` to `.gitignore`; delete the stray `woocommerce/gemini-*.jpeg`.
2. Fresh-clone-and-swap, local files are truth, overwrite stale `origin/dev`.
3. Before pushing, verify the "deleted" items are intentional: docs moved into `docs/`, plus `single-product.php` and `theme-toggle.php`. Don't propagate a deletion you didn't mean.
4. Confirm `.github/` workflows are intact and paths are hardcoded (April 6 caution).
5. Push `dev` clean; confirm the staging deploy fires and passes.

Paste `git status` and `git remote -v` at the start so the exact swap sequence can be written against real state, not blind.

---

## Phase A — Design tokens (type system) · ~45–60 min

From `FALCON_TYPE_SYSTEM_SPEC.md`:
- Create `base/_design-tokens.scss` (the `:root` clamp tokens).
- Create/extend `base/_typography.scss` (bare `h1`–`h6`, `p`, `li` → tokens).
- Import tokens first, then typography, before components/pages in `custom.scss`.

This is the "fonts shrink uniformly on small screens" win, delivered once for the whole site. Test locally at multiple widths. Do not deploy yet.

---

## Phase B — Define the ONE canonical feature section · ~30 min

The "good" section (the category/product feature block) is the reference. Its pattern:
`row g-0 align-items-stretch` · `.image-frame` · `.feature-content-wrap` · `.falcon-headline` · `.falcon-intro` · `.falcon-benefits` · `.benefit-content h3`.

- Consolidate all feature-section CSS into the shared `_category-sections.scss`, referencing tokens. Remove per-section duplicate rules.
- Decide delivery for template-driven instances: a single `template-parts/sections/feature-split.php` partial, or a documented/saved block pattern, so they share one source instead of being re-typed.

---

## Phase C — Migrate the divergent sections onto the pattern · ~60–90 min

- **`#about-us` (lives in page-builder/DB):** rebuild its content using the shared classes. Strip the inline styles (image `min-height:100%`, content `padding`/`max-width`). Delete the throwaway scoped `#about-us` overrides from last night. This kills the three bugs we traced *at the source*:
  - 10px paragraph beating the scoped rule
  - first benefit icon offset ~9px
  - stretched/distorted image
- **Verify the existing on-pattern sections** (category pages, product feature blocks, showcase) still match after the token + consolidation changes.

---

## Phase D — Image fit + responsive type, inherited not patched

Once the divergent sections use the shared classes, `contain` image behavior and clamp type come from the shared component + tokens automatically. No per-section overrides anywhere. Confirm this is true (no lingering `#about-us`-scoped rules).

---

## Honest WordPress DRY ceiling

- Template-driven sections can share a `template-part` — truly DRY.
- DB/builder sections (`#about-us`, the homepage cards) cannot include a PHP partial. The realistic DRY there is: same shared CSS classes + a saved block pattern, and migrate the one-offs onto it. Fully DRY where the architecture allows, deliberately consolidated where it doesn't.

---

## Homepage category cards — scope note

The overlay cards are a *different* component (image with text overlay), not the feature-split pattern. Recommend they stay their own component rather than forcing them into the feature system. Decide at the start whether they're in scope tomorrow or left as-is (they're already fixed and look good).

---

## Deploy

Through **staging**, not hot-SCP. Test matrix: home, one category, a product, the showcase, `#about-us` at ~390 / 768 / 1100 / 1500. Then promote to production.

---

## Open decisions to settle at the start

1. Token values — defaulted in the spec (h4=20, body=16, hero=display, eyebrow=14); confirm or adjust.
2. Feature-split delivery — `template-part` vs saved block pattern.
3. Homepage overlay cards — in scope or leave as their own component (recommend leave).

---

## Rough timing

Step 0: 30–45m · A: 45–60m · B: 30m · C: 60–90m · D: folded in · test + deploy: 30–45m.
Realistically a focused half-day. Order is fixed: reconciliation → tokens → canonical pattern → migrate → deploy.
