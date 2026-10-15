# B4 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `72980db`

**Scope:** B4 from [the implementation plan](implementation-plan-final3.md): compact service discovery, answers before media, and final actions before related navigation.

## Changes

- Added a shared discovery renderer and small data file for the existing home/overview descriptions and overview images. Destinations, ordering and default labels use the existing eight-entry service catalogue. The PV card uses “Solar- und PV-Reinigung” to avoid an awkward compound-word break; the full catalogue label and service H1 remain unchanged. No service is presented as more popular or commercially preferred.
- Replaced the home icon-heavy cards with compact text cards. Each H3 is the actual navigation link, visibly underlined with a directional cue. The article itself has no click handler or wrapping link; location cards retain their independent targets.
- Moved the eight linked services to the first main section of `/leistungen/`, under an explicit H2. Kept all eight existing overview photos/alts with controlled, shorter crops.
- Moved all 30 existing specialist terms behind the main choices into four native disclosure groups. The terms remain in the HTML and can be expanded with the keyboard. The user confirmed that “Hygiene-, Desinfektions- und Reinraumreinigung” remains offered; its wording is retained without adding certification or other claims.
- Reworked each service lead, body and sidebar together. The body answers four questions in order: suitability, possible work and boundaries, planning/inspection, and useful enquiry details. Removed repeated generic planning formulas in favour of existing service-specific facts.
- Preserved all 56 scope-list items, 64 suitability tags and 24 regional link anchors. Material/access qualifications, inspection before stain treatment, optional documentation, and agreed handover/extra-cleaning boundaries remain explicit.
- Moved the six portrait video figures after the planning answer. Their complete markup remains unchanged, including source, poster, controls, `playsinline`, `preload="none"`, captions and fallback text. Büro/Gewerbe and Entrümpelung receive no new videos.
- Moved each service's final action before the related-service section in actual DOM order. For all nine local pages, extracted the existing two alternative-city routes into `related_links` page configuration. The shared template renders this navigation after the final action, with the original FAQs still before it. The old blocks were removed rather than duplicated.
- Kept related navigation visually secondary through smaller heading roles and compact spacing. Removed obsolete icon/card/catalogue CSS with no remaining consumers.
- Reviewed all eight service metadata/schema descriptions against the preserved scope. No material discrepancy required a metadata change; titles, canonical URLs, breadcrumbs and structured data remain intact.
- Rebuilt generated CSS with the actual PHP builder and changed the common asset version to `1.1.4`.

## Content boundaries preserved

| Service | Material qualification retained |
|---|---|
| Büro/Gewerbe | Agreed cleaning plan, intervals, execution times and object-specific work |
| Glas/Fenster | Frames/rebates by agreement; scope and safe access checked for the actual surfaces |
| Grund/Spezial | Suitable materials, surface condition and type of residue determine the method |
| Teppich | Suitable loose/fixed carpets; method and stain treatment depend on material and inspection |
| Polster | Cover, condition and stains checked before deciding a suitable treatment |
| Entrümpelung | Inspection where useful, broom-clean handover by agreement, additional cleaning agreed separately |
| Fassade/Graffiti | Substrate, contamination and access determine feasibility; no universal method promised |
| Solar/PV | Suitable modules and safe access checked first; material-conscious method and optional documentation |

No prices, drying times, disposal obligations, outcome guarantees, qualifications, references or other new business claims were invented.

## Verification

| Check | Result |
|---|---|
| PHP syntax | All 51 changed/new PHP files passed `php -l`, including the discovery helper/data |
| Route/metadata preservation | All 28 routes retain one H1 with the same text, title/meta/canonical/schema/breadcrumbs; no unexpected HTTP or JavaScript errors |
| Content integrity | Independently compared all 56 scope items, 64 suitability tags, six complete video figures and 24 regional link anchors; all preserved |
| Local content/order | All nine local content remainders are unchanged apart from the extracted terminal block. All 27 original FAQ entries remain before the close; all 18 alternative-city links retain their exact labels, targets and order, after the final action |
| Service order/media | All eight final actions precede related-service navigation. Suitability, scope and planning answers precede all six videos. Videos remain paused at time 0 with `preload="none"`; no new video was added to the other two services |
| Discovery/catalogue | All eight routes remain selectable on home/overview. Overview choices precede the 30 exact specialist terms. No nested anchors, article click handler or whole-card link; all four native groups can be opened by keyboard and expose all terms |
| Responsive layout | 200 route/width states across 320/390/768/980/981/1080/1081/1440/1920/2560 px; no horizontal overflow, clipped-text reports or CTA/policy failures |
| Enlarged browser fonts | Actual Chromium 20 px and 32 px browser defaults: 102 states each; no reflow failures |
| Text spacing | 68 states using 1.5 line height, .12em letter spacing, .16em word spacing and 2em paragraph spacing; no overflow or clipping |
| B3 regression | 56 route/policy states plus early offer, footer/Backtop and catalogue checks passed; existing primary/final destinations and WhatsApp policy retained |
| Keyboard focus | New discovery title links and disclosure summaries retain the visible 3 px focus ring; summary focus stays inside its boundary |
| Independent editorial review | All eight edited lead/body/sidebar sets checked without a lost relevant qualifier, unsupported promise or metadata contradiction |
| Visual review/final fixes | 16 representative route/viewport combinations reviewed. Shortened PV card labels and closed-neighbour alignment were fixed and rechecked. A further 64 one-open-group states at normal/enlarged fonts and text spacing passed without stretching, overflow or focus loss |
| B1/form regression | All five steps, native service labels, estimate option, review/edit, keyboard upload selection/removal, helper/error references, invalid styling and reduced-motion Backtop passed at 320/390/768/1440 px |
| Form/transport preservation | Offer/Contact markup, core/form scripts, schema and handlers are byte-identical to B3. Test requests were intercepted; no real contact/offer was sent |
| CSS build | Actual PHP builder used; repeat build byte-identical and bundle matches the ten ordered source modules |
| Additional browser | Not installed; cross-browser validation remains open |

Baseline and new discovery heights were measured with their own HTML/CSS at the same viewport and 16 px browser default. Grid and enclosing section are reported separately, rounded to CSS pixels:

| Page / viewport | Old grid | New grid | Old section | New section |
|---|---:|---:|---:|---:|
| Home / 390 px | 2,573 | 1,189 | 2,851 | 1,447 |
| Home / 1440 px | 872 | 377 | 1,235 | 696 |
| Services / 390 px | 3,873 | 2,300 | 3,969 | 2,402 |
| Services / 768 px | 1,970 | 1,176 | 2,066 | 1,278 |
| Services / 1440 px | 1,198 | 762 | 1,366 | 915 |

At 390 px the formerly expanded specialist section measures about 278 px with its four groups closed, compared with 2,051 px before. Expanding the native groups keeps all 30 terms available; no content was removed to meet a height target.

The text-spacing harness temporarily bypassed CSP through Chromium's debugging protocol for test-only style injection. Normal checks retained the actual CSP; production policy and security headers are unchanged. The keyboard-file-chooser harness explicitly brings its browser page to the foreground before activation; no form change was required.

Generated CSS SHA-256: `3b93d63ed75d0c83e9edb879d66085a5d13681bf9eb3ace519e6458751af4f13`.

## Remaining batches

B5–B9 remain unstarted. Offer destinations remain generic; B5 will implement service/city context together with visible form initialisation. Form relevance, progress/success behaviour and the remaining company/gallery/task content stay in their planned batches. Additional-browser validation remains open because only Chromium is installed and the configured second-browser package source is blocked by network policy.

The original audit remains a record of its original website baseline. Earlier implementation records describe their own completed batches; this record documents B4.
