# KEM website – verified implementation plan

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3`

**Verified website baseline:** `00f1fe3b7750e0315f3ec0224a887f1a0e74b2d1`. Commit `48273b01ab4eba318c1a9083530caac930834904` added only the original audit; it did not change website code.

**Input:** [Corrected design audit](design-audit-final3.md), findings A01–A32, checked against actual PHP, CSS, JavaScript, configuration and content. Audit section 11 records the corrections.

**Status:** B1–B5 source implementation is complete; see the [B1](b1-implementation.md), [B2](b2-implementation.md), [B3](b3-implementation.md), [B4](b4-implementation.md) and [B5 implementation records](b5-implementation.md) for changes and validation limits. Additional-browser validation remains open. B6–B9 have not started. This plan was originally created during the verification-only stage; sections below describe the intended work and acceptance criteria.

## 1. Implementation decisions

1. Keep the existing PHP architecture, route set, brand palette, system fonts and core component language. No framework migration, new font dependency or JavaScript build pipeline is needed.
2. Use an early CTA in normal document flow. Remove the global floating WhatsApp overlay rather than introducing a different fixed mobile bar. Preserve WhatsApp as a secondary inline contact option where useful. This resolves the conflict between early action and unobscured content.
3. Establish typography and reading-width roles before accepting new page layouts. Repair the label specificity bug before assessing form-card density. Later batches use these roles; they do not redefine them globally.
4. Distinguish page tasks: commercial pages request an offer; Jobs invites applications; FAQ offers further contact; Contact supports direct contact/message; the offer page advances and submits its form. Do not put an offer-band or a second sales CTA on every page.
5. Use a shared page-intro contract with variants, not separate improvised header systems for every page. Keep the visible H1 distinct from the SEO/browser title. Each page retains exactly one content H1.
6. Carry offer context through explicit allowlisted data. A generic building-cleaning city page supplies a city, **not** the `general` service: `general` means Grund-/Spezialreinigung.
7. Treat conditional fields as a data contract spanning visibility, enabled/required state, browser validation, review, server validation and email output. Hiding an element alone is insufficient.
8. Preserve the existing five-step form, multi-service selection, optional phone/photos, estimate option and final review. Make state and relevance clearer before considering a different number of steps.
9. Add no invented references, staff identities, qualifications, location claims, job facts, response guarantees or measured conversion gains. Safe structural improvements proceed using existing verified content; missing evidence remains explicitly open.

### What has actually been corrected in the audit

The cross-check confirmed the core findings but corrected or qualified the following:

- 2,851 px is the entire mobile services section; the card grid itself is approximately 2,568 px.
- The home H1 is also smaller than the regular H2 at desktop widths, and falls from 31.2 to 24.8 px between 980 and 981 px.
- `.field label` overrides the intended service-card and estimate-label styles. Computed card text is smaller/heavier than the component declarations alone suggest.
- The sidebar is sticky above 980 px. Empty right-hand space is not a universal desktop problem to fill with new content.
- Reduced-motion smooth scrolling was reproduced in Chromium, strengthening the original code-only finding.
- The stepper-label contrast rounds to 4.64:1, not 4.65:1; the assessment is unchanged.
- The upload helper omits the existing 15 MB combined limit. Both client and server already enforce it.
- Object type is universally required on the server; two floor/access fields exist; three handlers participate in the offer-success reset.
- Only nine of 23 final bands have an inline WhatsApp action: home plus eight service details. Other final-band variants should not be rewritten as though they did.
- Jobs already says “zum nächstmöglichen Zeitpunkt” and mentions contract/pay conditions. The regional distinction between Brühl headquarters and Köln/Bonn service areas is already correct.
- Source references, main-content versus global-navigation claims, card-link semantics and the earlier four-package roadmap were clarified.

## 2. Actual architecture and its implications

This table records the verified pre-implementation baseline. B2 has since replaced the image-only hero helper and migrated visible intro fields; B3 introduced the action contract and replaced the transitional mobile enquiry block; B4 added shared discovery cards and local related-link configuration/rendering; B5 connected explicit service/city offer context to editable form initialisation. Current sources are documented in their implementation records.

| Area | Actual source of truth | Consequence for implementation |
|---|---|---|
| Route map | `config/pages.php`, 28 entries | Preserve URLs and public wrappers unless a change is specifically needed |
| Page metadata | `config/pages/*.php`; loaded by `app/helpers/pages.php` | Hero, breadcrumbs, final-band mapping and structured data are page configuration |
| Service content | `config/services/catalog.php`, eight `config/services/<slug>.php` files | Existing `article.title/lead/eyebrow` supply visible service intros; do not copy SEO titles into H1 |
| Service rendering | `app/templates/service-template.php`; eight body/summary pairs | One template change reaches eight pages; body order and summary links still need their own changes |
| Local rendering | `app/templates/location-template.php` directly includes nine `content/locations/*.php` files | H1/lead, grid, sidebar, FAQs and related-city links are currently inside the content files; changing the template alone is insufficient |
| Shared renderers | `app/helpers/render-components.php` | Current hero renders only image/badge; mobile CTA accepts only a label and has a generic URL; neither already supports the proposed contracts |
| Content inclusion | `app/helpers/html.php` | Final fragments use dynamic substitution; service summaries do not. PHP helper calls work in both; unsupported `{{offer_url}}` placeholders do not |
| Final bands | 23 `content/ctas/*.php` fragments | 21 offer bands, FAQ contact, Jobs email application; five pages have no separate band |
| Standalone pages | `public_html/index.php`, individual route `index.php` files | Home uses its own hero despite `hero => NULL`; standalone content is not all config-driven |
| Form markup | `public_html/angebotsanfrage/index.php` | Existing `type_*` flags and `cleaning_city` can carry contextual preselection without adding POST fields |
| Form state | Two IIFEs in `public_html/assets/js/forms/offer-form.js` | Step navigation and field/upload/review state have separate listeners that must remain coordinated |
| AJAX submission | `public_html/assets/js/core/main.js` | Shared with Contact; offer-specific success changes must not break Contact |
| Validation/transport | `config/forms/schemas.php`, `app/forms/contact-handler.php`, `app/forms/photo-upload.php` | Unknown POST fields are rejected; browser changes must match server rules and mail rows |
| Styling | Ten modules in `resources/css/00–09` | Modify sources, then generate `public_html/assets/css/styles.css` with `tools/build-css.php` |
| Cache version | `config/site.php::asset_version` | CSS and both JS entrypoints use the same version; update deliberately for an implementation release |

There is no need to turn all content into a new CMS. Extract only the shared intro/action structure required for consistent behaviour. Preserve the existing content/config split where it works.

## 3. Batch boundaries and dependencies

Each batch is a cohesive, reviewable implementation unit with its own checks. These are not size quotas. A batch may use several commits if that improves review, but its acceptance criteria remain one unit. Generated CSS belongs with the source changes that produced it.

| Batch | Outcome | Main prerequisite |
|---|---|---|
| B1 | Recognisable links, fields, focus and form labels | Existing baseline |
| B2 | Consistent type, reading widths and responsive page intros | B1 label/focus baseline |
| B3 | Clear primary/final actions, no floating overlap, compact footer | B2 intro/action slots |
| B4 | Faster service choice and answers before media | B2/B3 component contracts |
| B5 | Correct service/city context from CTA to form | B3 action contract; finalised service routes remain unchanged |
| B6 | Relevant fields with matching client/server/review/mail rules | B5 context initialisation |
| B7 | Clear form progress, density and persistent success | B1/B2 plus B5 → B6 |
| B8 | Contact, FAQ and Jobs organised around their tasks | B2/B3; B7 for shared Contact status regression |
| B9 | Useful gallery/local/company evidence without invented claims | B4/B5; only new factual content depends on evidence |

Recommended implementation order: **B1 → B2 → B3 → B4 → B5 → B6 → B7 → B8 → B9**, followed by an integration gate. Approved-copy/media collection can run alongside B1–B8. B8's content work can proceed earlier once B2/B3 are stable, but changes to shared form scripts should remain serial through B5–B7.

Do not split B5 into “all links now, form support later”, B6 into “hide fields now, server later”, or B7 into independently shipped reset handlers. Those are end-to-end behaviour changes that belong together.

## 4. Detailed batches

### B1 – Interaction and accessibility correctness

**Audit coverage:** A10–A13, the selector/cascade part of A23, the active-navigation correction in A27, A30 and A31's complete accessible help.

**Why together:** These are bounded corrections to the existing controls and their visible states. They provide a reliable baseline before changing density or page geometry.

**Changes**

1. Separate functional field borders from decorative card borders. Add a field-border token and light/dark focus tokens in `00-tokens.css`. Preserve the existing brand colours; calculate at least 3:1 for necessary field boundaries and authored focus indicators on their actual adjacent surfaces.
2. Give content links a permanent non-colour indicator, normally an underline with a controlled offset. Scope it to prose/content contexts. Audit overrides in local, summary, legal and contact content; do not underline every navigation item, button or entire multi-link card.
3. Correct both the global focus ring and the FAQ-specific ring. Ensure rings are not clipped by card/dropdown overflow.
4. Apply a visible focus treatment to the upload container using the input's focus, such as `:focus-within`; keep the transparent native input and label functional.
5. Resolve `.field label` specificity deliberately. Restrict generic label styling to actual field labels or give service/estimate components suitable specificity. Restore the intended checkbox/text alignment; normalise title and explanation weights. Do not just append a later `.service-choice` declaration with the same inadequate specificity.
6. Add stable IDs and additive `aria-describedby` for upload/phone help. Preserve the existing `ensureFieldError()` behaviour, which already merges error references rather than replacing the whole attribute.
7. Make upload help truthful: JPG/PNG/WebP, maximum five files, maximum 5 MB each, maximum 15 MB combined. Keep the existing limits and server checks.
8. Change the Backtop click handler to request an immediate scroll when reduced motion is enabled. Do not rely on the CSS media query to override an explicit JavaScript `smooth` request.
9. Set FAQ's active main-nav key to FAQ alone. Retain the existing native details, menu Escape/focus-return behaviour and skip link.

**Files**

- `resources/css/00-tokens.css`, `01-base.css`, `03-pages.css`, `05-offer-form.css`, `07-gallery-faq.css`, `08-offer-conversion.css`; relevant link overrides in `09-local-pages.css`.
- `public_html/angebotsanfrage/index.php`, `public_html/faq/index.php`.
- `public_html/assets/js/core/main.js`; markup help IDs where needed, without rewriting the AJAX flow.
- Generated CSS after implementation.

**Acceptance**

- Computed service-choice layout is the intended component layout; helper text is not accidentally 11.47 px/800 and titles are not accidentally weight 900.
- Content links are visible without hover and in grayscale; navigation/button patterns remain clear.
- Keyboard focus is visible on white, soft surfaces, blue and navy, including FAQ, menu and upload.
- Upload announces help plus errors without losing either description; visible limits match JS and PHP.
- Reduced-motion Backtop jumps immediately in Chromium and is checked in the chosen second browser.
- FAQ has exactly one current main-nav page. No API request or real message is needed for these checks.

### B2 – Typography, reading widths and responsive page-intro architecture

**Audit coverage:** A02, A07, A08, A14, shared-layout part of A28, A29.

**Why together:** Type roles determine wraps and heights. Hero, intro and breakpoint composition should be accepted against final roles rather than changed again in a late “polish” batch.

**Changes**

1. Define display/H1, H2, H3, lead, body, label, meta and action roles once. Keep the current system font. Use relative body sizing with a 16 px default appearance and verify increased browser-default font sizes.
2. Consolidate selected redundant weights/sizes while preserving intentional footer/card/meta differences. A smaller count is not itself the objective; predictable roles are.
3. Give home a stronger display role. Remove the abrupt 980/981-px H1 reduction and evaluate the 700/701-px transition. The proposed 28–34 px mobile display range is a design starting point, not a hard requirement divorced from content.
4. Define a small shared intro interface for visible title, lead, optional eyebrow, optional media and an action slot. These are proposed additions, not existing helpers. Use compact variants for Contact/FAQ/Jobs; use controlled media-plus-copy variants for sales/company pages.
5. Preserve home as a deliberate special composition. Its current hero is handwritten in `public_html/index.php`, so changing `kem_render_page_hero()` alone will not fix it.
6. For service pages, source the visible title/lead from existing `config/services/<slug>.php['article']`; remove their duplicate old article H1 when the new intro owns it. Preserve or migrate the existing early mobile CTA and its availability during this layout-only transition.
7. For local pages, move their repeated intro fields into a single per-page source, preferably an explicit `intro` group in the existing local `config/pages/*.php`. Let the shared template render that intro and remove the old H1/lead output from all nine local content files. Migrate the existing generic mobile CTA into the intro with its current availability, or retain the old helper until B3 replaces it atomically. B2 must not remove the current action before its replacement exists. Keep substantive sections/FAQs in content files. Do not leave two title sources or attempt to strip rendered HTML with regular expressions.
8. For standalone pages, migrate only what is needed to use the shared variant. Preserve SEO title, breadcrumbs and structured data independently of the visible intro.
9. Separate prose measure from layout width. Use approximately 60–75 characters as an initial prose target; do not globally narrow every `.narrow` element if it also contains layout content.
10. Respect the real sidebar behaviour: sticky above 980 px, static below. Evaluate the two-column 821–980 zone and choose its collapse/sticky behaviour based on content. Do not add filler blocks to occupy supposed universal empty space.
11. Decide a single coherent ultrawide image treatment as part of the hero change. Remove or replace the abrupt 1921-px `cover`→`contain` override; retain deliberate focal points and avoid stretching.
12. Remove superseded home/hero rules from the relevant modules, especially late overrides in `09-local-pages.css`. Keep CSS and the JS compact-menu boundary aligned; keep 1080 px unless the new header actually requires a change.

**Files**

- `resources/css/00-tokens.css`, `01-base.css`, `02-components.css`, `03-pages.css`, `04-responsive.css`, `06-service-pages.css`, `09-local-pages.css`; other modules only when applying a defined role.
- `app/helpers/render-components.php`, `app/templates/service-template.php`, `app/templates/location-template.php`.
- `public_html/index.php` and affected standalone page entrypoints.
- Nine local `config/pages/*.php` files and all nine `content/locations/*.php` intro blocks. Existing service article configuration remains the title source.
- Generated CSS; `main.js` only if the actual menu breakpoint changes.

**Acceptance**

- One H1 per route; no SEO-title suffix accidentally used as the content heading; no duplicated lead or early CTA. Existing mobile CTA availability is preserved until B3 installs the replacement.
- Home type is stable at 700/701 and 980/981 px. New geometry works at 320/390, 768, 820/821, 1080/1081, 1440, 1920/1921 and 2560 px.
- Contact/FAQ/Jobs can present their task promptly without a 470-px decorative lead-in. B8 will refine their actual task content.
- No horizontal overflow, clipped words or unintentional free image bands. Test 200% text, 320-CSS-px reflow and text-spacing overrides.
- Readability is checked from actual lines, not inferred solely from a pixel width.

### B3 – Primary/final actions, contact-surface policy and footer

**Audit coverage:** A01, A03, A04's competing channels, A06, CTA-availability part of A28, A32.

**Why together:** Early, final, alternative and global contact actions must follow one hierarchy. Removing an overlay while creating another competing action would fail the same objective.

**Changes**

1. Put the home offer action with its H1/lead. Use one dominant filled action and, if useful, a quieter service-selection link.
2. Render an early offer action for service/local intros at all relevant widths. Replace the old mobile-only helper output where the intro now provides the action; do not retain a duplicate CTA box simply because it already exists.
3. Define one small action-rendering contract using explicit label, destination/page context and optional secondary contact. Preserve a stable place for the page key or explicit context so B5 can add URL resolution without redesigning the component.
4. Use that contract for early, sidebar and final actions where practical. Existing PHP fragments can call a shared helper directly. Do not introduce unsupported dynamic placeholder strings in summaries.
5. In the nine final bands that currently repeat WhatsApp, reduce it to a secondary inline option. Do not add WhatsApp buttons to the 14 bands that do not currently contain one.
6. Preserve task exceptions: FAQ final → `/kontakt/`; Jobs final → existing application email; Contact, Offer and utility pages keep no extra sales band. A sales-page final CTA should use the same offer process as its early action.
7. Remove the global floating WhatsApp element and its obsolete positioning/responsive rules. Remove only its now-unused footer-visibility observer/class behaviour; retain unrelated Backtop/menu logic. Keep the business WhatsApp URL centrally configured.
8. On the offer page, use the step/submit action as the primary task; reduce the prominent pre-form WhatsApp area now, with final density/progress work in B7. Do not show a competing “request an offer” loop in its header/footer.
9. On Jobs, define header/menu/footer action policy around application, using the existing verified email route. B8 will build the facts and application content around it. Avoid independent desktop/mobile policies.
10. Compact footer groups and spacing, preserving address, phone, email, region, opening hours and legal links. Keep it as a fallback/orientation layer rather than another full conversion section.

**Files**

- `app/templates/header.php`, `app/templates/footer.php`, `app/helpers/render-components.php`; a small action helper if needed, loaded through `app/bootstrap.php`.
- `public_html/index.php`, offer-intro action markup, service/local intro integration.
- `content/ctas/startseite.php`, eight `content/ctas/leistungen-*.php` action groups; other CTA fragments only where the shared primary pattern is adopted, preserving their distinct secondary content.
- `resources/css/02-components.css`, `03-pages.css`, `04-responsive.css`, `06-service-pages.css`, `09-local-pages.css`; corresponding obsolete observer in `main.js`.
- Generated CSS.

**Acceptance**

- At 390/768/1024/1440 px a sales page has an early visible offer path outside the menu. Short-height screens do not require a fixed bar or clipped content.
- No fixed chat action overlays text, fields, menu or focus at any scroll position.
- One visually dominant action per decision area. FAQ/Jobs/form actions have the correct destination.
- Header desktop/menu and footer agree with page purpose. Essential contact/legal data remain accessible without collapsed traps.
- B5's context contract is specified; B3 does not claim that generic links already preserve service/city.

### B4 – Service discovery, catalogue and answer-before-media flow

**Audit coverage:** A09, A15, A16, A20; completion order from A06.

**Why together:** What users choose and what the selected page answers are one information path. This is structural editorial work using existing verified content, not dependent on new photography.

**Changes**

1. Put the eight linked main services early on `/leistungen/`, with a clear H2. Move the 30 unlinked specialist terms into a compact secondary grouping or relevant main-service explanation. Preserve genuinely offered specialist work; confirm ambiguous specialised claims rather than silently inventing or deleting capabilities.
2. Make home discovery more compact. Until real demand/business priorities are confirmed, use a neutral understandable grouping and preserve all eight services. Do not invent a “most popular” ranking or highlight arbitrary services as business leaders.
3. Keep service cards semantically clear: a title/link navigates; an article is not automatically a whole-card link. Multi-link location cards must retain independent targets. Improve clickable affordance without nested links.
4. On all eight service bodies, arrange suitability → scope/boundaries → process/evidence → relevant questions → final action. Move the six first-position portrait videos after a concise substantive answer. Büro/Gewerbe and Entrümpelung do not need new videos for symmetry.
5. Retain media controls, posters, `playsinline` and no autoplay. Keep accessible explanatory content available without playback.
6. Edit service lead/body/summary together to remove redundant planning formulas while retaining material/access qualifications and useful sidebar summaries. Prefer four user questions over repeated generic assurances.
7. In `service-template.php`, place the first clear final action before the large related-service section. For local pages, keep useful objection-answering FAQs before the close. Extract the existing two alternative-city routes from each content file into a small related-links configuration/renderer, then let `location-template.php` render that navigation after `kem_render_page_cta()`. This deliberately removes the old pre-final copy rather than appending a duplicate. Update DOM order, not only CSS visual order.
8. When service promises change materially, reconcile the visible text with `description`/`schema_extra` in the corresponding page configuration. This is consistency work, not an SEO expansion.

**Files**

- `public_html/index.php`, `public_html/leistungen/index.php`.
- Eight `config/services/<slug>.php`, eight `content/services/<slug>/body.php`, eight summaries where wording changes.
- `app/templates/service-template.php`, `app/templates/location-template.php`, related-links renderer/configuration and the relevant sections in all nine local content files/local page configs.
- `resources/css/03-pages.css`, `06-service-pages.css`, `09-local-pages.css` and generated CSS.
- Corresponding `config/pages/leistungen-*.php` only for actual metadata/schema consistency changes.

**Acceptance**

- A known service is selectable without first scanning 30 plain list points in the main content.
- All eight service pages explain the service before a tall video. No lost scope qualifiers or artificial new guarantees.
- Final action is a clear close; related routes remain available but secondary.
- Compare actual mobile grid/section heights separately. No arbitrary height target that removes useful content.
- No fake priority labels, no changed route URLs, no inaccessible whole-card construction.

### B5 – Contextual offer entry, end to end

**Audit coverage:** A05, context aspects of A19/A28.

**Why together:** Link generation, context validation and visible form initialisation are one feature. Ship them together so a specific CTA never promises a preselection the destination ignores.

**Proposed contract**

- Add a small PHP offer-URL/context helper, for example in `app/helpers/offers.php`, loaded in `app/bootstrap.php`. The name is proposed; no such helper currently exists.
- Add explicit service→form-key data to the existing service catalogue or a single offer configuration. Do not derive the key from the last URL segment.
- Add explicit `offer_context` to local page configuration: `city` plus service for Büro/Fenster, city only for generic Gebäudereinigung.
- Use GET parameters only to initialise existing checked `type_*` inputs and `cleaning_city`. No new POST provenance field is necessary; unknown POST fields are rejected today.
- Parse only scalar allowed context values. Ignore unknown keys, arrays and invalid combinations; escape when rendering and encode when creating URLs. Manual city input remains as flexible as the current form; the prefill allowlist does not prohibit other manually entered locations.

| Source service | Existing form key | Existing POST checkbox |
|---|---|---|
| Büro/Gewerbe | `office` | `type_office` |
| Glas/Fenster | `window` | `type_window` |
| Grund/Spezial | `general` | `type_general` |
| Teppich | `carpet` | `type_carpet` |
| Polster | `upholstery` | `type_upholstery` |
| Entrümpelung | `clearance` | `type_clearance` |
| Fassade/Graffiti | `graffiti` | `type_graffiti` |
| Solar/PV | `solar` | `type_solar` |
| Generic header/home/company CTA | No service | No automatic selection |
| Generic building-cleaning city page | City only | No `type_general` inference |

**Changes**

1. Implement the explicit mapping and URL helper with a generic fallback.
2. Wire all early, sidebar and final service/local destinations through it: eight summaries, 17 service/local final fragments and nine local contents, plus shared intro/mobile-action renderers. Keep global entry generic unless explicitly associated with the service page.
3. In PHP form rendering, validate incoming context and pre-check the existing service input/fill the city. Let existing `syncServicePanels()`/`updateReview()` see that initial state. If a JS initialiser is used instead, it must explicitly synchronise panels/required fields/review once.
4. Show the selection visibly and leave it editable. Stay on step 1; allow adding another service. Do not repeatedly apply URL values after a user's edits or on every step transition.
5. Keep canonical URL and structured page identity query-free. Do not prefill postcode, street, customer identity or appointment from the selected city/service.

**Files**

- Proposed `app/helpers/offers.php`, `app/bootstrap.php`, `config/services/catalog.php`; optional single `config/forms/offer.php` for shared offer rules.
- Nine local `config/pages/*.php` context entries; existing page/intro helpers.
- Eight summaries, 17 service/local CTA fragments, nine local content files where links still originate.
- `public_html/angebotsanfrage/index.php`, `public_html/assets/js/forms/offer-form.js` only as required for initialisation.

**Acceptance**

- Every one of eight service routes produces the correct form key from all its CTA locations.
- All nine city routes carry the correct city. Büro/Fenster carry the right service; three general building pages carry no inferred service.
- Generic entry, unknown values, array-valued parameters, edited selection, second service, Back/Next, review-edit and browser return all remain understandable.
- Form submission uses existing field names; no unexpected-field rejection. Canonical remains `/angebotsanfrage/`.
- Add small meaningful mapping/initialisation checks; do not create dozens of tests that merely repeat identical link markup.

### B6 – Conditional field relevance and one consistent data contract

**Audit coverage:** A21 and related review/data consistency.

**Why together:** The browser and PHP currently agree on universal object type. A purely visual reduction would create invisible required-field errors or misleading review/email output.

**Changes**

1. Write the field-relevance matrix before changing visibility. Separate location/identity, optional operational details and service-specific questions. Use the union of relevant fields for multi-service selections.
2. Keep postcode/city as the current universal location inputs. Keep object type required for the initial implementation unless the business confirms it is unnecessary for specified services; any conditional removal must update both markup and the server enum/requirement check in the same batch. A CSS-only hiding change is excluded.
3. Make optional floor/furnishing questions conditional based on the agreed use case. Pure PV should not be forced through irrelevant furnishing questions. Avoid asserting that floor/access is never relevant to window/facade work; access requirements can depend on the actual job.
4. Consolidate `floor` and `clearance_floor` into one clearly explained visible floor/access answer where they refer to the same object. Define which existing POST value remains authoritative and how legacy submissions are handled. Normalise once; review and mail must not show conflicting duplicates.
5. Distinguish object/company from customer/company. Offer an explicit one-time copy action only where useful; never silently overwrite a separately entered customer company.
6. Synchronise `hidden`, `disabled`, `required`, estimate/read-only state, step validation, review inclusion and mail rows. Disabled fields should not leave hidden validation errors. Review must ignore non-applicable stale values even if retained in memory for re-selection.
7. Adjust `config/forms/schemas.php` only if field names actually change. Preserve honeypot, upload validation and existing limits. Normalise service selection on the server rather than trusting a display-only `cleaning_types` summary.
8. Keep browser and server requirements together, preferably driven from a small shared configuration for the relevance decisions, rather than maintaining unrelated parallel condition lists.

**Files**

- `public_html/angebotsanfrage/index.php`.
- `public_html/assets/js/forms/offer-form.js`: service sync, estimates, `getValue()`, review generation and reset handling.
- `app/forms/contact-handler.php`: object checks, selected services, applicable optional fields and mail rows.
- `config/forms/schemas.php`; proposed `config/forms/offer.php` if used for shared policy.
- CSS only as required for conditional group presentation; upload validator does not need a policy change.

**Acceptance**

- Window, regular office, upholstery, PV, clearance, window+PV and office+upholstery scenarios.
- Switching selections never blocks on a hidden required control; applicable fields remain required; manual and estimated values survive reasonable Back/Next/edit paths.
- Review, outgoing test payload and constructed mail rows describe the same applicable data. No duplicate contradictory floor/company answers.
- An old-format payload is either still understood or fails with a clear field error according to the explicitly documented compatibility decision.
- Test validation through isolated logic or stubbed transport. Do not invoke a production mail send to verify layout or relevance.

**Factual decision:** Final field relevance requires operational confirmation. Until supplied, preserve uncertain mandatory questions and improve optional grouping instead of inventing a business rule. This does not block B1–B5 or the independent progress/success improvements in B7.

### B7 – Form presentation, progress, review and success lifecycle

**Audit coverage:** A04's remaining form density, A22, A23's presentation/targets, A24; integration of A12/A13/A31 and B5/B6.

**Why together:** Progress, validation, review editing and success share the same form lifecycle. They should be accepted together after initialisation/relevance is settled.

**Changes**

1. Finish the compact offer intro: title, short reassurance and first selection task close together. WhatsApp is a secondary help path, not the first large filled action.
2. Refine the nine choice cards after B1's specificity fix. Preserve whole-label selection and multi-service capability; shorten redundant explanation and reduce unused padding before reducing readable text.
3. Implement distinct `current`, `completed`, `upcoming` step states with exactly one `aria-current="step"`. Keep the current step's text on mobile. Completed state can use a check; do not make indicators look like navigation unless they really navigate with validation support.
4. Preserve the existing live announcement and H2 focus. Keep required markers with their text. Align privacy checkbox/explanation, use normal-weight explanatory prose and give review-edit/remove actions comfortable touch areas.
5. Preserve review editability and ensure its contents follow B6 relevance. Group labels must clarify what will actually be sent.
6. Replace the offer-specific reset-to-step-1 success path with a persistent success panel and focused confirmation heading. Offer a deliberate “new request” action that performs the full clean reset. Do not retain personal data unnecessarily after completion.
7. Coordinate all three existing reset participants: global `main.js` `form.reset()`/`form:success`, the step-navigation IIFE and the service/upload/review IIFE. Define an explicit successful-offer event/state contract rather than letting all three continue firing their old behaviour.
8. Keep Contact's generic AJAX flow working separately. On server/network/JSON/validation errors, retain input and show the appropriate message/field/step. Check radio-group and upload error targeting against the actual `namedItem()` return type instead of assuming every field is one HTMLElement.
9. Confirmation says the request was transmitted, not that the requested appointment is booked. Explain the next known step without inventing a response SLA or customer confirmation email.
10. Measure the “2–3 minutes” statement using real representative tasks. Until measured, use neutral duration wording where it cannot be justified; update home and form consistently.

**Files**

- `public_html/angebotsanfrage/index.php`.
- `public_html/assets/js/forms/offer-form.js`, `public_html/assets/js/core/main.js`.
- `resources/css/03-pages.css`, `05-offer-form.css`, `08-offer-conversion.css`; generated CSS.
- `content/ctas/startseite.php` if duration wording changes. Server response text only if the actual promise needs adjustment, without changing transport.

**Acceptance**

- All five phases have an unambiguous current state on desktop/mobile; keyboard and screenreader perceive changes coherently.
- Context, multi-service applicability, estimate option, review edits and current step remain consistent.
- Simulated `ok:true`, 422 field errors, 429, 500, non-JSON and network-failure paths. Intercept the endpoint or use isolated transport; no real email.
- After success, confirmation remains the primary view. “New request” alone returns to a clean step 1; failure never resets completed input.
- Contact still reports its own success/error correctly. Upload removal/preview cleanup does not leave stale review data.
- Test 320/390 px, text enlargement, mobile keyboard space, focus position and privacy wrapping.

### B8 – Contact, FAQ and Jobs as task-focused pages

**Audit coverage:** A25, A26, remaining A27; application of A02/A06.

**Why together:** These pages answer an immediate task rather than a broad sales introduction. They use B2's shared intro and B3's action policy; they do not need independent design systems.

**Changes**

1. Contact: place phone/email and current opening hours near the compact intro, before the full form on mobile. Explain general message versus detailed offer in one short decision aid. Keep the short form and full address/contact card as needed.
2. Ensure the detailed-offer link is visibly a link/secondary action. Avoid presenting call, email, WhatsApp, short form and five-step form as five equally dominant buttons.
3. FAQ: bring the actual ten questions immediately after a short title/intro. Keep native details and generous summary targets. Prioritise price/process/unverbindlichkeit using existing factual answers; no search/filter feature is required for ten questions.
4. Keep FAQ's final contact route. Match any changed visible general FAQ answer to its duplicated `FAQPage` structured data in `config/pages/faq.php`. This duplicated FAQ source exists on `/faq/`; local pages currently have Service schema, not FAQPage schema.
5. Jobs: put the existing mail application action beside the title/lead and repeat it at the end. Build a concise facts block from verified content: existing “zum nächstmöglichen Zeitpunkt”, contract and pay wording can be retained. Add hours/employment scope, actual assignment area, contact person, required documents and process only when confirmed.
6. Preserve existing tasks/requirements/benefits, with a clear distinction between requirements and employer offering. Use actual company/team evidence if available; do not label an unverified generic image as the real team.
7. Reconcile changed Jobs facts with `config/pages/jobs.php['schema_extra']` and the existing expiration behaviour in `head.php`. Do not fabricate a new `validThrough`, salary number or start date to make the schema appear current.
8. Regression-check the shared Contact form behaviour after B7 and header/menu/footer task policy after B3.

**Files**

- `public_html/kontakt/index.php`, `public_html/faq/index.php`, `public_html/jobs/index.php`.
- `config/pages/kontakt.php`, `faq.php`, `jobs.php` for presentation/metadata/schema consistency.
- `content/ctas/faq.php`, `content/ctas/jobs.php` if content changes; retain their destinations.
- Shared intro/action components from B2/B3, `resources/css/03-pages.css`, `07-gallery-faq.css` and generated CSS as needed.

**Acceptance**

- Mobile Contact exposes direct contact before the form; no unnecessary new required field.
- FAQ questions are early, operable by keyboard and correctly marked in navigation; visible answers and structured data agree.
- Jobs shows an early application route and accurate known facts, with missing details tracked rather than fabricated.
- No sales CTA competes with the page's actual task. No live message/application is sent during UI testing.

### B9 – Gallery, company evidence and useful local content

**Audit coverage:** A17, A18, A19 and remaining editorial A20; business-priority completion of A09 when evidence is supplied.

**Why together:** These changes turn generic claims/media into evidence. They share the same requirement for truthful, approved content; that requirement does not block safe reordering or shortening of existing material.

**Changes**

1. Add a simple topic overview or stable jump links to the gallery. Lead with varied services rather than three successive glass examples. Keep existing media and captions accurate; categories/anchors should still work without a complex JS filter.
2. Refine captions to explain the actual surface/task/process and observable result. Do not turn “example work situations” into named customer cases without proof. Add an appropriate contextual offer path during the long sequence, using B5.
3. Preserve posters, controls and `preload="none"`. Measure actual transfer/playback on a slow connection before re-encoding or deleting large videos. Repository media totals are not a page-load budget. Check whether meaningful audio requires captions/transcripts; do not assert audio exists without inspection.
4. On About/home, publish an approved actual contact person, process example, qualification or project case where available. A factual workflow demonstration can help without exposing a customer. Do not add empty proof counters or invented review stars.
5. Review all nine local pages using the same editorial questions. Preserve Brühl headquarters and Köln/Bonn service-area wording. Shorten generic duplication and site-organisation explanations. Add genuinely local logistical/service information only when supported.
6. Keep useful local FAQs before the close and related cities after/secondary according to B4. Local FAQ text lives in `content/locations`; the local configs currently contain Service schema only. Reconcile changed local service claims with their page descriptions/Service schema, without adding FAQPage schema merely for symmetry. Do not create new routes or imply new branches.
7. Once confirmed demand/service priorities exist, apply them to home discovery from B4. Without them, retain the neutral compact grouping and record the evidence-dependent priority decision as open.
8. Reconcile revised promises across visible content, page description and service/FAQ schema. New media requires source/permission and a factual caption/alt decision.

**Files**

- `public_html/galerie/index.php`, `public_html/ueber-uns/index.php`, selected home content.
- All nine `content/locations/*.php`, including their FAQ text; corresponding nine local `config/pages/*.php` for actual description/Service-schema claim changes.
- `config/pages/galerie.php`, `ueber-uns.php`, `startseite.php` only when their metadata changes.
- `resources/css/03-pages.css`, `06-service-pages.css`, `07-gallery-faq.css`, `09-local-pages.css`; actual media assets only when justified; generated CSS.

**Acceptance**

- Gallery relevance is understandable without eight playbacks; anchor focus/scroll positions respect the sticky header.
- Each published new proof item has a real source and approved statement. Missing evidence is not marked completed by adding a decorative box.
- Every local page is useful and honest. No invented local differentiator or unnecessary repetition to reach a word count.
- All original valid service/media links remain accessible; no autoplay or forced download regression.
- Slow-network observations distinguish initial poster load from optional playback. Any optimisation is accepted against measurements.

## 5. Evidence-dependent decisions and safe defaults

These are inputs to later implementation, not permission requests or reasons to pause the current verification/planning work.

| Decision / input | Needed for | Safe implementation until supplied | What remains open |
|---|---|---|---|
| Actual high-demand/business-priority services | Final prominence for A09 | Compact neutral grouping; keep all eight | Ranking and any “popular” claim |
| Named person, real project, qualification, approved media | A18 | Improve existing process explanation and layout | Publication of a concrete new proof item |
| Genuine local logistics/examples | A19 | Preserve known headquarters/area, shorten generic copy | Specific local differentiator |
| Specialist-service scope | A15/A20 | Keep existing qualified wording while clarifying navigation | Removing/expanding a specialised offer |
| Operational relevance of shared object fields | A21 | Preserve uncertain mandatory fields; reduce clearly optional clutter | Conditional removal of an existing required field |
| Job hours/assignment area/application documents | A26 | Show existing start/contract/pay statements and email action | Additional missing job facts/schema values |
| Guaranteed reply time/customer acknowledgement mail | A24 | State transmission and known review/contact process | Any SLA or email promise |
| Measured request duration | A21/B7 | Neutral wording without an unverified numerical guarantee | Confirming/replacing the 2–3-minute claim |
| Actual audio/accessible alternative requirement | A17 | Retain explanatory text and native controls | Appropriate subtitles/transcript if meaningful audio exists |

No implementation batch is “fully closed” if an evidence-dependent requirement it claims to satisfy is still unresolved. The remaining item must be listed explicitly. Conversely, new photos or job details are not prerequisites for correcting focus, links, CTA placement or form state.

## 6. Full audit-to-plan traceability

“Owner” is where the finding is primarily completed. Supporting batches establish prerequisites; this is not permission to implement the same global rule twice.

| Audit ID | Primary owner | Supporting work / completion check |
|---|---|---|
| A01 | B3 | B2 home display/intro; early in-flow offer action |
| A02 | B2 | B8 task content; single H1 and shorter decorative lead-in |
| A03 | B3 | Remove overlay and obsolete observer/styles; no replacement overlap |
| A04 | B7 | B3 channel hierarchy; first selection task earlier |
| A05 | B5 | All producers + allowlisted editable form consumer |
| A06 | B3 | B4 DOM order; FAQ/Jobs/bandless exceptions preserved |
| A07 | B2 | Home display and 980/981 continuity |
| A08 | B2 | One role definition, later batches only apply it |
| A09 | B4 | B9 evidence-dependent priority; neutral fallback |
| A10 | B1 | Content links recognisable without hover |
| A11 | B1 | Focus on every relevant surface, including FAQ override |
| A12 | B1 | B7 regression through upload step |
| A13 | B1 | Functional border token, not all card borders |
| A14 | B2 | Prose versus layout; actual sticky/static behaviour |
| A15 | B4 | Eight linked main targets before specialist catalogue |
| A16 | B4 | Six video-first bodies reordered; no new autoplay |
| A17 | B9 | Gallery topics, captions, in-sequence action, measured media |
| A18 | B9 | Approved proof content; no invented fallback |
| A19 | B9 | B5 context; existing region distinction retained |
| A20 | B4 | B9 local/company copy; new answer per section |
| A21 | B6 | B7 duration/density; client/server/review/mail agreement |
| A22 | B7 | Three states, one current step, mobile text |
| A23 | B7 | B1 specificity fix before B7 density/targets/privacy layout |
| A24 | B7 | Three reset participants + Contact regression |
| A25 | B8 | B2/B3 compact intro and task action; contact before form |
| A26 | B8 | B3 application policy; B9 optional real employer proof |
| A27 | B8 | B1 active-key/focus correction; early FAQ list and matching schema |
| A28 | B2 | B3 action availability; CSS/JS boundaries coordinated |
| A29 | B2 | Hero treatment across 1920/1921/2560 |
| A30 | B1 | JS immediate scroll with reduced motion |
| A31 | B1 | B7 screenreader/form-state regression; truthful limits |
| A32 | B3 | Compact but complete task-aware footer |

## 7. Build, review and final integration gate

### Per-batch requirements

- Check only the components and shared regression paths affected by the batch; broaden testing when a failure, new change or unresolved concern justifies it.
- Run `php -l` for changed PHP files and an appropriate syntax check such as `node --check` for changed JS. There is no existing mandatory npm build to invent.
- After actual CSS changes, run `php tools/build-css.php` and include `public_html/assets/css/styles.css` with the source modules. A repeat build must be deterministic. Do not edit the generated bundle alone.
- The existing preview container mounts the website read-only. It can render and lint; the CSS generator needs PHP CLI with write access to the working checkout, or a dedicated build container mounting that checkout for the build. Do not assume `docker exec kem-dev php tools/build-css.php` can write the bundle. No such build or mount change is part of this planning stage.
- Update `config/site.php::asset_version` deliberately when implementation assets are released; do not bump it for these documentation changes. Keep the existing common CSS/JS cache contract.
- For content/schema changes, inspect rendered JSON-LD, canonical paths and link destinations. Rerun `tools/generate-sitemap.php` only when its generated output/lastmod policy is actually required; preserve the 28-route set and 404 exclusion. Do not generate unrelated sitemap churn per visual edit.
- Use narrowly targeted behavioural checks for URL mapping, conditional requirements, review, step states and success/errors. Pure cosmetic fixes need visual/interaction verification rather than tests that mirror every CSS declaration.
- Review the diff as a batch and keep approved facts distinct from unresolved inputs. Roll back a problematic batch as a unit; avoid later unrelated patches masking an incomplete data contract.

### Final gate after implementation

1. **Route smoke:** all 28 routes render; normal pages 200 and explicit 404 page 404; exactly one content H1 each; no broken referenced CSS/JS/images. Do not count lazy images as broken before decoding or checking their actual request.
2. **Representative visuals:** home, overview, service with video, service without video, one page per local family, About, Gallery, FAQ, Jobs, Contact, Offer and legal/404. Compare desktop/mobile, not only the home page.
3. **Responsive boundaries:** 320/390, 700/701, 768, 820/821, 980/981, 1080/1081, 1440, 1920/1921 and 2560 where relevant. No missing early action, sudden H1 shrink, overlay or unplanned image bands.
4. **Text accessibility:** 200% text enlargement, 400% zoom/320 CSS-px reflow; line height 1.5, paragraph spacing 2 em, letter spacing 0.12 em and word spacing 0.16 em. No lost content or inaccessible controls.
5. **Keyboard/assistive technology:** skip link, menu/dropdown/Escape, FAQ, selections, Next/Back, upload, review editing, current-step announcement and confirmation focus. Check help/error descriptions on a real screenreader in the selected support matrix.
6. **Form scenarios:** generic/contextual entry, each service mapping, all city contexts, multi-service union, changing choices, estimates, unknown values, concrete/flexible date, optional uploads and error boundaries. Verify review/payload/mail agreement without live delivery.
7. **Lifecycle/error handling:** simulated success, field error, rate limit, server failure, invalid response and network failure. Confirm no hidden-error trap, accidental reset or duplicate-send view; Contact remains functional.
8. **Motion/media:** reduced-motion Backtop and menu transitions; voluntary video playback/posters on slow connection; real mobile keyboard and safe-area behaviour.
9. **Content integrity:** no false branches, copied customer claims, unapproved people/images, invented job data or reply guarantees; visible claims agree with schema. Record any evidence-dependent remainder against its A-ID.
10. **Delivery:** each completed batch has a concise change/validation record. A final review confirms the intended website diff, regenerated CSS and asset version. Deployment is a separate action when requested; this plan does not publish anything.

The final integration gate is validation of the related changes, not a tenth arbitrary editing batch. Current batch progress and validation limitations are recorded at the start of this plan and in the linked implementation record.
