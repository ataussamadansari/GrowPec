# UI Design Specification: College Comparison Matrix & Benchmark Engine

**Phase:** Phase 21 (UI Redesign) — College Comparison UI Modernization  
**Component:** `resources/views/colleges/compare.blade.php`  
**Framework:** Tailwind CSS (No internal CSS `<style>` blocks)  
**Status:** Approved & Ready for Implementation  

---

## 1. Design System & Token Foundation

### 1.1 Brand Palette & Color Tokens
GrowPec brand design tokens mapped to Tailwind CSS palette extensions:

```js
colors: {
    brand: {
        navy: '#002B67',        // Deep Brand Navy (Headers, Primary Badges, Links)
        darkNavy: '#001B45',    // Midnight Navy (Hero background, Sticky accents)
        darkerNavy: '#00122E',  // Deepest Navy (Gradients, Dark borders)
        gold: '#D9A400',        // Accent Gold (Primary CTA buttons, Star fills, Highlights)
        goldHover: '#B78300',   // Darker Gold for interactive hover states
        goldLight: '#FEF9C3',   // Subtle gold background tint for highlights
        green: '#008A43',       // Success / Verification / Fee highlight emerald
        greenLight: '#DCFCE7',  // Soft emerald background for badges
    }
}
```

### 1.2 Surface & Neutral Tokens
- **Background Root:** Clean subtle canvas `bg-slate-50/60` with soft contrast against cards.
- **Card Surfaces:** Pure white `bg-white` with `border border-slate-200/80` and `rounded-2xl shadow-sm`.
- **Hero Surface:** Linear gradient `bg-gradient-to-r from-[#00122E] via-[#001B45] to-[#002B67]` with decorative radial glows.
- **Category Rows:** `bg-slate-100/80 text-brand-navy font-bold text-xs uppercase tracking-wider`.
- **Sticky Column Surface:** `bg-slate-50/95 backdrop-blur-sm border-r border-slate-200/80`.
- **Sticky Header Surface:** `bg-white/95 backdrop-blur-sm border-b border-slate-200/80 shadow-xs`.

---

## 2. Layout & View Architecture

### 2.1 Hero Section
- **Breadcrumb Navigation:** High-contrast, clean breadcrumb links with hover underlines and active gold indicator.
- **Header Grid:**
  - Left: Display title with icon `bi bi-intersect text-amber-400`, bold typography, descriptive subtitle.
  - Right: Live status pill badge (`Comparing X of 4 Colleges` or `Select 2 to 4 Colleges to Benchmark`) with soft golden gradient and icon.

### 2.2 Interactive Comparison Slot Selector
- Modern card with 4-column responsive grid (`grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4`).
- Label: Semi-bold, small, muted with indicator for required vs optional slots.
- Input: `rounded-xl border border-slate-300 bg-slate-50/50 px-3.5 py-2.5 text-sm font-medium text-slate-800 focus:border-[#002B67] focus:ring-2 focus:ring-[#002B67]/20 focus:bg-white transition-all`.
- Action Footer: Flex alignment with "Reset Slots" secondary button and "Update Comparison" primary button.

### 2.3 Side-by-Side Comparison Matrix Table
- **Container:** Rounded-2xl card wrapper with horizontal scroll (`overflow-x-auto`) and smooth scrollbar.
- **Sticky Columns & Headers:**
  - Left column: `sticky left-0 z-20` ensures metric labels remain visible as users scroll horizontally across 4 colleges.
  - Top header row: `sticky top-0 z-20` keeps college identities and instant "Enquire Now" CTAs in view during vertical table exploration.
- **College Header Card:**
  - White card container with subtle inner padding and border.
  - College logo: `w-16 h-16 p-2 rounded-xl border border-slate-200 bg-white object-contain shadow-xs mx-auto`.
  - Remove button: Absolute top-right circular button with hover transition to danger red.
  - College short name & link to profile with hover color shift.
  - Location badge: Pin icon with city, state.
  - Mode & Type badges in compact pill shapes.
  - Quick Enquire CTA button with gold gradient and modal trigger attributes.
- **Add College Slot (when < 4 colleges selected):**
  - Dashed container `border-2 border-dashed border-slate-300 hover:border-brand-navy rounded-2xl p-6 text-center transition-all bg-slate-50/40 hover:bg-slate-50`.
  - Icon, title, explanation, and quick focus button.
- **Comparative Metric Rows:**
  - **Accreditations:** NAAC grade, UGC approval, NIRF rank rendered in colored pill badges.
  - **Heritage:** Established year, campus size.
  - **Ratings:** Star rating badge, 5-star graphic, total verified review counts.
  - **Tuition & Courses:** Bold annual fee range in emerald, program chips, active courses count.
  - **Placements:** Highest package with trophy pill, average package, recruiter chips.
  - **Campus Amenities:** Facility badges with green checkmarks.
  - **Scholarships:** Formatted bullet items with primary checkmarks.
  - **Final CTAs:** Apply/Enquire button + View Full Profile button.

### 2.4 Popular Benchmark Pairs (Launcher State)
- Displayed when less than 2 colleges are selected.
- 2-column grid of curated comparison pairs with tag badge, title, description, and direct compare link.

### 2.5 Expert Counseling Guidance Banner
- Full-width callout card at bottom with modern gradient and direct phone/modal CTA.

---

## 3. Tailwind CSS Enforcement & Removal of Internal CSS

- **Zero `<style>` Tags:** Completely remove the 230 lines of internal CSS from `compare.blade.php`.
- **Pure Utility Classes:** All layouts, spacing, typography, gradients, sticky positioning, borders, shadows, and interactive states use pure Tailwind CSS classes.
- **Tailwind Engine:** Loaded via `@push('styles')` with `corePlugins: { preflight: false }` to ensure zero disturbance to site-wide Bootstrap modals and navigation while unlocking 100% of Tailwind's utility ecosystem.
- **Dock Separation:** Ensure the floating comparison dock `#gpCompareDock` is suppressed on `/compare` to completely eliminate screen overlap.
