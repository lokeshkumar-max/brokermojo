# BrokerMojo WordPress Theme

The BrokerMojo landing page as a fully admin-managed theme. The design, CSS
and animations are the original build, unchanged.

## Install
1. Install **one** fields plugin (Plugins → Add New):
   - **Secure Custom Fields** (free, includes repeaters) — recommended, or
   - **ACF PRO**, or
   - **Advanced Custom Fields** (free — lists use fixed slots with a "Show" switch).
2. Appearance → Themes → Add New → Upload Theme → choose `brokermojo.zip` → Activate.
3. Open the WordPress admin once. The theme creates a **Home** page, sets it as
   the front page and fills every field with the original content (images are
   copied into the Media Library).

## Edit
Pages → **Home**. One tab per section:
Hero · Network Gap · Connect · Inventory · How It Works · Features · Statement ·
Why BrokerMojo · Testimonials · Pricing · FAQ · Header · Footer · App Popup ·
Mobile Bar · Brand & Contact · SEO & Settings.

- **Brand & Contact** holds values used in many places (store links, email,
  phone, address, launch note, logo).
- **Heading — orange part** is the accent text shown in brand orange.
- **Icons** are SVG code fields; leave them as they are to keep the current icons.
- Adding or removing steps / features / cards updates the scroll animations,
  dots and "01 / 06" counters automatically.
- An empty image field falls back to the original image, so a layout never
  loses its picture.
- Testimonial videos: upload an MP4/WebM, or paste an embed URL
  (e.g. `https://www.youtube.com/embed/VIDEO_ID`).

## Tools — Appearance → BrokerMojo
- **Restore original content** (overwrites all fields).
- **Convert lists** — shown if you switch between free ACF and ACF PRO / SCF.

## Notes
- The WordPress admin bar is hidden on the front end by default (it covers the
  fixed header). Turn it on under *SEO & Settings*.
- With Yoast / Rank Math / AIOSEO / SEOPress active, the theme leaves the title,
  description and social tags to that plugin.
- WordPress' own block/global styles are not loaded on the home page.

## Files
- `assets/css/main.css`, `assets/js/main.js` — the original stylesheet and script
- `inc/schema.php` — every editable field
- `inc/defaults.php` — the original content
- `template-parts/sections/*` — one file per section
