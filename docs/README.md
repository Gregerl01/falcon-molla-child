# Falcon Product System --- Documentation Index

This `/docs` directory is the **single source of truth** for the Falcon
Truck Bodies theme product system.

It governs:

• Product post_content structure\
• Excerpt feature block structure\
• Overall dimension tables\
• Configuration tab layout\
• 4‑column grid standard\
• ABC dimension formatting\
• Image naming conventions\
• AI workflow rules\
• Non‑negotiable layout enforcement

------------------------------------------------------------------------

# 🔒 Documentation Hierarchy (Order of Authority)

If conflicts ever occur, follow this order:

1.  **Falcon_Canonical_Feature_Block_System_v1.md**\
    Controls product excerpt structure (4 benefit items required).

2.  **Falcon_Product_Import_and_Layout_System_MASTER.md**\
    Controls post_content markup and configuration tab layout.

3.  **THEME_ARCHITECTURE.md**\
    Defines theme file structure and component rules.

4.  **WORKFLOW.md**\
    Defines AI + Claude Code workflow behavior.

Nothing overrides these documents.

------------------------------------------------------------------------

# 🧱 Non‑Negotiable Layout Rules

These rules must always be enforced:

• All excerpts use exactly **4 benefit items**\
• All configuration tabs follow **ABC labeling structure**\
• All dimensional grids use **4-column layout** (even if empty
placeholders required)\
• No freestyle markup\
• No inline styling\
• No structural changes without updating documentation\
• Documentation must be updated BEFORE implementation changes

If layout drifts, revert to canonical system immediately.

------------------------------------------------------------------------

# 🖼 Image Naming Standards

Product blueprint images must follow consistent naming:

`series-model-view.webp`

Examples:

-   fmb56-p1-srw-rear.webp\
-   fmb56-p1-drw-rear.webp\
-   fmb56-p1-ss.webp\
-   fmb56-p1-cs.webp

No inconsistent naming allowed.

------------------------------------------------------------------------

# 📐 Column Logic Rule

Default rule: **Always use 4 columns** for consistency.

If product truly only requires 3 views, maintain 4-column grid and use
placeholder to preserve structure alignment.

Consistency \> conditional layout shifts.

------------------------------------------------------------------------

# 🤖 AI Enforcement Protocol

Before generating any product markup, AI must:

1.  Confirm series type (FSB, FMB, FCB, etc.)\
2.  Confirm SRW/DRW logic\
3.  Confirm excerpt structure\
4.  Confirm configuration tab structure\
5.  Confirm 4-column grid enforcement

If unclear → stop and request clarification.

No assumptions.

------------------------------------------------------------------------

# 🛠 Adding New Products

When adding a new product:

1.  Follow Canonical Feature Block System\
2.  Follow Canonical Layout System\
3.  Insert correct overall dimension tables into post_content\
4.  Insert ABC mini spec tables into configuration tab\
5.  Maintain 4-column layout\
6.  Verify naming consistency\
7.  Confirm alignment with existing series structure

If structure differs, documentation must be updated first.

------------------------------------------------------------------------

# 🚫 Prohibited Actions

• Mixing layout systems\
• Removing ABC labeling\
• Changing column count\
• Improvised grid structures\
• Skipping excerpt benefit structure\
• Breaking documentation hierarchy

------------------------------------------------------------------------

# 📌 Final Rule

This folder governs the Falcon theme product system.

If uncertainty occurs, the correct response is:

"Follow the master layout system exactly."

No deviations.

------------------------------------------------------------------------

Maintained for Falcon Truck Bodies Theme\
Version: 1.0
