# KEM Gebäudereinigung – Website-Deep-Audit für final6

**Prüfdatum:** 20.10.2026 · **Repository:** `kiesmo/kem-website`

**Ausgangsbranch:** `final5` · **Neu erstellter lokaler Branch:** `final6`

**Geprüfter Ausgangscommit:** `f88d4310526b78d671644ea2efb756f29fdbf8a0`

**Website:** https://www.kem-gebaeudereinigung.de/

## Ergebnis

Die Website besitzt eine stimmige Basis: klare Blau-/Navy-Farbwelt, lesbare Systemschrift, verständliche Leistungsnavigation und ruhige Komponenten. Die Änderungen auf final5 verbessern insbesondere den frühen Leistungszugang, mobile Karten, Überschriften und die frühere Sticky-Seitenleiste. Ein kompletter Neubau ist aus den Befunden nicht erforderlich.

Dieser Bericht enthält **46 offene Befunde und Verbesserungsansätze**: 9 zu Design/Layout/Visuals, 9 zu Formularen, 4 zur Barrierefreiheit, 6 zur Performance, 8 zu Sicherheit/Datenschutz, 7 zu Inhalten/SEO und 3 zu Betrieb/Pflege. Bestätigte Fehler, gestalterische Empfehlungen und offene externe Abnahmen werden ausdrücklich unterschieden. Die Anzahl ist keine Fehlerquote und kein Qualitätsscore.

Die wichtigsten konkreten Fehler sind das ungültige Telefonmuster der Angebotsanfrage, das stille Verwerfen eines sechsten Drag-and-drop-Fotos, unzureichende serverseitige Detailvalidierung, ein vorzeitiger Versand per Enter nach Rücksprung aus der Übersicht sowie einzelne Kontrast- und Touch-Zielmängel. Die Galerie bleibt sowohl in ihrer mobilen Länge als auch beim initialen Laden der Medien der deutlichste gestalterische und performante Schwachpunkt. Eine bereits im vorigen Audit festgehaltene versionierte SMTP-Zugangskonfiguration muss vertraulich betrieblich geklärt werden; ihre Zugangsgültigkeit wurde nicht getestet.

**Kein Website-Code wurde geändert.** `final6` wurde lokal unmittelbar von `origin/final5` erstellt. Die einzige vorgesehene Repository-Ergänzung ist dieser Bericht. Prüfskripte, temporäre Pakete, Screenshots und Messdaten liegen außerhalb des Website-Repositorys. Die lokale Website wurde mit einem schreibgeschützten Repository-Mount ausgeführt. Keine echte E-Mail, Bewerbung oder SMTP-Anmeldung wurde ausgelöst.

**Remote-Status:** Der automatische Freigabecheck hat das Pushen des neuen Branches zu GitHub abgelehnt, weil er hierfür eine ausdrückliche Push-Freigabe verlangt. Deshalb ist `final6` zunächst lokal angelegt; der Audit wird lokal dokumentiert und bereitgestellt. Eine Veröffentlichung wurde nicht ausgeführt.

## Prüfumfang und Aussagekraft

### Durchgeführte Untersuchungen

- Alle **27 regulären öffentlichen Seiten plus Fehlerseite**: vollständige HTML-/Inhaltsprüfung, HTTP-Status, Metadaten, JSON-LD, interne Verlinkung und Ganzseitenaufnahmen bei **1440 × 900** und **390 × 844 CSS-Pixeln**, DPR 1. Vor der Aufnahme wurden lange Seiten durchgescrollt, um nachgelagerte Bilder zu laden.
- **168 weitere Route-/Breitenkombinationen**: dieselben 28 Seiten bei 320, 768, 981, 1081, 1280 und 1920 px. Dazu acht Prüfungen mit verdoppelter Root-Schriftgröße auf vier Hauptwegen bei 390/1440 px. Letzteres ist eine Textgrößensimulation, keine vollständige Browserzoom-Abnahme.
- Prüfung aller **17 Zusammenfassungskarten** bei 1440 × 768: Die frühere Sticky-Positionierung ist entfernt. Header, Navigation, Dropdown, mobile Menübedienung, Footer, FAQ, Galerie, Kontakt und Angebotswizard wurden zusätzlich untersucht.
- **Axe-core 4.14.0** auf allen 56 Ausgangsansichten mit WCAG A/AA einschließlich WCAG 2.2 AA; weitere Prüfungen der fünf Formularschritte. Die Prüfsoftware wurde für die Instrumentierung mit CSP-Bypass geladen. Ein zusätzlicher Formularlauf mit regulär wirksamer CSP bestätigte den Schrittwechsel; Schutzheader wurden unabhängig per HTTP geprüft.
- Vollständiger Angebotsablauf mit synthetischen Daten, Service-/Ortsvorbelegung, direkter Rückkehr aus dem Bearbeiten zur Übersicht, feldbezogenem Fehler, HTML-Fehlerantwort, Netzwerkfehler, Erfolg, Datenbereinigung und Neubeginn. Sämtliche Versandversuche wurden im Browser lokal abgefangen und mit Mock-Antworten beantwortet.
- Lokale API-Negativtests ausschließlich mit ungültigen, nicht versandfähigen Daten; reine Validierungsfunktion ohne Mailtransport ausgeführt. Upload- und Konfigurationslogik statisch geprüft.
- **63 unterschiedliche im Browsercrawl angeforderte lokale Ressourcen** sowie **24 unterschiedliche Open-Graph-Bildziele** erreichbar; diese Mengen überschneiden sich. Interne Fragmentziele geprüft. Medieninventar: 62 Rasterbilder und 8 MP4-Dateien; byteidentische Bildgruppen per Hash erfasst.
- Acht Videos in Chromium jeweils kurz gestartet, pausiert und zur Mitte gesprungen, ohne MediaError; je ein mittlerer Frame visuell gesichtet. Alle Dateien enthalten laut ffprobe eine H.264-Videospur und keine Audiospur. Es wurde nicht jede Videosekunde gesichtet.
- **12 mobile Lighthouse-Messungen**: je drei für Startseite, Galerie, Angebotsanfrage und Glas-/Fensterreinigung. Details und Grenzen unten.
- **146 PHP-Dateien** einschließlich Vendor mit PHP 8.4.26 syntaxgeprüft; beide JavaScript-Dateien mit `node --check` geprüft. `php tools/build-css.php --check` bestätigt, dass das ausgelieferte CSS zu seinen Quellen passt.

### Grenzen

Die Live-Domain war aus der Umgebung nicht erreichbar: Der konfigurierte Proxy verweigerte den HTTPS-Tunnel mit **403 Forbidden**. Es wurde kein Umgehungszugriff versucht. Alle Laufzeitbefunde beziehen sich auf den lokalen Apache-2.4.68-/PHP-8.4.26-Container mit wirksamer `.htaccess`, nicht auf das produktive Hosting.

Nicht abgenommen sind produktive DNS-/TLS-/CDN-Einstellungen, echte Indexierung und Rankings, Google-Unternehmensprofil, Core-Web-Vitals-Feldwerte einschließlich INP, echte Zustellung und SPF/DKIM/DMARC, Betriebsabläufe, Nachweise, Bildrechte und rechtliche Einzelfragen. Safari/iOS, Firefox, echte Mobilgeräte und Screenreader wurden nicht praktisch abgenommen. Automatisierte Accessibility-Ergebnisse sind keine vollständige WCAG-Konformitätsbestätigung. Die Sicherheitsprüfung ist eine Quell- und lokale Robustheitsprüfung, kein vollständiger Penetrationstest.

### Einordnung

| Kennzeichnung | Bedeutung |
|---|---|
| P1 | Vorrangig klären; hier vertraulicher Umgang mit versionierten Zugangsdaten |
| P2 | Relevanter Nutzungs-, Qualitäts- oder Robustheitsmangel; nächster Verbesserungsblock |
| P3 | Gezielte Optimierung oder Pflege |
| Bestätigt | Im aktuellen Code oder unter beschriebenen lokalen Bedingungen nachgewiesen |
| Empfehlung | Beobachtete Verbesserungschance ohne behauptete Funktionsstörung |
| Offen | Benötigt produktive oder betriebliche Informationen; kein bewiesener Live-Fehler |

Kein akuter schwerer Vorfall oder Totalausfall wurde nachgewiesen. Aufwandsschätzungen sind relativ: klein = begrenzter Eingriff, mittel = mehrere Zustände/Komponenten, groß = neue Medien, Inhalte oder Betriebsarbeit. Gestalterische Vorschläge versprechen keine ungemessene Conversion-Steigerung.

## 1. Design, Layout und Visuals

### D01 – Mobiler Startseiten-Hero verdeckt die eigentliche Reinigungsszene

**P2 · Empfehlung · Aufwand: mittel.** Bei 390 px ist die Person links stark angeschnitten, während Werkzeug und Arbeitssituation hinter dem großen blauen Textpanel verschwinden. Das Bild beansprucht eine große Fläche, trägt mobil aber weniger zur Leistungsbotschaft bei als auf Desktop. Der Text selbst bleibt gut lesbar.

- **Beleg:** `public_html/index.php:9`; `resources/css/02-components.css:404` und `:427`; mobile Positionierung in `resources/css/04-responsive.css`. Aufnahme `home-390.png`.
- **Vorschlag:** Eigenen mobilen Bildausschnitt mit erkennbarer Tätigkeit und Werkzeug komponieren oder Bild und Text anders anordnen. Den Motivschwerpunkt je Breakpoint bewusst festlegen.
- **Abnahme:** Bei 320/390/560 px bleiben Tätigkeit, Hauptaussage und Anfrageaktion erkennbar; keine wichtigen Bilddetails hinter dem Panel.

### D02 – Der mobile Kurzüberblick und die zweite Anfrageaktion kommen sehr spät

**P2 · Empfehlung · Aufwand: mittel.** Zusammenfassungskarten folgen mobil nach dem gesamten Artikel einschließlich großem Portraitvideo. Bei Glas liegt die erste Anfrageaktion bei y≈511, die nächste erst bei y≈4225; bei Solar bei y≈569 und y≈4248. Auf Büro Köln liegen ungefähr 3070 px zwischen beiden Aktionen. Die nicht mehr fixierte Desktopkarte löst den früheren Sticky-Fehler, aber nicht diese mobile Reihenfolge.

- **Beleg:** `app/templates/service-template.php:16`; entsprechende `.content-grid`-Strukturen in `content/locations/`; Aufnahme Glas/390. Koordinaten bei 390 × 844, am Seitenanfang gemessen.
- **Vorschlag:** Mobil den kompakten Überblick früher integrieren oder nach dem Leistungsumfang eine ruhige Anfrageaktion anbieten. Bild-/Textwiederholungen reduzieren. Auch die große leere rechte Spalte langer Desktopartikel bei der Komposition mitbetrachten.
- **Abnahme:** Nach den entscheidungsrelevanten Informationen ist der nächste Schritt ohne lange Rücksuche erreichbar; keine neue störende Überlagerung erzeugen.

### D03 – Galerie ist mobil lang und beginnt mit drei ähnlichen Themen

**P2 · Empfehlung · Aufwand: mittel.** Die Galerie ist bei 390 px etwa **8207 px** hoch. Die ersten drei von acht Videos betreffen Glas/Fenster; andere Leistungen folgen später. Zwischen Intro-Anfrageaktion bei y≈460 und der nächsten bei y≈7280 liegt eine sehr lange Strecke.

- **Beleg:** Reihenfolge und Raster in `public_html/galerie/index.php:8`; `resources/css/07-gallery-faq.css:17`; Aufnahme `galerie-390.png`.
- **Vorschlag:** Kurzen abwechslungsreichen Einstieg aus mehreren Leistungsarten zeigen; weitere Clips nach Thema erschließen. Kompakte Vorschauen oder eine einfache Auswahl prüfen. Bei Beispielen einen passenden Leistungs-/Anfrageweg anbieten.
- **Abnahme:** Mehrere Leistungsarten sind früh erkennbar; zusätzliche Inhalte und der nächste Schritt bleiben leicht erreichbar. Keine wichtigen Beispiele ausschließlich hinter horizontalem Wischen verstecken.

### D04 – Große Motive schaffen bisher wenig überprüfbares Unternehmensvertrauen

**P2 · Empfehlung · Aufwand: mittel bis groß.** „Über uns“ zeigt mehrere allgemein wirkende Team-/Reinigungsszenen, nennt aber keine Personen oder Funktionen. Eine Referenzliste gibt es nur auf Anfrage. Galerieuntertitel beschreiben überwiegend einen „kurzen Einblick“, ohne Ausgangslage, konkreten Umfang und Ergebnis zu erläutern. Die Galeriecollage ist im Alt-Text sinnvoll als illustrativ eingeordnet.

- **Beleg:** `public_html/ueber-uns/index.php:9`; Galerieeinträge in `public_html/galerie/index.php`; `config/pages/galerie.php`.
- **Vorschlag:** Freigegebene reale Ansprechpartner und Arbeitssituationen mit Kontext zeigen. Bei echten Projekten Aufgabe, Rahmenbedingungen und Ergebnis ergänzen. Vorher/Nachher nur bei vergleichbaren Aufnahmen einsetzen.
- **Abnahme:** Bild und Text erklären nachvollziehbar, wer arbeitet und was geleistet wurde. Keine unbelegten Referenzen, Bewertungen oder Zertifikate ergänzen. Aus dem heutigen Aussehen wird keine KI-Herkunft oder Unechtheit abgeleitet.

### D05 – Zwei gefüllte Headeraktionen konkurrieren um Aufmerksamkeit

**P3 · Empfehlung · Aufwand: klein.** Auf Desktop stehen blauer Angebotsbutton und grüner WhatsApp-Button gleichrangig übereinander. Die abweichende WhatsApp-Farbe erhält zusätzliches Gewicht. Funktion und Beschriftung sind verständlich; die Geschäftspriorität ist visuell weniger eindeutig.

- **Beleg:** `app/templates/header.php`; `resources/css/02-components.css:302`.
- **Vorschlag:** Gewünschten Hauptweg festlegen und den alternativen Kontaktweg ruhiger darstellen. Den Unterschied anhand echter Nutzung beurteilen.
- **Abnahme:** Eine klare Hauptaktion, eine gut auffindbare Alternative und ausreichende Kontraste/Fokuszustände bleiben erhalten.

### D06 – Auf Mobilgeräten fehlt ein früher direkter Telefonweg

**P3 · Empfehlung / Produktentscheidung · Aufwand: klein.** Unter dem Navigations-Breakpoint verschwindet die Topbar samt Telefonnummer. Im mobilen Menü stehen Anfrage und WhatsApp, aber kein eigener Anruflink. Telefon bleibt über Kontakt und untere Seitenbereiche erreichbar. Die Historie enthält einen bewusst zurückgenommenen Telefon-Menüpunkt; dies ist daher keine neue Regression.

- **Beleg:** `app/templates/header.php`; `resources/css/04-responsive.css:20`; Revert-Commit `306e5f8`.
- **Vorschlag:** Falls Anrufe ein wichtiger Vertriebskanal sind, einen kompakten Telefonweg im Menü oder beim Einstieg erneut fachlich abwägen.
- **Abnahme:** Der Anruf ist ohne lange Suche möglich, ohne den kompakten Header oder die Hauptaktion zu überladen.

### D07 – Bilder der Leistungsübersicht werden mobil zu schmalen Streifen

**P3 · Empfehlung · Aufwand: mittel.** Bei 390 px sind die Kartenbilder ungefähr **360 × 96 px** groß. Einige Motive zeigen dadurch vor allem Tisch, Arm oder Polsterausschnitt statt einer schnell verständlichen Reinigungstätigkeit. Die Kartenfläche ist inzwischen vollständig und sinnvoll klickbar; betroffen bleibt die Bildkomposition.

- **Beleg:** `resources/css/03-pages.css:104`; `config/services/discovery.php`; Aufnahme `leistungen-390.png`.
- **Vorschlag:** Gezielt komponierte mobile Vorschaubilder oder ein kompaktes Bild-/Textlayout prüfen. Motivschwerpunkt und Seitenverhältnis zusammen mit den Bilddateien abstimmen.
- **Abnahme:** Gegenstand und Tätigkeit sind erkennbar, ohne die mobile Auswahl wieder unnötig zu verlängern. Die Auslieferungsgröße behandelt P02.

### D08 – Fassadenclip hat eingebrannte schwarze Balken

**P3 · Bestätigte visuelle Inkonsistenz · Aufwand: mittel.** Im mittleren Frame des Fassaden-/Graffiticlips liegen schwarze Balken innerhalb des kodierten Portraitbildes. Die meisten übrigen Clips nutzen ihre Fläche vollständiger.

- **Beleg:** `public_html/assets/video/services/fassadenreinigung/fassadenreinigung-praxis.mp4`; Framekontaktblatt im Belegpaket.
- **Vorschlag:** Bei verfügbarem Original einen passenden neuen Ausschnitt/Encode erstellen. Die Darstellung nicht blind mit CSS vergrößern, wenn dadurch Reinigungsdetails verloren gehen.
- **Abnahme:** Sinnvoll genutzter Bildraum ohne Verzerrung und ohne Verlust wesentlicher Inhalte; Poster und Clip passen zusammen.

### D09 – Startseite wiederholt die Aussage zu klaren Absprachen

**P3 · Empfehlung · Aufwand: klein.** Der Einleitungsabsatz erklärt bereits Leistungsumfang, Turnus und Einsatzzeiten. Direkt danach wiederholt die erste Stärkenkarte diese drei Punkte fast vollständig. Das verlängert vor allem mobil einen ohnehin umfangreichen Bereich; die inzwischen früh platzierten Leistungen sind davon unabhängig bereits verbessert.

- **Beleg:** `public_html/index.php`, Abschnitt `.intro-section`; `resources/css/09-local-pages.css:141`.
- **Vorschlag:** Einleitung straffen und die Karten für zusätzliche konkrete Informationen nutzen, beispielsweise tatsächlichen Ablauf oder Ansprechpartner, soweit belegbar.
- **Abnahme:** Jeder Abschnitt liefert einen eigenen Informationsnutzen; Wiederholung reduziert sich ohne Verlust wichtiger Aussagen.

## 2. Formulare und Conversion

### F01 – Erster Formularschritt benötigt viel Scrollen vor „Weiter“

**P2 · Empfehlung · Aufwand: mittel.** Bei 390 × 844 liegt der erste Weiter-Button in der allgemeinen Angebotsanfrage bei y≈1466; mit Ortskontext bei y≈1501. Vorher stehen Einleitung, Fortschritt, weitere Schritteinleitung und neun Auswahlkarten. Der erste einfache Auswahlschritt überschreitet damit deutlich die sichtbare Höhe.

- **Beleg:** `public_html/angebotsanfrage/index.php:10`; Formularstile in `resources/css/05-forms.css`; `offer-step1-390.png`.
- **Vorschlag:** Einstieg und Fortschrittsdarstellung verdichten, Wiederholungen streichen und mobile Auswahlkarten kompakter gestalten. Mehrfachwahl und große Touch-Flächen erhalten.
- **Abnahme:** Die Auswahl und ihr nächster Schritt werden mit weniger Scrollen verständlich, auch bei großer Schrift. Kein zusätzliches Pflichtfeld einführen.

### F02 – Telefon-Pattern der Angebotsanfrage ist ungültig

**P2 · Bestätigter Funktionsfehler · Aufwand: klein.** Das Pattern `[0-9+\(\) /.\-]{6,30}` enthält einen im aktuellen HTML-Pattern-Modus nicht korrekt maskierten Schrägstrich. Chromium meldet einen RegExp-Syntaxfehler; `abcdef` hat `patternMismatch=false` und besteht die Feldprüfung. Das Kontaktformular maskiert den Schrägstrich bereits korrekt und weist denselben Testwert zurück. Der Server besitzt eine eigene Telefonprüfung, sodass kein vollständiger Validierungsausfall vorliegt.

- **Beleg:** `public_html/angebotsanfrage/index.php:189`; Browserkonsole und ValidityState in den Formularbelegen.
- **Vorschlag:** Angebotsmuster mit dem funktionierenden Kontaktfeld abgleichen und Browser-/Serverregeln bewusst angleichen.
- **Abnahme:** Zulässige Telefonnummern funktionieren; Buchstaben werden schon im Browser abgewiesen, ohne Pattern-Fehler in der Konsole.

### F03 – Sechstes Drag-and-drop-Foto verschwindet ohne Hinweis

**P2 · Bestätigter Funktionsfehler · Aufwand: klein.** Beim Ablegen von sechs Dateien werden durch `.slice(0, 5)` nur fünf übernommen. Die spätere Mengenprüfung sieht die ursprüngliche Überschreitung nicht mehr. Im Test blieben fünf Dateien und eine leere Fehlermeldung zurück. Das kann den Eindruck erwecken, alle ausgewählten Fotos seien beigefügt.

- **Beleg:** `public_html/assets/js/forms/offer-form.js:436`, insbesondere `:441`; Test `drop6`.
- **Vorschlag:** Überschreitung vor Übernahme erkennen und verständlich melden; entweder gesamte Auswahl zur Korrektur zurückweisen oder das Weglassen ausdrücklich erklären.
- **Abnahme:** Dateiauswahl und Drag-and-drop behandeln sechs Dateien nachvollziehbar gleich; kein stilles Verwerfen.

### F04 – Serverseitige Detailvalidierung akzeptiert unplausible Flächen und Auswahlwerte

**P2 · Bestätigter Datenqualitäts-/Robustheitsmangel · Aufwand: mittel.** Die reine Vorbereitungsfunktion akzeptiert bei ansonsten gültigen Angaben `office_area=-250` und `office_frequency=Erfundener Turnus` mit **leerer Fehlerliste**. Pflichtprüfungen sichern hier überwiegend nur Nichtleere. Einige zentrale Auswahlfelder und Polster-Anzahlen werden dagegen bereits korrekt geprüft.

- **Beleg:** `app/forms/offer-request.php:67`; `config/forms/offer.php:65` und `:77`; isolierter Test ohne SMTP.
- **Vorschlag:** Serverregeln für Flächen, Anzahlen und echte Select-Werte zentral definieren. Dezimalkomma, sinnvolle Grenzen und den ausdrücklich angebotenen Schätzwert berücksichtigen. Freitext dort zulassen, wo er fachlich gewollt ist.
- **Abnahme:** Negative/unsinnige Flächen und erfundene Enum-Werte erzeugen passende Feldfehler; erlaubte Schätz- und Dezimalangaben bleiben nutzbar. Kein SQL-/Code-Injektionsnachweis wird aus diesem Befund abgeleitet.

### F05 – Enter kann nach „Zurück“ aus der Prüfübersicht vorzeitig senden

**P2 · Bestätigter Interaktionsfehler · Aufwand: klein bis mittel.** Reproduktion: Angaben bis zur Übersicht ausfüllen, Datenschutzhinweis bestätigen, über den normalen Zurück-Button zu den Kontaktdaten gehen und im Vornamensfeld Enter drücken. Im Mock-Test wurde unmittelbar ein POST ausgelöst und der Erfolgszustand angezeigt. Die erneute Übersicht und eine separate bewusste Sendebetätigung wurden übersprungen. Der direkte Bearbeiten-Weg mit „Ändern“ funktioniert dagegen inzwischen korrekt.

- **Beleg:** `public_html/assets/js/forms/offer-form.js:90`; regulärer Zurück-Weg bei `:98`; Submit-Handler in `public_html/assets/js/core/main.js`. Test `enter_before_review.sent=1`.
- **Vorschlag:** In jedem Bearbeitungsschritt implizites Submit als Schrittwechsel behandeln; Versand nur im aktiven letzten Schritt zulassen. Serverseitige Validierung beibehalten.
- **Abnahme:** Enter in allen Textfeldern vor der Übersicht löst keinen Versand aus, auch nach vorherigem Bestätigen, Zurückgehen oder Ändern. Der Sendebutton funktioniert weiterhin per Tastatur.

### F06 – Lokale Upload-/POST-Limits widersprechen den zugesagten 15 MB

**P2 · Lokal bestätigt / Produktion offen · Aufwand: mittel.** Das Formular verspricht fünf Fotos à 5 MB, insgesamt 15 MB. Der lokale PHP-Container erlaubt `upload_max_filesize=2M` und `post_max_size=8M`. Ein garantiert ungültiger POST von ca. 9 MB produziert wegen aktiver Fehleranzeige HTML-Warnungen mit anschließendem JSON und lokal HTTP 200. Der Versandpfad wurde dabei nicht erreicht. Das sind lokale Einstellungen, kein Nachweis für dieselben Live-Limits.

- **Beleg:** `public_html/angebotsanfrage/index.php:175`; `app/forms/photo-upload.php:22`; lokale INI-Abfrage und Test `oversized-invalid`.
- **Vorschlag:** Webserver-, PHP-, Formular- und Mailgrenzen zusammen abstimmen; Multipart- und Base64-Aufschlag berücksichtigen. Übergröße früh erkennen und in einem kontrollierten Fehlerformat beantworten; öffentliches `display_errors` deaktivieren.
- **Abnahme:** Ein erlaubter Grenzfall wird vollständig verarbeitet; zu große Anfragen ergeben nachvollziehbar 413/Validierungsfehler statt PHP-Warnung oder vermeintlichem Erfolg. Im Produktivhosting gesondert verifizieren.

### F07 – Array im Formulartyp erzeugt Warnungen vor der Typprüfung

**P2 · Codefehler bestätigt / lokale Fehleroffenlegung · Aufwand: klein.** `form_type[]=kontakt` wird vor der allgemeinen Array-Prüfung nach String konvertiert. Lokal folgen „Array to string conversion“, ein interner Dateipfad und ein Fehler beim Setzen des HTTP-Status; die Antwort bleibt HTTP 200 mit Warnungs-HTML vor JSON. Auch bei abgeschalteter Fehleranzeige bleibt die falsche Prüfungsreihenfolge bestehen.

- **Beleg:** `app/forms/contact-handler.php:78` vor `:84`; API-Test `array-type`.
- **Vorschlag:** Eingabeformate vor Casts, Normalisierung und Indexzugriff prüfen. Fehleranzeige im produktiven Betrieb abschalten und Fehler serverseitig protokollieren.
- **Abnahme:** Array-/verschachtelte Feldformen werden ohne PHP-Warnung als konsistenter 400-JSON-Fehler abgewiesen. Kein interner Pfad erscheint in der Antwort.

### F08 – Bei JavaScript-Ausfall fehlen Navigations- und Anfragefallback

**P2 · Bestätigte Robustheitslücke · Aufwand: mittel.** Ohne JavaScript zeigt die Angebotsseite nur Schritt 1. „Weiter“ ist ein wirkungsloser Button, der Submit bleibt verborgen; ein `noscript`-Hinweis fehlt. Auch das mobile Hauptmenü öffnet sich nicht. Der serverseitige Inhalt gewöhnlicher Seiten bleibt grundsätzlich vorhanden.

- **Beleg:** `resources/css/05-forms.css:106`; `public_html/angebotsanfrage/index.php:47`; mobile Navigationsregeln in `resources/css/04-responsive.css`; eigener No-JS-Lauf.
- **Vorschlag:** Ohne Script eine benutzbare Gesamtform oder einen deutlichen Telefon-/E-Mail-Ersatzweg anbieten; mobile Navigation durch progressive Erweiterung zugänglich halten.
- **Abnahme:** Bei blockiertem oder fehlgeschlagenem Script ist der Zustand verständlich und ein brauchbarer Kontakt-/Navigationsweg vorhanden.

### F09 – Formularversand besitzt keinen eigenen Timeout oder Abbruchweg

**P3 · Empfehlung zur Robustheit · Aufwand: klein bis mittel.** Während des Sendens werden sämtliche Formularelemente deaktiviert. `fetch()` hat keinen anwendungsseitigen Timeout und keine Abbruchfunktion. Bleibt eine Verbindung lange offen, kann der wartende Zustand bis zum Browser-/Netzwerkabbruch anhalten. Normale Netzwerkfehler werden bereits verständlich behandelt und behalten die Eingaben.

- **Beleg:** `public_html/assets/js/core/main.js:234` und `:258`; kein AbortController im Versandpfad.
- **Vorschlag:** Angemessene Zeitgrenze und verständliche Wiederherstellung anbieten. Bei unklarem Ergebnis erklären, dass eine Anfrage eventuell angekommen sein kann; Schutz vor Doppelversand berücksichtigen.
- **Abnahme:** Eine künstlich dauerhaft offene Mock-Antwort lässt den Nutzer nach definiertem Zeitraum wieder handeln. Nicht behaupten, ein Clientabbruch verhindere bereits gestarteten Serverversand.

## 3. Barrierefreiheit und Bedienung

### A01 – Hinweise in Formularschritt 2 unterschreiten den Textkontrast

**P2 · Bestätigter Accessibility-Mangel · Aufwand: klein.** Auf dem hellblauen Einsatzortblock erreicht `(optional)` mit `#6a7681` auf `#edf5fa` etwa **4,21:1**; der Firmenhinweis mit `#66737e` etwa **4,40:1**. Bei 14 px wird das erforderliche Verhältnis von 4,5:1 für normalen Text unterschritten. Die Ausgangsansicht des Wizards allein deckt diesen späteren Zustand nicht auf.

- **Beleg:** Axe-Prüfung von Schritt 2; `resources/css/05-forms.css:373` und Regeln für `.optional-label`; `public_html/angebotsanfrage/index.php:54`.
- **Vorschlag:** Hinweistexte auf den tatsächlich verwendeten Hintergrund abstimmen, möglichst über gemeinsame Farbrollen.
- **Abnahme:** Mindestens 4,5:1 in allen betroffenen Formularzuständen, einschließlich Hinweis-, Schätz-, Fehler- und deaktivierter Darstellung soweit jeweils anwendbar.

### A02 – Telefon- und E-Mail-Ziele im Footer liegen zu eng

**P2 · Bestätigter Touch-Zielmangel · Aufwand: klein.** Axe markiert den Footer-Telefonlink auf allen 56 Ausgangsansichten. Auf Desktop misst er etwa **99,8 × 19 px**; der sichere Abstand zum benachbarten Kontaktziel ergibt nur etwa **21,6 px** statt 24 px. Breite allein ersetzt ausreichende Höhe beziehungsweise Abstand nicht.

- **Beleg:** `app/templates/footer.php`, Kontakt-`address`; `resources/css/03-pages.css:323`; Regel `target-size` im Axe-Bericht.
- **Vorschlag:** Telefon und E-Mail als getrennte ausreichend hohe Zeilen mit passendem Abstand gestalten, ohne unnötige große Buttons einzuführen.
- **Abnahme:** WCAG-2.2-Zielgröße beziehungsweise zulässige Abstandsregel erfüllt; vorzugsweise komfortable Touch-Höhen um 44 px. Nicht pauschal jeden normalen Fließtextlink als Verstoß werten.

### A03 – Mobiles Menü kombiniert Fokusfalle mit weiter zugänglichem Seitenhintergrund

**P3 · Semantische Empfehlung / Screenreader-Abnahme offen · Aufwand: mittel.** Das geöffnete Menü sperrt Scrollen und hält Tab innerhalb von Menü und Schalter, nutzt aber normales Navigationsmarkup. Hauptinhalt/Footer werden weder `inert` noch anderweitig modal ausgeschlossen. Tastatur-Escape und Fokusrückgabe funktionieren; eine Fehlbedienung mit einem realen Screenreader wurde nicht nachgewiesen.

- **Beleg:** `public_html/assets/js/core/main.js:26` und `:84`; im offenen Zustand kein `inert` am Hauptinhalt.
- **Vorschlag:** Ein konsistentes Modell wählen: normale ausklappbare Navigation mit natürlichem Fokusfluss oder vollständiges modales Verhalten mit passender Semantik und Hintergrundbehandlung. Nicht nur ein ARIA-Attribut ergänzen.
- **Abnahme:** VoiceOver/TalkBack und NVDA/JAWS prüfen: sichtbare und angesagte Inhalte passen zusammen, Schließen ist klar und der Fokus kehrt sinnvoll zurück.

### A04 – Stumme Videos haben nur sehr knappe Textalternativen

**P2 · Empfehlung zur gleichwertigen Zugänglichkeit · Aufwand: mittel.** Alle acht MP4s sind ohne Audiospur. Titel und allgemeine Bildunterschriften benennen zwar das Thema, beschreiben aber nur wenig von dem gezeigten Vorgang oder Ergebnis. Es gibt keine weitergehende gleichwertige Medienbeschreibung; ein `aria-label` benennt lediglich den Player.

- **Beleg:** `public_html/galerie/index.php`; Videofiguren in `content/services/*/body.php`; ffprobe-Inventar.
- **Vorschlag:** Wesentlichen visuellen Informationsgehalt pro Clip als zugänglichen Text beschreiben, gegebenenfalls in einem kurzen aufklappbaren Absatz. Relevante Handlungen und Grenzen nennen.
- **Abnahme:** Die wesentliche Aussage ist auch ohne Sehen/Abspielen verständlich. Bei rein stummen Clips sind erfundene Dialoguntertitel nicht sinnvoll; entscheidend ist die angemessene Alternative für Video-only-Inhalt.

## 4. Performance und Medienauslieferung

### Messwerte

Lighthouse **13.5.0**, Chromium, mobile Emulation **412 × 823**, DPR 1,75, simuliertes Netz mit 150 ms RTT / 1638,4 kbit/s und vierfacher CPU-Verlangsamung. Je drei neue Navigationsläufe; angegeben ist der Median. Die zugrunde liegenden HTTP-Abrufe laufen lokal. Die simulierten Ergebnisse sind weder Live-Nutzerwerte noch ein vollständiger Vergleich zur früheren Auditversion.

| Seite | Performance-Score | LCP | TBT | CLS | Übertragene Daten beim initialen Lauf |
|---|---:|---:|---:|---:|---:|
| Startseite | 97/100 | 2,552 s | 8 ms | 0 | ca. 339 KiB |
| Galerie | 83/100 | 4,656 s | 31,5 ms | 0 | ca. 755 KiB |
| Angebotsanfrage | 100/100 | 1,301 s | 0 ms | 0 | ca. 73 KiB |
| Glas-/Fensterreinigung | 98/100 | 2,404 s | 8 ms | 0 | ca. 279 KiB |

LCP über 4 s liegt im ungünstigen Orientierungsbereich; die Galerie verdient deshalb Vorrang. Auf der Startseite liegt der Median knapp über 2,5 s. TBT ist ein Labormesswert und ersetzt INP nicht. CLS 0 in diesen initialen Läufen ist keine Garantie für sämtliche Interaktionen.

### P01 – Alle acht Galerieposter laden bereits beim ersten Seitenaufruf

**P2 · Bestätigte vermeidbare Medienlast · Aufwand: mittel.** Ohne Scrollen und ohne Wiedergabe fordert die Galerie sämtliche acht Poster an: zusammen rund **480265 übertragene Bytes** im ersten Lighthouse-Lauf. `preload="none"` verhindert die initiale Videolast, verzögert aber die Poster nicht. Diese konkurrieren mit der großen Einleitungscollage um das mobile Netzbudget.

- **Beleg:** Initialer normaler Browserlauf und Lighthouse-Netzwerkprotokoll; `public_html/galerie/index.php`, Videoausgabe.
- **Vorschlag:** Poster und gegebenenfalls Player erst in sinnvoller Nähe zum Sichtbereich laden, mit fest reservierten Abmessungen und brauchbarer Tastatur-/No-JS-Bedienung. Oberhalb sichtbare Medien nicht unnötig verzögern.
- **Abnahme:** Erste Ansicht lädt nur benötigte Medien; späteres Scrollen/Wiedergabe funktioniert ohne Layoutsprung. LCP und Transfer unter gleichen Bedingungen vergleichen.

### P02 – Passende responsive Bildvarianten fehlen

**P2 · Bestätigtes Auslieferungspotenzial · Aufwand: mittel.** Bilder werden ohne `srcset`/`sizes` ausgeliefert. Die Galeriecollage ist 1536 × 1024 groß und etwa 252 kB schwer, erscheint im mobilen Lighthouse-Lauf aber mit ungefähr 384 × 256 CSS-Pixeln. Karten verwenden unter anderem 1200 × 800-Dateien für schmale Bildstreifen; das Fassadenkartenbild ist rund 381 kB groß. WebP allein löst die Größenwahl nicht.

- **Beleg:** `app/helpers/render-components.php`, Introbildausgabe; `app/helpers/service-discovery.php`; Medieninventar und Lighthouse `image-delivery-insight`.
- **Vorschlag:** Wenige bedarfsgerechte Breiten und bewusste Ausschnitte erstellen; `srcset`/`sizes` an reale Layouts anpassen. Kompressionsqualität visuell bewerten und hohe DPR berücksichtigen.
- **Abnahme:** Browser wählen eine geeignete Variante, Bilder bleiben scharf und Motivschwerpunkte erhalten. Gemeldete Lighthouse-Einsparungen sind Schätzungen, keine zugesicherte Nettoersparnis.

### P03 – JavaScript-MIME passt lokal nicht zu Gzip- und Cacheregeln

**P3 · Lokal bestätigt / Produktion offen · Aufwand: klein.** Apache liefert `.js` als `text/javascript`; `.htaccess` konfiguriert Ablaufzeit und Kompression für `application/javascript`. Im Abruf mit `Accept-Encoding: gzip` fehlen beim Hauptscript sowohl Kompression als auch die vorgesehenen Cache-Header. Lighthouse weist auf fehlende Script-Cachezeit hin.

- **Beleg:** `public_html/.htaccess`, `ExpiresByType` und `AddOutputFilterByType`; Headeraufnahme des Hauptscripts. Auf der Angebotsseite betrifft es zusammen etwa 41 KiB Scripttransfer inklusive Headern.
- **Vorschlag:** Tatsächlich verwendete MIME-Typen in Cache-/Kompressionsregeln berücksichtigen; das Ergebnis am Zielserver prüfen.
- **Abnahme:** Beide Scripts werden mit korrektem MIME, sinnvoller Cachezeit und ausgehandelter Kompression ausgeliefert; geänderte Versionen werden weiterhin rechtzeitig geladen.

### P04 – Lange Bildcachezeit benötigt eine verlässliche URL-Versionierung

**P3 · Wartungsrisiko · Aufwand: klein bis mittel.** WebP und SVG erhalten ein Jahr Cachezeit, ihre URLs tragen jedoch keinen Inhaltsfingerabdruck. Die zentrale `asset_version` wird nur an CSS und JavaScript angehängt. Wird ein Motiv unter gleichem Dateinamen ersetzt, können Besucher lange die vorherige Version sehen; ein aktuell veraltetes Bild wurde nicht nachgewiesen.

- **Beleg:** `public_html/.htaccess`; `app/templates/head.php`; Bildausgabe der Templates.
- **Vorschlag:** Geänderte Medien unter neuen/inhaltsbezogenen URLs ausliefern oder eine bewusst abgestimmte Revalidierungsstrategie verwenden.
- **Abnahme:** Browser mit altem Cache sehen nach einer beabsichtigten Bildänderung zuverlässig das neue Motiv.

### P05 – Identische Bilder werden unter mehreren URLs gepflegt

**P3 · Bestätigtes Redundanzpotenzial · Aufwand: klein bis mittel.** Der Hashvergleich findet **11 Gruppen byteidentischer Bilder**. Ein Büro-/Gewerbemotiv liegt beispielsweise unter acht Content-/Kartenpfaden; weitere Motive werden für drei Städte und die zentrale Leistungsseite kopiert. Unterschiedliche URLs verhindern den gemeinsamen Browsercache und erhöhen den Pflegeaufwand.

- **Beleg:** Medieninventar/Hashgruppen; `config/services/discovery.php` und lokale Bildkonfigurationen.
- **Vorschlag:** Wirklich identische Medien auf gemeinsame versionierte Assetpfade beziehen. Texte/Alt-Beschreibungen weiterhin kontextgerecht pflegen. Ortsbezug nicht durch bloßen Dateinamen suggerieren.
- **Abnahme:** Unveränderte Medien werden über einen gemeinsamen Pfad wiederverwendet; keine defekten Bilder oder ungewollten Cachewechsel.

### P06 – Einige kurze Videos sind für mobile Wiedergabe relativ datenintensiv

**P3 · Medienoptimierung · Aufwand: mittel.** Solar umfasst rund **5,84 MB für 15,73 s** bei etwa 2,97 Mbit/s, Polster **2,36 MB für 8,8 s** bei etwa 2,15 Mbit/s. Die Dateien werden erst bei Wiedergabe relevant; es handelt sich nicht um initial heruntergeladene Videomegabytes.

- **Beleg:** ffprobe-Medieninventar; MP4-Dateien unter `public_html/assets/video/`.
- **Vorschlag:** Für die kleinen Portraitplayer passendere Encodes bei erhaltener Detailerkennbarkeit vergleichen. MP4-Start und Range-/Seek-Verhalten auf dem Zielhosting prüfen; adaptive Auslieferung nur bei entsprechendem tatsächlichem Bedarf.
- **Abnahme:** Start und Wiedergabe funktionieren unter mobilen Netzbedingungen; weniger Daten ohne sichtbare störende Artefakte. H.264-Fallback und `playsinline` erhalten.

## 5. Sicherheit, Datenschutz und Abhängigkeiten

### S01 – Versionierte SMTP-Konfiguration braucht vertrauliche Klärung

**P1 · Bereits dokumentierter Geheimnisbefund / Zugangsgültigkeit offen · Aufwand: mittel.** Der frühere Audit dokumentiert einen SMTP-Passwortliteral im Git-Repository. Die Dateien `private/contact.php` und `private/smtp-config.php` besitzen auf dem jetzigen Ausgangscommit **dieselben Git-Blob-IDs** wie der damals geprüfte Stand final4. Die betreffenden Inhalte wurden für diesen Audit nicht ausgegeben und keine Anmeldung getestet. Außerhalb des DocumentRoot zu liegen schützt nicht vor Zugriff über Repositorykopien oder Historie.

- **Beleg:** `docs/deep-audit-final5.md`, S01; Git-Objektvergleich dieser beiden Pfade zwischen `7d51f15` und `f88d431`.
- **Vorschlag:** Betreiberseitig feststellen, ob der dokumentierte Wert aktiv oder wiederverwendet ist; gegebenenfalls rotieren. Secrets künftig außerhalb der Versionsverwaltung bereitstellen und den Umgang mit bestehenden Kopien/History gezielt entscheiden.
- **Abnahme:** Kein aktives/recyceltes Geheimnis bleibt über die versionierte Konfiguration nutzbar; Deployment funktioniert mit getrennt bereitgestellten Zugangsdaten. Keine Zugangswerte in Tickets, Screenshots, Bericht oder Belegpaket kopieren. Ein tatsächlich erfolgter Fremdzugriff wird nicht behauptet.

### S02 – Rate-Limit greift spät und reserviert nicht atomar

**P2 · Bestätigtes Härtungspotenzial · Aufwand: mittel.** Die Zeitprüfung erfolgt nach Feld- und gegebenenfalls Dateiprüfung. `is_file`/`filemtime` und `touch` sind getrennt; gleichzeitige Requests können denselben freien Zustand sehen. Das Limit schützt daher den frühen Verarbeitungspfad nicht und garantiert keine atomare Versandsperre. Es wurde kein Lastangriff ausgeführt.

- **Beleg:** `app/forms/contact-handler.php:181`; Uploadprüfung vorher bei `:165`.
- **Vorschlag:** Frühe angemessene Größen-/Frequenzgrenzen und atomare Reservierung mit definiertem Ablauf einsetzen. Gemeinsame IPs, Reverse-Proxy-Vertrauen und den Umgang mit SMTP-Fehlern berücksichtigen.
- **Abnahme:** Begrenzte Paralleltests mit Mock-Transport führen nicht zu unkontrolliertem Mehrfachversand; legitime Nutzer hinter gemeinsamer IP bleiben angemessen bedienbar.

### S03 – Öffentlicher Mailendpoint prüft keine Herkunft

**P3 · Empfehlung zur Missbrauchsbegrenzung · Aufwand: mittel.** Der POST-Handler nutzt Feldprüfung, Honeypot und IP-Zeitlimit, aber weder Origin-/Referer-Abgleich noch einen Formularnachweis. Andere Websites können grundsätzlich einfache Form-POSTs anstoßen; CORS allein verhindert das Absenden nicht. Es geht hier um Spam und Ressourcenverbrauch, nicht um einen nachgewiesenen Zugriff auf ein angemeldetes Benutzerkonto.

- **Beleg:** `app/forms/contact-handler.php`; ausgegebenes Formularmarkup ohne entsprechenden Nachweis.
- **Vorschlag:** Herkunftsprüfung beziehungsweise geeigneten kurzlebigen Formularnachweis als zusätzliche Schicht bewerten. Immer mit Rate-/Größenlimits kombinieren; Botabwehr mit möglichst geringer Bedienhürde.
- **Abnahme:** Unpassende Cross-Site-Anfragen werden im vorgesehenen Modell abgewiesen; legitime Besucher und erforderliche Integrationen bleiben funktionsfähig. Direkte Bots werden durch eine Herkunftsprüfung allein nicht zuverlässig verhindert.

### S04 – IP-Prüfsummendateien haben keine anwendungsseitige Löschung

**P3 · Bestätigter Pflegepunkt / tatsächliche Aufbewahrung offen · Aufwand: klein.** Pro IP wird ein deterministisch benanntes `kem_form_...`-Dateiobjekt im temporären Verzeichnis erzeugt. Der Code prüft sein Alter, löscht es aber nicht nach Ablauf. Der Hoster könnte temporäre Dateien bereinigen; dessen reale Frist ist unbekannt.

- **Beleg:** `app/forms/contact-handler.php:182`; Datenschutzhinweis zu einer „für kurze Zeit“ verwendeten Prüfsumme.
- **Vorschlag:** Löschung/Ablauf betrieblich festlegen und technisch sicherstellen. Prüfen, ob eine zeitlich begrenzte Ableitung sinnvoll ist; eine bloße Hashfunktion ist keine automatische Anonymisierung.
- **Abnahme:** Alte Einträge verschwinden gemäß dokumentierter Frist, ohne die Frequenzbegrenzung zu unterlaufen.

### S05 – Umgang mit Foto-Inhalten und Metadaten ist wenig konkret

**P2 · Transparenz-/Betriebsprüfung · Aufwand: klein bis mittel.** Die Formularbestätigung erwähnt Fotos, die Datenschutzerklärung beschreibt den Fotopfad und mögliche Metadaten dagegen nicht ausdrücklich. Uploads werden nach MIME-/Größenprüfung direkt angehängt; eine Metadatenentfernung ist nicht erkennbar. Bilder können je nach Quelle sensible Räume, Personen oder Standort-/Geräteinformationen enthalten.

- **Beleg:** `public_html/angebotsanfrage/index.php:170` und `:196`; `app/forms/photo-upload.php`; `public_html/datenschutz/index.php`, Abschnitt 4.
- **Vorschlag:** Zweck, Empfänger, Mail-/Backupaufbewahrung und Umgang mit Metadaten mit dem tatsächlichen Betrieb abgleichen. Kurzer Hinweis, nur erforderliche Objektfotos ohne unnötige Personen-/Dokumentdaten hochzuladen. Metadatenentfernung nur mit bewusstem Qualitäts-/Funktionskonzept.
- **Abnahme:** Angaben entsprechen dem realen Ablauf; Verantwortlichkeiten und Löschung sind geregelt. Kein konkreter Datenschutzverstoß wird allein aus der knappen Beschreibung abgeleitet.

### S06 – Bildprüfung begrenzt MIME und Dateigröße, aber keine Bildstruktur

**P3 · Härtungsempfehlung · Aufwand: mittel.** Finfo, erlaubte MIME-Typen, `is_uploaded_file` und Größenlimits sind vorhanden. Eine Prüfung auf dekodierbare Bildstruktur, Pixelabmessungen oder problematische Formateigenschaften fehlt. Die Website rendert die hochgeladenen Bilder serverseitig nicht; deshalb wird kein aktueller serverseitiger Bilddecoder-Angriff behauptet.

- **Beleg:** `app/forms/photo-upload.php:29`.
- **Vorschlag:** Passende Strukturlimits und einen betrieblichen Anhang-/Malwareschutz festlegen. Falls später neu kodiert wird, Decoderressourcen und Metadaten bewusst behandeln.
- **Abnahme:** Beschädigte oder unpassende Inhalte werden verständlich abgewiesen; gültige Fotos funktionieren innerhalb der dokumentierten Grenzen. Sichere Verarbeitung beim Empfänger gesondert prüfen.

### S07 – PHPMailer ist ohne reproduzierbare Paketverwaltung eingebunden

**P3 · Wartbarkeit-/Lizenzprüfung · Aufwand: mittel.** Drei Bibliotheksdateien werden manuell geladen. PHPMailer nennt Version **7.1.1** und LGPL im Header; eine Composer-Manifest-/Lockdatei und ein separat mitgelieferter vollständiger Lizenztext fehlen im geprüften Repositorybestand.

- **Beleg:** `vendor/autoload.php`; `vendor/phpmailer/phpmailer/src/PHPMailer.php:16` und `:772`; Dateiinventar.
- **Vorschlag:** Bezugsquelle, Version, Integritäts-/Updateweg und passende Lizenzbeigaben dokumentieren; reproduzierbare Abhängigkeitsverwaltung prüfen. Sicherheitsmeldungen regelmäßig bewerten.
- **Abnahme:** Eine saubere Umgebung kann dieselbe freigegebene Bibliothek nachvollziehbar beziehen; Updateverantwortung ist klar. Kein bestimmter CVE oder Lizenzverstoß wurde nachgewiesen; Versionsnummern allein belegen weder Sicherheit noch Verwundbarkeit.

### S08 – WhatsApp- und Aufbewahrungsangaben mit dem Betrieb präzisieren

**P3 · Offene Transparenz-/Betriebsprüfung · Aufwand: klein.** WhatsApp wird allgemein erwähnt, ohne anklickbare Anbieter-Datenschutzinformation oder konkrete eigene Bearbeitungs-/Löschkriterien. Auch Mail-/Logfristen bleiben überwiegend abstrakt. Ob dies den realen Prozessen entspricht, ist aus dem Code nicht entscheidbar.

- **Beleg:** `public_html/datenschutz/index.php`, Abschnitte 2, 4 und 6; `app/helpers/actions.php`, WhatsApp-Link.
- **Vorschlag:** Tatsächlich verwendeten Dienst/Anbieter, Aufbewahrung, Berechtigungen und Löschkriterien fachlich abgleichen; aktuelle Anbieterinformationen verlinken.
- **Abnahme:** Websiteinformationen und betriebliche Praxis stimmen überein. WhatsApp ist aktuell ein normaler externer Link mit lokalem Icon; beim bloßen Seitenaufruf wurde kein WhatsApp-Request beobachtet. Daraus folgt kein pauschaler Bedarf für einen Cookie-Banner.

## 6. Inhalte, Vertrauen und SEO

### C01 – Ortsseiten bieten noch wenig konkreten lokalen Zusatznutzen

**P2 · Inhaltsempfehlung · Aufwand: mittel.** Die drei Büro- und drei Fenster-Ortsseiten unterscheiden sich in der Einleitung und lokalen Ansprache, übernehmen aber große Teile der Leistungslisten und wiederkehrende Planungsaussagen. Auch die Bilder sind vielfach identisch. Brühl ist bereits korrekt als Firmensitz bezeichnet; zusätzliche Niederlassungen werden nicht behauptet.

- **Beleg:** `content/locations/bueroreinigung-{koeln,bruehl,bonn}.php` und entsprechende Fensterseiten; Hashgruppen der Bilder.
- **Vorschlag:** Vorhandene echte lokale Einsatzbeispiele, Besonderheiten und verlässliche Abdeckung erläutern; allgemeine Leistungsinformationen zentral halten. Keine erfundenen Stadtteilreferenzen, Anfahrtsversprechen oder Niederlassungen hinzufügen.
- **Abnahme:** Jede Ortsseite beantwortet eine eigenständige lokale Frage. Eine Duplicate-Content-Strafe oder Rankingverschlechterung wurde nicht nachgewiesen.

### C02 – Stellenanzeige lässt wichtige Arbeitsbedingungen und Bewerbungsdetails offen

**P2 · Recruiting-Empfehlung · Aufwand: klein bis mittel.** Start, unbefristeter Vertrag und übertarifliche Bezahlung sind genannt. Wochenstunden, Voll-/Teilzeit, typische Einsatzzeiten, Einsatzregion, benötigte Unterlagen und Ansprechpartner bleiben offen. „Übertariflich“ allein gibt Bewerbern wenig Vergleichbarkeit. Bewerbung öffnet direkt das E-Mail-Programm.

- **Beleg:** `config/pages/jobs.php`, `job_facts`; `public_html/jobs/index.php`; `app/helpers/actions.php`, `kem_application_action`.
- **Vorschlag:** Tatsächliche Rahmenbedingungen und einen knappen Bewerbungsablauf ergänzen. Falls möglich, Stunden-/Vergütungsrahmen konkretisieren; einen sichtbaren E-Mail-Kontakt als Alternative zum Mailprogramm-Button anbieten. Strukturierte Angaben passend mitpflegen.
- **Abnahme:** Bewerber wissen, was sie erwartet, was sie senden sollen und wie es weitergeht. Keine Beschäftigungsart oder Vergütung erfinden. Ein Ausschluss aus Google Jobs allein wegen optionaler Felder wurde nicht belegt.

### C03 – Rückmeldung nach einer Anfrage hat keinen belastbaren Zeitrahmen

**P3 · Conversion-/Textempfehlung · Aufwand: klein.** Der Erfolg bestätigt den Eingang und erklärt weitere Prüfung; eine realistisch erwartbare Rückmeldefrist wird nicht genannt. „In Kürze“ im Kontaktformular bleibt ebenfalls unbestimmt. Der Hinweis, dass ein Wunschtermin keine Bestätigung ist, ist sinnvoll vorhanden.

- **Beleg:** `public_html/angebotsanfrage/index.php:203`; `app/forms/contact-handler.php:224`; `content/faq.php`.
- **Vorschlag:** Nur einen intern verlässlich erfüllbaren Zeitraum nennen und gegebenenfalls einen Weg für dringende Anliegen erläutern.
- **Abnahme:** Besucher können den nächsten Schritt zeitlich einordnen; keine unbelegte 24-Stunden-Zusage.

### C04 – FAQ enthält inhaltliche Überschneidungen ohne Gruppierung

**P3 · Redaktionelle Empfehlung · Aufwand: klein.** Kostenfaktoren, hilfreiche Angaben, Anfrageablauf und Angebotserstellung überschneiden sich. Zehn geschlossene Einträge stehen gleichrangig untereinander; die Frage nach der Angebotserstellung wiederholt weitgehend die Preisfaktoren. Die neue gemeinsame Datenquelle verhindert bereits die frühere getrennte Pflege von Sichttext und Schema.

- **Beleg:** `content/faq.php`; `public_html/faq/index.php`.
- **Vorschlag:** Redundante Antworten straffen, nach Kosten/Anfrage und Ausführung/Zusammenarbeit gruppieren. Konkrete Servicefragen auf passende Leistungsseiten verweisen lassen.
- **Abnahme:** Jede Frage hat einen eigenen Nutzen; native Details-Bedienung und Übereinstimmung mit FAQPage-Daten bleiben erhalten. Ein FAQ-Rich-Result wird nicht als garantiertes SEO-Ergebnis versprochen.

### C05 – Überprüfbare Unternehmensprofile werden nicht verknüpft

**P3 · Empfehlung, sofern vorhanden · Aufwand: klein.** Unter den externen Weblinks wurde nur `wa.me` gefunden. Ein öffentliches Unternehmens-/Bewertungsprofil und ein entsprechender `sameAs`-Bezug im Unternehmensschema fehlen. Es wurde nicht geprüft, ob solche Profile tatsächlich existieren.

- **Beleg:** Crawl-Linkbestand; `app/templates/head.php`, LocalBusiness-Daten.
- **Vorschlag:** Bei nachgewiesenem vorhandenem Profil eine passende Verknüpfung anbieten und Stammdaten abgleichen. Echte Kundenstimmen mit nachvollziehbarer Herkunft prüfen.
- **Abnahme:** Verknüpfte Profile gehören nachweislich zum Unternehmen; keine erfundenen Sterne, Bewertungen oder Social-Konten. Das Weglassen nicht vorhandener Profile ist kein Fehler.

### C06 – Social-Vorschauen haben keine gezielte Share-Komposition

**P3 · Visual-/Metadatenempfehlung · Aufwand: mittel.** Alle 24 geprüften Open-Graph-Bildziele sind erreichbar. Viele verwenden allgemeine breite Hero-Motive; Angaben wie `og:image:alt`, Bildmaße und `og:site_name` fehlen. Ein schlechter Ausschnitt im konkreten Zielkanal wurde nicht praktisch nachgewiesen.

- **Beleg:** `app/templates/head.php`; `config/pages/*.php`, `og_image`.
- **Vorschlag:** Für wichtige Einstiegsseiten markengerechte Share-Bilder mit sicheren Rändern und geeigneter Proportion erstellen, etwa 1200 × 630; beschreibende Metadaten ergänzen.
- **Abnahme:** Vorschauen in den tatsächlich relevanten Messengern/Netzwerken kontrollieren; Kernmotiv und Marke bleiben trotz Zuschnitt erkennbar.

### C07 – Spezialleistungen und Qualitätsaussagen betrieblich konkretisieren

**P3 · Offene fachliche Inhaltsabnahme · Aufwand: mittel.** Desinfektions- und Reinraumreinigung werden auf final5 inzwischen näher erklärt. Öffentliche Informationen zu konkreten Verfahren, gegebenenfalls relevanten Vorgaben und belegbaren Qualifikationen bleiben jedoch knapp. Auch „umweltbewusste Verfahren“ und „Qualitätskontrolle auf Wunsch“ werden nur allgemein erläutert. Daraus folgt keine Feststellung fehlender Qualifikation oder einer falschen Zusage.

- **Beleg:** `content/services/grundreinigung/body.php`, Spezialreinigungen; `public_html/ueber-uns/index.php`; Stärkenabschnitt der Startseite.
- **Vorschlag:** Tatsächlich angebotenen Umfang, Grenzen und auftragsbezogene Qualitätssicherung mit dem Betrieb abgleichen. Nur zutreffende Beispiele und vorhandene Nachweise veröffentlichen; allgemeine Aussagen präzisieren, wo es Kunden bei ihrer Entscheidung hilft.
- **Abnahme:** Texte sind fachlich belastbar und erklären konkrete Leistungen, ohne unbelegte Norm-, Hygiene- oder Umweltversprechen. Bereits ergänzte Textilvorbereitung, Trocknung und Entsorgungsabstimmung nicht wieder als fehlend behandeln.

## 7. Betrieb und Pflege

### O01 – Deployment- und Betriebsanleitung ist weiterhin unvollständig

**P2 · Wartbarkeitsempfehlung · Aufwand: mittel.** CSS-Erzeugung und FAQ-/Sitemap-Pflege sind auf final5 dokumentiert und funktionieren. Eine vollständige Repository-Anleitung für lokalen Start, benötigte PHP-Erweiterungen/INI-Werte, Secret-Bereitstellung, Deployment, Rollback und sichere Zustellprüfung fehlt weiterhin. Die Startdateien dieser Cloud-Umgebung liegen separat unter `kem-cloud-setup`.

- **Beleg:** Repository-Dateiinventar; `docs/css-maintenance.md`, `docs/content-maintenance.md`, `tools/build-css.php`; lokale Limitabweichung F06.
- **Vorschlag:** Kompakte Betriebsanleitung mit Voraussetzungen und überprüfbaren Schritten ergänzen. Kleine sinnvolle Regressionstests für die kritischen Formularregeln und HTTP-Verträge vorsehen.
- **Abnahme:** Eine zweite Person kann den Stand ohne geheime Werte im Repository reproduzierbar starten, prüfen und zurückrollen. Kein Frameworkwechsel oder umfassendes Tooling allein zur Modernisierung nötig.

### O02 – Stellenstatus und Ablaufdatum gemeinsam pflegen

**P3 · Pflegepunkt, derzeit nicht abgelaufen · Aufwand: klein.** Das JobPosting gilt bis **10.11.2026, 23:59 Uhr**. Das Template unterdrückt danach das abgelaufene strukturierte JobPosting, die sichtbare Stellenanzeige bleibt jedoch bestehen. Am Prüfdatum 20.10.2026 ist sie noch innerhalb der angegebenen Frist.

- **Beleg:** `config/pages/jobs.php`, `validThrough`; `app/templates/head.php`, Ablaufprüfung.
- **Vorschlag:** Rechtzeitig betrieblich entscheiden, ob verlängert, geschlossen oder auf Initiativbewerbung umgestellt wird; Sichttext und strukturierte Daten gemeinsam pflegen.
- **Abnahme:** Nach Ablauf entsteht kein Widerspruch zwischen sichtbarem Stellenangebot und tatsächlichem Recruitingstatus. Keine automatische Verlängerung ohne fachliche Bestätigung.

### O03 – Produktive und organisatorische Abnahmen fehlen als Nachweis

**P2 · Offen, kein bestätigter Live- oder Rechtsfehler · Aufwand: mittel.** Lokale Funktion und vorhandene Schutzkonfiguration beweisen nicht die korrekte Inbetriebnahme. Rechtsformabhängige Impressumsangaben, Verträge mit Dienstleistern und tatsächliche Daten-/Bildverarbeitung lassen sich aus dem Repository nicht vollständig entscheiden.

- **Beleg:** Gesperrter Live-Zugriff; `public_html/impressum/index.php`, `public_html/datenschutz/index.php`; lokale Apache-/PHP-Konfiguration.
- **Vorschlag:** Auf dem echten Hosting TLS/Zertifikate, Redirects, CSP/HSTS, Fehleranzeige, PHP-Supportstand, Body-/Upload-/Mailgrenzen, Backups/Wiederherstellung und Monitoring prüfen. Echte Zustellung, Reply-To, Anhänge, Fehler/Bounces und SPF/DKIM/DMARC mit einem freigegebenen Testempfänger abnehmen. Unternehmensangaben, notwendige AVV, Löschpraxis und Medien-/Referenzrechte fachlich verifizieren.
- **Abnahme:** Die real geltenden Anforderungen und Betriebsabläufe sind dokumentiert und getestet. Keine angeblich fehlende USt-ID, Registereintragung oder Zertifizierung ohne Kenntnis der tatsächlichen Voraussetzungen behaupten. Echte Geräte/Screenreader und Feldperformance ergänzen.

## 8. Bereits verbessert und positiv verifiziert

### Frühere Auditpunkte, die nicht unverändert offen bleiben

Die Bezeichnungen in dieser Tabelle beziehen sich ausschließlich auf `docs/deep-audit-final5.md`. Dieser neue Bericht verwendet eigene IDs; die IDs sind nicht zwischen Versionen austauschbar.

| Früherer Punkt | Aktueller Stand auf final5 / Ausgangsstand von final6 |
|---|---|
| D01 – Sticky-Karte verdeckt Button | Auf allen 17 Karten ist die Position jetzt `static`; früherer Sticky-Fehler beseitigt. Mobile Reihenfolge separat in neuem D02. |
| D03 – Leistungen erst sehr spät auf der Startseite | Leistungsbereich steht jetzt vor der Unternehmensvorstellung. Überschrift mobil bei y≈624 statt früher ca. 1763. |
| D04 – Sehr große mobile Homepagekarten | Kompakteres Icon-/Textlayout umgesetzt. Weitere Gestaltungsoptimierungen sind möglich, der alte Zustand besteht nicht mehr. |
| D06 – Service-H1 mit drei Städtenamen | Leistung und regionaler Zusatz sind inzwischen getrennt; deutlich kürzere Serviceüberschriften. |
| D11 – Nur Titel einer Karte verlinkt | Ein semantischer Link umfasst die gesamte Karte; sichtbare Fokus-/Interaktionszustände vorhanden. |
| D12 – Telefon-Emoji | Durch konsistentes SVG ersetzt. |
| D14 – Tags und Navigation zu ähnlich | Informative Tags sind ruhiger, Navigationslinks besitzen deutlichere Merkmale. |
| F06 – Bearbeiten erfordert erneut alle Folgeschritte | Direkter Ändern-Weg kehrt nach Übernahme zur Übersicht zurück; im aktuellen Ablauf bestätigt. Neuer Enter-/Zurück-Fehler ist davon getrennt F05. |
| S06 – Versteckte/Backup-Pfade unzureichend gesperrt | Regeln erweitert; geprüfte versteckte/Backup-Pfade liefern lokal 403. |
| C03 – Spezialleistungen nur kurze Schlagwörter | Erläuterungen ergänzt und überholte Leistungsbehauptungen bereinigt. Fachliche Abnahme bleibt als neuer C07 offen. |
| C04 – Textilvorbereitung/Trocknung fehlen | Auf Teppich-/Polsterseiten ergänzt, einschließlich realistischer Fleckentfernungsgrenzen. |
| C05 – Entsorgungsumfang zu wenig erklärt | Abtransport und Entsorgung werden jetzt ausdrücklich vorab vereinbart und im Angebot festgehalten. |
| O01 – Kein CSS-Build | Buildskript und Pflegeanleitung vorhanden; `--check` besteht. Allgemeine Betriebsdokumentation bleibt neuer O01. |
| O03 – FAQ-/Sitemap-Pflege getrennt/unklar | Sichtbare FAQ und Schema aus gemeinsamer Quelle; Pflege und tatsächlich betroffene Sitemap-Daten dokumentiert. |
| O04 – Formular-CSS über mehrere Dateien verteilt | Formularregeln zusammengeführt und Reihenfolge dokumentiert; keine erneute pauschale Bereinigung erforderlich. |

### Weitere tragfähige Eigenschaften

- Alle 27 regulären Routen lokal HTTP 200. Direkte Fehlerseite und unbekannter Pfad liefern 404; Fehlerseite `noindex`. Keine defekten internen Links oder Fragmentziele im geprüften Bestand.
- Genau eine H1 pro Seite; eindeutige Titel und Meta-Descriptions, passende Canonicals, parsebares JSON-LD. Sitemap enthält genau die 27 regulären Routen. Keine reguläre Seite ist ohne eingehenden internen Link; alle Navigationsgruppen sind erreichbar.
- Altpfade für Teppich, Polster, Fassade, Jobs, Angebotsanfrage und den geprüften Solar-Alias führen zum vorgesehenen Ziel. Explizite `index.php`-Adressen werden bereinigt.
- Keine sichtbaren horizontalen Überläufe in den 168 Zusatzkombinationen oder den acht Textgrößensimulationen. Absichtlich offscreen liegende Honeypots wurden nicht als Layoutfehler gezählt.
- Lesbare Grundtypografie, relative Schriftrollen und zentrale Tokens. Skip-Link, sichtbare Fokuszustände, native FAQ-/Dropdown-Bedienung und Reduced Motion vorhanden. Mobile Escape-Bedienung und Fokusrückgabe funktionieren im geprüften Ablauf.
- Bilder besitzen Alt-Attribute und Maßangaben; keine doppelten IDs in den Ausgangsansichten festgestellt. Die Qualität jeder Bildbeschreibung folgt daraus nicht automatisch.
- Servergerenderte Inhalte, lokale Medien/Systemschriften, kleine Scriptbasis mit `defer`, separates Angebotsscript nur auf der betreffenden Seite. Kein initialer Drittanbieterrequest und keine Analyse-/Marketingcookies im geprüften Ablauf beobachtet.
- Kontextvorbelegung für Leistung/Ort, bedingte Felder, Schätzoption, Prüfübersicht und direkter Bearbeiten-Rückweg funktionieren im Beispielablauf. Feldbezogene Mock-Fehler führen zum richtigen Schritt/Feld; Eingaben bleiben erhalten. Erfolg fokussiert die Bestätigung, bereinigt persönliche Formularwerte und erlaubt einen leeren Neubeginn.
- API fordert POST und validiert unter anderem E-Mail, Datenschutzhinweis und mehrere Auswahlwerte. Feste Empfänger-/From-Konfiguration, validiertes Reply-To, Plaintext-Mail, normalisierte Anhangnamen, Finfo und Uploadlimits vorhanden. Keine dauerhafte öffentliche Uploadablage gefunden.
- Private Konfiguration und Vendor liegen außerhalb des DocumentRoot. Directory Listing ist deaktiviert. Lokal wirksame CSP, Frame-Schutz, Referrer-/Permissions-Policy und `nosniff`; HSTS für HTTPS ist konfiguriert. Produktivwirkung bleibt offen.
- Sämtliche Syntaxprüfungen und der lesende CSS-Bundlecheck bestehen. Alle acht Videos können im getesteten Chromium starten und zur Mitte springen. Kein Autoplay.

## 9. Priorisierte Arbeitsliste für spätere Änderungen

**Dieser Audit setzt keinen dieser Vorschläge um.**

1. **Vertraulich klären:** S01. Keine Zugangsdaten in öffentliche Aufgabenbeschreibungen übernehmen.
2. **Konkrete Formular- und Accessibility-Fehler beheben:** F02–F07 sowie A01/A02. F06 im tatsächlichen Hosting abgleichen; neue Regressionstests insbesondere für Enter, Drag-and-drop und das API-Fehlerformat vorsehen.
3. **Wichtige mobile Wege verbessern:** D01–D03, D07 und F01. Hauptaktionen und Bildaussage gemeinsam gestalten; nicht allein auf zusätzliche fixierte Buttons setzen.
4. **Medienlast reduzieren:** P01/P02 zuerst, danach P03–P06. Gestaltung und Bildschärfe erhalten; Messungen unter gleichen Bedingungen wiederholen.
5. **Vertrauen und Entscheidungsinformationen ergänzen:** D04, D09 und C01–C07 mit realen Betriebsinformationen. D05/D06 als bewusste Produktentscheidungen behandeln.
6. **Robustheit und Betrieb abschließen:** F08/F09, A03/A04, S02–S08 und O01–O03; anschließend echte Geräte, Screenreader, produktive Zustellung und Feldwerte prüfen.

## 10. Seitenmatrix und Belege

Alle folgenden Seiten wurden bei 1440/390 px vollständig aufgenommen und in den sechs Zusatzbreiten untersucht. Reguläre Seiten lieferten lokal 200; die Fehlerseite 404.

| Gruppe | Geprüfte Routen |
|---|---|
| Hauptseiten | `/` · `/ueber-uns/` · `/leistungen/` · `/galerie/` · `/faq/` · `/jobs/` · `/kontakt/` · `/angebotsanfrage/` · `/impressum/` · `/datenschutz/` |
| Leistungen | `/leistungen/buero-und-gewerberaumreinigung/` · `/leistungen/glas-und-fensterreinigung/` · `/leistungen/grundreinigung/` · `/leistungen/teppichreinigung/` · `/leistungen/polsterreinigung/` · `/leistungen/entruempelung/` · `/leistungen/fassadenreinigung/` · `/leistungen/solaranlagenreinigung/` |
| Gebäudereinigung lokal | `/gebaeudereinigung-bruehl/` · `/gebaeudereinigung-koeln/` · `/gebaeudereinigung-bonn/` |
| Büroreinigung lokal | `/bueroreinigung-bruehl/` · `/bueroreinigung-koeln/` · `/bueroreinigung-bonn/` |
| Fensterreinigung lokal | `/fensterreinigung-bruehl/` · `/fensterreinigung-koeln/` · `/fensterreinigung-bonn/` |
| Fehlerfälle | `/404.php` und ein unbekannter Pfad; zusätzlich Abweisungs-/Redirect-/API-Negativfälle |

Die Datei-/Zeilenbelege beziehen sich auf den angegebenen Ausgangscommit. Viele Inhalte stehen in langen einzelnen PHP-/HTML-Zeilen; Komponentenbeschreibung und Selektor ergänzen deshalb die Zeilennummer. Pixelkoordinaten sind gerundete lokale Beispielwerte, keine unveränderlichen Eigenschaften aller Geräte.

Das begleitende **`audit-final6-belege.zip`** enthält ausgewählte Desktop-/Mobilaufnahmen, Formularzustände, ein Video-Framekontaktblatt und maschinenlesbare Ergebnisübersichten. Prüfskripte und sämtliche Detailmessungen bleiben zusätzlich unter `/workspace/work/audit-final6/`, außerhalb des Website-Codes. Kein Secret-Konfigurationsinhalt ist Bestandteil des Belegpakets. Ganzseitenaufnahmen können Sticky-Header ungewöhnlich positionieren; solche Aufnahmeeffekte wurden nicht als Websitefehler gewertet.

**Unverändertheit:** Beim Start war das Repository sauber. `final6` wurde aus `origin/final5` auf `f88d4310526b78d671644ea2efb756f29fdbf8a0` angelegt. Der abschließende Gitvergleich lässt ausschließlich `docs/deep-audit-final6.md` als neue Dokumentation zu; alle zuvor getrackten Website-, Konfigurations-, Medien- und Abhängigkeitsdateien bleiben unverändert. Der Bericht wird als eigener lokaler Dokumentationscommit auf final6 gespeichert. Kein Remote-Push und kein Deployment wurden ausgeführt.
