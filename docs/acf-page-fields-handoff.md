# Handoff: Custom ACF fields for page text and images

This document explains how the 360 Hotelier theme wires **Advanced Custom Fields (ACF)** to page content, and how to add the same kind of **bilingual text** and **image** fields for **other** page contexts (About, Services, Portfolio, and so on) in a consistent way.

---

## 1. Architecture snapshot

### Schema (hardcoded defaults)

Each major page “type” is identified by a **context** string: `home`, `about`, `services`, `service`, `portfolio`, `contact`, `founder`, etc.

- Contexts and their field definitions live in PHP files under `inc/page-meta/schema/` (for example `schema-home.php`, `schema-about.php`).
- The registry class `Hotelier_Page_Meta_Schema` loads those files in `class-hotelier-page-meta-schema.php`.
- Each field is an array with at least:
  - `type`: usually `text`, `textarea`, or `image`
  - `label`: editor-facing description
  - `default` (for copy) or `default_url` (for images)

Templates call `Hotelier_Page_Content::get_text( $post_id, $context, $field_key )` and `get_image_url( ... )` using the same `$context` and schema field keys.

### Greek defaults

When the visitor is on Greek (`/el/…`), `hotelier_get_current_lang()` returns `el`. If ACF does not supply a value, copy falls back to:

1. `Hotelier_El_Page_Defaults::get( $context, $field_key )` when a string exists for that pair  
2. Otherwise the English `default` from the schema file

Keys in the EL map are conceptually `{context}.{field}` (for example `about.hero_title`). See `inc/translations/el/class-hotelier-el-page-defaults.php`.

English and Greek **share the same WordPress page** (same post ID); language is determined by URL prefix, not by separate posts.

### Front-end resolution (where ACF plugs in)

`Hotelier_Page_Content::get_text()` and `get_image_url()` are the single entry points for theme templates.

**Important:** ACF is only used where the theme **explicitly** checks for it. Everything else stays schema + EL defaults (and hero/CTA special cases). Today:

- **Home** text: `Hotelier_Home_Text_Acf_Field` (when `context === 'home'`)
- **Home** images (except hero + bottom CTA band): `Hotelier_Home_Image_Acf_Field`
- **Hero background** (`hero_bg`): `Hotelier_Hero_Image_Field` (`hotelier_hero_image`)
- **Bottom CTA image** (`cta_feat_img`): `Hotelier_Cta_Feat_Image_Field` (`hotelier_cta_feat_image`)
- **SEO** document title / meta description: separate resolver, not `get_text()`

### Locale helper

`hotelier_get_current_lang()` is defined in `inc/i18n/hotelier-i18n-bootstrap.php` and returns `en` or `el`.

---

## 2. What already exists (reference)

| Feature | Field group class | Location rules | Meta / field names | How the front end resolves |
|--------|-------------------|----------------|--------------------|----------------------------|
| SEO title + description (EN / EL) | `Hotelier_Seo_Meta_Field` | All pages (`post_type == page`) | `hotelier_seo_title_en`, `hotelier_seo_description_en`, `…_el` | `Hotelier_Seo_Meta_Resolver` (theme-managed pages only) |
| Hero background | `Hotelier_Hero_Image_Field` | Front page + templates in `Hotelier_Acf_Image_Location_Rules` | `hotelier_hero_image` | `get_image_url` when field is `hero_bg` |
| Bottom CTA band image | `Hotelier_Cta_Feat_Image_Field` | Same location set as hero | `hotelier_cta_feat_image` | `get_image_url` when field is `cta_feat_img` |
| Homepage copy (EN / EL) | `Hotelier_Home_Text_Acf_Field` | Static front page only | `hotelier_home_{schema_key}_en` / `_el` | `get_text` when `context === 'home'` |
| Homepage images | `Hotelier_Home_Image_Acf_Field` | Static front page only | `hotelier_home_{schema_key}` (excludes `hero_bg`, `cta_feat_img`) | `get_image_url` / `get_attachment_id` when `context === 'home'` |
| One-time defaults into ACF | `Hotelier_Seo_Meta_Seeder`, `Hotelier_Home_Text_Acf_Seeder`, `Hotelier_Home_Image_Acf_Seeder` | — | Options like `hotelier_*_seed_version` | Hooked on `acf/init` at priority **20** (after field registration) |

All of these classes are loaded and registered from `inc/page-meta/hotelier-page-meta.php` (`require_once` + `::register()`).

---

## 3. Recipe: Add bilingual **text** ACF for another context (example: `about`)

### Naming

Use a **prefix that matches the context** and does not collide with existing keys, for example:

- `hotelier_about_{schema_key}_en` and `hotelier_about_{schema_key}_el`

Avoid reusing `hotelier_home_*` or `hotelier_seo_*` patterns for non-home / non-SEO data.

### New field group class

Mirror the structure of `Hotelier_Home_Text_Acf_Field`:

1. On `acf/init`, call `acf_add_local_field_group()`.
2. Loop `Hotelier_Page_Meta_Schema::fields_for_context( 'about' )` (or your target context) and include only `text` and `textarea` fields.
3. For each schema key, register **two** subfields (EN / EL) with labels derived from the schema `label` plus a language suffix.
4. Set `default_value` from the schema `default` for English; for Greek use `Hotelier_El_Page_Defaults::get( 'about', $key )` when non-empty, otherwise the English default (same pattern as home).
5. **Location rules** must match **every** page where templates call `get_text( …, 'about', … )`. Often that is a single template (e.g. `page-templates/template-about.php`). Confirm with a repo search for `'about'` as the context argument—do not guess.

### Resolver: connect ACF to `get_text()`

Extend `Hotelier_Page_Content::get_text()` (or introduce a small helper it calls) so that when:

- `$context` is your target (e.g. `'about'`), and  
- the field is one of your managed text fields, and  
- `get_field()` returns a non-empty string for the **current** language,

…then return that string **before** falling back to EL defaults and schema.

**Home vs other pages:** Homepage text ACF reads from the **static front page ID** via `Hotelier_Page_Content::front_page_id()`. For About, Services, etc., the value is almost always stored on **the page being edited**—use the `$post_id` passed into `get_text()` (typically the same as `get_queried_object_id()` on that template). Align this with your ACF location rules so editors see fields on the same post the front end reads.

### Seeder (optional but recommended)

Copy the pattern from `Hotelier_Home_Text_Acf_Seeder`:

- Store a version in an option (e.g. `hotelier_about_text_acf_seed_version`).
- On `acf/init` priority 20, if the version is outdated, loop pages that should receive defaults (by template, slug, or ID list), and for each field call `update_field()` only when the current value is empty.

Bump the version constant when you add new schema keys so existing sites can backfill once.

### Admin layout (save space)

For EN / EL pairs, use ACF `wrapper` `width` `50` on each field so they sit on one row. Use `100` on **tab** fields so a new tab starts on a full row. The SEO and homepage text groups already follow this pattern.

---

## 4. Recipe: Add **image** ACF for another context

### Naming

Single image per logical field (shared across languages unless you deliberately split):

- Example: `hotelier_about_{schema_key}`

### Do not duplicate hero / bottom CTA

If the template uses schema key `hero_bg` or `cta_feat_img`, those are already wired to `hotelier_hero_image` and `hotelier_cta_feat_image` on the allowed templates. Exclude those from a new “page images” group or you will confuse editors with two pickers for the same thing.

### New field group class

Mirror `Hotelier_Home_Image_Acf_Field`:

1. Loop schema fields with `type === 'image'` for your context, minus any keys you exclude (hero / CTA / etc.).
2. Use ACF `image` fields with `return_format` => `id`.
3. Set `mime_types` to include `svg` only for fields that need SVG (e.g. inline logo markup).

Location rules must again match every page that calls `get_image_url( …, $context, … )` for those keys.

### Resolver

Extend `Hotelier_Page_Content::get_image_url()` for your `$context` and managed field list: read the attachment ID from `get_field()`, then resolve a public URL (`wp_get_attachment_image_url` or `wp_get_attachment_url` for non-image attachments such as SVG).

If any template uses `get_attachment_id()` (for example inline SVG), extend that method the same way for the relevant field keys.

### Seeder

Same idea as `Hotelier_Home_Image_Acf_Seeder`: for each non-empty `default_url` in the schema, run `attachment_url_to_postid()`. If the file exists in the Media Library at that URL, save the ID with `update_field()` when empty. If the URL is not in the library, the seeder cannot guess an ID—front end will keep using schema `default_url` until someone picks an image in ACF.

---

## 5. Checklist before shipping

- [ ] Grep templates for `get_text` and `get_image_url` with the target `$context` so ACF **location rules** match every relevant page.
- [ ] Ensure every ACF **field key** (`key` => `field_…`) is unique across all local groups.
- [ ] Test English and Greek URLs; clear ACF values and confirm fallbacks to schema + `Hotelier_El_Page_Defaults`.
- [ ] Bump seed version when adding new fields so deployments can populate empty meta once.
- [ ] Register new classes in `inc/page-meta/hotelier-page-meta.php`.

---

## 6. Out of scope and pitfalls

- **Portfolio gallery** uses the “ACF Photo Gallery Field” plugin and a field name `portfolio_gallery` configured in the WP admin; the theme reads IDs via `Hotelier_Portfolio_Gallery_Store` (`inc/admin/portfolio-gallery/`). That path is separate from the schema loop described above.
- **FAQ** sections use `Hotelier_Faq_Content` and gettext strings, not `schema-*.php`, for most copy.
- **File size:** Prefer keeping each new class under ~500 lines; generate field arrays in loops (as home text/images do) or split a thin “config” from registration if needed.

---

## Quick file map

| Concern | Path |
|--------|------|
| Schema registry | `inc/page-meta/class-hotelier-page-meta-schema.php` |
| Schema files | `inc/page-meta/schema/*.php` |
| `get_text` / `get_image_url` | `inc/page-meta/class-hotelier-page-content.php` |
| Bootstrap | `inc/page-meta/hotelier-page-meta.php` |
| Greek defaults map | `inc/translations/el/class-hotelier-el-page-defaults.php` |
| Hero / CTA location rules | `inc/page-meta/class-hotelier-acf-image-location-rules.php` |
