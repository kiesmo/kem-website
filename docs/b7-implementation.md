# B7 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `ad7f7c6`

**Scope:** B7 from [the implementation plan](implementation-plan-final3.md): form presentation, progress, review and the offer-success lifecycle, preserving B5 context and the confirmed B6 field policy.

## Presentation and progress

- Compact offer title and a short reassurance replace the large benefits/duration introduction. The first selection task moves closer to the page title. Home and form no longer state an unmeasured “2–3 minutes”; no new completion-time estimate is substituted.
- Nine native whole-label, multi-select service cards retain readable text and service identities. Shorter supporting copy and smaller padding/gaps reduce repetition and unused space.
- The five-step list distinguishes current, completed and upcoming steps. Exactly one editing step has `aria-current="step"`; completed steps use a check and a separate visual treatment. Indicators remain informational. The current step's full text stays visible below the indicators on mobile.
- Existing polite progress announcements and heading focus remain. Review sections stay editable and follow B6 applicability. Edit/remove controls have at least a 44 px target and wrap when text grows. The privacy checkbox aligns with normal-weight explanatory text, and required markers stay attached to their text.

## Success and request-state contract

| State | Behaviour |
|---|---|
| Editing | B5 context supplies initial service/city only. Current edits, multi-service selection, estimates and the confirmed five-service furnishing rule drive fields, review and payload |
| Sending | Capture `FormData` before temporarily disabling controls. Freeze navigation and editing, announce progress and prevent a second request. Preserve each control's previous disabled state |
| Failure | Restore the prior control states before presenting errors. Preserve inputs, files and estimates. A field error opens its step and focuses the relevant control; a general error focuses the status |
| Successful offer | Require a successful HTTP response and an object JSON payload with boolean `ok: true`. Shared AJAX restores temporary states and dispatches `form:success` with its message. It does not reset the offer or move focus to an old form status |
| Confirmation | The offer controller clears user data, files/previews, review, estimate caches and default context values; hides the form/intro; shows the confirmation and focuses its heading. The view remains until a deliberate restart or document navigation. Browser return to the same cached document preserves it |
| New request | Only the explicit new-request action performs native reset and a neutral clean start. It synchronises fields and dispatches `form:new-request`, clearing the transport's completed guard and resetting progress to step 1. URL preselection is not reapplied |
| Contact | Retains its own native reset, success event, status and focus flow. Offer confirmation logic does not take over Contact |

The confirmation reports transmission of an enquiry. It states that a requested date is not a booking confirmation. It adds no response deadline or customer-confirmation-email claim. The offer response message is neutral; Contact's existing response text and all server validation/transport rules remain unchanged.

## Error and file handling

- JSON syntax errors, non-JSON responses, invalid response envelopes and nonboolean success values are failures. A truthy string cannot clear the request or display confirmation.
- Radio errors resolve `RadioNodeList` to an applicable control and share a group message/description. `photos` and `photos[]` resolve the existing upload field. Disabled controls do not become invisible error targets; existing help descriptions are retained.
- Native validation selects an actual validating input/select/textarea rather than a fieldset. Field errors retain their field focus; general errors use the status region.
- Upload previews revoke object URLs when replaced, removed or cleared. Removal keeps keyboard focus on an appropriate remaining action or the upload input. A frozen upload control cannot accept a drop while a request is pending.
- Success does not retain submitted personal values in hidden form fields, review or preview DOM. No persistent form storage is introduced. A full page reload remains a new GET; B5's separate forced-reload estimate-restoration limitation is not claimed as solved.

## Verification

| Check | Result |
|---|---|
| Syntax and diff | All four changed PHP files lint; both JavaScript files pass `node --check`; `git diff --check` passes |
| Existing data contracts | `php tools/check-offer-context.php`: 456 checks; `php tools/check-offer-request.php`: 604 checks. B5 mappings and the confirmed B6 applicability/legacy-floor rules remain intact |
| Rendered/source contract | 62 assertions preserve all 80 named controls, field requirements/enums, policy data, context inputs and protected server contracts; presentation, progress and success hooks match their controllers |
| Shared AJAX in isolation | 24 real-DOM/browser fixtures cover pending/complete guards, capture-before-disable, exact restoration, strict response types, native validation, radio grouping/help/error clearing, upload aliases and Contact reset |
| Actual offer failures | 14 intercepted response cases pass, including 422 email/radio/upload errors, 429/500, non-JSON, malformed JSON, invalid envelopes and network failure. Inputs, files and estimates survive; field errors open/focus the right step, general errors focus status |
| Contact | Eight separately intercepted outcomes pass. Its successful reset/status focus and failed-request data retention remain correct |
| Success and restart | Two intercepted successful requests cover the entire lifecycle. Pending controls freeze after capturing both service/contact fields and a nonempty File; duplicates are blocked. Confirmation survives `pageshow` and genuine BFCache return; personal fields, files/previews, review, estimate caches and SSR defaults are cleared. Deliberate restart is context-free and a second request succeeds |
| Navigation and existing behaviour | Five contextual entry states, all five phases, Back/Next, review edits, narrowed furnishing applicability, estimate/manual restoration, two-photo removal focus and review cleanup pass |
| B1 regression | Existing full regression passes at 320/390/768/1440 px: labels, all steps, estimates, review, native keyboard file selection/removal, help/error references, 422 retention and reduced-motion/standard Backtop behaviour |
| Reflow | 96 states cover six views at 320/390/768/1440 px with normal text, actual 20/32 px browser defaults and spacing overrides. A reproduced 320 px/32 px review-clipping defect was fixed with zero-minimum tracks and wrapping; populated reviews pass at all four widths |
| Short viewports | 36 focus/geometry checks pass at 320/390 px widths and 420/360 px heights, including headings, contact fields, privacy, actions and confirmation. These emulate reduced viewport space; they are not a real device/keyboard test |
| Visual and semantic review | 49 views cover all five phases, confirmation and restart at nominal widths, short height and actual 20/32 px text. Focused headings remain below the sticky header; privacy and touch actions reflow. A second defect—mobile phase names removed by `display:none`—was fixed with visually hidden text. Final Chromium accessibility-tree checks expose all five phase names/states with exactly one current step; desktop labels and mobile geometry remain correct |
| Site/content | All 28 routes render. All 131 offer destinations, metadata, canonical/schema, breadcrumbs and other-page content/media/CTA ordering remain intact. Home changes only the duration sentence; Contact's rendered source is unchanged |
| Independent code review | No concrete lifecycle defect found after reviewing guards, event ordering, error focus, cleanup, browser return and restart. Six PHP policy/validation/upload/transport sources remain byte-identical; the handler change is only its offer-success sentence |

At a generic 390 px entry with the normal 16 px browser default, the intro height changed from 253.6 to 130.1 px, the form begins at y=308.2 instead of y=510.0, and the first card appears 317.5 px earlier (y=583.2 instead of y=900.7). The service grid itself changed from 968.6 to 835.3 px. These are layout measurements, not completion-time or conversion claims. No representative user timing study was performed; the numerical duration claim was removed.

All browser API submissions were intercepted or fulfilled locally. No production contact/offer message or SMTP delivery was triggered. Chromium is the available browser; additional-browser and real-device/screenreader validation remain open. Font checks assert actual computed sizes in fresh browser contexts; enlarged-text screenshots use current-viewport capture to preserve those sizes.

CSS was generated by the actual PHP builder and matches all ten ordered source modules. Shared asset version is `1.1.7`. Final CSS SHA-256: `ee00c6354ec62ebd7df10f2a3e8823a3de1293bcc89d59cb2a647c11ad4f34d8`.

## Remaining batches

B8–B9 remain unstarted. Contact/FAQ/Jobs task layout and remaining company/gallery/evidence content retain their planned scope. Earlier implementation records describe their own baselines; the implementation plan tracks current progress.
