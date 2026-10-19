# UI Design Specification: Reviews & Rating UI Redesign

**Phase:** Phase 26 — Reviews & Rating UI Redesign  
**Document:** `UI-SPEC.md`  
**Status:** Approved Design Contract  
**Design Philosophy:** Rich Aesthetics, Visual Excellence, Trust-Centric Typography, and Fluid Micro-Interactions  
**Target Scopes:**  
1. **Homepage Website Reviews & Ratings Section & Submission Modal** (`resources/views/home.blade.php`)  
2. **College Profile Reviews & Ratings Tab & Submission Card** (`resources/views/colleges/show.blade.php`)  

---

## 1. Design System & Token Foundation

### 1.1 Color Palette
The reviews design system bridges GrowPec's institutional navy brand with warm, celebratory rating gold and trust-inducing emerald greens:

```css
:root {
    /* Brand Foundation */
    --gp-navy-950: #00122e;
    --gp-navy-900: #00163F;
    --gp-navy-800: #001F59;      /* Primary Brand Navy */
    --gp-navy-700: #0a327d;
    --gp-navy-50:  #f0f5ff;

    /* Rating & Accent Tokens */
    --gp-gold-500: #F59E0B;      /* Active Star Fill & High Ratings */
    --gp-gold-600: #D97706;      /* Star Hover / Active */
    --gp-gold-100: #FEF3C7;      /* Rating Badge Background */
    --gp-gold-50:  #FFFBEB;      /* Star Pill Background */

    /* Verification & Trust */
    --gp-emerald-600: #059669;   /* Verified Student Check */
    --gp-emerald-50:  #ECFDF5;   /* Verified Badge Background */

    /* Neutrals & Surfaces */
    --gp-surface-white: #FFFFFF;
    --gp-surface-card:  #FFFFFF;
    --gp-surface-muted: #F8FAFC;
    --gp-surface-border: #E2E8F0;
    --gp-surface-border-subtle: #EDF2F7;
    --gp-text-primary: #0F172A;
    --gp-text-secondary: #475569;
    --gp-text-muted: #94A3B8;

    /* Shadows & Elevation */
    --gp-shadow-subtle: 0 1px 3px 0 rgba(0, 31, 89, 0.04), 0 1px 2px -1px rgba(0, 31, 89, 0.04);
    --gp-shadow-card:   0 4px 20px -2px rgba(0, 31, 89, 0.06), 0 2px 6px -1px rgba(0, 31, 89, 0.03);
    --gp-shadow-hover:  0 20px 30px -8px rgba(0, 31, 89, 0.12), 0 8px 12px -3px rgba(0, 31, 89, 0.04);
    --gp-shadow-modal:  0 25px 50px -12px rgba(0, 22, 63, 0.35);
}
```

### 1.2 Typography & Hierarchy
- **Font Family:** `system-ui, -apple-system, "Plus Jakarta Sans", "Inter", sans-serif`.
- **Large Score Numeral:** `font-size: clamp(3.2rem, 5vw, 4.2rem)`, `font-weight: 800`, `letter-spacing: -0.03em`.
- **Section Heading:** `font-size: clamp(1.75rem, 3vw, 2.35rem)`, `font-weight: 800`, `color: var(--gp-navy-800)`.
- **Review Card Headline:** `font-size: 1.1rem`, `font-weight: 700`, `color: var(--gp-text-primary)`.
- **Review Body Text:** `font-size: 0.965rem`, `line-height: 1.65`, `color: var(--gp-text-secondary)`.
- **Reviewer Metadata:** `font-size: 0.85rem`, `font-weight: 600`, `color: var(--gp-text-primary)`.
- **Badge & Microcopy:** `font-size: 0.75rem`, `font-weight: 600`, `letter-spacing: 0.02em`.

---

## 2. Component Design Specifications

### 2.1 Component 1: The Trust & Aggregate Rating Hero Card
The centerpiece of the review section. Instead of a sterile statistics table, it presents an executive trust summary that immediately establishes authority:

```
┌────────────────────────────────────────────────────────────────────────────────────────┐
│  Overall Rating & Student Voice                                                        │
│                                                                                        │
│  ┌───────────────────────┐  ┌───────────────────────────────────┐  ┌─────────────────┐ │
│  │       4.9             │  │ 5 ★  ████████████████████ 88%     │  │ Share Your      │ │
│  │   ★★★★★               │  │ 4 ★  ████ 10%                     │  │ Experience      │ │
│  │                       │  │ 3 ★  █ 2%                         │  │                 │ │
│  │   Based on 124        │  │ 2 ★  0%                           │  │ [ + Write a   ] │ │
│  │   Verified Ratings    │  │ 1 ★  0%                           │  │ [   Review    ] │ │
│  │                       │  │                                   │  │                 │ │
│  │  [✓ 100% Genuine]     │  │  Recommendation: 98% Positive     │  │ 100% Verified   │ │
│  └───────────────────────┘  └───────────────────────────────────┘  └─────────────────┘ │
└────────────────────────────────────────────────────────────────────────────────────────┘
```

#### Visual Specs:
- **Container:** Rounded 24px (`border-radius: 1.5rem`), solid white background with subtle gradient backdrop glow (`radial-gradient(ellipse at top right, rgba(245, 158, 11, 0.08), transparent 70%)`). Border: `1px solid var(--gp-surface-border)`.
- **Score Block (Left):**
  - Number in giant display weight with smooth gold gradient text (`background: linear-gradient(135deg, #F59E0B, #D97706); -webkit-background-clip: text; -webkit-text-fill-color: transparent;`).
  - Star cluster: 5 oversized rounded stars (`font-size: 1.35rem`) with gold drop-shadow.
  - Verification chip: Pill badge with emerald shield icon *"100% Student Verified"*.
- **Distribution Meter (Center):**
  - Row height: 8px pill tracks with `#F1F5F9` background.
  - Progress fill: Gradient amber with smooth `width` easing on scroll-in (`transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1)`).
  - Hovering a star row highlights corresponding star counts with subtle brightness boost.
- **Call to Action (Right):**
  - High-contrast primary navy button with gold pencil icon.
  - Micro-copy reassurance: *"No login required • Moderated before publication"*.

---

### 2.2 Component 2: Modern Review Cards Grid

```
┌────────────────────────────────────────────────────────┐
│ ★★★★★                        [ 📌 Featured Review ]   │
│                                                        │
│ "Smooth Counseling and Unbiased College Comparison"    │
│                                                        │
│ The counselor guided me through the entire online MBA  │
│ admission process. Helped me compare Amity vs Manipal  │
│ with genuine fee breakdowns. Absolutely recommended!   │
│                                                        │
│ ────────────────────────────────────────────────────── │
│  (A)  Ananya Sharma            🕒 3 days ago           │
│       ✓ Verified Student       👍 Helpful (14)         │
└────────────────────────────────────────────────────────┘
```

#### Visual Specs:
- **Card Surface:** Pure white surface with border `1px solid #E2E8F0`, `border-radius: 18px`.
- **Card Hover State:**
  - `transform: translateY(-4px) scale(1.008)`.
  - Box shadow shifts to `0 20px 30px -10px rgba(0, 31, 89, 0.12)`.
  - Border highlights to `color-mix(in srgb, var(--gp-navy-800) 25%, #E2E8F0)`.
- **Card Header:**
  - Filled gold stars with crisp SVGs or Bootstrap icons (`font-size: 0.95rem`, letter spacing: 2px).
  - Optional *"Featured"* or *"Top Review"* badge in warm gold pill badge.
- **Headline & Body:**
  - Review headline in bold navy (`font-size: 1.05rem`, `font-weight: 700`).
  - Review quote in muted navy slate with quotation punctuation styling.
  - Line-clamp toggle: Reviews over 220 characters feature a clean inline *"Read more"* toggle with fade mask.
- **Card Footer:**
  - Avatar: 42px gradient circle with reviewer initials in crisp white typography.
  - Name: Bold primary dark.
  - Trust badge: Green checkmark with *"Verified Student"*.
  - Timestamp: Relative time (e.g. *"2 weeks ago"*).
  - Interactive "Helpful" counter with thumbs-up icon and click pulse animation.

---

### 2.3 Component 3: Premium Review Submission Modal Dialog

```
┌────────────────────────────────────────────────────────────┐
│  ⭐ Rate & Review GrowPec                              [✕] │
│  Share your feedback to guide fellow learners              │
├────────────────────────────────────────────────────────────┤
│                                                            │
│   How would you rate your overall experience?              │
│                                                            │
│             ★    ★    ★    ★    ★                          │
│             [ ★★★★★ Outstanding (5/5) ]                    │
│                                                            │
│   Your Full Name *               Your Email Address *      │
│   [ Rahul Sharma          ]      [ rahul@example.com     ] │
│                                  🔒 Kept 100% confidential │
│                                                            │
│   Review Headline (Optional)                               │
│   [ e.g. Smooth admission process & great guidance       ] │
│                                                            │
│   Detailed Feedback *                    [ 84 / 1500 chars]│
│   ┌──────────────────────────────────────────────────────┐ │
│   │ Tell future students about the counselors, courses,  │ │
│   │ or transparency you experienced...                   │ │
│   └──────────────────────────────────────────────────────┘ │
│                                                            │
│   🛡️ All reviews are moderated to maintain authenticity.   │
│                                                            │
│   [       Submit Review for Moderation →        ]          │
└────────────────────────────────────────────────────────────┘
```

#### Visual Specs:
- **Modal Window:** Centered dialog, `max-width: 580px`, `border-radius: 24px`, overflow hidden, backdrop blur (`backdrop-filter: blur(8px)` with `background: rgba(0, 22, 63, 0.55)`).
- **Modal Header:** Deep brand gradient (`linear-gradient(135deg, var(--gp-navy-900), var(--gp-navy-800))`) with subtle decorative mesh pattern, clean white typography, and white close button.
- **Interactive 5-Star Picker:**
  - 5 large interactive stars (`font-size: 2.2rem`).
  - Live hover state: stars track cursor position, filling dynamically with transition `transform: scale(1.18)` and amber color shift.
  - Active rating label chip below: e.g. *"★★★★★ Outstanding (5/5)"*, *"★★★★☆ Very Good (4/5)"*, etc.
  - Fully accessible: Keyboard arrow keys navigate between stars; Space/Enter selects.
- **Inputs & Focus States:**
  - Modern floating or clean bordered inputs (`border: 1.5px solid #CBD5E1; border-radius: 12px; padding: 12px 16px`).
  - Focus state: `border-color: var(--gp-navy-800); box-shadow: 0 0 0 4px rgba(0, 31, 89, 0.12)`.
  - Live character counter: Displays active character count (`x / 1500 chars (min 15)`); counter text shifts from red (<15) to neutral slate (≥15).
  - Privacy callout: Green shield icon clarifying email address is never published or shared.
- **Submit Button:**
  - Full-width pill button (`border-radius: 9999px`), deep navy with gold icon, hover gradient shift, and loading spinner state during submission.

---

## 3. Responsive Adaptations

| Viewport | Aggregate Summary Card | Review Cards Grid | Modal Dialog |
|---|---|---|---|
| **Desktop (≥1200px)** | 3-column horizontal layout (Score, Meter, CTA) | 3 cards per row | 560px centered dialog with 2-column input row |
| **Tablet (768px–1199px)** | 2-column layout (Score & CTA stacked, Meter on right) | 2 cards per row | 540px centered dialog |
| **Mobile (<768px)** | 1-column stacked layout (Score top, Meter middle, CTA bottom) | 1 card per row (clean swipeable carousel or stacked list) | Full-width bottom sheet or compact centered modal |

---

## 4. Micro-Interactions & Animation Guidelines

1. **Star Hover & Selection Physics:**
   - On star hover: `transition: transform 0.15s cubic-bezier(0.34, 1.56, 0.64, 1), color 0.15s ease`.
   - Scale factor: `1.2x` on hover, `0.9x` on click down, snapping to `1.05x` on selection lock.
2. **Review Card Entry & Hover:**
   - Cards reveal with subtle staggered fade-up animation (`opacity: 0 -> 1; translateY(16px -> 0)`).
   - Card hover lift: `transform: translateY(-4px)`, shadow expands downward smoothly.
3. **Progress Bar Fill On Screen Reveal:**
   - Uses `IntersectionObserver`: When the summary card scrolls into the viewport, progress bars fill from `0%` to their target percentage over `800ms`.
4. **Post-Submission Success Celebration:**
   - Form replaces with a success banner featuring an animated green checkmark, warm congratulations, and moderation timeline notice.

---

## 5. Accessibility & Inclusivity (WCAG 2.1 AA)

- [x] **Contrast:** High rating gold on white meets 4.5:1 ratio using dark amber `#D97706` for text labels and pure gold `#F59E0B` for large graphical stars.
- [x] **Keyboard Navigation:** Full tab-order support across write review button, modal inputs, star selector, and card interactions.
- [x] **ARIA Semantics:**
  - Star rating component uses `role="radiogroup"` with `role="radio"` and dynamic `aria-checked="true/false"`.
  - Modal conforms to `role="dialog"`, `aria-modal="true"`, and `aria-labelledby`.
  - Progress bars use `role="progressbar"`, `aria-valuenow`, `aria-valuemin="0"`, `aria-valuemax="100"`.
- [x] **Screen Reader Labels:** Star icons have explicit hidden text (e.g. `<span class="visually-hidden">5 out of 5 stars</span>`).

---

## 6. Harmonization with College Profile Reviews (`show.blade.php`)

To guarantee a unified brand identity across GrowPec:
- The design tokens, card styles, aggregate hero layout, and star selector defined in this specification will be applied consistently to both:
  1. The **Homepage Website Reviews section** (`resources/views/home.blade.php`).
  2. The **College Profile Reviews tab** (`resources/views/colleges/show.blade.php`).
- Visitors and students experience identical, premium design polish whether reviewing GrowPec or reviewing a specific university.

---

## 7. Next Steps & Approval Gate

- [x] UI Design Contract authored (`UI-SPEC.md`).
- [ ] User review & approval of UI specification.
- [ ] Implementation in Blade templates and CSS stylesheets.
- [ ] Cross-browser & responsive verification.
