# CSS efficiency and reuse (360 Hotelier theme)

Use this when adding or changing styles so the theme stays maintainable and avoids redundant rules.

## 1. Tokens first (`style.css` `:root`)

- **Colours, spacing rhythm, radii, shadows, typography scale** live in [style.css](../style.css) under `:root`. Add new values there instead of hard-coding hex values, repeated `6rem`, or magic numbers in component CSS.
- Examples already in use: `--section-padding-y`, `--color-section-gray`, `--hero-overlay-*`, `--radius-card`, `--shadow-card`, `--text-*`.

**Before writing a new rule, ask:** can this be a variable used in multiple places?

## 2. One source of truth per pattern

| Pattern | Approach |
|--------|----------|
| Section vertical padding | `padding-block: var(--section-padding-y)` (mobile overrides the token in the shared `@media` block, not per-section lists). |
| Purple hero/band overlays | `section-overlay` + optional `section-overlay--strong`; gradient stops from `:root`. |
| Card lift on hover | Shared selectors in [assets/css/parts/01-global-header.css](../assets/css/parts/01-global-header.css) (transition + `:hover`). Component rules keep layout/surface only. |
| Identical grids | Merge selectors (e.g. two blocks sharing the same `grid-template-columns`) or one utility class—do not copy-paste the full grid declaration. |
| Section titles / subtitles | Extend grouped selectors (`front-section__*` / `page-section__*`) or introduce a neutral BEM block once if you rename markup. |

**Before duplicating a block of 3+ declarations, ask:** does another class already do this, or can I group selectors?

## 3. File organisation

- Main styles are split under [assets/css/parts/](../assets/css/parts/); load order is defined in [inc/enqueue.php](../inc/enqueue.php). **Put new rules in the partial that matches the feature** (e.g. inner pages → part 05), and **keep each file under ~500 lines**; add a new partial if a file grows too large, then enqueue it in order.
- **Do not** reintroduce a single monolithic `main.css` unless you have a build step that bundles partials.

## 4. Markup and BEM

- Prefer **one overlay pattern** for full-bleed heroes/bands: absolutely positioned overlay + content with `position: relative; z-index: 2`.
- Keep **modifier naming consistent** (`--center`, `--strong`, `--white`) rather than new one-off class names for the same visual.
- When PHP introduces a new section, reuse existing blocks (`page-section`, `page-section__heading`, `section-overlay`) before inventing `page-foo__section` with duplicate padding.

## 5. Editor vs front

- [assets/css/editor-style.css](../assets/css/editor-style.css) is loaded after `style.css` in the block editor. **Rely on `:root` tokens from `style.css`** for sizes and colours; keep editor-only rules minimal and **aligned** with front-end heading/body scale (see comment in `editor-style.css`).

## 6. Quick checklist (before opening a PR)

1. No new hard-coded `#f4f5f7`-style greys if a token exists or should exist.
2. No new `padding-block: 6rem` on sections without `var(--section-padding-y)` (unless explicitly exceptional).
3. No second copy of the same `linear-gradient` overlay—use variables + shared classes.
4. Card-style components either match the shared lift pattern or document why they are different.
5. New CSS lives in the correct `parts/*.css` file; enqueue updated if you add a file.

## 7. Optional next improvements (backlog)

- Unify heading markup under a neutral `section-heading` BEM block across PHP + style guide.
- Shared **surface** classes for white panels (radius + shadow + padding variants).
- Prose width tokens (`--prose-narrow`, `--prose-wide`) for `max-width` in `ch` / `px`.
- Merge `posts-loop` grid with other `auto-fill` / `auto-fit` grids only where the track definition is truly identical.
