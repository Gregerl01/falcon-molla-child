# Falcon Truck Bodies – Development & Deployment Workflow

This document defines the **official workflow** for developing, staging, and deploying the Falcon Truck Bodies website.  
It exists to prevent mistakes, reduce friction, and ensure consistency across environments.

All contributors, tools, and AI assistants must follow this workflow unless explicitly approved otherwise.

---

## 🎯 Project Goals

- Maintain a stable production site at all times
- Use staging as the review and approval environment
- Use Git for **code**, not database/content
- Avoid daily full-site migrations
- Enable fast, safe CSS/JS/template updates
- Minimize busywork and risk

---

## 🌎 Environments

### 1) Local Development
- Local WordPress environment
- VS Code for all code edits
- NPM used locally for asset compilation
- No production credentials
- Used for development and experimentation

### 2) Staging
- Domain: `stg.falconbodies.com`
- Hosted on Hostinger
- Mirrors production structure
- Used for:
  - Team review
  - Client approval
  - Pre-production validation

### 3) Production
- Domain: `falconbodies.com`
- Must remain stable
- Changes only applied after staging approval

---

## 🧱 Code vs Database Separation (Critical Rule)

### A) Code (Git-controlled, auto-deployed)

Stored in the **child theme repository** and deployed automatically:

- PHP templates
- Template parts
- functions.php
- WooCommerce overrides
- SCSS / CSS
- JavaScript
- Theme assets (icons, SVGs, UI images)
- Compiled build output (`dist/`)

Git is the **source of truth** for all of the above.

---

### B) Database / Content (NOT in Git)

Handled intentionally via WordPress tools:

- Page/post content
- Menus
- Widget placement
- Plugin settings
- Media Library uploads
- Theme options stored in DB

These are **not** deployed via Git.

---

## 🔁 Deployment Strategy

### Git Branching
- `main` → auto-deploys to **product - not wired yet**
- `staging` → auto-deploys to **staging**

### Deployment Method
- GitHub Actions
- SSH + rsync
- Only the child theme is synced:
- No WordPress core files, plugins, or uploads directories are deployed via Git

### Exclusions
- `node_modules/`
- `.env`
- logs (e.g. `*.log`, `/logs/`, `/storage/logs/`)
- OS files (e.g. `.DS_Store`, `Thumbs.db`)

### Build Process
- `npm run dev` → local development (watch)
- `npm run build` → production-ready assets (minified/lean)
- Built assets **are committed** and deployed (example: `assets/dist/` or your configured output folder)
- Hostinger does **not** run NPM builds (server receives compiled output only)

---

## 🧩 Plugin Management Workflow

Plugins are **not** deployed via Git.

### Adding a Plugin (Example: Dealer Locator)

Preferred approach:
- Install/configure on **staging** first (closest to production), unless local is required for development/testing.

Process:
1. Install and configure on **staging** (or local if needed)
2. Test functionality on staging
3. Promote to production after approval:
   - Install same plugin + version
   - Reapply settings manually or via plugin export/import (if supported)
   - Create/import any required pages/shortcodes/widgets

Git is only used for:
- Theme integration
- CSS/JS overrides
- Template wrappers
- Shortcode helpers

---

## 🖼️ Images & Media

### Git should contain (theme assets only):
- Theme icons
- SVGs
- UI graphics
- Decorative assets referenced by templates/CSS

### Git should NOT contain (content media):
- Media Library uploads
- Content images (hero photos, galleries, blog images)
- Customer/client-provided photos intended for Media Library

Media moves via:
- All-in-One WP Migration (intentional)
- WP Export/Import (pages + attachments when needed)
- Manual Media Library uploads (small changes)

---

## 🔄 Migration Strategy

### Used For:
- Initial environment setup
- Large content changes
- Structural DB changes
- Production cutover

### Not Used For:
- Daily CSS changes
- Template updates
- Small content edits

### Preferred Tools:
- All-in-One WP Migration
- WordPress Export/Import (pages only, when applicable)
- Plugin-specific export tools (when available)

---

## 🧪 Release Checklist (Staging → Production)

Before production deploy:
- [ ] Code merged into `dev`
- [ ] GitHub Action deploy succeeds
- [ ] Cache cleared (LiteSpeed / theme cache)
- [ ] Smoke test: Home, key category page(s), contact form, mobile navigation