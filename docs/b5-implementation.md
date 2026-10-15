# B5 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `e83e9c5`

**Scope:** B5 from [the implementation plan](implementation-plan-final3.md): explicit offer context from service/local actions through editable form initialisation.

## Changes

- Added `app/helpers/offers.php` and loaded it before the action renderer. `kem_offer_url($pageKey)` resolves only explicit catalogue/page configuration and creates an RFC 3986 encoded local offer URL. Unknown and generic routes fall back to `/angebotsanfrage/`.
- Added one explicit `offer_service` entry for each of the eight service routes and `offer_context` for all nine local routes. No service is inferred from a slug or the phrase Gebäudereinigung.
- Connected the existing B3 offer-action boundary to this resolver. Early, sidebar, final and page-associated header/menu/footer actions now share the correct destination without duplicating URL construction across their existing fragments. Generic home/company/overview entry stays generic; FAQ/Jobs/Contact/form policies are unchanged.
- Added a small city-token registry in `config/forms/offer.php`. It controls URL prefilling only; the existing free-text city field still accepts other manually entered locations.
- Validated incoming context in PHP, pre-checked the existing `type_*` checkbox and filled the existing `cleaning_city` input. The form still starts on step 1, supports multiple selections and leaves both values editable. No postcode, street, identity or appointment is inferred.
- Added a quiet step-1 city hint so city-only entry is visible before the location step. It reads the current city field and updates after manual edits; it disappears when the field is empty. The selected service remains visible through the existing checked-card treatment.
- On `pageshow`, synchronised panels, required states, estimates, appointment controls, uploads, city hint and review from the current native form state. JavaScript does not parse/reapply URL values, reset the current step or overwrite restored edits.
- Kept existing form names, POST schema, API action, validation handlers and transport unchanged. There is no hidden provenance field and no `service`/`city` POST field. Canonical, Open Graph URL and structured page identity stay query-free.
- Added `tools/check-offer-context.php`, a CLI check for the mapping/parser/initial-render contract. It renders GET pages in isolated processes and never submits requests.
- Incremented the shared asset version to `1.1.5` for the form-script change. CSS remains unchanged from B4.

## URL and field contract

| Source | Query values | Existing form control |
|---|---|---|
| Büro/Gewerbe | `service=office` | `type_office` |
| Glas/Fenster | `service=window` | `type_window` |
| Grund/Spezial | `service=general` | `type_general` |
| Teppich | `service=carpet` | `type_carpet` |
| Polster | `service=upholstery` | `type_upholstery` |
| Entrümpelung | `service=clearance` | `type_clearance` |
| Fassade/Graffiti | `service=graffiti` | `type_graffiti` |
| Solar/PV | `service=solar` | `type_solar` |
| Generic building-cleaning city route | City only | `cleaning_city`, no automatic service |
| Büro/Fenster city route | Corresponding service plus city | Existing service checkbox and `cleaning_city` |
| Generic home/company/overview | None | No automatic service or city |

City tokens are `koeln`, `bruehl` and `bonn`; their visible values are Köln, Brühl and Bonn. For example, `/bueroreinigung-bruehl/` produces `/angebotsanfrage/?service=office&city=bruehl`. `/gebaeudereinigung-bruehl/` produces only `/angebotsanfrage/?city=bruehl`.

Only exact, known string tokens are accepted. Unknown keys, unknown values, arrays, nested arrays and non-string values are ignored. Each part is validated independently: a valid service survives an invalid city and vice versa. Any of the eight known services may be combined with any of the three known cities; comma-separated/multiple-service query values are not supported. Additional services are selected manually in the existing form. `other` remains a manual selection, not a service-page prefill token.

This is an initial-value contract. User edits, additional services, ordinary Back/Next and review-edit use the current form values. Native form reset retains its normal default-value semantics; the existing multi-handler success/reset flow remains assigned to B7.

## Verification

| Check | Result |
|---|---|
| Syntax | All 17 changed/new PHP files passed `php -l`; changed offer-form JavaScript passed `node --check` |
| Repeatable contract checks | `php tools/check-offer-context.php`: 456 checks passed, covering 17 explicit mappings, generic/unknown routes, strict invalid-value handling, URL round trips and 23 isolated GET form renders |
| All offer surfaces | All 131 offer actions checked: 102 contextual links on the 17 service/local routes and 29 generic links. Early, sidebar, final, header, compact-menu and footer destinations match their page context |
| Actual entry links | All 17 distinct service/local origins plus generic entry clicked through to the form; correct checkbox/city state, first step and editable controls |
| Query handling | 50 cases with and without JavaScript, 100 states total: all 24 valid service/city combinations, generic/partial contexts, unknown keys/values, arrays, malformed and attempted foreign-field prefills passed |
| Identity and field boundaries | Canonical/OG URL query-free; JSON-LD identical across all 100 query/JavaScript states. No inferred postcode/street/identity/appointment, no new POST field names |
| Restore and visual review | Native checked-card and city hint reviewed at 390/768/1440 px and short height. Actual BFCache return preserves manually changed multiple selections, city, estimate state and active step; derived panels, hidden service summary, hint and review remain current |
| Edited flow and payload | Changed the initial office/Köln context to window + general/Hürth, navigated Back/Next and both review-edit paths, then submitted office + window/Leverkusen. Intercepted multipart data contains only existing schema fields and the final selections, city/postcode, estimates and service details. Removed general fields are disabled and absent; the stubbed 422 response preserves edits |
| Entry-note reflow | 32 targeted responsive/font/spacing states passed, including 320/390/768/1440 px and actual 20/32 px browser defaults; no overflow or clipped hint |
| Site regression | All 28 routes retain H1, metadata, canonical/schema, content/media, eight discovery routes, 30 specialist terms, nine local FAQ sets and 17 final-before-related orders |
| B1 regression | All five form steps, labels, estimates, review/edit, keyboard upload selection/removal, help/error references, invalid styling and reduced-motion Backtop passed at 320/390/768/1440 px |
| Protected implementation | CSS, content, shared header/footer, Contact page, core script, POST schema and handlers unchanged |
| Additional browser | Not installed; cross-browser validation remains open |

The CLI check performs GET rendering only. Browser submission fixtures are intercepted and fulfilled locally; no request reached the contact endpoint or SMTP. Browser verification used Chromium. The history check explicitly enabled its real back/forward cache and recorded `pageshow.persisted === true`.

A separate history check forced a full document reload by disabling BFCache. Edited service/city values were restored, but estimate checkboxes and their values reset. This also occurs in the B4 baseline `e83e9c5`, and was reproduced with both generic and contextual B5 entry. B4 additionally left restored service panels hidden/disabled; B5 synchronises them correctly. This existing estimate-restoration limitation remains recorded for the later form-state work. B5 adds no persistent form storage; the passing BFCache result above does not imply full-reload persistence of every field.

Generated CSS is unchanged from B4: `3b93d63ed75d0c83e9edb879d66085a5d13681bf9eb3ace519e6458751af4f13`.

## Remaining batches

B6–B9 remain unstarted. Field relevance, floor/company consolidation, progress/success behaviour and remaining task/evidence content stay in their planned batches. B5 does not change required object type or suppress existing questions for a preselected service.

Additional-browser validation remains open because only Chromium is installed and the configured second-browser package source is blocked by network policy. Earlier audit/implementation records retain their own baseline observations; this record documents B5.
