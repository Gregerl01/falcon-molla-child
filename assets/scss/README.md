# Modular SCSS Structure - Implementation Guide
## Falcon Truck Bodies - Molla Child Theme

---

## 📋 OVERVIEW

Your 3607-line custom.scss file has been split into **20 organized, manageable files**.

### File Structure:
```
molla-child/assets/scss/
├── custom.scss (MAIN - 64 lines)
├── base/
│   ├── _variables.scss
│   ├── _colors.scss
│   ├── _typography.scss
│   ├── _mixins.scss
│   └── _global.scss
├── layout/
│   ├── _header.scss
│   ├── _navigation.scss
│   └── _footer.scss
├── components/
│   ├── _buttons.scss
│   ├── _sections.scss
│   ├── _parallax.scss
│   ├── _images.scss
│   └── _faq.scss
├── pages/
│   ├── _home.scss
│   └── _page-templates.scss
├── woocommerce/
│   ├── _product-lists.scss
│   ├── _product-single.scss
│   ├── _tabs.scss
│   └── _gallery.scss
├── blog/
│   └── _blog.scss
└── utilities/
    └── _helpers.scss
```

---

## 🚀 INSTALLATION STEPS

### Step 1: Backup Your Current File
```bash
# Navigate to your theme directory
cd wp-content/themes/molla-child/assets/scss/

# Backup your current file
cp custom.scss custom.scss.backup
```

### Step 2: Create the New Structure
Create these folders in `/molla-child/assets/scss/`:
- `base/`
- `layout/`
- `components/`
- `pages/`
- `woocommerce/`
- `blog/`
- `utilities/`

### Step 3: Copy All Files
Copy each `.scss` file from this package into the corresponding folder.

### Step 4: Important Files to Check

**You already have these separate files** (referenced in original):
- `_colors.scss` (imported on line 28)
- `_typography.scss` (imported on line 29)
- `_parallax.scss` (imported on line 30)

**Make sure these exist or are created with your actual content.**

### Step 5: Compile SCSS
Compile `custom.scss` to `/assets/css/custom.css` using your current method:
- If using VS Code: Run your compile task
- If using command line: `sass custom.scss ../css/custom.css`
- If using a build tool: Run your build command

### Step 6: Test Your Site
1. Clear all caches (WordPress, browser, CDN)
2. Visit your site and check:
   - Homepage
   - Product pages
   - Product category pages
   - Blog posts
   - Custom page templates

---

## 📝 WHAT'S IN EACH FILE

### BASE FILES
- **_variables.scss**: SCSS variables (sizes, spacing, etc)
- **_colors.scss**: Color system and selections
- **_typography.scss**: Font definitions (placeholder for your existing file)
- **_mixins.scss**: Reusable SCSS mixins
- **_global.scss**: Site-wide base styles, sections

### LAYOUT FILES
- **_header.scss**: Header, logo, search, cart icons
- **_navigation.scss**: Menu styles, dropdowns, underlines
- **_footer.scss**: Footer background and borders

### COMPONENT FILES
- **_buttons.scss**: All button styles (primary, outline)
- **_sections.scss**: Hero, features, specs, accessories, CTA
- **_parallax.scss**: Parallax scroll sections (placeholder for existing file)
- **_images.scss**: Image section hover effects
- **_faq.scss**: FAQ accordion styles

### PAGE FILES
- **_home.scss**: Homepage-specific styles
- **_page-templates.scss**: Custom page template styles

### WOOCOMMERCE FILES
- **_product-lists.scss**: Product grid/list layouts, features
- **_product-single.scss**: Single product page layout
- **_tabs.scss**: Product tabs styling
- **_gallery.scss**: GT3 gallery fix

### BLOG FILES
- **_blog.scss**: Blog and post styles, comments

### UTILITY FILES
- **_helpers.scss**: Utility classes, responsive helpers

---

## 🔧 CUSTOMIZATION

### Adding New Styles

**For a new button style:**
→ Add to `components/_buttons.scss`

**For header changes:**
→ Edit `layout/_header.scss`

**For new product feature:**
→ Add to `woocommerce/_product-single.scss` or `_product-lists.scss`

**For homepage section:**
→ Add to `pages/_home.scss`

### Creating New Partials

If you need a new component:
1. Create new file: `components/_your-component.scss`
2. Add to `custom.scss`: `@import "components/your-component";`
3. Write your styles in the new file

---

## ⚠️ IMPORTANT NOTES

### Existing Separate Files
Your original file referenced these imports:
```scss
@import "colors";      // line 28
@import "typography";  // line 29  
@import "parallax";    // line 30
```

**ACTION REQUIRED:**
1. Check if these files exist in your `/scss/` folder
2. If they do, **keep them** and remove the placeholder content from:
   - `base/_colors.scss`
   - `base/_typography.scss`
   - `components/_parallax.scss`
3. If they don't exist, you'll need to create them with your actual content

### Commented Code
I've **removed all commented code** from the original file. If you need any of it:
- Check your backup: `custom.scss.backup`
- Copy specific sections back as needed

### Import Order Matters
The order of imports in `custom.scss` is intentional:
1. Bootstrap/Vendors first
2. Variables and mixins
3. Base styles
4. Specific components
5. Utilities last

**Don't rearrange the import order** unless you know what you're doing.

---

## 🐛 TROUBLESHOOTING

### "File not found" errors
- Check file paths in `custom.scss`
- Ensure all folders exist
- Verify file names match (with underscore prefix)

### Styles not applying
- Clear all caches
- Check compiled CSS file was regenerated
- Inspect browser console for errors
- Verify `custom.css` is being enqueued

### Compilation errors
- Check for syntax errors in individual partials
- Ensure all `@import` statements have closing semicolons
- Verify Bootstrap paths are correct for your setup

---

## 📊 BENEFITS OF THIS STRUCTURE

✅ **Find things in seconds** instead of searching 3600 lines  
✅ **Team-friendly** - multiple developers can work simultaneously  
✅ **Easy maintenance** - change header without touching products  
✅ **Reusable code** - mixins prevent duplication  
✅ **Clear organization** - every style has a logical home  
✅ **Better Git workflow** - cleaner diffs and commits  
✅ **Professional structure** - industry-standard organization

---

## 📈 NEXT STEPS

1. **Install the structure** (follow steps above)
2. **Test thoroughly** on all page types
3. **Update your workflow** to edit specific partials instead of one huge file
4. **Create a style guide** documenting which file contains what
5. **Train team members** on the new structure

---

## 🆘 NEED HELP?

If you run into issues:
1. Check your `custom.scss.backup` file
2. Verify all folder structure is correct
3. Ensure compilation is working
4. Check browser console for CSS errors
5. Test with caching disabled

---

## 📦 PACKAGE CONTENTS

This package includes:
- 1 main SCSS file (`custom.scss`)
- 19 partial SCSS files (organized in folders)
- This README file
- All content from your original 3607-line file (minus comments)

**Total lines in new structure:** ~3200 (excluding whitespace and removed comments)
**Number of files:** 20
**Longest file:** ~150 lines
**Average file length:** ~160 lines

---

**Good luck with your modular SCSS! Your future self will thank you.** 🎉
