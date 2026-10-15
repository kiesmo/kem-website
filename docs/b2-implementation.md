# B2 implementation record

**Date:** 15 October 2026, UTC

**Branch:** `final3` · **Starting commit:** `ab7875a`

**Scope:** B2 from [the implementation plan](implementation-plan-final3.md): type roles, readable measures and responsive page introductions. Verification results are recorded below.

## Changes

- Defined shared display, H1–H3, lead, body, label, meta and action sizes and line heights. Body text now uses `1rem`, giving the same 16 px default while respecting the browser's default font size. Existing system fonts and brand colours remain.
- Applied those roles to navigation, cards, content, form labels/help, review text and footer text. Retained deliberate compact footer/legal/review roles and the B1 choice-label specificity, field boundaries, focus and prose-link rules.
- Gave the home heading a continuous display scale instead of competing breakpoint overrides. Its panel participates in document flow, allowing the hero to grow with enlarged copy. The home layout remains its own composition.
- Let the home introduction cards wrap according to their text width, avoiding narrow three-column titles. Aligned the first local/service article heading with its sidebar after extracting the old intro.
- Replaced the image-only page-hero renderer with `kem_render_page_intro()`: visible title, lead, optional eyebrow, media, actions and the transitional mobile enquiry block. It escapes text/URLs and keeps visible copy separate from SEO titles. Each route retains one H1.
- Service introductions use the existing `config/services/*.php['article']` fields. Nine local introductions now have one source in their existing page configurations. Six standalone pages use the same renderer. Existing substantive copy, article sections, FAQs, sidebar contents and final bands are preserved.
- Contact, FAQ and Jobs use compact introductions without their decorative hero images. Services, locations, service overview, company and gallery use copy beside controlled media on desktop and copy before media on smaller screens. The existing per-image focal-point classes are retained.
- Added opt-in `.prose` with a `64ch` maximum for long service/local/company/legal copy, tuned against rendered lines rather than the nominal unit alone. Contact body paragraphs receive the same measure without narrowing the form. `.narrow` retains its existing 870 px layout limit; FAQ and gallery retain their own container alignment.
- Kept heading width independent of prose width: compact H1s have their own `26ch` maximum, while intro leads use the prose measure at their lead font size.
- Collapsed the article/sidebar and intro grids together at the nominal 980 px boundary. The sidebar becomes static at that same boundary, resolving the former two-column 821–980 px arrangement. The existing generic mobile offer block remains available in service/local intros until B3.
- Kept `object-fit: cover` throughout the viewport range. Home imagery has a centred 1920 px maximum with intentional navy framing beyond that width; there is no abrupt 1921 px fit-mode switch. Inner-page media remains within the content container. Removed the obsolete hero rules and late home overrides.
- Kept the compact-menu boundary at 1080 px with a 16 px browser default, expressed as `67.5em` in both CSS and JavaScript. At a larger browser default it switches sooner to accommodate larger navigation text. The related content/CTA boundary uses `61.25em` for the same reason.
- Made the nominal 820/560 px responsive refinements follow the browser default too. Grid tracks can shrink without expanding to the longest German word, and long text/URLs can wrap. This fixes enlarged-text overflow in service lists, navigation links, home cards, contact fields and footer columns.
- Gave the desktop header a font-relative maximum width, controlled navigation line height and row-sized hit areas. The topbar height also follows the font default. Enlarged text therefore stays within the header rather than overlapping its neighbouring rows.
- Rebuilt `public_html/assets/css/styles.css` with the actual PHP build script and incremented the shared asset version to `1.1.2`.

## Verification

| Check | Result |
|---|---|
| PHP / JavaScript syntax | All 36 changed PHP files passed `php -l`; `main.js` passed `node --check` |
| Rendered content preservation | All 28 routes compared with `ab7875a`: identical visible H1 text, one H1 each, original lead present once, unchanged SEO/title/meta/canonical/schema/breadcrumbs, H2 sequence and main-content link target counts |
| Ordinary responsive layouts | 11 route families × 15 widths = 165 states; no horizontal overflow, clipped-text reports, JavaScript errors or unexpected HTTP failures |
| Widths checked | 320, 390, 700, 701, 768, 820, 821, 980, 981, 1080, 1081, 1440, 1920, 1921 and 2560 px |
| Transitional offer action | All eight services and nine locations at 390/980/981 px: one mobile enquiry block through 980, hidden at 981 with the default font; existing destination and label retained |
| Home type boundaries | H1 is 28 px at both 700/701; 31.36/31.392 px at 980/981, with no abrupt size reduction |
| Text spacing | 32 states across eight route families: 1.5 line height, .12em letter spacing, .16em word spacing and 2em paragraph spacing; no overflow or clipped-text reports |
| Browser default fonts | Actual Chromium browser defaults set through CDP, rather than a CSS-only root override: 20 px in 32 states and 32 px in 48 states; all passed reflow checks |
| Additional 200% text stress | Doubled every element's computed font size without changing viewport width in 24 states; no horizontal overflow or clipped-text reports after fixes |
| Menu synchronisation | 14 font/width combinations at defaults 16/20/32 px; CSS and JS switch together at 1080/1350/2160 px. Tab access, dropdown activation, Escape and focus return passed in compact mode |
| Header geometry | 15 actual-default-font states including breakpoint adjacencies: visible navigation, logo, CTA and topbar text remain within their rows. Header text-spacing checks and desktop dropdown keyboard/focus checks also passed at defaults 16/20/32 px |
| Rendered reading measure | Sampled actual text-line rectangles at 390/981/1440/2560 px. Desktop service paragraphs generally 70–74 characters per full line, local paragraphs 66–76, contact body about 63 and legal text mostly 64–74, with an occasional longer line. Mobile lines shorten naturally |
| Visual review | Home, service overview/detail, local, company, gallery, Contact, FAQ and Jobs reviewed at 390/1440 px, plus ultrawide imagery. Awkward home title wrapping and first-heading/sidebar misalignment were found, fixed and checked again |
| B1 regressions | Five-step form, native label selection, estimate option, review/edit, keyboard upload selection/removal, helper/error descriptions, focused invalid state and reduced-motion Backtop passed at 320/390/768/1440 px |
| Delivery side effects | Browser-intercepted form-error fixtures only; no request reached the contact endpoint or SMTP |
| CSS output | Actual PHP builder used; repeat build is byte-identical and the generated bundle matches the ten ordered source modules |
| Additional browser | Not available: Chromium is the installed runtime; the configured second-browser package source remains blocked by network policy. Cross-browser validation remains open |

The text-spacing harness temporarily bypassed CSP through Chromium's debugging protocol to inject test-only styles. Normal route checks retained the website's actual CSP; no production security header or policy was changed.

The additional computed-font doubling is a diagnostic, not the browser-default test: it leaves root-relative geometry and media queries at 16 px while forcing individual elements to twice their calculated size. Its desktop header still overlaps vertically under that artificial override. The actual 32 px browser default, including wide-screen header geometry, passes. This diagnostic limit must not be read as a clean result for every possible custom stylesheet.

Generated CSS SHA-256: `a700ee72e1fbb728a6f64870726fad99e513a72d1898f142eb8fd5448baf3057`.

## Remaining work

At completion of B2, B3–B9 were unstarted. [B3 has since been implemented](b3-implementation.md), replacing the transitional mobile CTA and floating WhatsApp control. B4–B9 remain unstarted: content/media ordering, contextual offer URLs, conditional form rules and progress/success behaviour remain assigned to their existing batches. No real contact message or offer was submitted during verification.

B2's handover required B3 to disable `mobile_offer` when replacing its intro actions; B3 removed the obsolete helper, configuration and styles together. Existing hero tag configuration remains unused display metadata and can be cleaned up with subsequent page-specific work.

The audit continues to describe its original website baseline. This record describes the B2 changes rather than rewriting historical findings as though they were observations of the new implementation.
