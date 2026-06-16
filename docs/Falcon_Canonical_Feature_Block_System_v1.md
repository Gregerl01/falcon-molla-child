# Falcon Canonical Feature Block System

Version 1.0\
Single Source of Truth for Product Excerpts

------------------------------------------------------------------------

## Purpose

This document defines the required structure for all Falcon product
**post_excerpt** content used in WP All Import.

This structure is mandatory and must be followed exactly to ensure: -
Visual consistency across all products - Uniform animation timing -
Layout stability - Predictable import behavior - Scalable product
expansion

------------------------------------------------------------------------

# Locked 4-Benefit Rule

Every product excerpt MUST contain:

-   1 Headline
-   1 Intro paragraph
-   Exactly 4 benefit blocks
-   Identical animation pattern
-   Identical icon structure

No exceptions.

------------------------------------------------------------------------

# Canonical HTML Structure (DO NOT MODIFY)

``` html
<div class="falcon-feature-block">

  <h2 class="falcon-headline">
    {{ PRIMARY PERFORMANCE HEADLINE }}
  </h2>

  <p class="falcon-intro">
    {{ 1–2 sentence positioning statement describing chassis class, crane rating, and vocational intent. }}
  </p>

  <div class="falcon-benefits">

    <div class="benefit-item" data-aos-delay="250" data-aos="fade-left">
      <div class="benefit-icon">
        <i class="bi bi-lightning-fill"></i>
      </div>
      <div class="benefit-content">
        <h4>{{ Benefit 1 Title }}</h4>
        <p>{{ Benefit 1 supporting sentence. }}</p>
      </div>
    </div>

    <div class="benefit-item" data-aos-delay="300" data-aos="fade-left">
      <div class="benefit-icon">
        <i class="bi bi-lightning-fill"></i>
      </div>
      <div class="benefit-content">
        <h4>{{ Benefit 2 Title }}</h4>
        <p>{{ Benefit 2 supporting sentence. }}</p>
      </div>
    </div>

    <div class="benefit-item" data-aos-delay="350" data-aos="fade-left">
      <div class="benefit-icon">
        <i class="bi bi-lightning-fill"></i>
      </div>
      <div class="benefit-content">
        <h4>{{ Benefit 3 Title }}</h4>
        <p>{{ Benefit 3 supporting sentence. }}</p>
      </div>
    </div>

    <div class="benefit-item" data-aos-delay="400" data-aos="fade-left">
      <div class="benefit-icon">
        <i class="bi bi-lightning-fill"></i>
      </div>
      <div class="benefit-content">
        <h4>{{ Benefit 4 Title }}</h4>
        <p>{{ Benefit 4 supporting sentence. }}</p>
      </div>
    </div>

  </div>

</div>
```

------------------------------------------------------------------------

# Non-Negotiable Rules

## 1. Always Four Benefits

Never three. Never five.

## 2. Icon Enforcement

Must use:

``` html
<i class="bi bi-lightning-fill"></i>
```

## 3. Animation Timing (Locked Pattern)

-   250
-   300
-   350
-   400

Do not alter delay increments.

## 4. Headline Standard

Headlines must be performance-focused, not marketing fluff.

Examples: - Heavy-duty 60CA crane body performance. - 6' short bed
service body engineered for structural durability. - Extreme-duty 120CA
crane body platform. - 84CA mechanics body built for high-cycle lifting.

------------------------------------------------------------------------

# System Intent

This structure ensures:

-   Balanced grid appearance
-   Predictable AOS behavior
-   Clean import mapping
-   Uniform product presentation
-   No layout drift

If any product deviates from this structure, refactor immediately.

------------------------------------------------------------------------

# Enforcement Phrase

If layout drift occurs, return to this document and apply:

"Follow the Falcon Canonical Feature Block System exactly."

------------------------------------------------------------------------

End of Document
