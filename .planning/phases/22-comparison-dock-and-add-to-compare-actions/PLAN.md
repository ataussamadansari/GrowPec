# Phase 22 Plan: Comparison Dock & "Add to Compare" Actions

**Phase:** Phase 22 — Comparison Dock & "Add to Compare" Actions  
**Milestone:** v1.5 — College Comparison & Advanced Search Filters  
**Status:** In Progress / Ready for Execution  
**Created:** 2026-10-18  

---

## 1. Phase Objective
Provide a unified, persistent **Floating Comparison Dock** and interactive **"Add to Compare" buttons** on college cards and detail pages, allowing prospective students to seamlessly collect up to 4 universities as they browse and launch a benchmark comparison from any page.

---

## 2. Technical Architecture & Component Flow

```
┌─────────────────────────────────────────────────────────────┐
│ 1. Student Browsing:                                        │
│ • College Listings (colleges/index.blade.php)               │
│ • College Profile (colleges/show.blade.php)                 │
│ • User clicks "Add to Compare"                              │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 2. Client-Side State Engine (localStorage):                 │
│ • Key: growpec_compare_colleges                             │
│ • Stores [{id, slug, name, logo}] (Max 4 colleges)          │
│ • Synchronizes button states (active/inactive) across DOM   │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 3. Floating Comparison Dock (layouts/app.blade.php):        │
│ • Fixed floating tray at viewport bottom (z-index: 1040)    │
│ • Displays selected college thumbnails, titles, & slots     │
│ • "Compare Now (N)" button -> GET /compare?colleges=s1,s2   │
│ • "Clear All" & individual remove ("×") actions             │
└──────────────────────────────┬──────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────┐
│ 4. Matrix Sync & Quick Switcher (colleges/compare.blade.php):│
│ • URL query params sync back into localStorage               │
│ • Add-slot triggers seamless modal/dropdown picker          │
└─────────────────────────────────────────────────────────────┘
```

---

## 3. Detailed Implementation Tasks

### Task 22.1: Global Comparison Dock & Client Storage Engine in `layouts/app.blade.php`
- **Location:** Before `</body>` in `resources/views/layouts/app.blade.php`.
- **Markup Component (`#gpCompareDock`):**
  - Container fixed to viewport bottom (`position: fixed; bottom: 0; left: 0; right: 0; z-index: 1040; transform: translateY(120%); transition: transform 0.3s ease-in-out;`).
  - Activates with `.is-visible` (`transform: translateY(0);`) whenever `growpec_compare_colleges.length > 0`.
  - Max-width container (`container-xl` / `container-fluid px-3 px-md-4`).
  - Elevated card with shadow `0 -6px 25px rgba(0, 43, 103, 0.12)`, rounded-top-4, white background, navy top border `border-top: 3px solid #002B67`.
  - Up to 4 slot items:
    - Selected: College thumbnail logo, truncated name, remove badge (`×`).
    - Empty (when < 4): Dashed slot placeholder ("+ Add Slot").
  - Actions bar:
    - "Compare Now (N)" button: Navigates to `/compare?colleges=slug1,slug2...`. Disabled/warns if N < 2.
    - "Clear All" button: Clears localStorage and hides dock.
- **JavaScript Engine (`growpec-compare.js` inline script in `layouts/app.blade.php`):**
  - Storage Key: `const COMPARE_STORAGE_KEY = 'growpec_compare_colleges';`
  - Max Limit: `const MAX_COMPARE_COLLEGES = 4;`
  - Core functions:
    - `getStoredCompareColleges()`: Returns parsed array from `localStorage`.
    - `saveStoredCompareColleges(list)`: Persists array and triggers `renderCompareDock()` and `syncCompareButtons()`.
    - `toggleCollegeComparison(elOrData)`: Handles add/remove toggle; shows toast/alert if attempting to exceed 4 colleges.
    - `removeCollegeFromCompare(slug)`: Removes single college by slug.
    - `clearAllCompareColleges()`: Empties array and resets buttons.
    - `renderCompareDock()`: Re-renders the dock slots, updates counter badge, enables/disables "Compare Now" CTA.
    - `syncCompareButtons()`: Scans DOM for `.btn-add-compare[data-college-slug]` and adds `.is-active` / updates label & icon ("Compare" vs "Added").
  - Lifecycle: Runs on `DOMContentLoaded` and listens to `window.addEventListener('storage', ...)`.

### Task 22.2: Add Comparison Quick Actions to College Listing Cards
- **Location:** `resources/views/colleges/index.blade.php` (line ~1203 inside `.college-horizontal-card`).
- **Button Markup:**
  ```blade
  <button type="button" 
          class="btn btn-outline-primary btn-sm btn-add-compare d-inline-flex align-items-center gap-1"
          data-college-id="{{ $college->id }}"
          data-college-slug="{{ $college->slug }}"
          data-college-name="{{ $college->name }}"
          data-college-logo="{{ $college->logo ? (str_starts_with($college->logo, 'http') ? $college->logo : asset('storage/' . $college->logo)) : '' }}"
          onclick="toggleCollegeComparison(this)"
          title="Compare this college">
      <i class="bi bi-arrow-left-right"></i>
      <span class="compare-btn-text">Compare</span>
  </button>
  ```
- **Styling:**
  - CSS rule for `.btn-add-compare.is-active`:
    `background-color: #002B67 !important; color: #ffffff !important; border-color: #002B67 !important;`
  - Hover states and smooth scale transition.

### Task 22.3: Add Comparison Action to College Detail Profile Hero
- **Location:** `resources/views/colleges/show.blade.php` (line ~2510 inside hero CTA group).
- **Button Markup:**
  ```blade
  <button type="button" 
          class="c-btn c-btn--outline btn-add-compare d-inline-flex align-items-center gap-2"
          data-college-id="{{ $college->id }}"
          data-college-slug="{{ $college->slug }}"
          data-college-name="{{ $college->name }}"
          data-college-logo="{{ $college->logo ? (str_starts_with($college->logo, 'http') ? $college->logo : asset('storage/' . $college->logo)) : '' }}"
          onclick="toggleCollegeComparison(this)">
      <i class="bi bi-arrow-left-right"></i>
      <span class="compare-btn-text">Add to Compare</span>
  </button>
  ```
- **Styling:**
  - Integrates with `.c-btn` system in `show.blade.php`.
  - `.c-btn.btn-add-compare.is-active` styles with navy background and gold checkmark icon.

### Task 22.4: Sync In-Matrix Selection with Client State in `compare.blade.php`
- **Location:** `resources/views/colleges/compare.blade.php`.
- **Query Param Synchronization:**
  - When loading `/compare?colleges=slug1,slug2...`, pass active colleges JSON or read the server-side `$selectedColleges` into `localStorage`.
  - Ensures visiting a shared comparison URL immediately populates the dock for the student.
  - In empty table slots (when selected < 4), clicking "+ Add College to Compare" activates a clean college picker modal or focuses the slot selector bar.

### Task 22.5: Automated Pest Feature Tests & Lint Verification
- **Create:** `tests/Feature/CollegeComparisonDockTest.php`:
  1. `test_layout_renders_comparison_dock_markup()`: Asserts `#gpCompareDock` and action containers exist on public views.
  2. `test_colleges_index_renders_add_to_compare_buttons()`: Asserts `.college-horizontal-card` has `.btn-add-compare` with `data-college-slug` attributes.
  3. `test_colleges_show_renders_add_to_compare_button()`: Asserts detail page hero contains `.btn-add-compare` for the given college.
  4. `test_compare_page_syncs_with_slug_parameters()`: Asserts `/compare?colleges=slug1,slug2` renders comparison matrix successfully.
- **Pint Hygiene:** Run `vendor/bin/pint --format agent` to format modified PHP files.
- **Suite Verification:** Run `php artisan test --compact` to verify all 133+ tests remain 100% green.

---

## 4. Verification & Success Criteria
- [ ] Comparison dock floats smoothly at bottom when >= 1 college is added to compare.
- [ ] Users can add up to 4 colleges; trying to add a 5th warns the user cleanly.
- [ ] Clicking "Compare Now" navigates to `/compare?colleges=...` with correct comma-separated slugs.
- [ ] Listing cards and show page buttons dynamically toggle state between "Compare" / "Add to Compare" and "Added" / "In Compare".
- [ ] Removing colleges from dock or clicking "Clear All" instantly reflects across UI buttons.
- [ ] All automated tests pass 100% green with zero regressions (`php artisan test --compact`).
