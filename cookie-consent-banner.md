# Cookie consent banner — how it’s built

This document describes a **fixed bottom cookie consent strip**: HTML structure, CSS show/hide and motion, JavaScript persistence, and accessibility. The examples use **generic placeholders** so you can reuse the pattern on any site; the **reference implementation** in this WordPress theme is called out at the end of each section.

There is no jQuery dependency — everything is vanilla JavaScript.

---

## 1. Overview

- **What it is:** A small bar anchored to the bottom of the viewport with short copy, a link to your privacy or cookie policy, an **Accept** action, and an optional **dismiss** (close) control.
- **Naming:** Markup uses **BEM-style** classes: `.cookie-banner`, `.cookie-banner__text`, `.cookie-banner__actions`, `.cookie-banner__accept`, `.cookie-banner__close`.
- **Persistence:** The reference theme stores consent in **`localStorage`**, not as an HTTP cookie. The UI says “cookies” because that matches user-facing language and policy; the **storage mechanism is separate** from browser cookie APIs.
- **Scope:** This pattern **does not load or block** analytics or ad scripts by itself. If your jurisdiction or stack requires **consent before** third-party tags run, add a separate gating step (conditional script injection, tag manager consent mode, server-side rules, etc.).

---

## 2. HTML pattern

### Goals

- **No flash of banner before logic runs:** The root node starts with the **`hidden`** attribute so it is not shown until script removes it.
- **Stable hook for script:** A single `id` (e.g. `{BANNER_ID}`) lets you query the banner once.
- **Semantics:** `role="dialog"` and `aria-label` identify the region for assistive tech.

### Generic template

Replace `{BANNER_ID}`, `{PRIVACY_URL}`, and button classes with your project’s conventions.

```html
<div
  id="{BANNER_ID}"
  class="cookie-banner"
  role="dialog"
  aria-label="Cookie consent"
  hidden
>
  <p class="cookie-banner__text">
    Short consent copy.
    <a href="{PRIVACY_URL}">Privacy policy</a>.
  </p>
  <div class="cookie-banner__actions">
    <button type="button" class="cookie-banner__accept">Accept</button>
    <button type="button" class="cookie-banner__close" aria-label="Dismiss cookie banner">
      &times;
    </button>
  </div>
</div>
```

- **`hidden`:** Native boolean attribute; paired with CSS so the dismissed banner does not occupy layout.
- **Close button:** Use a real `<button>` and an **`aria-label`** if the visible label is only a symbol (e.g. ×).

### In this theme

Markup lives in [`footer.php`](../footer.php) immediately before `wp_footer()`. The banner id is `mci-cookie-banner`. Copy and the privacy link use theme helpers (`mci_t`, `mci_te`, `mci_url`) and translation files under `inc/translations/` — optional on a non-WordPress site; plain static HTML is enough for the pattern.

---

## 3. CSS pattern

### Layout and stacking

- **`position: fixed`** with `bottom` / `left` (and on small screens, `right`) keeps the bar above page scroll.
- **`z-index`** should be high (e.g. `9999`) so the banner stays above headers, overlays, and widgets.

### Enter / exit animation

Two visual states:

1. **Default (in DOM but not “shown” for animation):** `opacity: 0`, `transform: translateY(16px)`, with `transition` on `opacity` and `transform`.
2. **Visible:** A class such as **`.is-visible`** sets `opacity: 1` and `transform: translateY(0)`.

When the user dismisses, script removes `.is-visible` first; when the transition finishes, script sets **`hidden`** again so the element is fully removed from interaction and layout.

### `hidden` and `display`

Pair the attribute with an explicit rule so `[hidden]` maps to `display: none` (covers browsers that rely on your stylesheet for `hidden` behavior in complex layouts).

### Generic example

Map `--your-*` tokens to your design system (colors, spacing, radii, shadows).

```css
.cookie-banner {
  position: fixed;
  bottom: var(--your-spacing-md);
  left: var(--your-spacing-md);
  z-index: 9999;
  display: flex;
  align-items: center;
  gap: var(--your-spacing-sm);
  max-width: 480px;
  padding: var(--your-spacing-sm) var(--your-spacing-md);
  background: var(--your-color-surface);
  border: 1px solid var(--your-color-border);
  border-radius: var(--your-radius-md);
  box-shadow: var(--your-shadow-lg);
  opacity: 0;
  transform: translateY(16px);
  transition: opacity 0.4s ease, transform 0.4s ease;
}

.cookie-banner[hidden] {
  display: none;
}

.cookie-banner.is-visible {
  opacity: 1;
  transform: translateY(0);
}

/* Narrow screens: stack text and actions */
@media (max-width: 540px) {
  .cookie-banner {
    left: var(--your-spacing-sm);
    right: var(--your-spacing-sm);
    max-width: none;
    flex-direction: column;
    align-items: stretch;
  }

  .cookie-banner__actions {
    justify-content: flex-end;
  }
}
```

### In this theme

Styles are in [`style.css`](../style.css) under **`/* 14b. Cookie Banner */`**. Design tokens use the `--mci-*` prefix. The accept button reuses `.btn.btn-primary` for visual consistency with the rest of the theme.

---

## 4. JavaScript behavior

### Storage key

Use a **namespaced** key per project, e.g. `yourproject_cookies_accepted`, to avoid collisions with other scripts or embeds.

### Flow

1. Select the banner by id.
2. If the element is missing **or** `localStorage.getItem(STORAGE_KEY)` is truthy → **exit** (banner stays hidden).
3. Otherwise: **`removeAttribute('hidden')`**, force a reflow (e.g. `element.offsetHeight`), then **`classList.add('is-visible')`** so the CSS transition runs from the initial state.
4. On **Accept** or **Close**: **`classList.remove('is-visible')`**, listen for **`transitionend`** once, then **`setAttribute('hidden', '')`**, and **`localStorage.setItem(STORAGE_KEY, '1')`**.

The reflow step ensures the browser applies the non-visible styles before adding `is-visible`, so the fade/slide-in is visible on first display.

### Generic example

```javascript
(function () {
  var STORAGE_KEY = 'yourproject_cookies_accepted';
  var banner = document.getElementById('{BANNER_ID}');

  if (!banner || localStorage.getItem(STORAGE_KEY)) {
    return;
  }

  banner.removeAttribute('hidden');
  banner.offsetHeight; // reflow
  banner.classList.add('is-visible');

  function dismissBanner() {
    banner.classList.remove('is-visible');
    banner.addEventListener(
      'transitionend',
      function () {
        banner.setAttribute('hidden', '');
      },
      { once: true }
    );
    localStorage.setItem(STORAGE_KEY, '1');
  }

  var accept = banner.querySelector('.cookie-banner__accept');
  var closeBtn = banner.querySelector('.cookie-banner__close');
  if (accept) accept.addEventListener('click', dismissBanner);
  if (closeBtn) closeBtn.addEventListener('click', dismissBanner);
})();
```

### localStorage vs HTTP cookies

| Approach | Typical use |
| -------- | ----------- |
| **`localStorage`** | Simple client-only “already answered” flag; no server round-trip; **not sent** with HTTP requests; **per-origin** (scheme + host + port). |
| **`document.cookie`** | Readable by client and sent on requests to the same site (depending on attributes); can align with server logic. |
| **Server `Set-Cookie`** | SSR, consent APIs, or **subdomain-wide** policies when attributes are set carefully. |

Choose based on legal advice, product requirements, and whether the server must see consent on first request.

### In this theme

Logic is in [`assets/js/main.js`](../assets/js/main.js): storage key **`mci_cookies_accepted`**, element id **`mci-cookie-banner`**.

---

## 5. Accessibility

**Already in the reference markup:**

- **`role="dialog"`** and **`aria-label`** on the container identify the consent region.
- **Dismiss control** uses **`aria-label="Dismiss cookie banner"`** because the visible text is a glyph.

**Optional enhancements** (not required for a minimal bar, but useful for strict modal semantics):

- **`aria-modal="true"`** if you treat the banner as blocking the rest of the page.
- **Focus management:** move focus into the banner when it opens and return focus to a sensible element when it closes.
- **Keyboard:** ensure Accept and Close are focusable and operable (native `<button>` satisfies this).

---

## 6. Checklist for porting

- [ ] **Ids and classes** — Avoid collisions with other components; keep the BEM block name consistent if you copy CSS wholesale.
- [ ] **Storage key** — Unique per site or product (`brand_cookies_accepted`).
- [ ] **Script loading** — Run after the banner exists in the DOM (defer, end of body, or bundled app entry).
- [ ] **Styles** — Swap design tokens; confirm contrast and touch targets on mobile.
- [ ] **Legal copy** — Match your privacy/cookie policy and jurisdictions (this doc is not legal advice).
- [ ] **Analytics / tags** — If required, gate third-party scripts on the same consent signal (extend JS or use a CMP/tag manager).

---

## Reference implementation map

| Concern | File |
| ------- | ---- |
| HTML | [`footer.php`](../footer.php) |
| CSS | [`style.css`](../style.css) — section **14b. Cookie Banner** |
| JS | [`assets/js/main.js`](../assets/js/main.js) — cookie banner block |
