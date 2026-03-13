# Load-in Animation Technique

## Overview

The homepage uses **scroll-triggered fade-in + slide-up** animations. Elements start hidden and slightly below their final position, then animate in when they enter the viewport.

---

## 1. CSS (in `assets/css/home-v2.css`)

**Base state (hidden):**

- `.fade-in`: `opacity: 0`, `transform: translateY(24px)`
- Transition: `opacity` and `transform` over `0.5s` (via `--transition-slow`)

**Visible state:**

- `.fade-in.visible`: `opacity: 1`, `transform: translateY(0)`

**Staggered delays:**

- `.fade-in-delay-0` through `.fade-in-delay-10` with `transition-delay` from `0s` to `1s` in 0.1s steps
- On mobile (≤768px): all delays set to `0s` so elements appear together

---

## 2. JavaScript (in `assets/js/main.js`)

- Uses **IntersectionObserver**
- Options: `root: null`, `rootMargin: '0px'`, `threshold: 0.25` (element is considered visible when 25% is in view)
- When an element intersects, add the `visible` class and stop observing it
- All elements with `.fade-in` are observed on page load

---

## 3. Usage in Markup

Elements receive two classes:

1. `fade-in` — enables the animation
2. `fade-in-delay-N` — sets stagger (0–10)

Example:

```html
<h2 class="fade-in fade-in-delay-0">Title</h2>
<p class="fade-in fade-in-delay-1">Subtitle</p>
<div class="fade-in fade-in-delay-2">Card</div>
```

---

## Summary for Another LLM

- **Effect:** Fade in + slide up 24px
- **Trigger:** IntersectionObserver at 25% visibility
- **Duration:** 0.5s
- **Stagger:** Optional 0.1s steps (0–1s) via `fade-in-delay-N`
- **Mobile:** No stagger (all delays 0)
- **One-time:** Elements are unobserved after they become visible
