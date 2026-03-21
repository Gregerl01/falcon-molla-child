# Falcon Truck Bodies — Product Import Skill

This skill defines the process for importing products into the Falcon Truck Bodies website. Read this before adding any new products or categories.

---

## Architecture Overview

Products use a **custom meta + theme rendering** approach. No HTML is stored in WooCommerce tab content fields. Instead:

- `_falcon_config_json` custom field stores configuration/spec data as JSON
- `_falcon_tech_overview` custom field stores the condensed description as JSON
- PHP functions in `functions.php` read the meta and render the tab HTML
- `configurations.js` handles interactive toggles (SRW/DRW, Flat/Flip Top, etc.)
- `_configurations.scss` provides all styling (dark/light mode compatible)

The hero section (post_excerpt) still uses the `falcon-feature-block` HTML pattern with lightning bolt bullets — this is imported via WP All Import CSV.

---

## Product Data Structure

### Hero Section (post_excerpt)
Standard falcon-feature-block HTML with 4 benefit items. This goes in the CSV `post_excerpt` field.

### Description Tab (_falcon_tech_overview)
JSON with three arrays:
```json
{
  "construction": [
    ["Body panels", "14-ga galvanneal steel (front, rear, bed sides, wheel panels, bulkhead)"],
    ["Interior", "16-ga galvanneal walls and doors"],
    ["Understructure", "Formed 10-ga HR steel with 1/8″ HR treadplate floor"],
    ["Finish", "Powder-coated to match body color"]
  ],
  "dimensions": [
    ["Cab-to-axle", "56CA"],
    ["Body length", "98″"],
    ["Width", "77.5″ (SRW) / 94″ (DRW)"]
  ],
  "standard": [
    ["Bumper", "14-ga galvanneal universal bumper..."],
    ["Doors", "Flush-mounted, stainless piano hinges..."]
  ]
}
```

### Configurations Tab (_falcon_config_json)
JSON with toggles, compartments, and dimension data:
```json
{
  "prefix": "fsb56",
  "static": false,
  "subtitle": "56CA service body — select your configuration to view dimensions.",
  "toggles": [
    {
      "key": "chassis",
      "default": "srw",
      "options": [
        {"value": "srw", "label": "SRW"},
        {"value": "drw", "label": "DRW"}
      ]
    },
    {
      "key": "top",
      "default": "flat",
      "options": [
        {"value": "flat", "label": "Flat Top (40″)"},
        {"value": "flip", "label": "Flip Top (42.5″)"}
      ]
    }
  ],
  "compartments": [
    {
      "title": "Streetside",
      "type": "Compartment size / door opening",
      "rows": [
        ["A — Front", "40″H × 34″W / 35″H × 30″W"],
        ["B — Horizontal", "20″H × 40″W / 15″H × 37″W"]
      ]
    }
  ],
  "data": {
    "srw-flat": {
      "body": [["Cab-to-axle","56CA"],["Body length","98″"]],
      "side": [["A","19.5″"],["B","40″"]],
      "rear": [["A","14″"],["B","49.5″"]]
    }
  }
}
```

For static products (single configuration, no toggles): set `"static": true` and `"toggles": []`. Use `"default"` as the single key in the data object.

### Gallery Tab (tab_content_2nd)
HTML with image grid and lightbox. Stored in WooCommerce custom tab field (database). Uses the `falcon-product-gallery` class structure. This remains in the CSV/database — not converted to custom meta.

---

## Character Encoding Rules

**CRITICAL:** Use Unicode characters in all JSON, never escaped quotes:
- Inch marks: `″` (U+2033) not `\"` or `"`
- Em dash: `—` (U+2014) not `--`
- Multiplication sign: `×` (U+00D7) not `x`

This prevents JSON parsing failures when WordPress processes the data via `wp_slash()` and `update_post_meta()`.

---

## Import Workflow (Per Category)

### Step 1: Generate JSON Files
For each product in the category, create two JSON files:
- `{product}-config-meta.json` — configurations data
- `{product}-tech-meta.json` — technical overview data

Data sources:
- Compartment specs CSV (`Compartment_Specs_-_falcon_compartment_sizes.csv`)
- Product data CSV (per category)
- Client-provided spec sheets

### Step 2: Create Save Script
Create `_save-all-meta.php` with the correct post IDs for the target environment:
```php
$products = array(
    array('id' => POST_ID, 'label' => 'PRODUCT NAME', 'config' => '_product-config-meta.json', 'tech' => '_product-tech-meta.json'),
);
```

The script:
- Reads JSON from files in the theme root
- Validates JSON before saving
- Uses `wp_slash()` to preserve backslashes during `update_post_meta()`
- Fixes Gallery tab title if corrupted
- Reports char counts and validation status

### Step 3: Upload to Server
For local: files go directly in theme root
For staging/production: use SCP from terminal (not Claude Code — needs interactive password):
```bash
scp -P 65002 _save-all-meta.php _*-meta.json u772682663@92.112.191.78:/path/to/themes/molla-child/
```

### Step 4: Run the Script
Visit: `https://DOMAIN/wp-content/themes/molla-child/_save-all-meta.php`
Must be logged into WP admin.

### Step 5: Verify
Check each product page — all three tabs should render:
- Description: spec tables (construction, dimensions, standard)
- Configurations: toggles + dimension tables + compartment grid
- Gallery: image grid with lightbox

### Step 6: Clean Up
Delete ALL temp files from the server:
```bash
ssh -p 65002 u772682663@92.112.191.78 "rm /path/to/themes/molla-child/_save-all-meta.php /path/to/themes/molla-child/_*-meta.json"
```

---

## Environment Post IDs

### Local (falconlocaldev2026v2.local)
| Product | Post ID |
|---------|---------|
| STEEL FSB SERIES | 2411 |
| STEEL FSB56 SERIES | 2412 |
| STEEL FSB60 SERIES | 2413 |
| STEEL FSB84 SERIES | 2414 |

### Staging (stg.falconbodies.com)
| Product | Post ID |
|---------|---------|
| STEEL FSB SERIES | 2422 |
| STEEL FSB56 SERIES | 2423 |
| STEEL FSB60 SERIES | 2424 |
| STEEL FSB84 SERIES | 2425 |

### Production (falconbodies.com)
TBD — add IDs when products are created on production.

---

## Categories Completed

- [x] Service Bodies (4 products: FSB, FSB56, FSB60, FSB84)

## Categories Remaining

- [ ] Mechanics Bodies (FMB56, FMB60, FMB84, FMB120 + PRO models)
- [ ] Contractor Bodies
- [ ] Landscape Bodies
- [ ] Hauler Bodies
- [ ] Enclosed Bodies
- [ ] Chipper Bodies
- [ ] Welder Bodies
- [ ] Saw Bodies

---

## Theme Files Involved

- `functions.php` — `falcon_render_configurations()` and `falcon_render_tech_overview()` functions, tab filter on `woocommerce_product_tabs`
- `assets/js/configurations.js` — toggle click handling, table population from data-config JSON
- `assets/scss/components/_configurations.scss` — all configuration tab styling
- Molla tab keys: `1st` (Configurations), `2nd` (Gallery), `description` (Description)

---

## Known Gotchas

1. **WordPress strips backslashes on meta save.** Always use `wp_slash()` when calling `update_post_meta()`.
2. **esc_attr() required on data-config attribute.** The PHP render function must escape the JSON before outputting it in the HTML attribute. Without this, double quotes in the JSON break the HTML tag.
3. **Molla tab keys are "1st" and "2nd"**, not "tab-custom-1" and "tab-custom-2". The WooCommerce tab filter must target the correct keys.
4. **Script tags don't execute in WooCommerce tab content.** All JS must live in theme files, never in database tab content.
5. **CSV imports break on complex HTML.** Quotes in HTML fields corrupt CSV column boundaries. This is why we moved to custom meta fields.
6. **Post IDs differ per environment.** Always verify IDs before running the save script.
7. **SCP requires interactive terminal.** Claude Code can't do password-authenticated SCP — use your own terminal.
8. **Gallery tab title corruption.** Bad CSV imports set tab_title_2nd to garbage. The save script auto-fixes this to "Gallery".
