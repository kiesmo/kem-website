# B3 implementation record

**Date:** 15 October 2026, Europe/Berlin

**Branch:** `final3` · **Starting commit:** `860e0cb`

**Scope:** B3 from [the implementation plan](implementation-plan-final3.md): primary/final actions, page-purpose policy, contact alternatives and a compact footer.

## Changes

- Added a shared action contract in `app/helpers/actions.php`, loaded through the existing bootstrap. Actions carry an explicit intent, originating page key, label and destination. One renderer supplies filled primary actions and underlined inline alternatives.
- Added the primary offer action alongside the home H1/lead, with a quieter service-selection link. The white filled action contrasts with the existing blue hero panel; its keyboard focus uses the dark-surface focus token.
- Added an early offer action to all 20 media introductions: eight services, nine locations, service overview, company and gallery. Replaced the mobile-only helper and its configuration/styles atomically, rather than retaining duplicate enquiry boxes. Early actions now remain available at desktop widths too.
- Migrated 23 final bands, eight service summaries and nine local sidebar actions to the shared renderer. Their existing primary labels, destinations, headings, substantive copy, phone links and ordering remain. FAQ closes with Contact; Jobs closes with the same application email and subject.
- Reduced exactly the nine existing final-band WhatsApp options to a short inline alternative. The other 14 final bands received no WhatsApp option. Contact also keeps WhatsApp as an underlined inline contact route.
- Removed the global floating WhatsApp markup and all obsolete floating/button styles. Removed only the now-unused footer visibility observer from `main.js`; menu, Backtop and form logic remain. Backtop occupies the lower corner vacated by chat and retains B1's reduced-motion behaviour.
- Removed the prominent WhatsApp block before the offer form. A quiet inline question/contact alternative follows the form. Form markup, fields, steps, native validation settings, POST contract and form scripts are unchanged.
- Applied one header/menu/footer policy at all widths. Sales pages use the offer process; Jobs uses the existing application email; FAQ uses Contact. Contact and the offer form have no competing global primary action. The footer renders its optional action as an inline fallback rather than a second filled sales button.
- Compacted the footer into three groups: company/region, contact/opening hours, and service navigation/action. Address, phone, email, three region links and surrounding area, opening hours, out-of-hours information and legal links remain visible. Reduced logo size, spacing and repeated sales copy.
- Reserved the footer's trailing edge for Backtop so it cannot cover contact, service or legal links while they scroll past. This gutter disappears at widths where Backtop is hidden.
- Rebuilt generated CSS with the actual PHP build script and incremented the common asset version to `1.1.3`.

## Action policy

| Page purpose | Header and compact-menu action | Footer action | Main/final action |
|---|---|---|---|
| Sales pages | Offer | Inline offer link | Early offer plus existing sidebar/final offer where present |
| Jobs | Application email | Inline application email | Existing application final band |
| FAQ | Contact | Inline Contact link | Existing Contact final band |
| Contact | None | None | Message form and direct contact details |
| Offer form | None | None | Current step/submit action; inline WhatsApp alternative after the form |
| Legal/404 utility pages | Existing generic offer destination | Inline offer link | No extra final sales band |

## B5 integration contract

`kem_offer_action($pageKey, $label)` is the shared offer destination boundary. Every early, sidebar, final and global offer action supplies the actual originating route explicitly. Content fragments use explicit routes because their include scope does not inherit the page template's `$pageKey`.

For now the destination intentionally remains `/angebotsanfrage/`. B3 does **not** claim service/city preselection. B5 must resolve allowlisted service/city context at this boundary and implement matching visible form initialisation in the same batch. Generic building-cleaning city routes must not imply the form's `general` cleaning type. No unsupported dynamic placeholder was introduced.

## Verification

| Check | Result |
|---|---|
| Syntax | All 59 changed/new PHP files passed `php -l`; changed `main.js` passed `node --check` |
| Source preservation | All 28 routes retain one H1 with the same text, SEO/title/meta/canonical/schema/breadcrumbs and substantive non-action content |
| Action migration | All 23 final destinations checked: 21 offer, FAQ Contact and Jobs application email. Exactly nine finals retain WhatsApp as an inline alternative; the other 14 have none. Origin metadata matches actual routes |
| Shared page policy | All 28 routes at 390/1440 px: header, compact-menu and footer destinations agree with page purpose; no offer loop on Contact or the offer form |
| Early enquiry path | 21 sales surfaces × 390/768/1024/1440 px × 900/500 px viewport height = 168 checks; primary offer action present in normal flow outside the menu, before intro media and without clipping |
| Responsive layout | 11 route families × ten widths = 110 states, including 320/390/768/980/981/1080/1081/1440/1920/2560 px; no horizontal overflow or clipped-text reports |
| Enlarged browser fonts | Actual 20 px and 32 px defaults through Chromium CDP: 48 states each, no reflow failures |
| Text spacing | 32 states using 1.5 line height, .12em letter spacing, .16em word spacing and 2em paragraph spacing; no overflow or clipping |
| Chat removal | No floating WhatsApp control, old mobile-only CTA or filled WhatsApp button remains. No obsolete helper, configuration, CSS or footer-observer consumer remains |
| Essential footer data | Address, phone, email, regional links, hours/out-of-hours text and legal links checked on all 28 routes |
| Footer size | Physical height reduced from 1,030 to 742 px at 390 px; 803 to 497 px at 768; 379 to 311 px at 1440. This includes the retained contact and legal information |
| Independent review | Action destinations, page exceptions, contrasts, CSS/source agreement and 14 representative rendered states checked without a blocker |
| Visual review | 45 views across nine route types and five viewports, including 390 × 568 px. Early and final action hierarchy accepted; the tablet Backtop/legal-link collision was fixed and rechecked at footer entry/end at 768/1024 px, plus 1440 px |
| Keyboard focus | Seven new action targets checked with actual keyboard focus; both home actions use the gold 3 px ring against the blue panel |
| Final footer/menu checks | After the gutter fix, 100 footer route/font/spacing states and 300 scroll-position probes passed, including a 6 px focus allowance around links. All 28 compact-menu policies checked after the opening transition; correct visible destinations and Escape behaviour |
| B1 regression | All five steps, native service labels, estimate option, review/edit, keyboard upload selection/removal, help/error references, invalid styling and reduced-motion Backtop passed at 320/390/768/1440 px |
| Form preservation | Offer and Contact `<form>` markup is byte-identical to `860e0cb`; form scripts, schemas and handlers were not changed |
| Requests/errors | No unexpected HTTP or JavaScript errors. API interception prevented real contact/offer submission; no external contact link was activated |
| CSS build | Actual PHP builder used; repeat build byte-identical and generated bundle matches the ten ordered source modules |
| Additional browser | Not available; cross-browser validation remains open |

The text-spacing harness temporarily bypassed CSP through Chromium's debugging protocol to inject test-only styles. Normal route checks retained the actual CSP; production policy and security headers are unchanged.

Generated CSS SHA-256: `4ca77b4045aa217e1c03e200103e16f89b0e9f4b730950b0eec562f4b0d0dfef`.

## Remaining batches

At completion of B3, B4–B9 were unstarted. [B4 has since been implemented](b4-implementation.md); B5–B9 remain unstarted. B3 itself preserved content/media/related-link order, form relevance rules, progress/success behaviour and existing business claims. Additional-browser validation remains open because only Chromium is installed; the configured package source for another browser remains blocked by network policy.

The original audit and earlier implementation records retain their historical baseline observations; current changes and validation belong to this record.
