# final2 – Implementierung und Abnahme

**Stand:** 14. Oktober 2026 · **Branch:** `final2` · **Basis:** `00f1fe3b7750e0315f3ec0224a887f1a0e74b2d1`.

Der korrigierte Audit und der detaillierte Plan wurden zuerst mit dem tatsächlichen Code abgeglichen. Nach dem anschließenden Implementierungsauftrag wurden alle elf Batches nacheinander umgesetzt. Kein Framework-/Maildienstwechsel; bestehende URLs und Formularfeldnamen bleiben erhalten.

## Abgeschlossene Batches

| Batch | Ergebnis | Commit |
| --- | --- | --- |
| B01 | Lesbare Aktionen, sichtbare Fokus-/Feldzustände und Inhaltslinks | `f5c0a30` |
| B02 | Kompakte kontinuierliche Heroes mit früher H1 und Angebotsaktion | `273d0b1` |
| B03 | Sicherer editierbarer Service-/Ortskontext und CTA-Hierarchie | `b869e0f` |
| B04 | Kurzer Formulareinstieg, Auswahlkarten und validierter Fortschritt | `5f8242e` |
| B05 | Acht frühe Ganzkarten-Links, Zusatzleistungen nachgeordnet | `8f49a30` |
| B06 | Frühe Servicefakten, Videos nach Umfang, weniger mobile Wiederholung | `129338e` |
| B07 | Dauerhafte lokale/Serverfehler, Schutz vor doppeltem Versand, Bestätigung | `f8cc3bc` |
| B08 | Optionale Angaben ohne Datenverlust, kompakte Polsterwahl und Upload | `6d3d850` |
| B09 | Passende Seitenaktionen, kompakter Footer, zuverlässiger Menü-/Footerfokus | `6597e6b` |
| B10 | Realer Anfrageablauf, priorisierte FAQ, frühe Kontakt-/Bewerbungswege und Rechtsanker | `38ae3dd` |
| B11 | Galerie mit sechs Gruppen und acht Clips, sachliche Praxisbelege und Bildtexte | `9ddd318` |

## Vollständige Befundabdeckung

Alle 40 Befunde wurden auf ihre konkreten Verbraucher angewandt. Die Medienpunkte F07/F37/F38/F39 verlangen ohne neue Freigaben keine neuen Bilder, Bewertungen, Kundenlogos oder Teambehauptungen. Hier wurde vorhandenes Material sachlich eingesetzt.

| Befund | Batch | Tatsächliche Umsetzung / Einordnung |
| --- | --- | --- |
| F01 | B02 | Früher Home-Hero-Angebotsweg |
| F02 | B02 | Hero nach Seitenaufgabe |
| F03 | B03 | Primary-/WhatsApp-Gewichtung |
| F04 | B05 | Kompakte mobile acht Leistungen |
| F05 | B05 | Kernkatalog vor Zusatzlisten |
| F06 | B06 | Sechs Videos nach Umfang/Eignung |
| F07 | B11 | Vorhandenes Praxisvideo auf Home, Arbeitsweise und Referenzkontakt auf Über uns; keine erfundenen Referenzfälle |
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
| F32 | B08 | Ein Validator für Picker/Drop, 5/5/15-MiB-Limits, Entfernen/Fokus/URL-Bereinigung geprüft; physische Geräte offen |
| F33 | B01, B09 | FAQ einmal aktuell; richtige Semantik je Routentyp |
| F34 | B02, B09 | Direkter kompakter Angebotsweg; passende Headerrolle |
| F35 | B01 | Sichtbare Inhaltslinks |
| F36 | B09 | Kontextgesteuerte Floating-Aktion |
| F37 | B11 | Bildherkunft und tatsächliche Alt-/Caption-Behauptungen |
| F38 | B09/B11 | Vorhandene SVGs mit kompakter Header-/Footergröße; neue offizielle Variante weiterhin optional |
| F39 | B02/B11 | Kontinuierlicher cover-Hero und Focal Points geprüft; zusätzliche picture/srcset-Dateien wurden mangels Bedarf/Freigabe nicht erzeugt |
| F40 | B10, B09 | Ruhiger Rechts-/Hilfseinstieg und passender Rahmen |

## Prüfungen und praktische Grenzen

- Reale PHP-Ausgabe über Apache/PHP 8.4, 28 konfigurierte Routen: Statuscodes, genau eine H1, Metadaten/Schema, aktuelle Navigation, gültige lokale Assets, keine doppelten IDs/verschachtelten Links und keine horizontalen Überläufe.
- Browser-Prüfungen mit Chromium: schmale/mobile, Tablet-, Desktop- und Ultrawide-Breiten sowie kurze Landscape-Ansichten; Hero-Kontinuität an 1366/1921 und Headerwechsel an 1080/1081.
- Alle neun Formularzweige und Mehrfachauswahl: Kontext/Whitelist/Duplikate, Schätzwerte, konkreter Termin, optionale Werte in FormData und Review, neun Polstermengen, lokale und Serverfehler, Fehler-Rücksprung, Netzwerk-/non-JSON-Fälle, Doppel-Submit und leerer Neustart.
- Upload: Picker und Drop mit 0/1/5/6 Dateien, Einzel-/Gesamtlimit, Null-Byte-/HEIC-Dateien, Entfernen, Fehlermeldungen, Tastaturfokus, downstream Fortschritt und Freigabe der Vorschau-URLs.
- Native Menübedienung: Fokus nach tatsächlicher Sichtbarkeit, Tab/Shift+Tab-Schleife, Dropdown-/Menü-Escape, Fokus-Rückgabe, reduzierte Bewegung; Footer-Fokusübergabe vor dem Verbergen der schwebenden Aktion.
- FAQ-DOM und FAQPage stammen aus derselben Quelle und sind text-/reihenfolgegleich. Rechtstexte und JobPosting-Daten wurden gegen den Ausgangsstand abgeglichen. Acht Videoquellen/Poster/Fachlinks bleiben erhalten, ohne Autoplay; alle acht Originalclips enthalten keinen Audiostream.
- Zusätzlich 15 echte HTTP-Multipart-Szenarien gegen einen isolierten lokalen PHP-Endpoint: gültige JPG/PNG/WebP, echter Inhalts-MIME, leere/gefälschte Dateien, Anzahl-/Einzel-/Gesamtlimits samt exakten Grenzen. Dieser Endpoint lädt nur den bestehenden Upload-Helfer; keine Kontakt-API und kein Mailer.
- PHP-/JS-Syntax, CSS-Bundle aus zehn Quellen, definierte CSS-Tokens und `git diff --check` geprüft.

Die Gesamtprüfungen bestanden ohne Fehler: 674 Routenprüfungen, 283 Layoutprüfungen, 284 Formular-/Vertrags-/Uploadprüfungen und 180 Prüfungen der statischen Vorschau.

Alle Browser-POSTs in der Produkt-QA wurden abgefangen; 15 zusätzliche Upload-POSTs liefen ausschließlich zum isolierten Testendpoint. Es wurden keine Testmails versendet. Tatsächlicher SMTP-Versand sowie physische iOS-/Android-Geräte einschließlich ihrer nativen Fotoauswahl und Bildschirmtastatur wurden hier nicht geprüft. HEIC bleibt wie im Backend nicht unterstützt. Zusätzliche freigegebene Referenzfälle, eine offizielle Kompaktmarke und neue Bildvarianten stehen weiterhin nur bei tatsächlichem Materialbedarf an.

## Veröffentlichung zur Ansicht

Der vollständige PHP-Code wird im GitHub-Branch `final2` bereitgestellt. Die separate private Sites-Vorschau enthält gerenderte Seiten und öffentliche Assets; sie führt keinen PHP-Mailhandler aus. Der sichtbare Vorschauhinweis und eine eigene Formularprüfung zeigen ausdrücklich einen Test ohne Versand. Die PHP-Produktstrecke behält ihren bestehenden Mail-/Serververtrag.

Batch-Prüfungen liefen jeweils vor dem zugehörigen Commit am bereits angewandten Arbeitsstand; ihr `commit` bezeichnet deshalb gegebenenfalls den Vorgänger, ergänzt um den geprüften Arbeitsstand. Der Export weist den finalen Produktcommit `9ddd318` aus.

Die lokale Gesamt-QA und die Exportprüfung liegen als maschinenlesbare Belege unter `docs/verification/`. Screenshots und temporäre Testskripte bleiben außerhalb der Produktquellen. Der historische Audit wird nicht als Beschreibung des neuen Zustands ausgegeben.
