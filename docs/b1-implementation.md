# B1 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `cfef027`

**Scope:** B1 from [the implementation plan](implementation-plan-final3.md). Source implementation is complete and the Chromium checks below passed. Additional-browser validation remains open because no second browser is installed and the configured Debian snapshot package source returns a network-policy HTTP 403. No browser-policy or system configuration was changed to bypass that restriction.

## Changes

- Added a functional field-border token, separate from decorative borders: `#7c8995`, contrast 3.58:1 on white and 3.18:1 on the soft surface.
- Added surface-aware focus colours: dark blue on light surfaces, yellow in the header/footer. Dropdown focus stays inside its clipped row; FAQ uses the corrected focus token.
- Made prose links permanently underlined. Navigation, buttons, WhatsApp actions and existing card/gallery actions keep their component treatments. Removed the conflicting local-services underline reset and prevented duplicate lines from legacy privacy `<u>` markup.
- Corrected the label cascade so service choices use their intended flex layout. Titles are 16 px/700, descriptions 14 px/400; estimate labels regain their intended layout, muted colour and 13.12 px/700 styling. Long words wrap without overflowing narrow screens.
- Applied functional field boundaries without overriding the existing red error border/shadow, including focused invalid fields.
- Added a visible focus ring on the upload container while preserving the transparent native file input and whole-label interactions.
- Connected phone/upload helper text through stable IDs. Existing JavaScript still adds field-error descriptions without removing those help references.
- Completed the visible upload instructions: five files, up to 5 MB each, 15 MB combined. Existing validation and upload limits are unchanged.
- Backtop jumps immediately with reduced motion enabled and retains smooth scrolling otherwise.
- FAQ marks only FAQ as the current main-navigation page.
- Rebuilt `public_html/assets/css/styles.css` using the actual PHP build script and changed the common asset version from `1.1.0` to `1.1.1`.

## Verification

| Check | Result |
|---|---|
| PHP syntax | Offer page, FAQ page and site configuration passed `php -l` |
| JavaScript syntax | Changed `main.js` passed `node --check` |
| CSS build | Actual `tools/build-css.php` executed; repeated build byte-identical; bundle matches the ten ordered source modules |
| Links | All 28 routes inspected; 79 prose links underlined; navigation/button/WhatsApp/more/gallery-action exceptions preserved |
| Responsive form | 320, 390, 768 and 1440 px; intended card layout/type, native label selection and no horizontal page overflow |
| Page reflow | All 28 routes at 1440 px; selected home/contact/offer/FAQ/service/local families at 320/390 px without horizontal page overflow |
| Focus | Skip link, header/footer, dropdown, light/soft surfaces, field and FAQ visually checked; dropdown Escape and FAQ keyboard activation preserved |
| Upload | Real Tab focus reaches the input and visibly outlines its container; keyboard file chooser, local test-file selection and removal passed |
| Descriptions | Upload retains `photos-help`, `photos-limits`, `photos-error`; phone retains its hint and error references |
| Form regression | All five steps, estimate option, service toggle, final review and review-edit return passed at all four form widths |
| Server-error presentation | Browser-intercepted 422 fixture returns to the phone field with red invalid styling, preserved help and retained entered data |
| Reduced motion | Scroll position remains 0 immediately and after 16/60/100-ms sampling; normal-mode animation remains and finishes at 0 |
| Delivery side effects | No request reached the PHP contact endpoint or SMTP; test responses were intercepted inside the browser |
| Additional browser | Not run; installed runtime is Chromium only and the configured package source is blocked. This remains a validation limitation |

Generated CSS SHA-256: `2a14fd817746c8a995123b499e6f0335442590cf89a632b91515887f13f411f9`.

## Remaining batches

B2–B9 are not started. In particular, this change does not redesign page heads, remove the existing floating WhatsApp control, change form-field relevance, alter progress/success behaviour, reorder service content or add business claims. Those remain assigned to their planned batches. The audit remains a record of the original baseline, with this implementation record describing the B1 changes.
