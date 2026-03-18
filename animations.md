# Scroll-Triggered Fade-In Animation System

## Overview

Every homepage section and the footer uses **scroll-triggered fade-in + slide-up** animations. Elements start invisible and 24px below their resting position, then animate in when they enter the viewport. Groups of elements (cards, boxes, steps, list items, footer links) stagger one after another at 0.1s intervals.

---

## 1. CSS — `assets/css/main.css`

### Why `translate` instead of `transform`

The animation uses the CSS **`translate`** property (not `transform`) for the slide-up motion. This is critical: `translate` and `transform` are independent CSS properties — they compose, they don't override each other. This means:

- Cards with `transform: translateY(-2px)` on hover → hover still works
- The logo ticker with `transform: translateX(...)` keyframe animation → still scrolls
- The footer logo with `transform: translateY(50%)` offset → still positioned correctly
- Buttons with `transform: scale(0.98)` on `:active` → still scale on press

**`fade-in` can be safely added to any element regardless of its existing transforms.**

### Base state (hidden):

```css
.fade-in {
    opacity: 0;
    translate: 0 24px;
    transition: opacity 0.5s ease, translate 0.5s ease;
}
```

### Visible state:

```css
.fade-in.visible {
    opacity: 1;
    translate: 0 0;
}
```

### Staggered delays (0–10, in 0.1s steps):

```css
.fade-in-delay-0  { transition-delay: 0s; }
.fade-in-delay-1  { transition-delay: 0.1s; }
/* ... */
.fade-in-delay-10 { transition-delay: 1s; }
```

### Mobile (≤ 768px):

All delays collapse to `0s` — every element in a section appears simultaneously, no stagger.

---

## 2. JavaScript — `assets/js/navigation.js`

Added inside the IIFE, after the scroll handler:

```js
var fadeEls = document.querySelectorAll('.fade-in');
if (fadeEls.length) {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, { root: null, rootMargin: '0px', threshold: 0.25 });

    fadeEls.forEach(function(el) { observer.observe(el); });
}
```

- **Trigger:** 25% of element visible in viewport
- **One-time:** Element is unobserved after animating in (never re-triggers)

---

## 3. Stagger Pattern Per Section

Within each section, elements stagger sequentially. The counter restarts at `delay-0` for each new section (sections are far apart on screen, the observer triggers them independently).

### Hero (`section-hero.php`)

| Element | Classes |
|---|---|
| `h1.front-hero__title` | `fade-in fade-in-delay-0` |
| `p.front-hero__subheadline` | `fade-in fade-in-delay-1` |
| `div.front-hero__ctas` | `fade-in fade-in-delay-2` |

### Services Overview (`section-services-overview.php`)

| Element | Classes |
|---|---|
| `h2.front-section__title` | `fade-in fade-in-delay-0` |
| `p.front-section__subtitle` | `fade-in fade-in-delay-1` |
| Card 1 (Yield & Revenue) | `fade-in fade-in-delay-2` |
| Card 2 (Online Sales) | `fade-in fade-in-delay-3` |
| Card 3 (E-Commerce) | `fade-in fade-in-delay-4` |
| Card 4 (Contracting) | `fade-in fade-in-delay-5` |
| `p.front-services-overview__cta` | `fade-in fade-in-delay-6` |

### Why Choose (`section-why-choose.php`)

| Element | Classes |
|---|---|
| `h2.front-section__title` | `fade-in fade-in-delay-0` |
| `p.front-section__subtitle` | `fade-in fade-in-delay-1` |
| Box 1 (Cyprus Market) | `fade-in fade-in-delay-2` |
| Box 2 (Experience) | `fade-in fade-in-delay-3` |
| Box 3 (Full Support) | `fade-in fade-in-delay-4` |
| Box 4 (Trusted) | `fade-in fade-in-delay-5` |
| `div.front-why-choose__image` | `fade-in fade-in-delay-3` |

### Results (`section-results.php`)

| Element | Classes |
|---|---|
| `h2.front-section__title` | `fade-in fade-in-delay-0` |
| `li` item 1 (+20%) | `fade-in fade-in-delay-1` |
| `li` item 2 (+15%) | `fade-in fade-in-delay-2` |
| `li` item 3 (B2B) | `fade-in fade-in-delay-3` |
| `li` item 4 (360°) | `fade-in fade-in-delay-4` |
| `p.front-results__trust` | `fade-in fade-in-delay-5` |
| `div.front-results__ticker` | `fade-in fade-in-delay-6` |

> Note: `fade-in` is on the `.front-results__ticker` wrapper — NOT on `.front-results__ticker-track`, which has the `translateX` keyframe animation.

### How We Work (`section-approach.php`)

| Element | Classes |
|---|---|
| `div.front-approach__heading` | `fade-in fade-in-delay-0` |
| `div.front-approach__image` | `fade-in fade-in-delay-1` |
| Step 1 (Audit) | `fade-in fade-in-delay-2` |
| Step 2 (Strategy) | `fade-in fade-in-delay-3` |
| Step 3 (Execution) | `fade-in fade-in-delay-4` |
| Step 4 (Review) | `fade-in fade-in-delay-5` |
| `a.front-approach__cta` (btn) | `fade-in fade-in-delay-6` |

> The `.front-approach__content` card wrapper has no `fade-in` — only the internal steps and CTA do, so the card border appears and content fills in sequentially.

### Featured Banner (`section-featured-banner.php`)

| Element | Classes |
|---|---|
| `div.front-featured-banner__content` | `fade-in fade-in-delay-0` |

> Entire content block animates as one unit (title + text + button).

### Meet the Founder (`section-founder.php`)

| Element | Classes |
|---|---|
| `div.front-founder__image` | `fade-in fade-in-delay-0` |
| `h2.front-founder__heading` | `fade-in fade-in-delay-1` |
| `h3.front-founder__name` | `fade-in fade-in-delay-2` |
| Bio paragraph 1 | `fade-in fade-in-delay-3` |
| Bio paragraph 2 | `fade-in fade-in-delay-4` |
| Bullet point 1 | `fade-in fade-in-delay-5` |
| Bullet point 2 | `fade-in fade-in-delay-6` |
| Bullet point 3 | `fade-in fade-in-delay-7` |
| Bullet point 4 | `fade-in fade-in-delay-8` |
| `a.front-founder__cta` (btn) | `fade-in fade-in-delay-9` |

> `.front-founder__card` wrapper has no `fade-in` — only the internal elements stagger.

### Contact (`section-contact.php`)

| Element | Classes |
|---|---|
| `h2.front-contact__title` | `fade-in fade-in-delay-0` |
| `p.front-contact__text` | `fade-in fade-in-delay-1` |
| `a.front-contact__cta` (btn) | `fade-in fade-in-delay-2` |

> `.front-contact__content` wrapper has no `fade-in` — only the internal elements stagger.

### Footer (`footer.php`)

Each column's heading and links stagger independently within their column. All 4 columns trigger at roughly the same time as the footer enters the viewport.

| Element | Classes |
|---|---|
| All 4 `h4.footer-col__heading` | `fade-in fade-in-delay-0` |
| Navigation `<nav>` (whole block) | `fade-in fade-in-delay-1` |
| Follow Us: Facebook `<li>` | `fade-in fade-in-delay-1` |
| Follow Us: LinkedIn `<li>` | `fade-in fade-in-delay-2` |
| Follow Us: Instagram `<li>` | `fade-in fade-in-delay-3` |
| Legal: Privacy Policy `<li>` | `fade-in fade-in-delay-1` |
| Legal: Cookie Policy `<li>` | `fade-in fade-in-delay-2` |
| Legal: Terms `<li>` | `fade-in fade-in-delay-3` |
| Contact: Phone `<li>` | `fade-in fade-in-delay-1` |
| Contact: Email `<li>` | `fade-in fade-in-delay-2` |
| Contact: Address `<li>` | `fade-in fade-in-delay-3` |
| `div.footer-bottom` | `fade-in fade-in-delay-0` |
| `div.footer-logo` | `fade-in fade-in-delay-1` |

> Navigation column uses `wp_nav_menu` — individual `<li>` items can't be staggered without a custom walker, so the whole `<nav>` animates as one block.

---

## 4. Key Rules for Future Elements

1. **Use `fade-in` + `fade-in-delay-N` on any element** — the `translate` property means transform conflicts are impossible.
2. **Restart the delay counter at `delay-0` per section** — sections are visually separate, so each should read as its own sequential reveal.
3. **Animate grids/lists at the item level**, not the container level, for the stagger effect.
4. **Mobile collapses all stagger** — delays 1–10 are all `0s` on ≤ 768px, so everything appears together.
5. **One-time animation** — elements unobserve themselves after triggering; they never re-animate on scroll back.
