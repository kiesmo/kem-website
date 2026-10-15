# B6 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `72bcf9f`

**Scope:** B6 from [the implementation plan](implementation-plan-final3.md): conditional field relevance, one floor/access answer, explicit company copying and consistent browser/server data.

## Field-relevance decisions

The initial matrix was defined before B6's visibility changes; the current matrix incorporates the confirmed furnishing follow-up below. Required object type remains unchanged because no operational confirmation authorises removing it. Postcode/city and the existing contact identity requirements also remain unchanged. Optional location/object and customer details remain distinct.

Floor/access remains optional for every service, including window, facade and solar work. The user confirmed that room furnishing should appear only for office, general, carpet, clearance or “other” cleaning. Window, upholstery, facade and solar requests omit it unless combined with one of those five services. Multiple services use the union of applicable fields.

| Service | Optional floor/access | Optional room furnishing | Existing required service answers |
|---|---|---|---|
| Office / commercial | Yes | Yes | Area or estimate; frequency |
| Window | Yes | No | Sash count or estimate; cleaning scope |
| General / specialist | Yes | Yes | Area or estimate; reason |
| Carpet | Yes | Yes | Cleaning scope; soiling |
| Upholstery | Yes | No | Cleaning scope; soiling |
| Clearance | Yes, once | Yes | Area or estimate; scope |
| Facade / graffiti | Yes | No | Area or estimate; surface |
| Solar / PV | Yes | No | Access; soiling |
| Other | Yes | Yes | Description, preserving the existing server minimum |

With no selected service, service panels and the two optional operational fields are inactive. Object/company designation, optional street, required postcode/city and required object type remain common. Appointment date/time apply only to a concrete appointment. Optional photos, their limits, the honeypot and privacy requirements are preserved.

## Data and compatibility contract

- `config/forms/offer.php` is the shared source of service labels, field membership, required service answers and optional-field applicability. PHP renders the client policy; browser and server use the same relevance lists.
- Existing `type_*` flags with the exact value `1` determine selected services. `cleaning_types` is recomputed from them. The previous handler already used selected flags for email labels; this change also normalises the display summary and inactive data.
- Inactive known fields are excluded from browser validation, review and submission. The server clears their values before conditional validation and email construction, including stale values submitted by an older client. Unknown fields and invalid array formats remain rejected by the existing request envelope.
- User-entered values remain in browser memory when a service is deselected so that reselecting it can restore manual answers and estimate choices. Inactive fields are disabled, lose required/error state and contribute no review rows. This does not add persistent storage or change the B5 full-reload limitation.
- `floor` is the sole visible floor/access answer. It covers the selected services at the same location; service-specific differences can be stated in that answer. `clearance_floor` remains allowed only as a legacy input name. For selected clearance, a nonempty legacy value fills an empty `floor`; matching values appear once. Different nonempty values produce a clear `floor` field error asking for one reconciled answer. For other services, stale `clearance_floor` is ignored. Review and email show a provided floor/access answer once.
- Object designation/company at the cleaning location (`cleaning_company`) and the customer's company (`company`) have separate labels and autocomplete sections. An explicit copy action is available only when the source is nonempty and the customer field is empty. It copies once per click; later edits remain independent and an existing customer company is preserved.
- Field names remain compatible with the existing schema. The new interface omits the legacy floor input and adds no POST field. Contact's validation and transport, SMTP configuration, uploads and rate limits retain their existing contracts.

## Changes

- Added `app/forms/offer-request.php` as a side-effect-free policy and request-preparation boundary. It accepts cleaned fields, normalises applicability, validates the existing requirements and constructs mail rows. It reads no private configuration and performs no transport. The existing handler still owns sanitisation, the request envelope, shared contact checks, uploads, rate limits and SMTP.
- Extended `config/forms/offer.php`, retaining B5's city tokens. The rendered `data-offer-policy` contains only the service/relevance policy; it exposes no mail configuration. Service labels and required-field sets now come from that shared source.
- Updated service/optional-group synchronisation to control visibility, enabled/required state and stale field errors together. Review reads enabled values only. Initial load, service changes and browser return use the current form state; B5 URL defaults are not reapplied.
- Consolidated the floor/access controls, clarified company labels and help text, separated object/customer autocomplete sections and added the guarded copy action. Keyboard focus moves to the filled customer field after copying.
- Fixed validation of irrelevant stale upholstery counts and furnishing values by normalising them before their field checks. Flexible appointments discard stale date/time values. Concrete dates are checked for ISO format before date parsing so malformed values produce a field error.
- Added `tools/check-offer-request.php` for repeatable pure-policy/preparation checks. The existing B5 GET-render checks remain in place. No POST schema names or upload policies changed.
- Added scoped hidden-group rules and a quiet, wrapping copy button with a 44 px minimum height. Gave help text below inputs enough clearance for the keyboard focus ring. Generated CSS with the actual PHP builder from all ten ordered source modules. Incremented asset version to `1.1.6`.

## Initial B6 verification (`4a8ca2b`)

These results record the initial B6 release, which used the broader optional furnishing default. The confirmed follow-up policy and its verification are recorded below; the current matrix above describes the implemented policy.

| Check | Result |
|---|---|
| Syntax | All eight changed/new PHP files passed `php -l`; offer-form JavaScript passed `node --check`; `git diff --check` passed |
| Pure request contract | `php tools/check-offer-request.php`: 603 checks passed, including the seven required scenarios and all nine individual services, inactive data, exact flags, missing requirements, legacy floor conflicts and appointment handling |
| B5 contract | `php tools/check-offer-context.php`: all 456 mapping/parser/GET-render checks still pass |
| Rendered policy | 75 independent assertions: client policy equals PHP configuration; all nine panel field/required sets, enums, universal fields, honeypot/upload attributes, one floor and an unsubmitted copy button match the contract. There are 80 named controls, with only the obsolete visible `clearance_floor` removed |
| Full browser tasks | Window, office, upholstery, solar, clearance, window + solar and office + upholstery completed through review and intercepted submission. Eight intercepted POSTs also cover an edited/error path; existing schema fields and final applicable values match |
| Switching and errors | Deselection excludes inactive values from review/payload, clears hidden field errors and preserves values in memory. Reselection preserves estimates/read-only state and restores the previous manual value when the estimate is unchecked. Hidden requirements do not block Next |
| Company and browser return | Explicit copy, empty/nonempty destination guards, later independent edits and focus tested. Real BFCache return preserves edited selection, city, current step and estimates; derived panels/review/copy availability stay current |
| Actual handler isolation | 50 scenarios ran through a copy of the current handler with synthetic configuration and a recording transport under Docker `--network none`. Includes the seven captured browser payloads, floor compatibility, common/conditional validation, unknown/array/honeypot guards, upload errors, method/rate/transport failures and four paired Contact baseline comparisons |
| Review/mail agreement | All 112 nonempty data values across the seven browser reviews match the isolated handler's constructed mail values. Each has one floor/access row; company values remain distinct. The UI's empty-photo placeholder is intentionally absent from mail |
| B1 regression | All five form steps, service labels, estimates, review/edit, keyboard file selection/removal, help/error references and invalid styling passed at 320/390/768/1440 px; reduced-motion Backtop and standard smooth scrolling preserved |
| Responsive reflow | 64 states across four service combinations and 320/390/768/1440 px, using normal text, spacing overrides and actual 20/32 px browser defaults. Enlarged-text checks use fresh browser contexts and assert computed body/label sizes; no overflow or clipping |
| Visual and keyboard focus | Floor/help text, distinct company fields, optional-group visibility and copy action accepted at 320/390/768/1440 px. After the spacing fix, all four input/help pairs have 8 px clearance for the 6 px focus-ring extent at actual 16/20/32 px defaults. Copy action remains at least 44 px high, wraps at enlarged text and moves keyboard focus to the filled field |
| Site/source boundaries | All 28 routes rendered; 131 B5 offer destinations, page identity, H1/H2, substantive content, media and CTA order retained. All 29 protected sources unchanged, including Contact markup, the API wrapper, shared AJAX script, upload validator, request utilities, schema, catalogue and local page configurations |
| CSS | PHP-generated bundle matches the ten ordered source modules; SHA-256 `4031d30821f33961381563effeb2bc0b01943d2eb2f76e49c39d7c8e251c50c5` |

## Confirmed furnishing follow-up

After the initial B6 push, the user selected the five-service furnishing rule on 15 October 2026. Updated the shared policy and its regression expectations. Browser visibility, disabled state, review and server validation/mail inclusion all consume that policy; no separate JavaScript or markup condition was added. Floor/access and required object type retain their existing rules.

| Follow-up check | Result |
|---|---|
| Syntax and pure policy | Both changed PHP files lint; `php tools/check-offer-request.php` passes 604 checks, including upholstery count validation independently of inactive room furnishing and furnishing validation after adding office |
| Browser relevance and state | All 511 nonempty service combinations apply the five-service union correctly and retain floor/access. Seven full tasks and ten locally intercepted POSTs passed; valid/invalid stale furnishing is omitted when inactive and restored on reselecting an applicable service. Estimates, company copying, hidden error clearing and real BFCache return remain correct |
| Actual handler and mail | 29 isolated cases passed: 22 targeted individual/combined-service furnishing cases plus seven fresh browser payloads. All 109 nonempty review/mail values match; the three removed furnishing rows account for the difference from the initial 112. Each captured mail has one floor/access answer |
| Scope | Eleven independent source checks confirm the sole production change is the explicit furnishing-service list. Frontend scripts, markup, CSS, handler, normalisation helper, schema, uploads and API wrapper are unchanged. Tests and this record reflect the confirmed choice |

All browser submissions were intercepted and fulfilled locally. Isolated handler checks used synthetic configuration and a recording transport; they did not read production private/vendor files, call the real endpoint or send SMTP. Browser QA uses Chromium; a second browser remains unavailable. Handler fixtures cover validation/upload error paths, but not successful HTTP file-upload parsing, response headers or real mail delivery.

## Remaining batches

B7–B9 remain unstarted. Form presentation, progress and success lifecycle stay assigned to B7. B6 retains the existing success/reset behaviour. The original audit and prior implementation records describe their respective baselines; current progress is tracked in the implementation plan.
