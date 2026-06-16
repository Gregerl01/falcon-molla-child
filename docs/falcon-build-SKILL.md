# Falcon Truck Bodies — Build Skill

This skill contains everything needed to work on the Falcon Truck Bodies website. Read this before making any changes.

---

## Project Overview

**Client:** Falcon Truck Bodies (falcontruckbodies.com / falconbodies.com)
**Theme:** Molla parent theme + custom child theme (Falcon Molla)
**Platform:** WordPress + WooCommerce
**Repo:** github.com/Gregerl01/falcon-molla-child

---

## Environments

| Environment | Domain | Deploy Method |
|---|---|---|
| Local | falconlocaldev2026v2.local | Manual (LocalWP) |
| Staging | stg.falconbodies.com | Auto via GitHub Actions (staging branch) |
| Production | falconbodies.com | Not wired yet (main branch) |

**Hostinger SSH:** u772682663@92.112.191.78 port 65002
**GitHub Actions Secret:** SSH_KEY (shared across Falcon, GSL, RF Supplements repos)

---

## Git Branching

- dev — primary working branch
- staging — auto-deploys to stg.falconbodies.com on push
- main — production (deploy workflow not yet created)

**Deploy flow:** dev → merge into staging → push → GitHub Actions rsync to Hostinger

**Critical:** .github/workflows/deploy-staging.yml only exists on staging branch. Dev does not have it. Merges from dev do NOT delete it.

---

## Database vs Git Boundary (Critical Rule)

**Git deploys (code):**
- PHP templates, functions.php, template parts
- SCSS / compiled CSS / JavaScript
- Theme assets (icons, SVGs, UI images)
- WooCommerce template overrides

**Database (NOT in Git, must replicate manually per environment):**
- Page/post content, shortcode placement
- WooCommerce products, categories, category thumbnails
- Menus, widgets, plugin settings
- Media Library uploads
- Theme options stored in DB

This is the #1 source of staging/production divergence.

---

## SCSS Pipeline

- **Compiler:** Dart Sass (no bundler)
- **Command:** npm run sass
- **Entry:** assets/scss/custom.scss
- **Output:** assets/css/custom.css
- **Compiled CSS is committed to Git** (Hostinger does not run npm)
- Bootstrap deprecation warnings are expected and harmless

---

## Styling Conventions

- **BEM naming:** .block__element--modifier
- **Dark/light mode:** data-theme attribute + CSS custom properties
- **AOS animations:** Conditionally loaded via functions.php
- **Bootstrap Icons:** CDN (cdn.jsdelivr.net), unconditional enqueue
- **Accent color:** --accent-color (Falcon blue)

---

## Known Issues / Gotchas

1. **Molla strips Bootstrap utility classes.** flex-row-reverse, d-flex, etc. may not work. Use custom classes with !important. Example: .is-reversed class on Falcon Bodies showcase.

2. **WooCommerce tab content quality.** HTML comments from AI-generated import content can break grid layouts. Data quality issue per product, not theme code.

3. **Transient GitHub Actions failures.** SSH timeouts happen occasionally. Re-run the job before debugging code.

4. **Screenshots of dark sections render black.** Use javascript_exec queries instead of screenshots for dark-themed sections.

5. **CSS specificity battles.** Debug pattern: fetch raw CSS via fetch() in console, inject style tag to test fix, use window.getComputedStyle() to confirm cascade winner.

6. **node_modules not deployed.** Any dependency loaded from node_modules at runtime will 404 on staging/production. Use CDN or copy to assets/vendor/.

7. **SSH_KEY is shared.** Falcon, GSL, and RF Supplements repos share the same Hostinger SSH key. If one repo regenerates it, update all three GitHub secrets.

---

## Category Page Architecture

All 12 category taxonomy templates share a unified product loop pattern:

Row classes: g-0 align-items-stretch overflow-hidden max-w-1500 mx-auto
Image: image-frame w-100 wrapper, full-size images
Content: feature-content-wrap with falcon-feature-block structure
Bullets: benefit-item with benefit-icon (bi-lightning-fill) + benefit-content
CTA: btn btn-primary "Learn More"
AOS: fade-right on image, fade-left on content (swap when reversed)

Page-level SCSS (assets/scss/pages/) contains ONLY hero styles. Shared section styles live in _category-sections.scss.

---

## Falcon Bodies Showcase Page

- **Template:** page-templates/page-falcon-bodies.php (Template Name: Falcon Bodies Showcase)
- **Loops through 9 categories** with hardcoded descriptions/bullets + dynamic WooCommerce thumbnails/URLs
- **Alternating layout:** is-reversed class on odd sections, CSS flex-direction: row-reverse !important
- **Empty categories:** Show "Coming Soon" instead of CTA button (checks $term->count)
- **Scoped styles:** All showcase-specific CSS under .falcon-bodies-showcase

---

## Completed Features

- [x] About Video Section shortcode (parallax, modal, sonar pulse)
- [x] Falcon Bodies Showcase page (9 stacked category sections)
- [x] Dark/light mode system
- [x] Category page product loops (unified pattern)
- [x] Bootstrap Icons CDN migration
- [x] GitHub Actions staging deploy pipeline
- [x] Full site audit (docs/SITE_AUDIT.md)

---

## Pending Work (from Site Audit — March 2026)

### Immediate (before next deploy)
- [ ] Fix heading hierarchy in all 12 category templates
- [ ] Add loading="lazy" to below-fold images
- [ ] Add skip-to-content nav link
- [ ] Fix gallery modal alt text
- [ ] Escape the_title() in product loop alt attributes
- [ ] Add *.css.map to .gitignore

### Short-term
- [ ] Delete all backup files and z-old-files/
- [ ] Delete unused SCSS files
- [ ] Remove dead JS functions and console.log
- [ ] Fix --text-muted color contrast
- [ ] Add font preconnect hints
- [ ] Verify Yoast SEO handles schema/canonicals/OG

### Medium-term
- [ ] Create production deploy workflow
- [ ] Implement responsive images with srcset
- [ ] Evaluate CSS code splitting
- [ ] FMB product page buildout (FMB56, FMB60, FMB84, FMB120)

---

## Developer Workflow

1. **Two-tool pattern:** Claude Chat for strategy/architecture. Claude Code for file edits.
2. **Claude Code mode:** Run with --dangerously-skip-permissions for uninterrupted execution.
3. **Deploy:** Commit on dev → merge into staging → push → GitHub Actions deploys automatically.
4. **SCSS changes:** Always run npm run sass after editing SCSS. Commit compiled CSS.
5. **Testing:** Test locally first, then push to staging.
6. **Browser debugging:** Chrome extension with javascript_exec for inspecting computed styles.
