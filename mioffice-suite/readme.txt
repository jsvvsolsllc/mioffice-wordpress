=== MiOffice Suite ===
Contributors: jsvvsolsllc
Tags: pdf, image, video, converter, compressor
Requires at least: 5.0
Tested up to: 6.7
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed MiOffice browser-based PDF, image, video, and AI applications on any WordPress page or post. Files never leave the visitor's browser.

== Description ==

MiOffice Suite lets you embed 66+ browser-based document processing applications directly into your WordPress site using simple shortcodes.

**Key Features:**

* **PDF Suite** — Merge, split, compress, convert, edit, rotate, protect, and unlock PDFs
* **Image Suite** — Compress, resize, crop, convert images. HEIC to JPG, WebP to JPG, and more
* **Video Suite** — Compress, convert, trim videos. Video to GIF, video to MP3
* **AI Suite** — Remove backgrounds, remove objects using on-device AI models
* **Scanner Suite** — Scan documents, receipts, IDs, whiteboards, and QR codes to PDF

**Privacy First:**

All processing runs entirely in the visitor's browser using WebAssembly (WASM). No files are uploaded to any server — not to your WordPress host, not to MiOffice, nowhere. Documents stay on the visitor's device.

**How It Works:**

The plugin embeds MiOffice applications via responsive iframes. Each application loads directly from mioffice.ai and processes files client-side using:

* **pdf-lib** — PDF manipulation in JavaScript
* **FFmpeg WASM** — Video processing compiled to WebAssembly
* **ONNX Runtime** — AI model inference in the browser
* **Canvas API** — Image processing without server round-trips

== Installation ==

1. Upload the `mioffice-suite` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use `[mioffice tool="merge-pdf"]` in any page or post

== Usage ==

**Embed a single application:**

`[mioffice tool="merge-pdf"]`

**Custom dimensions:**

`[mioffice tool="compress-image" width="100%" height="600"]`

**Show all applications in a category as a grid:**

`[mioffice category="pdf"]`
`[mioffice category="image"]`
`[mioffice category="video"]`
`[mioffice category="ai"]`
`[mioffice category="scanner"]`

**Available categories:** pdf, image, video, ai, scanner

See Settings → MiOffice Suite for the full list of application slugs.

== Frequently Asked Questions ==

= Do files get uploaded to any server? =

No. All processing happens in the visitor's browser using WebAssembly. Files never leave the device.

= Does this plugin slow down my site? =

No. The iframe loads lazily and only when the visitor scrolls to it. The plugin adds zero JavaScript or CSS to your site outside of the iframe.

= Can I embed multiple applications on one page? =

Yes. Use multiple `[mioffice]` shortcodes on the same page.

= Does it work on mobile? =

Yes. The embeds are fully responsive. MiOffice includes server-side fallback for mobile browsers that don't support WebAssembly.

= Is this plugin compatible with Gutenberg? =

Yes. You can add the shortcode in a Shortcode block or in the Classic Editor.

== Screenshots ==

1. PDF Merge application embedded on a WordPress page
2. Image compression application with drag-and-drop
3. Category grid showing all PDF applications
4. Admin settings page with available shortcodes

== Changelog ==

= 1.0.0 =
* Initial release
* Shortcode support for 30+ applications across 5 categories
* Responsive iframe embeds with lazy loading
* Category grid view for listing all applications in a suite
* Admin settings page with usage reference

== Upgrade Notice ==

= 1.0.0 =
Initial release.
