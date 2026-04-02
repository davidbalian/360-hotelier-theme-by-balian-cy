# Mobile hamburger menu — portable reuse guide

This document explains how to recreate the **360 Hotelier** theme’s mobile navigation on another site: full-screen overlay, hamburger-to-X animation, body scroll lock, `Escape` to close, and **accordion submenus** on small viewports.

**Note:** The older in-repo doc [hamburger-menu.md](hamburger-menu.md) describes the same feature but is partly outdated (wrong script filename, wrong desktop-hide selector, language-switcher markup that is not in the current header). Use **this file** as the portable reference; treat `hamburger-menu.md` as legacy notes only.

---

## 1. Behavior summary

- **Breakpoint:** Mobile layout uses **`max-width: 768px`** (desktop uses **`min-width: 769px`** in related JS). At that width the horizontal `.nav-menu` is hidden and `.mobile-nav-toggle` is shown.
- **Overlay:** `#mobile-nav.mobile-nav-overlay` is `position: fixed; inset: 0` with frosted-glass styling. Visibility animates via `opacity` + `visibility` (not `display`), with `.is-open` when visible.
- **Toggle:** `.mobile-nav-toggle` receives `.is-active` when open; three bars animate into an X.
- **No click-outside close:** The overlay fills the viewport; users close via the button again or `Escape`.
- **Debounce:** Rapid clicks are ignored for **280ms** after a toggle to match CSS transition timing.
- **Body scroll:** `document.body.style.overflow = 'hidden'` while open.
- **Submenus (mobile only):** Top-level items with children expand/collapse in place (accordion). Only one top-level submenu open at a time; closing the main overlay resets submenus.

---

## 2. Implementation checklist

| Step | Action |
|------|--------|
| 1 | Add the **HTML** structure: toggle button (inside header nav area) + overlay `div` **after** the header (sibling under your page wrapper), with duplicated or shared menu markup as needed. |
| 2 | Copy/adapt **CSS** from the theme partials listed in §8; map design tokens (see below). |
| 3 | Load **vanilla JS** equivalent to `MobileNavSubmenuToggle` + open/close/click/`Escape` from [assets/js/navigation.js](assets/js/navigation.js) (lines ~7–130). |
| 4 | If you use **nested menus**, mirror the DOM in §6 and include the mobile `@media (max-width: 768px)` rules for `.mobile-nav__links` in [assets/css/parts/01b-primary-nav-submenu.css](assets/css/parts/01b-primary-nav-submenu.css). |
| 5 | Set **z-index** so the fixed header stacks above the overlay if the toggle must stay visible (this theme: header `200`, overlay `199`). |
| 6 | Verify **ARIA** on the button and overlay (§4). |

**CSS variables to replace** (examples from this theme):

- `--color-charcoal`, `--color-purple` — text, links, accents.
- `--header-height`, `--top-bar-height` — overlay top padding and layout.
- `--wp-admin-bar-offset` — only if you replicate WordPress admin bar handling ([assets/css/parts/01-global-header.css](assets/css/parts/01-global-header.css)).

---

## 3. Required DOM contract

| Requirement | Details |
|-------------|---------|
| Toggle | `button.mobile-nav-toggle` with `type="button"`, `aria-controls="mobile-nav"`, `aria-expanded="false"`, `aria-label` (“Open menu” / “Close menu” toggled in JS). |
| Icon | Three children: `span.mobile-nav-toggle__line` (each is one bar). |
| Overlay root | `div#mobile-nav.mobile-nav-overlay` with `aria-hidden="true"` (JS sets `"false"` when open). |
| Inner shell | `.mobile-nav__content` > `nav.mobile-nav__menu` > `ul.mobile-nav__links` (WordPress outputs the `ul` via `menu_class`). |
| Desktop nav | Optional for parity: `nav.primary-navigation` with `ul.nav-menu` for horizontal links at wider breakpoints. |
| Current page | Optional: WordPress adds `.current-menu-item` on `li`; styles use it for active link color. |

**IDs and classes must match** what the JS queries: `.mobile-nav-toggle`, `#mobile-nav`, `.mobile-nav__links`, `.menu-item-has-children`, `.is-submenu-open`.

---

## 4. State machine

| State | `#mobile-nav` | `.mobile-nav-toggle` | `aria-hidden` (overlay) | `aria-expanded` (button) | `aria-label` (button) | `body.style.overflow` |
|-------|---------------|----------------------|-------------------------|---------------------------|------------------------|------------------------|
| Closed | no `.is-open` | no `.is-active` | `"true"` | `"false"` | Open menu* | `""` (default) |
| Open | `.is-open` | `.is-active` | `"false"` | `"true"` | Close menu* | `"hidden"` |

\*Use your own localized strings; the theme uses translatable “Open menu” / “Close menu”.

On close, all `li.menu-item-has-children.is-submenu-open` under `.mobile-nav__links` should be cleared and child `a[aria-expanded]` reset to `"false"`.

---

## 5. Vanilla JS to port

Source: [assets/js/navigation.js](assets/js/navigation.js).

**Include on any site (mobile menu + mobile submenus):**

1. **`MobileNavSubmenuToggle`** (object ~lines 16–86): `matchMedia('(max-width: 768px)')`, `init()` on `#mobile-nav`’s `.mobile-nav__links > .menu-item-has-children`, click on `:scope > a` prevents default on mobile, toggles `.is-submenu-open` and `aria-expanded`, `closeAll()` when closing overlay or when leaving mobile breakpoint.
2. **Toggle + `Escape`** (~lines 88–129): `openMobileNav` / `closeMobileNav`, click debounce with `isToggling` and `setTimeout(..., 280)`, `keydown` for `Escape`.

**Optional (same file, separate concerns):**

- **`PrimarySubmenuToggle`** — desktop-only submenu behavior on `.primary-navigation` (`min-width: 769px`).
- **Scroll handler** — adds `.is-scrolled` to `.site-header` and `.top-bar` for logo/color changes.
- **IntersectionObserver** — `.fade-in` animations.

For a minimal port, copy only the mobile block into your bundle or a standalone `mobile-nav.js` and drop dependencies on `.primary-navigation` / `.site-header` if unused.

---

## 6. Submenus on a non-WordPress site

The accordion expects **WordPress-shaped** markup (classes matter for both CSS and JS).

**Structure per top-level item with children:**

```html
<li class="menu-item menu-item-has-children">
  <a href="/services">Services
    <span class="nav-submenu-chevron" aria-hidden="true">
      <!-- inline SVG chevron, stroke currentColor — see theme: inc/menu-fallback.php hotelier_get_nav_submenu_chevron_markup() -->
    </span>
  </a>
  <div class="nav-submenu-clip">
    <ul class="sub-menu">
      <li class="menu-item"><a href="/item-1">Item 1</a></li>
      <!-- … -->
    </ul>
  </div>
</li>
```

**Behavior (≤768px):** Clicking the **parent** `a` does not navigate; JS calls `preventDefault`, closes other open siblings, then toggles `.is-submenu-open` on the `li`. `Enter` / `Space` on that link mirror the click. At wider widths, this mobile accordion logic does not run (`matchMedia` guard).

**Chevron markup** (exact string) lives in:

```19:21:inc/menu-fallback.php
function hotelier_get_nav_submenu_chevron_markup() {
    return '<span class="nav-submenu-chevron" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg></span>';
}
```

Accordion animation uses **CSS grid** `grid-template-rows: 0fr` → `1fr` on `.nav-submenu-clip` when the parent `li` has `.is-submenu-open` — see [assets/css/parts/01b-primary-nav-submenu.css](assets/css/parts/01b-primary-nav-submenu.css) under `@media (max-width: 768px)`.

---

## 7. WordPress appendix (this theme)

**Header markup:** [header.php](header.php)

- Primary menu: `wp_nav_menu` with `menu_class` => `nav-menu`, `walker` => `Hotelier_Primary_Nav_Walker`.
- Same `theme_location` and walker for mobile: second `wp_nav_menu` inside `#mobile-nav` with `menu_class` => `mobile-nav__links`, distinct `menu_id` (e.g. `mobile-primary-menu`).
- Toggle sits inside `nav.primary-navigation` after the desktop `ul`.

**Walker:** [inc/class-hotelier-primary-nav-walker.php](inc/class-hotelier-primary-nav-walker.php) wraps depth-0 submenus in `<div class="nav-submenu-clip">` and adds the “All Services” row for the Services hub.

**Chevron on menu items:** `nav_menu_item_title` filter in [inc/menu-fallback.php](inc/menu-fallback.php) appends chevron markup for top-level `primary` items with children.

**Fallback menu** (no menu assigned): [inc/menu-fallback.php](inc/menu-fallback.php) outputs the same `li` / `nav-submenu-clip` / `sub-menu` structure via `hotelier_default_nav_fallback`.

**Script enqueue:** [inc/enqueue.php](inc/enqueue.php) registers `360-hotelier-navigation` → `assets/js/navigation.js` in the footer, no jQuery dependency.

---

## 8. CSS files to copy or mirror

| File | What to reuse |
|------|----------------|
| [assets/css/parts/01-global-header.css](assets/css/parts/01-global-header.css) | `.mobile-nav-toggle` + `__line`, `.is-active` X animation, `.mobile-nav-overlay`, `.is-open`, `.mobile-nav__content`, `.mobile-nav__links` link styles; optional `:has(#mobile-nav.is-open)` top-bar color overrides; `.site-header:not(.is-scrolled):has(.mobile-nav-toggle.is-active)` logo tweak. |
| [assets/css/parts/01b-primary-nav-submenu.css](assets/css/parts/01b-primary-nav-submenu.css) | Desktop submenu rules if needed; **mobile** block `@media (max-width: 768px)` for `.mobile-nav__links` accordion + chevron rotation. |
| [assets/css/parts/06-style-guide-responsive-fade.css](assets/css/parts/06-style-guide-responsive-fade.css) | Inside `@media (max-width: 768px)`: `.nav-menu { display: none; }`, `.mobile-nav-toggle { display: flex; }`, `.mobile-nav-overlay { display: flex; … overflow-y: auto; }`, and related mobile header tweaks. |

Default desktop: `.mobile-nav-toggle` and `.mobile-nav-overlay` use `display: none` until the mobile media query shows them.

---

## 9. z-index and stacking

From [assets/css/parts/01-global-header.css](assets/css/parts/01-global-header.css):

- `.site-header` — `z-index: 200`
- `.mobile-nav-overlay` — `z-index: 199`

The overlay sits **under** the fixed header so the branding and hamburger remain visible and clickable. Adjust together on the target site if you use other floating UI (modals should sit above the header if required).

---

## 10. Closing triggers (reference)

| Trigger | Mechanism |
|---------|-----------|
| Toggle click | Toggles open/closed (debounced). |
| `Escape` | `document` `keydown` closes if overlay has `.is-open`. |
| Follow in-page link | Full navigation reloads; no extra JS needed. |

There is **no** document-level “click outside” handler for the mobile overlay.
