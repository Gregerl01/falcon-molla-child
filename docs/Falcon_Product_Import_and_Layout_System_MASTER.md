# Falcon Product Import & Layout System

## Single Source of Truth -- Version Archive + Human Usage Guide

------------------------------------------------------------------------

# 📌 Purpose

This document consolidates all previous Falcon layout and product import
workflow files into one canonical system.

It replaces: - falcon-product-build-workflow-v1.md -
falcon-canonical-layout-template-v1.md -
Falcon_Canonical_Product_Layout_System_v2.md -
README_Falcon_Product_Layout_System.md

From this point forward, this file is the governing document for:

• Post content structure\
• Overall dimension tables\
• Configuration tab layout\
• 3 vs 4 column logic\
• ABC formatting enforcement\
• Image naming standards\
• WP All Import mapping\
• Non‑negotiable build rules

If layout drift occurs, return to this document.

------------------------------------------------------------------------

# 🧠 SECTION 1 -- POST CONTENT STRUCTURE (Description Tab)

Every product page MUST follow this order:

1.  Intro paragraphs\
2.  Gradient divider\
3.  Performance section (if crane body)\
4.  Model-specific overall dimension table(s)\
5.  Structural construction\
6.  Lighting & electrical\
7.  Work-ready construction\
8.  Closing SEO reinforcement

### Overall Dimension Table Rules

Each model gets its own full-width striped table:

-   Use `table table-striped table-bordered`
-   Never use mini-spec-table here
-   Must include CA reference
-   Must include body length
-   Must include body height
-   Must include body width
-   Must include compartment depth
-   Must include load space width (if applicable)

If multiple configurations exist (SRW + DRW), each gets its own table.

------------------------------------------------------------------------

# 🧠 SECTION 2 -- CONFIGURATION TAB STRUCTURE

Configuration tab shows VIEW-BASED dimensional diagrams.

Layout logic:

• 4 Columns → If SRW + DRW\
• 3 Columns → If single configuration only

Columns include:

-   Rear View
-   Alternate Rear View (if applicable)
-   Street Side View
-   Curb Side View

------------------------------------------------------------------------

## Rear View Rules

Use mini-spec-table. Always use A / B / C labeling.

Never replace with descriptive labels.

------------------------------------------------------------------------

## Side View Rules

Must include two tables:

### 1. Cabinet & Compartment Dimensions

With columns: - Compartment Size - Door Opening

### 2. Overall Body Dimensions

Using D, E, CA where applicable.

------------------------------------------------------------------------

# 🧠 SECTION 3 -- ABC FORMAT ENFORCEMENT

Rear views → A, B, C only\
Side views → A, B, C for compartments\
Overall dims → D, E, CA

Never mix labeling systems.\
Never replace A/B/C with descriptive text.

------------------------------------------------------------------------

# 🧠 SECTION 4 -- 3 vs 4 COLUMN RULE

IF SRW + DRW → 4 columns\
IF Single only → 3 columns

No exceptions.

------------------------------------------------------------------------

# 🧠 SECTION 5 -- IMAGE NAMING STANDARD

Format:

series-model-view.webp

Examples:

fmb56-p1-drw-rear.webp\
fmb56-p1-ss.webp\
fmb84-pro6-rear.webp\
fmb120-pro14-ss.webp

Never upload random file names.\
Never allow WP auto-renaming to define structure.

------------------------------------------------------------------------

# 🧠 SECTION 6 -- WP ALL IMPORT MAPPING RULES

post_title → UPPERCASE SERIES NAME\
post_name → lowercase-hyphenated\
sku → UPPERCASE-HYPHENATED

post_content → Must follow Section 1\
Configuration Tab → Must follow Section 2

Gallery → Reuse same gallery structure per series

------------------------------------------------------------------------

# 🧠 SECTION 7 -- NON-NEGOTIABLE BUILD RULES

• No inline styles\
• No table class deviation\
• No changing ABC system\
• No column drift\
• No mixing layout systems\
• No breaking canonical structure

If something feels off, stop and verify against this file.

------------------------------------------------------------------------

# 📘 HOW TO USE THIS DOCUMENT (Human Guide)

1.  When building a new product:
    -   Follow Section 1 for description.
    -   Follow Section 2 for configuration.
    -   Apply Section 4 column rule.
    -   Follow Section 5 for image naming.
    -   Map fields per Section 6.
2.  When auditing existing products:
    -   Compare description against Section 1.
    -   Compare configuration layout against Section 2.
    -   Confirm ABC format compliance.
    -   Confirm image naming compliance.
3.  When using AI (ChatGPT / Claude):
    -   Paste this document first.
    -   Instruct: "Follow this master layout system exactly."

------------------------------------------------------------------------

# 🔒 VERSION CONTROL

Version: v1.0\
Status: Canonical Master File\
Location Recommendation: /docs/product-system/

This file replaces all prior workflow documents.
