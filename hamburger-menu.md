# Mobile Hamburger Menu — How It's Built

This document covers the complete implementation of the mobile hamburger menu: HTML structure, CSS animation, JavaScript behavior, and accessibility.

---

## Overview

The mobile nav is a **full-screen overlay** triggered by a 3-line hamburger button. It appears on viewports `≤ 768px`. The desktop nav group (`.header-nav-group`) is hidden at that breakpoint, and the hamburger button takes its place.

There is no jQuery dependency — everything is vanilla JavaScript.

---

## 1. HTML Structure (`header.php`)

### The Hamburger Button

```html
<button
  type="button"
  class="mobile-nav-toggle press-feedback"
  aria-label="Open menu"
  aria-expanded="false"
  aria-controls="mobile-nav"
>
  <span class="mobile-nav-toggle__line"></span>
  <span class="mobile-nav-toggle__line"></span>
  <span class="mobile-nav-toggle__line"></span>
</button>
```

- Three `<span>` elements are the three lines of the hamburger icon.
- `aria-controls="mobile-nav"` links the button to the overlay it controls.
- `aria-expanded="false"` is toggled to `"true"` by JS when the menu opens.
- `aria-label` switches between `"Open menu"` and `"Close menu"` dynamically.

### The Mobile Nav Overlay

```html
<div id="mobile-nav" class="mobile-nav-overlay" aria-hidden="true">
  <div class="mobile-nav__content">
    <nav class="mobile-nav__menu">
      <!-- wp_nav_menu() output — language-aware -->
    </nav>

    <div class="mobile-nav__lang">
      <!-- Language switcher dropdown (EN / RU / GR) -->
    </div>
  </div>
</div>
```

- `aria-hidden="true"` is toggled to `"false"` when the menu is open.
- The overlay covers the full viewport (`position: fixed; inset: 0`).
- The language switcher is nested inside the overlay so it's accessible on mobile.

---

## 2. CSS (`style.css`)

### Show/Hide the Hamburger vs. Desktop Nav

```css
/* ≤ 768px: hide desktop nav, show hamburger */
@media (max-width: 768px) {
  .header-nav-group {
    display: none;
  }

  .mobile-nav-toggle {
    display: flex;
    /* ... sizing, padding, etc. */
  }
}

/* ≥ 769px: hide hamburger and overlay */
@media (min-width: 769px) {
  .mobile-nav-toggle {
    display: none;
  }

  .mobile-nav-overlay {
    display: none;
  }
}
```

### Hamburger Button Styling

```css
.mobile-nav-toggle {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 5px;
  width: 2.5rem;
  height: 2.5rem;
  padding: 0;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--mci-color-text);
  transition:
    color 0.2s ease,
    transform 0.13s ease;
}

.mobile-nav-toggle__line {
  display: block;
  width: 22px;
  height: 2px;
  background: currentColor;
  border-radius: 1px;
  transition:
    transform 0.25s ease,
    opacity 0.25s ease;
}
```

### Hamburger → X Animation (`.is-active` state)

When the menu is open, `.is-active` is added to the button. The three lines animate into an X:

```css
/* Line 1: slides down 7px and rotates to 45° */
.mobile-nav-toggle.is-active .mobile-nav-toggle__line:nth-child(1) {
  transform: translateY(7px) rotate(45deg);
}

/* Line 2: fades out and collapses */
.mobile-nav-toggle.is-active .mobile-nav-toggle__line:nth-child(2) {
  opacity: 0;
  transform: scaleX(0);
}

/* Line 3: slides up 7px and rotates to -45° */
.mobile-nav-toggle.is-active .mobile-nav-toggle__line:nth-child(3) {
  transform: translateY(-7px) rotate(-45deg);
}
```

The `7px` value is the combined distance needed to make lines 1 and 3 meet at the center — `gap: 5px` + `height: 2px` = 7px per line.

### The Overlay

```css
.mobile-nav-overlay {
  position: fixed;
  inset: 0; /* covers full viewport */
  z-index: 199; /* above header (z-index: 100) but below any modals */
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: saturate(180%) blur(20px); /* frosted glass */
  padding: var(--mci-header-height) var(--mci-spacing-lg) 2rem;
  opacity: 0;
  visibility: hidden;
  transition:
    opacity 0.3s ease,
    visibility 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.mobile-nav-overlay.is-open {
  opacity: 1;
  visibility: visible;
}
```

- Uses `opacity` + `visibility` (not `display`) so the CSS transition animates smoothly.
- `backdrop-filter` gives the frosted glass effect.
- `padding-top: var(--mci-header-height)` keeps content clear of the fixed header.

### Menu Links

```css
.mobile-nav__links {
  list-style: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.5rem;
}

.mobile-nav__links a {
  font-size: 1.5rem;
  font-weight: var(--mci-font-weight-normal);
  color: var(--mci-color-text);
  text-decoration: none;
  letter-spacing: -0.008em;
  transition: color 0.2s ease;
}

.mobile-nav__links a:hover,
.mobile-nav__links .current-menu-item > a {
  color: var(--mci-color-primary);
}
```

### Dark Hero Override

Pages that have a dark hero image (About, Services, Contact, Gallery, Privacy Policy) need a white hamburger icon before the header scrolls. Once `.is-scrolled` is added (on scroll), the override is removed and the icon reverts to the default text color:

```css
@media (max-width: 768px) {
  .page-template-page-about .site-header:not(.is-scrolled) .mobile-nav-toggle,
  /* ... other dark-hero pages ... */ {
    color: var(--mci-color-white);
  }

  /* When active (X state) on dark hero, always revert to text color */
  .page-template-page-about .site-header:not(.is-scrolled) .mobile-nav-toggle.is-active,
  /* ... */ {
    color: var(--mci-color-text);
  }
}
```

---

## 3. JavaScript (`assets/js/main.js`)

### Element References

```js
var mobileNavToggle = document.querySelector(".mobile-nav-toggle");
var mobileNav = document.getElementById("mobile-nav");
var isToggling = false; // debounce flag
```

### Open / Close Functions

```js
function openMobileNav() {
  mobileNav.classList.add("is-open");
  mobileNav.setAttribute("aria-hidden", "false");
  mobileNavToggle.classList.add("is-active");
  mobileNavToggle.setAttribute("aria-expanded", "true");
  mobileNavToggle.setAttribute("aria-label", "Close menu");
  document.body.style.overflow = "hidden"; // prevent body scroll
}

function closeMobileNav() {
  mobileNav.classList.remove("is-open");
  mobileNav.setAttribute("aria-hidden", "true");
  mobileNavToggle.classList.remove("is-active");
  mobileNavToggle.setAttribute("aria-expanded", "false");
  mobileNavToggle.setAttribute("aria-label", "Open menu");
  document.body.style.overflow = ""; // restore body scroll
}
```

Each function handles both the **visual state** (CSS classes) and the **ARIA state** (attributes) together.

### Click Handler with Debounce

```js
mobileNavToggle.addEventListener("click", function () {
  if (isToggling) return; // prevent double-fire during animation

  isToggling = true;

  if (mobileNav.classList.contains("is-open")) {
    closeMobileNav();
  } else {
    openMobileNav();
  }

  setTimeout(function () {
    isToggling = false;
  }, 280); // matches ~CSS transition duration (0.3s)
});
```

The `isToggling` flag debounces rapid clicks during the 280ms animation window.

### Escape Key to Close

```js
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && mobileNav.classList.contains("is-open")) {
    closeMobileNav();
  }
});
```

### Language Switcher Inside the Overlay

The mobile overlay contains a language switcher with its own dropdown. A `click` propagation guard prevents the overlay's document-level "close lang dropdown" listener from firing when clicking inside `.mobile-nav__lang`:

```js
var mobileNavOverlay = document.getElementById("mobile-nav");
if (mobileNavOverlay) {
  mobileNavOverlay.addEventListener("click", function (e) {
    if (e.target.closest(".mobile-nav__lang")) {
      e.stopPropagation();
    }
  });
}
```

---

## 4. State Summary

| State      | `.mobile-nav-overlay` | `.mobile-nav-toggle` | `aria-hidden` | `aria-expanded` | `body.overflow` |
| ---------- | --------------------- | -------------------- | ------------- | --------------- | --------------- |
| **Closed** | —                     | —                    | `"true"`      | `"false"`       | (default)       |
| **Open**   | `.is-open`            | `.is-active`         | `"false"`     | `"true"`        | `"hidden"`      |

---

## 5. How to Close the Menu

| Trigger               | Handler                          |
| --------------------- | -------------------------------- |
| Click hamburger again | Click listener on toggle         |
| Press `Escape`        | `keydown` listener on document   |
| Navigate to a link    | Browser navigates (page reloads) |

There is no "click outside to close" behavior — the overlay covers the full screen so there is no "outside" area to click.

---

## 6. z-index Hierarchy

| Element               | z-index |
| --------------------- | ------- |
| `.site-header`        | 100     |
| `.mobile-nav-overlay` | 199     |

The overlay sits above the header content but the hamburger button (part of the header) remains visible on top because the header itself is `position: fixed` and the button is a direct child.
