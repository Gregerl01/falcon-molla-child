# Falcon Truck Bodies — Workflow (Authoritative)

Two environments. Local and Live. Staging is retired; ignore stg.falconbodies.com.

## Where code lives
- **Local** (your Mac): where you build and test. falconlocaldev2026v2.local
- **GitHub `dev`**: always-current backup and source of truth for code.
- **Live** (falconbodies.com): the public site. Changes only on purpose.

## The build-and-deploy loop (every change)
1. Work on `dev`, locally. Test on the local site until it looks right.
2. If you touched SCSS, run `npm run sass` to rebuild the CSS.
3. Save it up: `git add <specific files>`, `git commit -m "what changed"`, `git push origin dev`.
4. To publish to live: merge `dev` into `main` and push. The pipeline deploys the whole theme at once. Then purge LiteSpeed cache and check live in incognito.

## Hard rules (these prevent the disasters that have already happened)
- **Never use AIO (All-in-One WP Migration) to move code.** AIO overwrites the hidden `.git` folder and scrambles history. This caused the May reconciliation mess. AIO is content-only, live → local only, and even then see the safe-pull section below.
- **Deploy to live only by merging to `main`.** Never hand-SCP files to live except a true emergency hotfix, and if you do, immediately commit the same fix to `dev` so they don't drift.
- **Code lives in Git. Content lives in WordPress.** Pages, products, menus, plugin settings, and page-builder sections (like #about-us) are edited on live and never pushed up from local.
- **Stage files by name, never `git add -A`.** (The one exception was the one-time full snapshot during reconciliation.)
- Keep `_save-*.php`, `_fix-*.php`, `_*-meta.json` gitignored. They're import scratch, never committed.

## Getting data between environments without breaking things
Three kinds of data, three different pipes. Using the wrong pipe is what broke things before.

1. **Theme code** (PHP, SCSS, CSS, JS, templates) → **Git only.** Never AIO, never SCP-by-hand.
2. **Simple product content** (titles, prices, basic fields, categories) → **WooCommerce CSV export/import.** On live: Products → Export. On local: Products → Import. Touches only the database, never the theme or git. Note: product images may not come through the CSV; copy any missing image into the local media library by hand.
3. **Configuration tab JSON / complex structured data** → **never CSV, never spreadsheet.** A spreadsheet import mangles the JSON and destroys the tab data (this is what started the May breakage). Instead use the per-product `.json` files + `_save-all-meta.php` save-script, run once per environment against that environment's post IDs. See falcon-product-import-SKILL.md for the post-ID tables and the exact steps.

### Worked example: "I added products on live, I need them on local to style"
- DO: WooCommerce CSV export on live → CSV import on local for the simple fields. Then run the save-script locally to populate the configuration JSON for those products. Copy any missing product images by hand.
- DON'T: pull the whole site down with AIO to get a few products. That's what wrecked git.

## If you ever genuinely must use AIO
Back up the `.git` folder first, run the AIO import, then restore the `.git` folder over the top. Last resort only. Prefer the methods above.
