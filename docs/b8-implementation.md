# B8 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `95d4a12df4299330098cb4a919620419c6045390`

**Scope:** B8 from [the implementation plan](implementation-plan-final3.md): organise Contact, FAQ and Jobs around their immediate tasks using B2's intro contract and B3's action policy. Preserve B7's shared Contact submission behaviour and B5/B6 offer context and field rules.

## Contact: direct details before the message form

- A compact “Kontakt” title and short lead are followed immediately by a direct-contact panel. Phone, email and telephone hours now precede the complete form in both source and mobile reading order. The links and hours come from `config/site.php`; they are not separately hard-coded in the wrapper.
- Telephone hours remain Monday–Saturday, 08:00–17:00. The adjacent note preserves the distinction between telephone availability and cleaning appointments: appointments are by agreement and can take place outside those hours.
- “Nachricht senden” introduces the existing short form. One paragraph distinguishes a general message from the detailed offer request. The latter uses B3's action helper as an underlined inline link to the existing generic `/angebotsanfrage/` URL; it does not imply a service or city selection.
- The company card retains the company name, complete Brühl address and country, local service-area links and a quiet inline WhatsApp option. Repeated phone/email/hours and duplicate area prose were consolidated into their respective sections. There is no new sales band or row of competing filled contact buttons.
- The entire `<form>…</form>` source and its rendered markup are byte-identical to the starting commit. All seven named controls, required/optional states, limits, types, autocomplete, honeypot, privacy link, submit action, AJAX hook and status region remain intact. The privacy row receives scoped grid styling so the native checkbox aligns with normal-weight text and errors can use the full row.

Contact's source is `public_html/kontakt/index.php`; only its visible intro changes in `config/pages/kontakt.php`. Contact metadata, canonical URL and schema remain unchanged.

## FAQ: questions immediately after the introduction

- The shorter “Häufige Fragen” title/lead leads directly to the ten native disclosures. The task section and list no longer add a second large top gap after the intro.
- Existing questions and answers are preserved exactly. Their new order follows the task: cost, free/unbinding enquiry, enquiry process, helpful information, individual calculation, frequency, one-off/regular work, out-of-hours cleaning, later scope changes and service area. In original-position notation this is **8, 9, 1, 6, 5, 2, 7, 3, 4, 10**.
- `config/pages/faq.php` repeats those same ten pairs in the same order in `FAQPage.mainEntity`. No answer or factual claim was expanded. Other metadata and schema fields remain unchanged.
- Native `<details>`/`<summary>` behaviour is retained. Summaries have a minimum 60 px height; a separate grid track keeps the plus/minus indicator apart from wrapping question text. Focus treatment remains visible inside the card. These layout rules are scoped to `.task-page--faq`; the nine local pages keep their existing shared FAQ styling.
- The final action still goes to Contact. FAQ remains the only current navigation entry on this page. No search/filter control or extra offer action is added to the FAQ content.

FAQ's wrapper is `public_html/faq/index.php`; the repeated structured answers and visible intro are in `config/pages/faq.php`.

## Jobs: application route and supported facts first

- The shared compact intro keeps the full role title and a shorter lead. It now includes “Bewerbung per E-Mail senden” before the job details. It uses the existing `kem_application_action()` helper and the same email/subject as the unchanged final application action and B3's task policy.
- “Die Stelle auf einen Blick” is a semantic definition list rendered from the new presentation-only `job_facts` configuration. All three facts already appeared in the prior visible copy:

| Label | Existing supported wording |
|---|---|
| Start | Zum nächstmöglichen Zeitpunkt |
| Vertrag | Unbefristeter Arbeitsvertrag |
| Vergütung | Übertarifliche Bezahlung |

- The original two task items, two requirements and three employer benefits are preserved exactly. Separate labelled sections and spacing/rules distinguish these groups. Contract and pay remain in the benefits as well as the short summary.
- The existing preparation image, neutral alternative text and lazy-loading/dimensions are retained. It is not described as a photograph of the actual KEM team. The sidebar continues to identify Brühl as the headquarters; it does not claim a confirmed assignment area for this vacancy.
- The complete `JobPosting` block is unchanged, including `datePosted: 2026-08-12` and `validThrough: 2026-11-10T23:59:59+01:00`. The shared `head.php` expiry filter is unchanged. The short lead and facts remain consistent with the existing schema description; no schema date, salary amount or employment type was invented.

**Still missing factual inputs:** weekly hours/employment scope, actual job assignment area, a named application contact, required documents, the application process and verified company/team media. These remain open content inputs; the page adds none of them. The existing expiry filter controls schema output; it does not automatically remove or close the visible vacancy after expiry. B8 preserves that behaviour and does not establish a new vacancy date or renewal policy.

Jobs' wrapper is `public_html/jobs/index.php`; its intro, facts and existing schema are in `config/pages/jobs.php`.

## Shared styling and protected boundaries

The three wrappers use `.task-page` with a page-specific modifier, a compact intro and `.task-content`. Contact's direct panel and Jobs' fact list use responsive grid tracks, children with `min-width: 0` and wrapping text so long content can reflow. The existing palette, type tokens, system fonts, card language, route set and global header/footer remain in use. Source styles are in `resources/css/03-pages.css` and `07-gallery-faq.css`; the public bundle is generated by `php tools/build-css.php`.

No JavaScript, form policy/schema, request preparation, API endpoint, upload, mail transport, shared intro/action helper, global template or media file changes belong to this batch. The offer page remains unchanged, including the user-confirmed furnishing applicability for office, general, carpet, clearance and other cleaning.

## Verification

| Check | Result |
|---|---|
| Syntax and existing data contracts | All seven changed PHP files lint. `php tools/check-offer-context.php`: 456 checks; `php tools/check-offer-request.php`: 604 checks. `git diff --check` passes |
| Independent source/render comparison | 295 assertions against the starting commit pass. All 28 routes render; the other 25 pages retain their complete rendered HTML and configuration apart from asset-version URLs. Global headers/footers, media, target-page metadata and 19 protected source/transport boundaries remain unchanged |
| Contact contract | Source and rendered form are byte-identical, including all seven named controls. Browser field attributes match the baseline; direct phone/email/hours occur before the form. The detailed-offer and WhatsApp choices are inline links |
| Offer links and task policy | All 131 existing tagged offer actions and all 132 offer URLs remain intact. Contact's existing plain offer link now uses the helper, making 132 tagged actions without adding a URL. Six mobile/desktop states verify Contact/FAQ/Jobs header, mobile-menu and footer task actions, current navigation and final destinations |
| Contact responses | Eight locally intercepted outcomes pass: success, 422 email error, 429, 500, non-JSON, malformed JSON, null JSON and network failure. Success resets the fields and focuses status; failures retain values, and the field error marks/focuses email |
| FAQ keyboard and semantics | 369 checks pass at 320/390/1440 px, including 120 native Enter/Space toggle transitions, Tab order, visible focus, summary targets, navigation and exact ten-pair visible/schema ordering. Accessibility-tree checks resolve the actual summary DOM nodes and expose native disclosure roles and changing expanded states |
| Shared B7 offer regression | Two intercepted submissions exercise a 422 failure followed by success. Values/files are retained on failure; confirmation and cleanup work on success; deliberate new request returns to a clean, context-free first step |
| Jobs facts and expiry | All seven original list items and exactly three previously supported facts are preserved. The full JobPosting block is unchanged. Six isolated before/after expiry assertions confirm past/invalid dates omit JobPosting and a future date emits it; no runtime date is fabricated in production code |
| Reflow | 48 page/width/text states pass: all three pages at 320/390/768/1440 px, with normal text, actual 20/32 px browser defaults and spacing overrides. Contact is populated and FAQ answers are expanded. Checks include inner-element geometry rather than relying only on document width |
| Short viewports | 26 focus checks in six reduced-height viewports pass, covering direct contact, form/privacy/actions, FAQ summaries and application links below the sticky header. These simulate available viewport space; they are not a real mobile keyboard test |
| Visual review | 21 page/viewport combinations pass, covering 320/390/768/1440 px, 390 × 568 px and actual 20/32 px text at 390 px. Direct details, disclosure indicators, job facts, content groups and early/final actions reflow without a remaining defect |
| Independent documentation review | Contact, FAQ and Jobs claims, schema dates, missing facts and preserved boundaries were checked against the final source. A technically imprecise description of the responsive grid tracks was corrected |

At 390 px with the normal 16 px browser default, Contact's direct panel starts at y=306.8 before the form at y=854.8; FAQ's first question starts at y=311.4; Jobs' early application action starts at y=413.9. The application button also fits in the tested 568 px-high viewport. These are layout observations, not conversion or completion-time claims.

All browser API submissions were intercepted locally. No live message, application or SMTP delivery was triggered. Phone, email and WhatsApp destinations were inspected without activating them. Browser runs reported no JavaScript page errors or unintended real endpoint requests. Chromium is the available browser; additional-browser and real-device/screenreader validation remain open. Font checks assert actual computed sizes in fresh contexts; enlarged-text screenshots use current-viewport capture to preserve those sizes.

CSS was generated by the actual PHP builder and independently matched against all ten ordered source modules. Shared asset version is `1.1.8`. Final CSS SHA-256: `a5b2f2d1eb6221cbb340e67dbf0744f415bc4787f521010d3c5395c5771e71a3`.

## Remaining work

B8's source implementation is complete. B9 has not started; gallery, company evidence and local-content work retain their planned scope. The [implementation plan](implementation-plan-final3.md) tracks current progress; earlier batch records describe their own baselines. Additional-browser and real-device/screenreader validation remain open.
