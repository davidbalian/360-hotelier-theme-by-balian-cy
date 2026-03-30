# Hover smooth underline

## Default links (`style.css`)

The underline is **not** `text-decoration`. It is a **1px-tall background** that grows horizontally:

1. `background-image: linear-gradient(currentColor, currentColor)` — solid line in the link’s text colour.
2. `background-position: 0% 100%` and `background-repeat: no-repeat` — anchor the line along the bottom of the text.
3. Default `background-size: 0% 1px` (invisible). On hover: `100% 1px` (full width).
4. `transition: background-size 150ms ease` — animates the reveal.

Hover is wrapped in `@media (hover: hover) and (pointer: fine)` so touch devices do not rely on hover-only feedback. `:focus-visible` also sets `background-size: 100% 1px` for keyboard users. `:active` adds a light `transform: scale(0.98)`.

## Exceptions

- **≤768px:** Hover/focus underline is turned off on generic `a` (full-width block links looked like heavy bars). Focus still gets a visible outline.
- **Primary nav** (parent items with submenu + submenu links): Site-wide gradient is disabled; see below.
- **`a:has(img)`** and **`.btn`:** No underline (image links and buttons).

## Primary nav parent link (`assets/css/parts/01b-primary-nav-submenu.css`)

Those links skip the background trick and use **`a::after`**: a 1px bar with `width: 0` → `width: 100%` and `transition: width 0.25s ease` on hover, focus-visible, or when the submenu is open. That keeps the chevron layout clean and matches the “glide” underline for that row only.
