# KEM Gebäudereinigung – vollständiger Implementierungsplan für final2

**Planungsstand:** 14. Oktober 2026 · **Repository:** `kiesmo/kem-website`  
**Arbeitsbranch:** `final2` · **Basis:** `00f1fe3b7750e0315f3ec0224a887f1a0e74b2d1`, identisch mit `origin/final`  
**Grundlage:** [korrigierter Deep Design Audit](DEEP-DESIGN-AUDIT-final2.md), alle 40 Befunde, Seitentypen/Routen und tatsächlicher Quellcode.  
**Status:** B01–B11 nacheinander umgesetzt und geprüft. Der ursprüngliche Plan bleibt als Entwurfsgrundlage erhalten; der tatsächliche Stand, Prüfungen und bedingte Medienpunkte stehen in [IMPLEMENTATION-STATUS-final2.md](IMPLEMENTATION-STATUS-final2.md).

## 1. Ergebnis des Abgleichs und Ziel der Umsetzung

Der bestehende PHP-Aufbau, die zentrale Konfiguration, die acht Leistungsseiten, neun Standortseiten, zehn CSS-Module und das fünfstufige Formular bilden die Grundlage. Die Hauptarbeit betrifft die frühe Orientierung und Angebotsaktion, klarere Komponentenrollen, die Reihenfolge der Inhalte sowie verständliche Formularzustände. Ein Framework-Wechsel oder vollständiges Rebranding ist dafür nicht erforderlich.

Der Code bestätigt die Ursachen der 40 Audit-Befunde. Die korrigierte Fassung enthält 20 dokumentierte Präzisierungen und Ergänzungen. Dazu gehören die unvollständige Upload-Hilfe zum Gesamtlimit von 15 MiB, stilles Abschneiden beim Drag-and-drop, verschwundener Upload-Fehlertext trotz weiterhin ungültigem Input, Unterschiede zwischen Browser- und Servergrenzen, die fehlende Behandlung einer `RadioNodeList` bei Serverfehlern, ein unsichtbarer Upload-Fokus und die zu pauschale Navigations-Abnahme. F06 und die Galerie-Überarbeitung waren im ursprünglichen Paketplan nicht vollständig zugeordnet; sie sind hier enthalten.

Die aktuellen technischen Prüfungen bestätigen außerdem: Alle 74 ursprünglichen Quellpfade/-muster existieren; das CSS-Bundle entspricht genau seinen zehn Quellen; die Farbkontraste sind korrekt berechnet. In einer Chromium-Komponentenprüfung stimmen Panelaktivierung und Pflichtfelder aller neun Formularzweige. Dabei wurden keine POST-Anfragen ausgeführt. Die Seitenhöhen, Positionen und vollständigen Seiten-Renderings des Erst-Audits wurden nicht neu erhoben.

## 2. Arbeitsregeln und gemeinsame Verträge

- Jeden Batch als inhaltlich abgeschlossene Änderung mit eigenem Review und passenden Checks umsetzen. Ein separater Commit je abgeschlossenem Batch ist sinnvoll. Die Batchgrenze folgt der Komponente oder Funktion, nicht einer Zeilen- oder Dateizahl.
- Änderungen an CSS in `resources/css/` pflegen. Nach einem CSS-Batch `php tools/build-css.php` ausführen und das dadurch erzeugte `public_html/assets/css/styles.css` zusammen mit den Quellen prüfen. Keine isolierten Bundle-Overrides. Bei auslieferbaren CSS-/JS-Änderungen `config/site.php` → `asset_version` nachvollziehbar aktualisieren.
- Neue gemeinsame Komponentenregeln in `02-components.css`, Seitenvarianten in die passende Seitenquelle und Formularregeln in `05-offer-form.css`/`08-offer-conversion.css` einordnen. Globale Hero-Regeln aus `09-local-pages.css` gezielt zusammenführen. Nur Regeln entfernen, deren Ersatz und betroffene Verbraucher bekannt sind.
- Systemschrift, Navy-/Blau-Grundpalette, 1240-px-Container und bestehende URLs behalten. Genau eine H1 pro Route, korrekte Breadcrumbs, Metadaten und strukturierte Daten erhalten. Bildfreie Rechts-/Formular-/404-Einstiege bleiben bildfrei.
- Die Formular-Anfrage gilt wie im Audit als primäre Aktion auf Verkaufsseiten. WhatsApp bleibt erreichbar. Jobs, Kontakt, FAQ, Recht und das aktive Formular erhalten jeweils eine passende Gewichtung. Neue geschäftliche Zusagen werden aus den vorhandenen Fakten oder bestätigtem Material abgeleitet.
- Das bestehende Dropdown ist `details/summary`. Scroll-Lock, Escape-Abfolge, Fokusbegrenzung und Fokus-Rückgabe bleiben erhalten. Der Code verschiebt den Fokus beim Öffnen bereits im nächsten Animation Frame; dies ist kein neu zu erfindender Mechanismus.
- Die CSP aus `public_html/.htaccess` bleibt erhalten. Neue Kontexte über escaped HTML-Attribute und externe Skripte übertragen; keine generelle Freigabe von Inline-JavaScript/Inline-Styles.
- Formular-Datenvertrag erhalten: `type_*`, bestehende Feldnamen, `form_type`, Datenschutz, Honeypot, deaktivierte inaktive Panels, zentrale POST-Allowlist, Backend-Validierung und Mailaufbereitung. `cleaning_types` ist nur die bestehende Textzusammenfassung; der Server bestimmt die Auswahl aus `type_*`.
- Server/Transport bleiben in der vorhandenen Angebotsstrecke. Die Planung verlangt keine neue Formular-API, keinen neuen Maildienst, keine zusätzlichen öffentlichen Formulare und keine neue Datenbank.

## 3. Batches und Abhängigkeiten

**Empfohlene Reihenfolge:** B01 → B02 → B03 → B04 → B05 → B06 → B07 → B08 → B09 → B10 → B11, anschließend Gesamt-Abnahme. B05 kann nach B01–B03 vorgezogen werden, wenn die Katalogauswahl zuerst bearbeitet werden soll. B09 benötigt überwiegend B01/B03 und kann ebenfalls früher erfolgen. Die Materialklärung für B11 kann während der technischen Batches vorbereitet werden; fehlende neue Bilder blockieren die übrigen Änderungen nicht.

| Batch | Zusammenhängender Inhalt | Hauptbefunde | Umfang | Abhängigkeit |
| --- | --- | --- | --- | --- |
| B01 | Gemeinsame Typografie, Links, Fokus und Controls | F09–F15, F33, F35 | M | Basis festgelegt |
| B02 | Hero-System, Seitentitel und frühe Hauptaktion | F01, F02, F08, F19, F20, F34; Basis F39 | M–L | B01 |
| B03 | CTA-Hierarchie und vollständige Kontextübergabe | F03, F21, F22 | M | B01/B02 |
| B04 | Formulareinstieg, Auswahlkarten und Fortschritt | F26, F27, F29 | M | B01/B03 |
| B05 | Früher Katalog und semantisch klickbare Karten | F04, F05, F16; Umsetzung F11 | M | B01–B03 |
| B06 | Service-/Standortinhalte und mobile Verdichtung | F06, F17, F23 | M–L | B02/B03/B05 |
| B07 | Validierung, Versandzustände und Bestätigung | F30, F31; ergänzende Code-Lücken | M | B03/B04 |
| B08 | Optionale Details und konsistenter Upload | F28, F32 | M | B04/B07 |
| B09 | Header-/Footer-Kontexte und Floating-Kontakt | F18, F36; Rahmen F25/F34 | M | B01/B03; B04 für Formularprüfung |
| B10 | Seitenzweck, Anfrage-Ablauf und Hilfsseiten | F24, F25, F40; Kapitel 12.7–12.10 | M | B02/B03/B09 |
| B11 | Praxisbelege, Galerie und Bild-/Markenvarianten | F07, F37, F38, F39; Kapitel 12.5/12.6 | M, mit Material ggf. L | B02/B05/B06; bestätigtes Material nur für neue Zuordnungen |

S/M/L sind relative Größen, keine Stunden- oder Kostenkalkulation. B11 enthält optionale bzw. materialabhängige Ergänzungen; die Überarbeitung der vorhandenen Galerie und der bestehenden Bildausschnitte bleibt auch ohne neue Medien konkret umsetzbar.

## 4. B01 – gemeinsame visuelle und zugängliche Komponentenbasis

**Ziel:** Alle späteren Batches greifen auf dieselben lesbaren Buttons, Feldzustände, Fokusregeln und Textrollen zurück. Die kleine FAQ-Markierung wird im selben Batch als eindeutiger aktueller Navigationszustand korrigiert.

**Tatsächlicher Ausgangspunkt:** `.btn` und Kartenlinks verwenden `.82rem`. `.field label` betrifft jedes Nachfahren-Label mit Gewicht 800. Der gelbe Fokus hat auf Weiß 1,65:1. Der allgemeine Border-Token ergibt bei Eingaben 1,28:1. `.upload-dropzone input` ist deckend und transparent, ohne eigenen sichtbaren Wrapper-Fokus. Links erben ihre Textfarbe und besitzen global keinen Unterstrich.

**Dateien:** `resources/css/00-tokens.css`, `01-base.css`, `02-components.css`, `03-pages.css`, `05-offer-form.css`, `07-gallery-faq.css`, `08-offer-conversion.css`, betroffene Flächen in `09-local-pages.css`; `public_html/faq/index.php:4`; CSS-Bundle und Asset-Version als Folgeänderungen.

1. Rollen für Lesetext, Titel, Lead, Caption, Feldlabel, Hauptaktion, Hilfefläche und Abschluss definieren. Bestehende Tokens erweitern, statt alle Farben neu zu erfinden. Für Grundtext zunächst 16 px beibehalten; Hauptaktionen etwa 15–16 px mit mindestens 48 px Höhe erproben. Kleine Sekundäraktionen bleiben eine eigene Variante.
2. Einen Control-Border-Token von dekorativen Kartenrändern trennen. Idle, Hover, Focus, Invalid, Readonly und Disabled klar definieren. Loading gehört nur an Aktionen mit tatsächlichem Ladezustand. Kontrast der konkreten angrenzenden Flächen prüfen.
3. Hintergrundtaugliche Fokusregeln mit Trennkante einführen; dunkler Header darf eine passende Variante behalten. FAQ-Summary-Override gemeinsam korrigieren. Für die Dropzone sichtbares `:focus-within` vorsehen, das echte File-Input bleibt erreichbar. Focus in Karten und unter dem Sticky-Header darf nicht abgeschnitten werden.
4. Die breite Label-Regel auf echte Feldlabels begrenzen. Auswahl- und Schätzlabels nicht pauschal zu Block-/800-Komponenten machen. Den eigenen Auswahlkarten-Aufbau vervollständigt B04. Datenschutzhinweis und lange Hilfetexte erhalten normale, lesbare Gewichte.
5. Eine Text-/Lead-Lesebreite, beispielsweise 60–75ch bzw. 50–65ch, an echten Absätzen erproben. Globale `anywhere`-Regeln nicht pauschal löschen; normale deutsche Titel erhalten gezielte Trennung/Balancierung, technische lange Werte weiterhin ein Sicherheitsnetz. Kurze Kompaktlabels werden in B04/B05 eingesetzt.
6. Inhaltslinks dauerhaft erkennbar markieren. Dafür einen klar begrenzten Textbereich/Artikelstil verwenden, damit Navigation, Buttons, Ganzkarten und mehrteilige Standortkarten ihre eigene Interaktionsform behalten.
7. In `public_html/faq/index.php` nur `faq` als `$navActive` setzen. Die Abnahme anderer Seiten richtet sich nach vorhandenen Brand-/Haupt-/Dropdown-Zielen; kein falsches `aria-current` für bloße Elternbereiche hinzufügen.

**Abnahme:** Kontakt und Angebot zeigen erkennbar begrenzte Eingaben. Tastaturfokus ist auf Weiß, Soft-Flächen und Navy sichtbar; Upload und FAQ sind eingeschlossen. Der Datenschutztext dominiert nicht mehr den Schritt. FAQ hat genau einen aktuellen Navigationslink. Primäre Beschriftungen umbrechen vollständig bei 320 px. Die H1/H2-Hierarchie der Startseite wird erst in B02 abgeschlossen.

**Warum zusammen:** Tokens und die sie verbrauchenden Zustände müssen gleichzeitig stimmen. Reine Tokenänderungen ohne Anpassung spezifischer Overrides würden die dokumentierten Kaskadenprobleme erhalten.

## 5. B02 – Hero-System und früher Einstieg je Seitenaufgabe

**Ziel:** Startseite, Leistungen, Standortseiten und Hilfsseiten erhalten eine passende Bild-/Textkomposition; Titel und Hauptaktion erscheinen früh. Die 1366-/1921-Sprünge entfallen im selben System.

**Dateien:** `app/helpers/render-components.php`, `app/templates/service-template.php`, `app/templates/location-template.php`; Hero-Konfigurationen in `config/pages/*.php`; `public_html/index.php`, die eigenständigen Seiten mit Hero sowie die Titel-Einstiege in `content/locations/*.php`; `02-components.css`, `04-responsive.css`, globale Hero-Overrides in `09-local-pages.css`, nötige Tokens in `00-tokens.css`.

1. Drei bewusste Einstiegsvarianten definieren: Startseite mit Nutzen/Aktion, kompakter Service-/Standorteinstieg, sachlicher Utility-Einstieg für Kontakt/FAQ und ähnliche Aufgaben. Recht, Formular und 404 bleiben ohne großen Bild-Hero. Jobs erhält eine kompakte Variante mit Platz für den Bewerbungszweck aus B10.
2. Für Service-/Standortseiten eine gemeinsame Titel-/Lead-/Aktionsgruppe anbieten. Die Service-Überschrift aus `config/services/*` ist die bisherige inhaltliche Quelle; lokale Titel/Leads aus den neun Inhaltsdateien werden bei einer Verlagerung eindeutig in die jeweilige Konfiguration übernommen. SEO-`title` ist nicht automatisch der sichtbare H1-Text. Die vorhandene H1 an der alten Stelle entfällt beim Umzug; es gibt nie zwei H1.
3. Auf der Startseite einen primären Link „Kostenloses Angebot anfordern“ und einen kurzen Unverbindlichkeitshinweis im vorhandenen Hero ergänzen. Eine sekundäre Leistungsaktion bleibt nachgeordnet. Hero-H1 etwa 28–34 px mobil bzw. 42–52 px am Desktop erproben und gegen die H2-Hierarchie prüfen.
4. Höhe und Textposition inhaltsabhängig gestalten. Die Textgruppe darf bei vergrößerter Schrift oder 844 × 390 px nicht durch ein festes, absolut positioniertes Panel abgeschnitten werden. Bei kurzen Fenstern eine kompakte/stapelnde Komposition einsetzen. Sticky-Header-Höhe berücksichtigen.
5. Die gemeinsamen 1366-/1921-Regeln aus `09-local-pages.css` konsolidieren. Geplante Standardentscheidung: bildfüllender Crop mit kontrollierten Focal Points, ohne plötzlichen Wechsel auf `contain`. Die Größe darf von 1365 zu 1366 nicht um rund 61 px springen. Einzelne Motivpositionen bleiben als semantische Klassen oder sichere konfigurierte Rollen steuerbar.
6. Bestehende Bilddateien zunächst verwenden. Der Renderer bleibt später für echte mobile Varianten erweiterbar; keine nicht vorhandenen `srcset`-Dateien referenzieren. WebP, Abmessungen, hohe Hero-Ladepriorität und Lazy Loading nachgeordneter Bilder erhalten.

**Abnahme:** Bei 390 × 844 und 320 × 568 px ist die Startseiten-Anfrage ohne Menü und Scrollen erkennbar. Service-/Standorttitel und Anfrage sind im kompakten Einstieg erreichbar; Kontakt/FAQ zeigen Nutzinhalt früh. 1080/1081, 1365/1366, 1920/1921 und 2560 px bleiben kompositorisch konsistent. Tätigkeit im Bild erkennbar, kein verzerrtes Bild, kein verdeckter Text. 28 Routen weiterhin genau eine H1.

**Warum zusammen:** CTA, größerer H1-Text, Bildhöhe, Focal Point und Short-Viewport-Verhalten sind dieselbe Hero-Komposition. Getrennte Änderungen würden Platzprobleme erst nachträglich erzeugen.

## 6. B03 – ein CTA-System mit vollständiger Kontextübergabe

**Ziel:** Überschrift, Button, Handlungsrang und anschließende Formularauswahl passen zusammen. Frühe, seitliche und finale Anfragewege verwenden denselben geprüften Kontext.

**Dateien:** `app/helpers/render-components.php`, `app/helpers/html.php`, bei neuem Helper `app/bootstrap.php`; `config/services/catalog.php` bzw. bestehende Leistungskonfigurationen, `config/pages/*.php`; `content/services/*/summary.php`, `content/ctas/*.php`, `content/locations/*.php`, betroffene Header-/Hero-Links; `public_html/angebotsanfrage/index.php`, `public_html/assets/js/forms/offer-form.js`; CTA-Regeln in `02-components.css`, `03-pages.css`, `09-local-pages.css`.

**Geplanter URL-Vertrag:** `/angebotsanfrage/?service=window&city=koeln`. Parameter sind optionale Vorschläge. Eine zentrale Allowlist bildet Service-/Ortskeys ab; unbekannte, mehrfach widersprüchliche oder strukturierte Werte werden ignoriert. Die tatsächliche Objektadresse und Leistung bleiben vollständig änderbar.

| Herkunft | Formularkey | Standortvorschlag |
| --- | --- | --- |
| Büro-/Gewerberaumreinigung | `office` | Nur bei lokalem Herkunftskontext |
| Glas-/Fensterreinigung | `window` | Nur bei lokalem Herkunftskontext |
| Grund-/Spezialreinigung | `general` | Nur bei lokalem Herkunftskontext |
| Teppich / Polster | `carpet` / `upholstery` | Nur bei lokalem Herkunftskontext |
| Entrümpelung | `clearance` | Nur bei lokalem Herkunftskontext |
| Fassade/Graffiti | `graffiti` | Nur bei lokalem Herkunftskontext |
| Solar/PV | `solar` | Nur bei lokalem Herkunftskontext |
| Lokale Gebäudereinigung | Keine automatische Service-Auswahl | `bruehl`, `koeln` oder `bonn` |
| Lokale Büro-/Fensterreinigung | `office` / `window` | Passender Ortskey |
| Allgemeine Anfrage | Keine Vorauswahl | Kein Vorschlag |

1. Zentrale Kontextdefinition und URL-Helper ergänzen, zum Beispiel neue `config/forms/contexts.php` und `app/helpers/offer-context.php`. Das sind geplante Dateien. Für allgemeine Verbraucher lautet der Fallback weiterhin `/angebotsanfrage/`. Keine parallelen Mappinglisten für jede CTA-Datei erzeugen.
2. Das bestehende `kem_dynamic_html()`/`kem_render_content()` unterstützt nur Unternehmensplatzhalter. Es wird um einen ausdrücklich übergebenen, escaped Kontext erweitert, statt mit impliziten globalen Werten oder beliebigem String-Rewriting zu arbeiten. Beispielsweise ein optionaler Token `{{offer_url}}`, dessen Werte ausschließlich der Helper erzeugt; bestehende Unternehmensplatzhalter funktionieren unverändert.
3. Service-Zusammenfassung, Hero, `kem_render_mobile_offer_cta()`, finale CTA und relevante Standortlinks an diesen Vertrag anbinden. Der mobile Helper erhält neben seinem Label einen optionalen Kontext, seine bisherigen generischen Aufrufe bleiben gültig. Links von lokalem Büro/Fenster übertragen Leistung und Ort; generische Gebäudereinigung überträgt nur Ort.
4. Formularroute liest nur erlaubte Vorschlagswerte und stellt sie als sichere `data-*`-Attribute bereit. JavaScript übernimmt Checkbox-Status und Ort vor dem ersten `syncServicePanels()`/`updateReview()`. Keine rohen URL-Werte in HTML/Skript einsetzen.
5. Vorauswahl als Vorschlag sichtbar erklären; Nutzer können abwählen, weitere Leistungen hinzufügen und den Ort bearbeiten. Schritt 1 wird nicht automatisch übersprungen. PLZ/Straße werden nicht aus einem Ortsnamen erfunden. Der Server akzeptiert weiterhin die tatsächlichen freien Eingaben nach bestehenden Regeln.
6. Start-/Schluss-CTA und WhatsApp visuell nach Rang gestalten. WhatsApp-Grün bleibt erhalten; die primäre Aktion erhält die größere/kräftigere Handlungsrolle, WhatsApp einen ruhigeren Sekundärstil. Die End-CTA-Texte pro Zweck überarbeiten; „Haben Sie Fragen?“ auf der Leistungsübersicht nicht als Angebotseinleitung beibehalten.
7. „2–3 Minuten“ vorerst aus prominenten Zeitversprechen entfernen oder als unbestätigt zu klärende Aussage behandeln; keine neue Zeit erfinden. Eine spätere Wiederaufnahme setzt echte typische Einzel-/Mehrfachanfragen voraus.

**Abnahme:** Alle acht Service-Anfragen und neun lokalen Kontexte erzeugen passende, sichtbare Vorschläge. Unbekannte Parameter bewirken keine Fremdwerte; „Gebäudereinigung Köln“ wählt nicht ungefragt Grundreinigung. Review zeigt die wirkliche Checkbox-Auswahl und den bearbeiteten Ort. Die alte POST-Allowlist erhält keine neuen Pflichtfelder. Ein Direkteinstieg bleibt leer. Eine weitere Anfrage nach Erfolg startet nach dem ausdrücklich definierten Reset aus B07, ohne erneut ungefragt URL-Kontext zu laden.

**Warum zusammen:** CTA-Texte ohne funktionierende Vorauswahl würden F21 erhalten. Queryparameter ohne angepasste Links/Initialisierung/Review wären nur ein halber Datenweg.

## 7. B04 – Formulareinstieg, Service-Auswahl und Fortschritt

**Ziel:** Auf einen Angebotsklick folgt früh eine klare Auswahl; alle fünf Schritte sind verständlich und visuell/semantisch unterscheidbar.

**Dateien:** `public_html/angebotsanfrage/index.php`, `public_html/assets/js/forms/offer-form.js` → erste Multistep-IIFE, `paint()`, `showField()` und Navigation; `05-offer-form.css`, `08-offer-conversion.css`, gegebenenfalls ergänzende Auswahlkomponenten in `03-pages.css`.

1. Titel und Gratis-/Unverbindlichkeitshinweis kompakt vor die erste Frage setzen. Vorteilslisten, WhatsApp-Einstieg, Zeitbadge und wiederholte Mehrfachauswahl-Erklärungen zusammenführen. Eine statische Hilfemöglichkeit bleibt erreichbar; der Kanalwechsel steht nicht vor der ersten Eingabe.
2. Es gibt eine klare sichtbare Schritteinleitung und eine konsistente Mehrfachauswahl-Erklärung. Legend und H2 erfüllen unterschiedliche semantische Rollen, wiederholen aber nicht denselben langen Satz mehrfach. Schritt 1 soll bei 390 × 844 px mindestens die erste auswählbare Leistung zeigen.
3. `.service-choice` als eigene Label-Komponente mit explizitem horizontalem Checkbox-/Textaufbau, Schriftgröße, Titelgewicht und ruhigem Hilfetext definieren. Kurze Auswahlbezeichnungen nutzen, der ausführliche Text/Review bleibt eindeutig. Schätzoption, Terminauswahl und Datenschutz nicht versehentlich mitverändern.
4. Fortschritt in `current`, `complete`, `upcoming` unterscheiden. Aktueller Punkt erhält `aria-current="step"`; abgeschlossene Punkte einen Haken und eine andere Form. Abschluss bedeutet erfolgreich validierter Schritt, nicht bloß einmal besuchter Index. Bei Änderung früherer Angaben relevante spätere Zustände erneut prüfen, bevor „vollständig“ dargestellt wird.
5. Auf Mobil eine kurze sichtbare „Schritt X von 5 – …“-Anzeige behalten; die Live-Ansage bleibt separat zugänglich. `paint()` und `form:go-step` dürfen den Review-Rücksprung nicht auflösen. Punkte zunächst als Anzeige belassen, kein zusätzlicher unvalidierter Sprungpfad.

**Abnahme:** Auswahlkarten besitzen computed `display:flex`; Checkbox/Titel stehen klar zusammen. Alle neun Zweige und Mehrfachkombinationen funktionieren mit B03-Vorauswahl. Current/Complete sind auch ohne Farbwahrnehmung verständlich. Neuer Schritttitel erhält Fokus und wird nicht unter dem Header verdeckt. „Ändern“ erhält Auswahlen, Ort, Termin und optionale Werte.

**Warum zusammen:** Die Einstiegshöhe entsteht aus Intro, Fortschritt, Frage und Auswahlkarten zusammen. Nur kleinere Schrift oder weniger Card-Padding würde die dokumentierte Ursache nicht lösen.

## 8. B05 – Service-Katalog und tatsächlich klickbare Karten

**Ziel:** Leistungen werden schnell ausgewählt; Karten verhalten sich wie ihre sichtbaren Interaktionsflächen.

**Dateien:** `public_html/index.php`, `public_html/leistungen/index.php`, bei gemeinsamer Ausgabe `app/helpers/render-components.php` und `config/services/catalog.php`; `03-pages.css`, `04-responsive.css`, Katalogregeln in `02-components.css`.

1. Auf `/leistungen/` nach kurzem Intro einen sichtbar mit H2 bezeichneten Katalog der acht Kernleistungen zeigen. Die vier Gruppen mit insgesamt 30 Zusatzpunkten folgen anschließend. Eine kompakte Anfrageoption bietet einen allgemeinen Ausweg bei Unsicherheit.
2. Zusatzlisten verständlich in die vorhandenen Kategorien gliedern. Falls einklappbar, native `details/summary` verwenden und alle Inhalte im DOM behalten. Bestehende Fachleistungen direkt verlinken, wo die Zuordnung stimmt. Nicht behaupten, alle Spezialfälle hätten eine eigene Fachseite.
3. Auf Mobil die acht Startseitenleistungen als kompakte Service-Zeilen oder kleinere Karten darstellen, ohne künstliche 300-px-Mindesthöhe und übergroße Icon-Flächen. Eine Spalte ist die geplante schmale Variante; keine erzwungenen zwei Spalten mit zerlegten langen Namen. Die ursprüngliche Reihenfolge beibehalten, solange Geschäftsprioritäten fehlen.
4. Für jede Ein-Ziel-Servicekarte einen echten Link um die zusammengehörige Fläche verwenden. Sinnvollen zugänglichen Namen aus dem Leistungstitel ableiten, dekorative Icons/überflüssige Linktexte passend behandeln. Keine verschachtelten Links, keine JavaScript-Click-Weiterleitung und keine redundanten Tabstopps zum selben Ziel.
5. Mehr-Ziel-Standortkarten erhalten weiterhin getrennte erkennbare Links. Sie werden nicht pauschal zu einer Ganzkarte. Hover/Focus müssen dieselbe Bedienfläche anzeigen; ein Fokusrahmen darf an `overflow:hidden` nicht verschwinden.
6. Bei gemeinsamer Karten-Ausgabe den bestehenden Katalog gezielt um kurze Labels/Beschreibungs-/Bild-/Icon-Daten ergänzen. Keine neue parallel gepflegte Liste von acht Routen einführen. Bild/Icon-Varianten bleiben klar getrennt.

**Abnahme:** Acht Ziele vorhanden, vollständig benannt und mit einem Tabstop pro Ein-Ziel-Karte erreichbar. Der Kernkatalog steht vor den 30 Zusatzpunkten; alle Zusatzleistungen bleiben erreichbar. Bei 320/390/768 px keine abgeschnittenen Titel oder ausschließliche Slider-Navigation. Der mobile Überblick ist sichtbar kompakter, ohne Inhalte zu verlieren.

**Warum zusammen:** Reihung, Karte, Kompaktlabel und Linksemantik bilden gemeinsam die Leistungsauswahl. Eine reine Größenkorrektur würde die falsche Click-Erwartung behalten.

## 9. B06 – Leistungs-/Standortstruktur und mobile Wiederholungen

**Ziel:** Leistungsumfang und Eignung werden vor großen Belegmedien verständlich. Kurzfakten und Angebotswege bleiben erhalten, aber nicht als vollständige mobile Wiederholung.

**Dateien:** `app/templates/service-template.php`, `app/templates/location-template.php`; alle acht `content/services/*/body.php` und `summary.php`; alle neun `content/locations/*.php`; `public_html/index.php` → Region; `06-service-pages.css`, `04-responsive.css`, `09-local-pages.css`.

1. Service-Bodys nach dem gemeinsamen kompakten Einstieg gliedern: Umfang/Eignung → Praxisbeleg → Aufwand/Ablauf → passende FAQ/Ortslinks → nachgeordnete weitere Leistungen → finale Anfrage. Die sechs vorhandenen Videos werden innerhalb ihres bestehenden Inhalts neu eingeordnet; Büro und Entrümpelung erhalten kein erfundenes Video.
2. Portraitvideos mit nativen Controls, Poster, `playsinline` und `preload="none"` erhalten. Vorschau oder Breite kann kleiner werden; Tätigkeit und Bedienbarkeit dürfen nicht durch einen erzwungenen Breitbild-Crop verloren gehen. Die Galerie wird separat in B11 bearbeitet.
3. Mobile Kurzfakten einmal früh integrieren. Desktop-Summary kann rechts bleiben; mobil keine zweite große Foto-/Summary-Karte nach dem vollständigen Artikel. Inhalte aus `summary.php` deshalb eindeutig auf gemeinsame Fakten/Aktion und optionale Medien verteilen. Kein doppelter DOM-Block mit redundanten Links nur zur Breakpoint-Umschaltung.
4. Den Bereich 821–980 px ausdrücklich festlegen: Grid und Sticky-/mobile-CTA-Regeln gemeinsam auf eine sinnvolle Komposition abstimmen. Die geplante Vereinfachung ist ein gemeinsamer Wechsel von Aside-Verhalten und Inhaltsraster, statt zwei voneinander unabhängiger Umschaltungen bei 820 und 980. Die genaue Grenze mit echten Artikeln messen; nicht als unbegründeten festen neuen Zahlenwert setzen.
5. Die neun Standortseiten entsprechend ihrer Gruppe behandeln: allgemeine Gebäudereinigung, Büro, Fenster. Umfang, Turnus, Zugänglichkeit und lokale FAQ früh priorisieren. Brühl ist Sitz, Köln/Bonn sind Einsatzgebiete. Bestehende Routen, Fachlinks, Metadaten und wahrheitsgemäße lokale Informationen bleiben erhalten.
6. Den Startseiten-Regionsblock auf klare Sitz-/Einsatzinformation und die vorhandenen Orts-/Leistungslinks verdichten. Mehrfache gleichartige Ortsnennungen kürzen; Mehr-Ziel-Karten oder kompakte Linkgruppen bleiben verständlich. Nur belegte lokale Zusatzinformation aufnehmen, andernfalls bestehende praktische Fragen konkretisieren.
7. Weitere Leistungen/Orte vor den letzten Anfrageblock setzen. Die aktuelle Servicevorlage tut dies bereits; bei neuen Teilkomponenten diesen Abschluss beibehalten. Wiederkehrende CTAs brauchen einen konkreten Informationskontext, keine zusätzliche komplette Werbesektion.

**Abnahme:** Acht Leistungsseiten und neun lokale Seiten vollständig. Umfang/Eignung stehen vor den sechs langen Videos. Alle Summary-Fakten erhalten, mobil weniger redundante Bild-/Textstrecke. Tablet 820/821/980/981 und kurze Desktop-Fenster prüfen; der untere Aside-Button bleibt erreichbar. Jede Anfrage nutzt B03-Kontext.

**Warum zusammen:** Template, Body, Summary und Breakpoints bestimmen gemeinsam die Inhaltsreihenfolge. Nur die Aside auszublenden würde hilfreiche Fakten entfernen; nur das Video zu verschieben würde die doppelte mobile Summary erhalten.

## 10. B07 – einheitliche Validierung und klarer Anfrage-Abschluss

**Ziel:** Fehler bleiben sichtbar und zuordenbar; ein erfolgreicher Versand endet im Bestätigungszustand. Kontaktformular und Angebot teilen weiterhin zuverlässige Fehler-/Transportbausteine.

**Dateien:** `public_html/assets/js/core/main.js` → Fehlerhelfer/Submit-Handler, `public_html/assets/js/forms/offer-form.js` → Schrittvalidierung und `form:success`; `public_html/angebotsanfrage/index.php`, relevante Kontakt-Labels; `03-pages.css`, `05-offer-form.css`, `08-offer-conversion.css`. `app/forms/contact-handler.php` und `config/forms/schemas.php` sind Vertragsreferenzen; nötige Änderungen dort nur bei einer ausdrücklich geänderten fachlichen Regel.

1. Einen gemeinsamen lokalen/serverseitigen Fehlerpfad schaffen. Die bestehenden `ensureFieldError`, `showFieldError`, `clearFieldError` werden entweder als klar abgegrenzte gemeinsame externe Formularhilfe bereitgestellt oder über eine gezielte Formular-Ereignisschnittstelle wiederverwendet. Keine zweite unabhängige Fehlersammlung im Offer-Skript. Bei neuem externen Helper die Script-Reihenfolge im Footer ausdrücklich festlegen.
2. Beim Weitergehen den aktiven Schritt vollständig prüfen und dauerhafte Textfehler mit `aria-invalid`/`aria-describedby` erzeugen. Native `checkValidity()`/`reportValidity()` darf ergänzen. Bestehende Hilfe-IDs nicht überschreiben; einen kurzen Fehlerüberblick bei mehreren Fehlern mit den tatsächlichen Zielen verbinden. `clearFormErrors()` darf nicht weiter blind alle `.field-error`-Nodes leeren: aktive Upload-/Gruppenfehler erhalten oder im gemeinsamen Validierungslauf erneut erzeugen, solange ihr Input ungültig ist. Den Fehlertext erst nach tatsächlicher Korrektur entfernen.
3. Backend-Fehler auf Einzelcontrols, Radio-/Checkbox-Gruppen und Uploads auflösen. `appointment_preference` liefert eine `RadioNodeList`; den Gruppenfehler dem Fieldset zuordnen und das erste passende Radio fokussieren. `form:show-field` erhält ein Ziel im tatsächlich betroffenen Schritt. Nicht bloß `instanceof HTMLElement` verwenden und Gruppen dadurch ignorieren.
4. Die vorhandenen Wertgrenzen im Browser ergänzen: Ort/Vorname/Nachname mindestens zwei Zeichen, sonstige Leistung mindestens fünf, Polstermengen ganze nichtnegative Zahlen mit maximal vier Ziffern. Dabei gilt die tatsächliche Trim-/Unicode-Logik der Backend-Helfer als Referenz; native `minlength` allein genügt bei Leerzeichen nicht in jedem Fall. Texte erklären den notwendigen Umfang. Serveranforderungen werden nicht abgesenkt.
5. Submit-Zustände konsistent behandeln: laufend, Feldfehler, allgemeiner Fehler, Netzwerkfehler, unerwartete Nicht-JSON-Antwort und Erfolg. Während eines laufenden Sends doppelte Übermittlung verhindern und einen zugänglichen Ladezustand anzeigen. Bei jedem Fehler Eingaben/Dateien erhalten.
6. Den Angebots-Erfolg als eigenes DOM-/UI-Stadium außerhalb der sichtbaren Eingabestrecke anzeigen. Die derzeitige Folge `reset → form:success → Schritt 1 → Status` ändern: Daten werden erst bei bestätigtem `response.ok && data.ok` zurückgesetzt, danach erscheint die Bestätigung statt Schritt 1. Header/Schrittanzeige dürfen keine neue Aufgabe vortäuschen.
7. Bestehende Success-Listener für Schätzoptionen, Panels, Termine, Datei-Vorschau und Review koordiniert beibehalten. Ein Success-Event trägt nötigen Status/Antworttext; Formstatus und Fokus gehören dem tatsächlichen Bestätigungsbereich. Das normale Kontaktformular behält seinen angemessenen Inline-Status, statt versehentlich den Angebots-Wizard zu erhalten.
8. „Weitere Anfrage stellen“ beginnt ausdrücklich eine neue, leere Auswahlstrecke mit Fokus auf Schritt 1. Vorschläge aus der anfänglichen URL werden nicht erneut automatisch aufgespielt; eine originäre `checked`/`value`-Vorauswahl darf durch `form.reset()` nicht unbeabsichtigt zurückkehren. Persönliche Daten und Vorschau-URLs sind nach Erfolg bereinigt.

**Abnahme:** Dauerhafte Fehler bei leerer Leistung, kurzer Texteingabe, ungültiger PLZ, Polstermenge 10000 und Server-Radiofehler. Ein aktiver Upload-Fehler bleibt nach einem lokal ungültigen Submit sichtbar. Rücksprung in den richtigen Schritt, Beschreibungs-IDs erhalten, Eingaben bei Fehler intakt. Mock-Erfolg zeigt dominierende Bestätigung und definierten Neustart. Kontaktformular-Regressionsprüfung eingeschlossen. Backend-Antworten im Browser abfangen; echte Mailzustellung ist eine gesonderte Ende-zu-Ende-Prüfung mit freigegebenem Testempfänger.

**Warum zusammen:** Validierung, Rücksprung, Transport und Abschluss teilen Status/Fokus sowie denselben Form-Event-Lebenszyklus. Ein isolierter Success-Screen könnte Reset/Review/Upload-Listener sonst entkoppeln.

## 11. B08 – optionale Details und verlässliche Datei-Auswahl

**Ziel:** Schritt 2 wächst nur bei Bedarf; alle vorhandenen Angaben bleiben fachlich und technisch erhalten. Auswahlweg, Hilfe und Upload-Limits stimmen überein.

**Dateien:** `public_html/angebotsanfrage/index.php`, `public_html/assets/js/forms/offer-form.js` → Panels, `detailFields`, `syncFiles`, `removeFileAt`, Dropzone; `05-offer-form.css`, `08-offer-conversion.css`. Vertragsreferenzen: `config/forms/schemas.php`, `app/forms/contact-handler.php`, `app/forms/photo-upload.php`.

1. Pflichtkern vor optionalen Objektangaben zeigen. PLZ, Ort, Objektart und die aktiven Service-Pflichtfelder bleiben im sichtbaren Kern. Bereits optionale Firma/Objektbezeichnung, Straße, Etage, Möblierung und Hinweise in eine nachvollziehbare zusätzliche Gruppe einordnen. Keine neue Pflicht allein aus optischer Symmetrie erzeugen.
2. Für Polster eine kompakte Auswahl „Möbelart + Anzahl“ bzw. „Weiteres Möbel hinzufügen“ einführen. Die neun bestehenden Mengenfelder bleiben die übermittelten Zielnamen. Ein Möbeltyp erscheint höchstens einmal; Entfernen löscht nur diesen Wert nach nachvollziehbarer Benutzeraktion. Keine beliebigen neuen Array-Felder senden, die die Server-Allowlist nicht kennt.
3. Das Einklappen vorhandener Werte ist keine Abwahl. Befüllte optionale Gruppen werden entsprechend kenntlich gemacht und bleiben in Review/FormData. Nur ein tatsächlich abgewählter Service deaktiviert seine Felder wie bisher. Fehler in eingeklappten Bereichen öffnen diesen Bereich vor dem Fokuswechsel.
4. Die „Bitte vor Ort einschätzen“-Option samt vorherigem Wert, Readonly-Zustand und verständlichem Review erhalten. Die allgemeinen Längen-/Mengenregeln stammen aus B07. Datenanforderungen ändern oder Felder streichen erst nach fachlicher Klärung; diese erste Verdichtung kann mit unverändertem Vertrag erfolgen.
5. Upload-Hilfe nennt alle tatsächlichen Grenzen: JPG/PNG/WebP, maximal fünf Dateien, je 5 MiB, zusammen 15 MiB. Benutzertext und technische Berechnung werden konsistent gewählt; keine Zusage „fünfmal fünf“ implizieren. Bereits vorhandene Format-/Größenmeldungen verständlich zuordnen.
6. Picker und Drop verwenden denselben Validator. Die aktuelle `.slice(0, 5)`-Kürzung entfällt: geplantes Verhalten ist, eine übergroße Auswahl als Ganzes mit verständlichem Fehler und korrigierbarer Dateiliste zu zeigen. Es werden keine Dateien ohne Hinweis verworfen. Neue Auswahl ersetzt wie bisher die vorherige Liste; kein stilles Zusammenführen mit überraschenden Duplikaten.
7. Vorschau, Entfernen und Dateigrößen erhalten. Object-URLs bei Laden, Dekodierfehler, Entfernen, neuer Auswahl und Success zuverlässig bereinigen. Ein ungeeignetes Bild darf nicht als erfolgreiche Vorschau gelten. Fehler, Dateiliste und Input-Fokus gehören zusammen.
8. Native iPhone-/Android-Auswahl separat prüfen. HEIC bleibt zunächst nicht unterstützt und erhält eine konkrete Erklärung. Falls echte HEIC-Unterstützung erforderlich ist, eine eigenständige Konvertierung mit MIME-/Inhaltsprüfung, Limits und Browser-/Serververtrag bewerten; keine alleinige Änderung des `accept`-Attributs.

**Abnahme:** Polster mit einem und mehreren Möbeltypen, Auf-/Zuklappen, Entfernen und Review-Änderungen ohne Datenverlust. Alle neun Service-Zweige samt Mehrfachauswahl. Upload-Fälle: 0/1/5/6 Dateien; Datei über 5 MiB; Gesamtsumme über 15 MiB bei zulässigen Einzeldateien; HEIC/unerlaubtes Format; Entfernen korrigiert Fehler. Picker und Drop identisch. Serverseitige Prüfung in `photo-upload.php` bleibt maßgeblich.

**Warum zusammen:** Optionale Details und Fotos sind progressive Zusatzangaben derselben Wizard-Strecke. Ihre Darstellung muss mit Review, Fehler-Rücksprung, Deaktivierung und Bereinigung abgestimmt werden.

## 12. B09 – zweckgerechter Header/Footer und Floating-Kontakt

**Ziel:** Der gemeinsame Rahmen unterstützt die aktuelle Aufgabe und verdeckt keine Eingaben oder Aktionen.

**Dateien:** `app/templates/header.php`, `footer.php`, `config/pages/*.php` für eine explizite Seiten-/Aktionsrolle; `public_html/assets/js/core/main.js` → Menü/`footer-visible`; `02-components.css`, `03-pages.css`, `04-responsive.css`, gegebenenfalls Footerregeln in `09-local-pages.css`.

1. Konfigurierte Aktionsrolle einführen: Verkaufsseite mit Angebotsaktion, Jobs mit Bewerbung, aktive Angebotsstrecke mit reduzierter Konkurrenz, Hilfs-/Rechtsseite mit ruhiger Kontaktmöglichkeit. Den Branch nicht über verstreute CSS-Path-Sonderfälle oder bloße Textvergleiche steuern.
2. Für kompakte Header passende direkte Aktion prüfen. Auf Verkaufsseiten ist nach B02 ein früher Hauptweg vorhanden; ein nicht schwebender kompakter Headerlink kann besonders Tablet-Einstiege ergänzen. Bei 320 px bleiben Logo, Aktion und Menü lesbar; kein zusätzlicher fester Anfragebalken als Standard. Formularroute bewirbt nicht erneut dasselbe Formular.
3. Footer-Angebotsbutton aus der Öffnungszeiten-Spalte in eine Kontakt-/Anfragegruppe verschieben. Mobile Reihenfolge: kompakter Markenbezug → Kontakt/Aktion → Leistungen/Region → Zeiten → Rechtslinks. Desktop kann vier Spalten behalten. Adresse, Telefon, E-Mail, Zeiten und Recht bleiben unmittelbar erreichbar.
4. Floating-WhatsApp auf der aktiven Angebotsroute ausblenden und dort eine statische Hilfemöglichkeit nutzen. Jobs erhält ohne bestätigten Bewerbungs-WhatsApp-Weg keine entsprechende Bewerbungsbehauptung. Auf allgemeinen Seiten Kollisionen mit Fokus, wichtigen Buttons und Safe Areas prüfen; wenn nötig kontextabhängig nachordnen statt nur zusätzliche dauerhafte Leerräume einzubauen.
5. Den Footer-Observer und seine tatsächlichen Sichtbarkeitswechsel nach der Footer-Verdichtung prüfen. Verbergen per `visibility`/Fokus darf keine Tastaturfalle oder unsichtbaren Tabstop erzeugen. Back-to-top und Menü-Scroll-Lock bleiben konsistent; mobile Back-to-top-Ausblendung bleibt zulässig.
6. Aktive Seitenauszeichnung über alle Routentypen überprüfen. F33 ist bereits in B01 korrigiert; es wird kein Elternlink als andere aktuelle Seite markiert. Native Dropdown-/Fokuslogik erhalten.

**Abnahme:** Telefon/E-Mail nach dem Abschluss schnell auffindbar; Headeraktion passt zu Angebot/Bewerbung/Formular. Floating-Aktion überdeckt keine Inputs, Review-Ändern-Buttons oder primären Aktionen. 320/390, 768/820, 980 und 1080/1081 px, Safe Areas, Landscape und echte Smartphone-Tastatur prüfen. Menü inklusive RAF-Fokuswechsel, Tab-Schleife, doppelter Escape-Abfolge und Focus-Rückgabe vollständig bedienbar.

**Warum zusammen:** Der Footer beeinflusst den Floating-Observer, und beide CTAs gehören zur globalen Aktionsrolle. Sie getrennt zu ändern würde das sichtbare Kontaktverhalten unnötig widersprüchlich machen.

## 13. B10 – Anfrage-Ablauf und Seiten mit eigenem Zweck

**Ziel:** Die neuen gemeinsamen Komponenten passen zu Kontakt, FAQ, Jobs und Recht; der Ablauf nach einer Anfrage wird ohne erfundene Zusagen verständlich.

**Dateien:** `public_html/index.php`, `kontakt/index.php`, `faq/index.php`, `jobs/index.php`, `datenschutz/index.php`, `impressum/index.php`, `404.php`; passende `content/ctas/*.php`, `config/pages/faq.php`, `config/pages/jobs.php`; begrenzte Seitenstile in `03-pages.css`, `07-gallery-faq.css`.

1. Auf der Startseite einen kurzen Ablauf aus bereits beschriebenen Fakten einbauen: Eckdaten senden → Umfang klären, bei Bedarf Besichtigung → individuelles Angebot. Ein vierter Durchführungsschritt nur, wenn er den Entscheidungszeitpunkt verbessert. Die vorhandene Absprachen-Einleitung kürzen, statt den Ablauf zusätzlich zu jeder Erklärung zu duplizieren.
2. FAQ-Fragen zu Ablauf, Kosten/Unverbindlichkeit und notwendigen Angaben priorisieren. Die zehn nativen Akkordeons behalten; für zehn Fragen keine neue Such-/Filter-Anwendung vorsehen. Bei Reihenfolge-/Textänderung die `FAQPage`-Daten in `config/pages/faq.php` mit den tatsächlich sichtbaren Antworten abgleichen.
3. Auf Kontakt Telefon/E-Mail und verfügbare Kanäle vor oder neben der Formularaufgabe darstellen, auch mobil. Allgemeine Nachricht und detaillierte Angebotsanfrage klar unterscheiden. Inline-Angebotslink aus B01 nutzen. Keine neue eingebettete Karte, Besuchszusage oder Reaktionszeit ohne Bedarf/Fakten.
4. Jobs früh mit Rolle, bestätigten vorhandenen Eckdaten und E-Mail-Bewerbung ausstatten. B09 stellt den passenden Headerrahmen bereit; die eigentliche Stelle erhält frühe Bewerbung, klare Aufgaben/Voraussetzungen/Vorteile und eindeutigen Kontakt. Stundenumfang/Unterlagen erst ergänzen, wenn bekannt. Sichtbaren Inhalt, JobPosting und vorhandene Ablaufdatum-Logik in `head.php` konsistent halten; Ablaufdatum nicht aus optischen Gründen verlängern.
5. Datenschutz mit sinnvoller Lesebreite und Abschnittsankern versehen; bei Bedarf ein kleines Inhaltsverzeichnis aus vorhandenen Überschriften. Keine Änderung rechtlicher Aussagen. Impressum sachlich belassen. Ein möglicher aktiver Anker ist keine zweite Seiten-H1.
6. 404 auf kleine Buttonumbruch-/Abstandsfolgen der neuen Buttonbasis prüfen. Erklärung und Startseiten-/Leistungswege erhalten, kein zusätzlicher großer Medienblock. Direkte 404-Ausgabe und Statusverhalten prüfen.

**Abnahme:** Anfrage-Ablauf nachvollziehbar; Kontaktkanäle früh erkennbar; FAQ-Inhalt und Schema stimmen; Jobs bewirbt die Stelle statt Reinigung; Recht lesbar ohne Promotion im Text. Alle vorhandenen Inhalte, Metadaten und Statuscodes erhalten. „Qualitätskontrolle auf Wunsch“ bleibt eingeschränkt; keine erfundene Garantie oder Antwortzeit.

**Warum zusammen:** Dies ist die redaktionelle Anwendung der gemeinsamen Komponenten auf Seiten mit anderem Nutzerziel. Der technische Rahmen steht bereits; hier werden Inhalt, CTA und strukturierte Daten je Zweck zusammengeführt.

## 14. B11 – Belege, Galerie, Bildkomposition und optionale Markenvarianten

**Ziel:** Vorhandene Praxisbelege werden früher und klarer erreichbar. Unternehmenszuordnung und neue Medien werden nur mit Belegen eingesetzt.

**Dateien:** `public_html/index.php`, `ueber-uns/index.php`, `galerie/index.php`; `config/pages/*.php`, `config/services/*.php`, `app/helpers/render-components.php` und gegebenenfalls `app/helpers/html.php` → Bilder; Medien in `public_html/assets/img/`/`branding/` nur bei tatsächlicher neuer Freigabe; `06-service-pages.css`, `07-gallery-faq.css`, Hero-/Brandregeln aus B02/B09.

1. Die acht Galerie-Clips vollständig erhalten und nach Leistung gruppieren. Drei Glas-/Fenster-Clips werden als solche erkennbar. Eine kompakte Übersicht mit Ankern/Kurzcaption ermöglicht Auswahl vor der langen Videoabfolge; kleine Poster sind zusätzliche Navigation, kein Ersatz für nutzbare Player.
2. Nach B02-kompaktem Galerieeinstieg Videos/Captions früher zeigen. Portraitformat, native Controls, manuelle Wiedergabe, Poster und `preload="none"` erhalten. Keine Autoplay-Lösung oder ausschließlich horizontaler Slider. Audio-/Untertitelbedarf anhand tatsächlicher Inhalte prüfen.
3. Herkunft und Freigaben der Fotos klären. Der aktuelle Über-uns-Alt-Text behauptet schon „Reinigungsteam von KEM“; ohne Beleg neutral auf die dargestellte Tätigkeit beziehen. Echte Unternehmens-/Projekt-/Personenzuordnung erst nach Bestätigung. Neue Captions nennen nur tatsächliche Materialien/Aufgaben und belegte Orte.
4. Falls bestätigtes Material verfügbar ist, einen knappen Ansprechpartner-/Team- oder Referenzbaustein auf Über uns und einen passenden Praxisbeleg auf Home integrieren. Objektart, Aufgabe, Umfang und Ergebnis nur mit belegten Angaben. Falls Material fehlt, die vorhandene Arbeitsweise und Praxisvideos nutzen, statt neue Bewertungen/Zahlen/Logos zu erfinden.
5. Die wichtigsten Motive nach B02-Focal-Point-Prüfung auf echten Geräten beurteilen. Bei Bedarf tatsächliche mobile Bildausschnitte erzeugen und erst danach Renderer/Konfiguration um `<picture>` sowie passende `srcset`/`sizes` erweitern. Jeder referenzierte Kandidat muss existieren; passende Breiten und deklarierte Dimensionen verhindern unnötige Übertragung/Layoutsprünge. Art Direction und Dateigröße getrennt messen.
6. Kompakte Logo-Variante nur bei offizieller/verifizierter Variante einsetzen. Ohne diese Freigabe vorhandene SVGs mit passenden Header-/Footergrößen verwenden. Kein spontaner neuer Schriftzug oder vollständiges Rebranding.

**Abnahme:** Alle acht Clips und Fachlinks erreichbar, auch ohne Slider. Keine falsche Team-/Projekt-/Ort-Zuordnung. Neue Varianten bleiben bei 320/390/768/1440 px motivgerecht und korrekt ausgeliefert. Original- und Fallbackbilder funktionieren. Logo bleibt erkennbar, ohne Menü/Aktion zu verdrängen. Echte neue Referenzen/Assets stehen mit ihren Freigaben im Review.

**Warum zusammen:** Belegmedien, Captions, Alt-Texte, Unternehmensidentität und Art Direction müssen dieselbe Aussage treffen. Eine rein kosmetische Fotoersetzung würde die inhaltliche Zuordnung offenlassen.

## 15. Vollständige Befundabdeckung

Der erste genannte Batch trägt die Hauptverantwortung. Weitere Batches schließen die Anwendung auf konkrete Verbraucher ab. Materialabhängige Wünsche bleiben ausdrücklich bedingt; sie sind keine heimlichen Pflichtbedingungen für die technischen Batches.

| Befund | Hauptbatch | Konkret vorgesehen |
| --- | --- | --- |
| F01 | B02 | Früher Home-Hero-Angebotsweg |
| F02 | B02 | Hero nach Seitenaufgabe |
| F03 | B03 | Primary-/WhatsApp-Gewichtung |
| F04 | B05 | Kompakte mobile acht Leistungen |
| F05 | B05 | Kernkatalog vor Zusatzlisten |
| F06 | B06 | Sechs Videos nach Umfang/Eignung |
| F07 | B11 | Bestätigte Belege oder vorhandener sachlicher Praxis-/Ablaufbezug |
| F08 | B02 | Hero-H1 über H2 in der visuellen Skala |
| F09 | B01 | Lesbare Aktionsgrößen |
| F10 | B01, B06/B10 | Lesebreite/Absatzrhythmus und Anwendung |
| F11 | B01, B04/B05 | Trennung plus kurze Auswahl-/Kartenlabels |
| F12 | B01 | Rollen statt pauschaler 800/Uppercase |
| F13 | B01 | Kontrastfähiger Fokus inklusive Dropzone |
| F14 | B01 | Eigene sichtbare Control-Grenzen |
| F15 | B01, B03 | Semantische Soft-Flächen/Abschlussrolle |
| F16 | B05 | Ein-Ziel-Karten als echter Link |
| F17 | B06 | Eine mobile Faktenfolge und abgestimmte Breakpoints |
| F18 | B09 | Kompakter Footer, Anfrage bei Kontakt |
| F19 | B02 | Kein contain-Sprung ab 1921 |
| F20 | B02 | Kontinuierliche Hero-Höhe |
| F21 | B03 | Sicheres, sichtbares Service-/Ortsmapping |
| F22 | B03 | Titel/Text/Button verfolgen dieselbe Handlung |
| F23 | B06 | Weniger Wiederholung, lokale Entscheidungsinformation |
| F24 | B10 | Kurzer realer Anfrage-Ablauf |
| F25 | B10, B09 | Frühe E-Mail-Bewerbung und passende Rahmenaktion |
| F26 | B04 | Auswahl im frühen Viewport |
| F27 | B04, B01 | Eigene Service-Label-Komponente |
| F28 | B08 | Optionale Details/Furniture-Auswahl ohne Vertragsbruch |
| F29 | B04 | Current/Complete/Upcoming mit Schrittsemantik |
| F30 | B07 | Gemeinsame dauerhafte Fehler, Gruppenauflösung, Wertgrenzen |
| F31 | B07 | Bestätigung statt neuer leerer Strecke; definierter Neustart |
| F32 | B08 | 5/5/15-Grenzen, ein Auswahlvertrag, Geräteprüfung |
| F33 | B01, B09 | FAQ einmal aktuell; richtige Semantik je Routentyp |
| F34 | B02, B09 | Direkter kompakter Angebotsweg; passende Headerrolle |
| F35 | B01 | Sichtbare Inhaltslinks |
| F36 | B09 | Kontextgesteuerte Floating-Aktion |
| F37 | B11 | Bildherkunft und tatsächliche Alt-/Caption-Behauptungen |
| F38 | B11 | Vorhandene Logo-Größen; offizielle Kompaktvariante optional |
| F39 | B02, B11 | Focal Points, bei Bedarf echte Art-Direction-/Auflösungsvarianten |
| F40 | B10, B09 | Ruhiger Rechts-/Hilfseinstieg und passender Rahmen |

## 16. Vollständige Routenabdeckung

| Route/Gruppe | Umfang | Maßgebliche Batches |
| --- | --- | --- |
| `/` | Hero, acht Leistungen, Region, Ablauf, Beleg, Schluss-CTA | B02/B03/B05/B06/B10/B11 |
| `/leistungen/` | Kompakter Einstieg, früher Katalog, Zusatzgruppen, Anfrage | B02/B03/B05 |
| Acht Fachseiten: Büro, Glas, Grund, Teppich, Polster, Entrümpelung, Fassade, Solar | Titel/Aktion, Fakten, Umfang, sechs Videos, lokale Links, mobile Summary | B02/B03/B06 |
| Neun Ortsseiten: Gebäude/Büro/Fenster × Brühl/Köln/Bonn | Titel, passende Kontextvorschläge, lokale Inhalte/FAQ, Querverweise | B02/B03/B06 |
| `/ueber-uns/` | Früher Unternehmensbezug, vorhandene Arbeitsweise, korrekte Bildzuordnung, Belege sofern verfügbar | B02/B03/B11 |
| `/galerie/` | Kompakter Einstieg, acht gruppierte Clips, Übersicht und Caption | B02/B03/B11 |
| `/faq/` | Aktive Navigation, früher Inhalt, native Akkordeons, passender CTA/Schema | B01/B02/B03/B10 |
| `/kontakt/` | Frühe Kanäle, allgemeine Nachricht, sichtbarer Angebotslink, Controls/Fehler | B01/B02/B07/B10 |
| `/jobs/` | Kompakter Einstieg, Stelle/Eckdaten, frühe Bewerbung, passender Rahmen/JobPosting | B02/B09/B10 |
| `/angebotsanfrage/` | Alle fünf Schritte, neun Zweige, Kontext, Review/Upload/Fehler/Erfolg | B01/B03/B04/B07/B08/B09 |
| `/impressum/`, `/datenschutz/` | Bildfreier lesbarer Text, ruhiger Rahmen, Abschnittsanker | B01/B09/B10 |
| `/404.php` | Fehlerstatus, Erklärung, zwei Rückwege und kleine Buttonlayouts | B01/B09/B10 |

Alle Gruppen zusammen entsprechen den 28 Einträgen in `config/pages.php`: 27 reguläre Routen plus direkte 404.

## 17. Prüfungen je Batch und abschließende Abnahme

Nach jedem Batch nur dessen betroffene Komponenten/Seitentypen und wichtige gemeinsame Verbraucher prüfen. Eine komplette Browser-/Routenmatrix ist erst nach dem integrierten Stand nötig, außer ein gemeinsamer Umbau begründet sie schon früher.

**Technische Batch-Prüfung:** Geänderte PHP-Dateien mit `php -l`; geändertes JavaScript mit `node --check`; Quell-/Bundle-Konsistenz nach CSS-Build; keine neuen fehlenden Medien oder Scriptfehler. Für neue Kontext-/Validierungs-/Success-Logik kleine aussagekräftige Integrationsprüfungen vorsehen. Kein Test, der nur einen statischen Text oder CSS-Wert ohne relevanten Verhaltensvertrag kopiert.

**Routen und Layout:** Alle 28 Routen bei 1440 × 900 und 390 × 844 vollständig prüfen, Lazy-Bilder durch Scrollen laden. Erwartet: 27× HTTP 200, direkte 404 HTTP 404, genau eine H1 je Route, korrekte Canonical/Breadcrumb-/Schema-Daten, keine fehlenden Assets, kein unbeabsichtigter horizontaler Überlauf. Honeypot außerhalb des Bildschirms gesondert beurteilen.

**Relevante Breiten/kurze Fenster:** Home, Glas-/Fensterseite und Angebot bei 320, 360, 390, 560/561, 768, 820/821, 980/981, 1024, 1080/1081, 1180, 1365/1366, 1920/1921 und 2560 px. Echte Breakpointänderungen zusätzlich direkt davor/danach prüfen. 320 × 568 und 844 × 390 einbeziehen. Echten 200-%-Browserzoom/Textvergrößerung testen; Geräteskalierung allein ist kein Ersatz.

**Formularmatrix:** Alle neun Einzelzweige, mindestens Büro+Fenster und eine Mehrfachanfrage mit Polster/Solar/Sonstige, alle fünf Schritte, Schätzung an/aus, konkreter Termin an/aus, vorausgewählte und manuell geänderte Orte/Leistungen, Möbel hinzufügen/entfernen, optionalen Bereich auf/zu, Upload-Grenzfälle, Review-Ändern und neuer Versuch nach Fehler/Erfolg. Inaktive Panels sind disabled, fehlende Pflichtwerte blockieren an der richtigen Stelle, eingeklappte befüllte Optionen bleiben erhalten.

**Transport/Status:** Leere lokale Pflichtwerte, kurze Texte, Server-Einzelfehler, Server-Radiofehler, Uploadfehler, Nicht-JSON-Antwort, Verbindungsfehler und Mock-Erfolg. POST in der Browserprüfung abfangen, damit keine reale Anfrage versendet wird. Eine echte Backend-/Mail-Ende-zu-Ende-Prüfung bleibt separat mit Testempfänger und produktionsnaher Konfiguration zu organisieren; UI-Mock ist keine Zustellbestätigung.

**Bedienung:** Tastatur über Header, Dropdown, Cards, FAQ, jeden Formularschritt, Upload, Review und Erfolg. Screenreader-Stichprobe für Live-Status, aktuelle Schritte, Gruppenfehler und Bestätigung. Safari und Firefox zusätzlich zu Chromium; iPhone/Android für Kamera/HEIC/Picker, Mobil-Tastatur und Safe Areas.

**Inhaltsabnahme:** Keine erfundenen Bewertungen, Jahre, Kundenzahlen, Zertifikate, Niederlassungen oder Reaktionszeiten. Brühl bleibt Sitz. Dienstleistungs-Spezialfälle nur nach fachlicher Bestätigung behaupten. Neue Bild-/Personenzuordnungen und Referenzen haben konkrete Freigaben; rechtliche Inhalte sind sachlich unverändert. FAQ-/JobPosting-Angaben passen zum sichtbaren Text.

**Fertigkriterium:** Alle 40 Befunde besitzen einen nachvollziehbaren Abschluss: umgesetzt und passend geprüft, oder bei ausdrücklich optionalen/materialabhängigen Wünschen dokumentiert begründet zurückgestellt. Es bleiben keine versehentlich ausgelassenen Service-Videos, Galerieinhalte, Routentypen oder Formularzweige. Die finalen Dokumente nennen den tatsächlichen implementierten Commit und die tatsächlich ausgeführten Checks. Ein Deployment ist ein späterer, gesonderter Schritt.

## 18. Fachliche Klärungen ohne Blockade der Grundumsetzung

| Frage | Was schon konkret umgesetzt werden kann | Was von bestätigten Angaben abhängt |
| --- | --- | --- |
| Hauptkanal Formular/WhatsApp | Bestehende Formularhierarchie konsequent gestalten | Spätere andere Kanalgewichtung anhand echter Abschluss-/Qualitätsdaten |
| Formularumfang | Vorhandene optionale Felder nachordnen, Daten erhalten | Pflichtfelder streichen/erweitern oder neue Erhebungslogik |
| Zeitbedarf | Prominentes unbestätigtes 2–3-Minuten-Versprechen entfernen | Neue belastbare Zeitangabe nach typischen Nutzertests |
| HEIC/Kamera | Bestehende Formate korrekt erklären, identische Picker-/Drop-Grenzen | Reale Konvertierung und zusätzliche Formatunterstützung |
| Referenzen/Team/Bilder | Vorhandenen Praxisbezug ordnen und unbelegte Zuordnungen neutral halten | Echte neue Personen-/Kunden-/Projektbelege |
| Jobs | Bestehende Stelle/E-Mail-Bewerbung früh zeigen | Stundenumfang, benötigte Unterlagen, zusätzlicher Bewerbungskanal |
| Logo | Bestehende SVG-Größen und Platz im Header prüfen | Offizielle Kompaktvariante |
| Lokale Fakten | Bestehende sachliche Einsatzinformationen verdichten | Neue Orte, garantierte Einsatzzeiten oder lokale Referenzfälle |

**Abschluss dieses Planungsstands:** Batches sind nach Implementierungsinhalt aufgeteilt. Abhängigkeiten, tatsächliche Dateien/Funktionen, Datenschnittstellen, Risiken der jeweiligen Änderung und Abnahme sind dokumentiert. Der Code bleibt bis zum gesonderten Umsetzungsauftrag unverändert.
