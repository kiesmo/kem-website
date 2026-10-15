# KEM Gebäudereinigung – vollständiger Website-Deep-Audit

**Prüfdatum:** 15.10.2026 · **Ausgangsbranch:** final4 · **Auditbranch:** final5

**Geprüfter Commit:** `7d51f15a3f97bb78500910d72e2a187e426bcfcd`

**Repository:** kiesmo/kem-website · **Website:** https://www.kem-gebaeudereinigung.de/

**56 priorisierte Punkte:** 15 zu Design/Layout/Visuals, 7 zu Formularen, 4 zur Barrierefreiheit, 6 zur Performance, 9 zu Sicherheit/Datenschutz, 10 zu SEO/Inhalten und 5 zu Pflege/Betrieb. Bestätigte Fehler, Empfehlungen und offene Abnahmen sind jeweils gekennzeichnet.

## Ergebnis und Einordnung

Die Website besitzt bereits eine konsistente visuelle Basis: klare Blau-/Navy-Farbwelt, lesbare Systemschrift, wiederkehrende Komponenten und eine überschaubare technische Umsetzung. Die größten Verbesserungen liegen in der mobilen Gewichtung und Seitenlänge, der konkreten Bildaussage, dem Vertrauen durch nachvollziehbare Beispiele und einigen Formular-/Serverdetails. Ein kompletter gestalterischer oder technischer Neubau lässt sich aus den Befunden nicht begründen.

Bestätigt sind unter anderem ein bei niedrigen Desktopfenstern verdeckter Sticky-Angebotsbutton, zu geringer Kontrast einzelner Formularhinweise, ein ungültiges Telefon-Pattern und ein stilles Verwerfen überzähliger Drag-and-drop-Fotos. Die Galerie lädt acht Poster sofort und erreicht unter den beschriebenen mobilen Laborbedingungen einen LCP-Median von 4,324 Sekunden. Ein versionierter SMTP-Passwortliteral benötigt vorrangig eine vertrauliche Prüfung; seine Gültigkeit wurde nicht getestet.

**Es wurde kein Website-Code geändert.** final5 wurde lokal exakt aus origin/final4 erstellt. Als Repository-Ergänzung ist ausschließlich diese Audit-Dokumentation vorgesehen. Screenshots, Browsermessungen und Prüfskripte liegen außerhalb des Website-Codes. Es gab keine echte Mailzustellung, Bewerbung, SMTP-Anmeldung oder Veröffentlichung.

Der Remote-Push von final5 wurde vom automatischen Freigabecheck abgelehnt: externe Änderung und mögliche Datenübertragung ohne laut Prüfung hinreichend ausdrückliche Push-Freigabe. Der Branch ist deshalb zunächst **lokal** angelegt. Diese Einschränkung berührt die Untersuchung und den erstellten Bericht nicht.

## Aussagekraft und vollständige Prüfabdeckung

### Tatsächlich geprüft

- Alle **27 regulären öffentlichen Seiten** plus Fehlerseite: HTTP, vollständiges HTML, Metadaten, interne Links, Inhalte und Screenshots bei **1440 × 900** sowie **390 × 844 CSS-Pixeln**, DPR 1. Alle Bereiche wurden für die Screenshots durchgescrollt, damit nachgelagerte Bilder geladen werden.
- **144 zusätzliche Route-/Breitenkombinationen**: alle regulären Seiten bei 320, 768, 1081 und 1280 px; sechs zentrale Seiten zusätzlich bei 360, 560, 820, 981, 1180 und 1920 px. Vier Seiten zusätzlich mit auf 200 % gesetzter Root-Schriftgröße. Dies ist eine Textgrößensimulation, keine echte Browserzoom-Abnahme.
- Ergänzende Höhenprüfung der 17 Service-/Ortsseiten mit Zusammenfassungskarte bei **1440 × 768**; mehrere Scrollpositionen für die betroffenen Beispiele.
- Header, Dropdown, mobiles Menü, Footer, FAQ, Leistungs- und Ortsseiten, Galerie, Jobs, Kontakt, Angebotswizard, Upload, Datenschutz und Impressum; PHP-/JavaScript-/CSS-Quellen und serverseitiger Formularpfad.
- **Axe-core 4.10.3** auf 22 repräsentativen Routen, WCAG A/AA inklusive WCAG 2.2 AA; zusätzliche offene Menü- und Formularzustände. Tastaturpfad, Escape, Fokuswiederherstellung und Formularschritte praktisch in Chromium geprüft.
- Angebotsformular vollständig mit synthetischen Daten: Service-/Ortsvorbelegung, Schätzung, Pflichtfelder, Terminwahl, Review/Bearbeiten. Netzwerkfehler, HTML-Fehlerantwort, feldbezogener Serverfehler, Erfolg und Neubeginn mit **abgefangenen lokalen Mock-Antworten** geprüft. Die Erfolgsmeldung beweist keine SMTP-Zustellung.
- Sichere lokale API-Negativtests mit garantiert ungültigen Anfragedaten, einschließlich Übergröße; kein Versandpfad erreicht. Reiner PHP-Funktionstest zur Validierung ohne SMTP-Transport.
- Alle 71 unterschiedlichen in HTML/CSS referenzierten Assets und 24 unterschiedlichen Open-Graph-Bildziele erreichbar; Mengen überschneiden sich. Bildgrößen, Duplikate, Videoformate, Header, Kompression, Cache, Redirects und Sitemap geprüft.
- Alle acht MP4s zusätzlich ohne künstliche Drosselung jeweils ca. 2,5 Sekunden abgespielt, pausiert und zur Mitte gesprungen; Start/Dekodierung/Seek ohne MediaError. Je zwei extrahierte Frames pro Clip visuell gesichtet. Dies ist keine vollständige Sichtung jeder Videosekunde oder iOS-/Mobilfunk-Abnahme.
- **144 PHP-Dateien** einschließlich Vendor mit PHP 8.4.26 syntaxgeprüft; beide JavaScript-Dateien mit node --check geprüft.

### Grenzen, die keine grüne Freigabe erlauben

Die Live-Domain konnte aus der Cloud-Umgebung nicht abgerufen werden: Der konfigurierte Proxy verweigerte den Tunnel mit **403 Forbidden**. Es wurde kein alternativer Zugriff zur Umgehung versucht. Der lokale Apache/PHP-Container bindet final4 schreibgeschützt ein und berücksichtigt .htaccess. Lokale Header, Limits und Messwerte sind **keine Feststellung über das produktive Hosting**.

Nicht verifiziert sind Live-DNS/TLS/CDN, Hostingkonfiguration, tatsächliche Indexierung/Rankings, Google-Unternehmensprofil, echte Core-Web-Vitals-Feldwerte, produktive Mailzustellung, SPF/DKIM/DMARC, betriebliche Nachweise, Kunden-/Bildrechte, tatsächliche Löschpraxis sowie bedingt erforderliche Unternehmensangaben. Eine juristische Abnahme oder ein vollständiger Penetrationstest ist damit nicht verbunden. Safari/iOS, Firefox, echte Mobilgeräte und NVDA/JAWS/VoiceOver/TalkBack wurden nicht abgenommen. Automatisierte Accessibility-Prüfungen erfassen nur einen Teil der Anforderungen.

### Prioritäten und Befundarten

| Kennzeichnung | Bedeutung |
|---|---|
| P0 | Nachgewiesener akuter schwerer Vorfall/Totalausfall; hier keiner bestätigt |
| P1 | Vorrangig und vertraulich prüfen; hier der versionierte SMTP-Passwortwert |
| P2 | Deutlicher Qualitäts-, Nutzungs- oder Robustheitsmangel; im nächsten Verbesserungsblock behandeln |
| P3 | Gezielte Optimierung, Härtung oder Pflegepunkt |
| Bestätigt | Im Code und/oder lokal reproduziert; gilt nur für angegebene Bedingungen |
| Empfehlung | Beobachtete Verbesserungschance; keine behauptete Funktionsstörung |
| Offen | Benötigt Produktivzugriff, Fachwissen oder Unternehmensdaten; kein bereits bewiesener Fehler |

Die Priorität beschreibt Handlungsnutzen und mögliche Auswirkungen. Sie ersetzt weder eine rechtliche Bewertung noch eine Risikobewertung eines ungeprüften Produktionssystems. Gestalterische Empfehlungen behaupten keine gemessene Conversion-Steigerung.

## 1. Design, Layout, Visuals und responsive Nutzung

### D01 — Sticky-Zusammenfassung verdeckt ihren Angebotsbutton auf niedrigen Desktopfenstern

- **P2 · Bestätigter Layoutfehler · Aufwand: klein bis mittel.** Betroffen sind zahlreiche Leistungs-/Ortsseiten, unter anderem Glas, Solar, Grundreinigung und Büro.
- **Nachweis:** Bei 1440 × 768 bleibt die Glas-/Solarkarte während mehrerer Scrollpositionen bei y=134 mit 706 px Höhe stehen; der Button liegt bei y=762–807, also fast vollständig unterhalb des Fensters. Grundreinigung: Button y=789–834, vollständig außerhalb. Büro-Ortsseiten: y=736–781, teilweise außerhalb. Der globale Headerbutton bleibt erreichbar; deshalb kein blockierter Gesamtprozess.
- **Ursache:** `resources/css/06-service-pages.css:98` setzt sticky mit Headerabstand, ohne die verfügbare Fensterhöhe zu berücksichtigen. Die bestehende Abschaltung bei schmaler Breite löst geringe Höhe nicht.
- **Empfehlung:** Sticky nur aktivieren, wenn die gesamte Karte in die verfügbare Höhe passt; andernfalls normales Scrollen oder kompaktere Zusammenfassung. Einen zweiten verschachtelten Scrollbereich nur nach Bedienprüfung einsetzen.
- **Abnahme:** Bei 1280/1440 px Breite und 600/768/900 px Höhe bleibt die vollständige Kontaktaktion mit Maus und Tastatur erreichbar. Nicht nur die Breite testen.

### D02 — Der mobile Startseiten-Hero verliert das eigentliche Reinigungsmotiv

- **P2 · Designempfehlung · Aufwand: mittel.** Bei 390 px wird die Person links angeschnitten; Werkzeug und Arbeitssituation verschwinden größtenteils hinter dem großen blauen Textpanel. Der Text ist dabei gut lesbar, die Bildaussage trägt aber wenig zur Botschaft bei.
- **Beleg:** `public_html/index.php:9`; `resources/css/02-components.css:370–423`, insbesondere object-fit und zentrierte Motivposition. Das breitformatige Motiv füllt mobil eine 390 × 470 px große Fläche.
- **Empfehlung:** Einen eigenen mobilen Bildausschnitt mit sichtbar handelnder Person und Werkzeug verwenden oder Bild/Text auf schmalen Displays anders komponieren. Motivschwerpunkt pro Breakpoint festlegen. Kein pauschales Herunterskalieren ohne Beachtung von Ausschnitt und DPR.
- **Abnahme:** Bei 320/390/560 px ist die Tätigkeit erkennbar, das Gesicht/Motiv sinnvoll platziert und die Handlungsaufforderung weiterhin lesbar.

### D03 — Die eigentlichen Leistungen erscheinen auf der Startseite spät

- **P2 · Design-/Inhaltsempfehlung · Aufwand: klein bis mittel.** Die Überschrift „Unsere Reinigungsleistungen“ beginnt bei 390 px erst ungefähr bei **y=1763**, die erste Leistung bei y=1939. Vorher folgen Hero, große Inhaltsaufnahme, lange Einleitung und drei Erklärungskarten.
- **Beleg:** `public_html/index.php:9–18`; `.intro-showcase` in `resources/css/03-pages.css:16` und `.intro-strengths` in `resources/css/09-local-pages.css:141`. Der Hero verlinkt sinnvoll zu Leistungen, bietet aber keinen Überblick am selben Ort.
- **Empfehlung:** Leistungszugang früher platzieren; Einleitung kürzen, Foto und Stärken kompakter kombinieren oder einen knappen Leistungsüberblick direkt nach dem Hero einsetzen. Die Aussage zu klaren Absprachen nicht im Fließtext und in der ersten Karte fast identisch wiederholen.
- **Abnahme:** Mobile Erstbesucher können Angebot und passende Leistung mit deutlich weniger Scrollen erkennen; Lesbarkeit und gute Touch-Flächen erhalten.

### D04 — Acht große Einzelkarten verlängern die mobile Leistungswahl unnötig

- **P2 · Designempfehlung · Aufwand: mittel.** Auf der Startseite stehen die acht Karten mobil vollständig untereinander. Erste Leistungsüberschrift y=1939, letzte y=3574; die Homepage ist insgesamt ca. 6347 px hoch.
- **Beleg:** `resources/css/03-pages.css:69–135`: Kartenraster, große freistehende Icons, Body-Padding und Beschreibungen; Screenshot Home/390.
- **Empfehlung:** Mobil eine kompakte Liste mit Icon neben Titel/Text erproben, Beschreibungen straffen oder Prioritätsgruppen anbieten. Ein zweispaltiges Raster nur verwenden, wenn lange deutsche Leistungsnamen und große Schrift sinnvoll passen. Kein erzwungenes horizontales Karussell für wichtige Leistungen.
- **Abnahme:** Alle acht Leistungen bleiben direkt auffindbar und lesbar; die vertikale Strecke sinkt ohne Verkleinerung der Text-/Touchgrößen.

### D05 — Der mobile Kurzüberblick kommt erst nach dem vollständigen Artikel

- **P2 · Design-/Conversion-Empfehlung · Aufwand: mittel.** Im Desktoplayout sinnvolle Sidebar-Inhalte rutschen mobil hinter den ganzen Artikel, teils einschließlich langem Video. Dort wiederholt der „Kurzüberblick“ bereits gelesene Informationen.
- **Nachweis:** Glas-Service bei 390 px: erster primärer Introbutton y≈475, nächster Angebotsbutton erst y≈4287; Solar y≈608 → 4367. Auf Büro Köln y≈546 → 3714. In diesem mobilen Zustand ist der Header-Angebotsbutton ins Menü verlagert.
- **Beleg:** `app/templates/service-template.php:16`; `content/locations/bueroreinigung-koeln.php:7`; Breakpoint in `resources/css/04-responsive.css:180`; `.service-summary-card` in `resources/css/06-service-pages.css:141`.
- **Empfehlung:** Mobil den kompakten Überblick vor den Langtext setzen oder in den Artikel integrieren; nahe dem relevanten Leistungsumfang eine ruhige Anfrageaktion anbieten. Wiederholungen reduzieren. Ein dauerhaft fixierter Zusatzbutton ist nur eine mögliche Lösung und muss Bildschirmfläche/Fokus berücksichtigen.

### D06 — Lange Serviceüberschriften dominieren die Einstiegsbereiche

- **P2 · Typografie-/Hierarchieempfehlung · Aufwand: klein.** Servicebezeichnung plus drei Städtenamen erzeugen sehr hohe H1-Blöcke. Die Solarüberschrift belegt bei 1440 px vier Zeilen (ca. 245 px), bei 390 px fünf Zeilen (ca. 189 px); Kontext und Anfrageaktion rücken entsprechend nach unten.
- **Beleg:** `config/services/solaranlagenreinigung.php:18` und entsprechende Artikelüberschriften; Rendering `app/helpers/render-components.php:20`; H1-Stil `resources/css/01-base.css:135`. Auf Jobs wirkt die Desktopteilung „Glas- und“ / „Gebäudereiniger (m/w/d)“ ebenfalls unruhig.
- **Empfehlung:** Sichtbare H1 auf die eigentliche Leistung konzentrieren, Einsatzgebiet in Eyebrow/Lead erklären. SEO-Titel und sichtbare Überschrift dürfen weiterhin unterschiedliche Aufgaben erfüllen. Textbreite und ausgewogene Umbrüche für lange deutsche Wörter prüfen.
- **Abnahme:** Überschrift, Nutzen und primäre Aktion bilden auf Desktop und Mobil einen verständlichen Einstieg ohne abgeschnittene oder gequetschte Wörter.

### D07 — Die Galerie ist mobil lang und inhaltlich einseitig sortiert

- **P2 · Layout-/Redaktionsempfehlung · Aufwand: mittel.** Galerie bei 390 px ca. **8207 px** hoch. Die ersten drei von acht Videos zeigen Fenster-/Glasreinigung; andere Leistungen erscheinen erst später. Der Introbutton liegt bei y≈460, der nächste Anfragebutton erst bei y≈7280.
- **Beleg:** Reihenfolge `public_html/galerie/index.php:8–80`, Einspaltenraster `resources/css/07-gallery-faq.css:35`.
- **Empfehlung:** Einen kurzen, abwechslungsreichen Überblick mit repräsentativen Beispielen voranstellen; weitere Clips nach Leistung gruppieren oder über eine einfache Auswahl erschließen. Kurze Projekt-/Ergebnisinformationen ergänzen und eine Anfrageaktion bei den relevanten Beispielen vorsehen.
- **Abnahme:** Besucher erkennen mehrere Leistungsarten früh, müssen nicht zuerst drei ähnliche Clips passieren und erreichen den nächsten Schritt ohne lange Rücksuche.

### D08 — Bildsprache und Vertrauensbelege sind noch zu wenig miteinander verbunden

- **P2 · Visual-/Vertrauensempfehlung · Aufwand: mittel bis groß.** Viele große Motive zeigen gepflegte, allgemein wirkende Reinigungs- und Teamszenen. Auf „Über uns“ fehlen benannte Personen/Funktionen und öffentlich überprüfbare Beispiele. Die Galerie beschreibt meist nur „Kurzer Einblick …“.
- **Beleg:** `public_html/ueber-uns/index.php:9`; `public_html/galerie/index.php:8–80`; `config/pages/galerie.php:37` kennzeichnet die Collage ausdrücklich als illustrativ.
- **Empfehlung:** Echte, freigegebene Ansprechpartner und Arbeitssituationen mit konkretem Kontext zeigen; illustrative Motive nachvollziehbar einordnen. Bei realen Projekten Ausgangslage, Umfang und Ergebnis nennen. Vorher/Nachher nur bei vergleichbarer Aufnahme. Bildrechte und Kundeneinwilligungen betrieblich prüfen.
- **Grenze:** Aus dem Aussehen wird weder eine KI-Herkunft noch eine fehlende Echtheit behauptet. Referenzen, Zertifikate oder Kundenzahlen müssen belegbar sein.

### D09 — Die beiden gefüllten Headeraktionen konkurrieren visuell

- **P3 · Hierarchieempfehlung · Aufwand: klein.** Auf Desktop stehen blauer Angebotsbutton und grüner WhatsApp-Button gleichrangig übereinander. Das betont zwei Wege gleichzeitig; WhatsApp erhält durch die abweichende Farbe zusätzlich viel Gewicht.
- **Beleg:** `app/templates/header.php:62–64`; Headeraktionsstile in `resources/css/02-components.css`.
- **Empfehlung:** Geschäftlich gewünschten Hauptweg bestimmen und die Alternative ruhiger darstellen. Die verständlichen Beschriftungen beibehalten. Die aktuelle Funktion ist korrekt; eine bessere Abschlussrate ist erst nach Nutzungsbeobachtung belegbar.

### D10 — Der schnelle Telefonweg verschwindet im mobilen Header

- **P3 · Mobile-UX-Empfehlung · Aufwand: klein.** Unter 1080 px fällt die Topbar samt Telefonlink weg. Das mobile Menü bietet Angebotsanfrage und WhatsApp, aber keinen eigenen Telefonlink. Auf der Startseite ist Telefon erst über Kontakt/untere Seitenbereiche erreichbar.
- **Beleg:** `app/templates/header.php:23–26,57–59`; `resources/css/04-responsive.css:20–28`.
- **Empfehlung:** Einen gut beschrifteten Telefonweg im mobilen Menü oder nahe dem Einstieg anbieten, wenn Anrufe ein wichtiger Geschäftskanal sind. Die kompakte Headerhöhe dabei erhalten.

### D11 — Als Karten wahrgenommene Leistungen haben nur einen Titel-Link

- **P3 · Touch-/Affordanzempfehlung · Aufwand: klein.** Icon/Bild und große weiße Kartenfläche wirken zusammengehörig; tatsächlich navigiert ausschließlich der unterstrichene Titel. Das ist bewusst umgesetzt und kein defekter Link.
- **Beleg:** `app/helpers/service-discovery.php:57`; `resources/css/03-pages.css:68–125`.
- **Empfehlung:** Prüfen, ob eine größere eindeutig erkennbare Klickfläche sinnvoll ist. Falls gesamte Karte verlinkt wird, einen einzigen semantischen Link und sichtbaren Fokus verwenden; keine verschachtelten Links. Alternativ die reine Titelinteraktion visuell deutlicher halten.

### D12 — Das Telefon-Emoji passt nicht zur sonst kontrollierten Iconsprache

- **P3 · Visual-Empfehlung · Aufwand: klein.** Das Telefon in der Desktop-Topbar wird als rotes Emoji dargestellt; Form/Farbe variieren je Betriebssystem. Leistungsicons und WhatsApp-Logo sind dagegen kontrollierte Vektorgrafiken.
- **Beleg:** `app/templates/header.php:25` verwendet das Zeichen ☎, während die übrigen Icons als SVG eingebunden sind.
- **Empfehlung:** Ein kleines, zur Linienbreite und Farbe des Headers passendes SVG einsetzen. Die zugängliche Textbeschriftung des Telefonlinks erhalten.

### D13 — Mobile Leistungsbilder schrumpfen zu stark beschnittenen Bildstreifen

- **P3 · Visual-Empfehlung · Aufwand: mittel.** Auf /leistungen/ sind Kartenbilder mobil etwa 362 × 96 px hoch. Büro-/Polstermotive zeigen dadurch überwiegend Tisch/Handschuh bzw. Arm/Sessel statt einer schnell erkennbaren Tätigkeit. Das Bild wird zum schmalen Schmuckstreifen über relativ viel Text.
- **Beleg:** `resources/css/03-pages.css:88–92` mit clamp-Bildhöhe und object-fit:cover; Screenshot Leistungen/390. Die fehlenden passenden Bilddateien behandelt ergänzend P02.
- **Empfehlung:** Für Mobilgeräte gezielt komponierte Ausschnitte oder proportionale Vorschaubilder testen. Alternativ eine kompakte Bild-/Textliste verwenden. Motiv und Objekt sollen erkennbar bleiben, ohne die Karten erneut stark zu verlängern.

### D14 — Nichtinteraktive Objekt-Tags und Navigationschips sehen ähnlich aus

- **P3 · Konsistenz-/Bedienempfehlung · Aufwand: klein.** Objektarten wie Büros/Praxen/Wintergärten erscheinen in umrahmten Rechtecken. Spätere Links auf Städte/Leistungen benutzen ähnliche Formen. Die Bedienbarkeit erschließt sich stärker aus Position/Text als aus der visuellen Sprache.
- **Beleg:** `resources/css/06-service-pages.css:82–96` gegenüber `resources/css/03-pages.css:201–208`; `content/services/glas-und-fensterreinigung/body.php:3`.
- **Empfehlung:** Informations-Tags ruhiger von echten Links absetzen; Navigation konsistent mit Link-/Pfeilmerkmal und sichtbaren Zuständen gestalten. Keine Interaktion für reine Inhaltslabels suggerieren.

### D15 — Der Fassadenclip enthält eingebrannte schwarze Balken

- **P3 · Bestätigte visuelle Inkonsistenz · Aufwand: mittel.** Zwei extrahierte Stichprobenframes zeigen schwarze Balken innerhalb des kodierten Portraitbildes. Andere Galerieclips nutzen die Fläche überwiegend vollständig.
- **Beleg:** `public_html/assets/video/services/fassadenreinigung/fassadenreinigung-praxis.mp4`; Einbindung `content/services/fassadenreinigung/body.php:11`; Kontaktblatt im Belegpaket.
- **Empfehlung:** Passenden neuen Ausschnitt/Encode prüfen, sofern Originalmaterial und Rechte verfügbar sind. Nicht pauschal mit CSS vergrößern und dabei bildwichtige Reinigungsdetails abschneiden.

## 2. Formularabläufe und funktionale Qualität

### F01 — Der erste Formularschritt erfordert viel Scrollen vor „Weiter“

- **P2 · UX-Empfehlung · Aufwand: mittel.** Neun großflächige Auswahlkarten plus Einleitung und Fortschrittsanzeige stehen vor der einzigen Weiter-Aktion. Selbst nach Auswahl der ersten Leistung muss der Nutzer an allen übrigen Karten vorbeiscrollen. Auch bei 1440 × 900 liegt die Weiter-Aktion unter dem ersten Fenster.
- **Beleg:** `public_html/angebotsanfrage/index.php:20–47`; mobile Einzelspalte `resources/css/05-offer-form.css:606` und Padding `:576`.
- **Empfehlung:** Schritt 1 kompakter komponieren; Icon/Text-Struktur und Hilfstexte auf notwendigen Umfang reduzieren. Eine gut sichtbare, gegebenenfalls kontextuell fixierte Weiter-Aktion testen, ohne Mehrfachauswahl, Endinhalte oder Fokus zu verdecken. Die große nutzbare Label-Fläche beibehalten.

### F02 — Das Telefon-Pattern des Angebotsformulars ist ungültig

- **P2 · Bestätigter Frontendfehler · Aufwand: klein.** `public_html/angebotsanfrage/index.php:189`: Der nicht korrekt escapete Schrägstrich im Zeichenblock ist im aktuellen HTML-RegExp-v-Modus ungültig.
- **Reproduktion:** In Chromium `abcdefghi` in #offer-phone eintragen und Gültigkeit prüfen: checkValidity ist true, patternMismatch false; Konsole meldet ungültigen regulären Ausdruck. Das Kontaktformular weist denselben Wert korrekt zurück.
- **Empfehlung:** Für beide Formulare ein gemeinsames browserkompatibles Pattern verwenden. +49, Leerzeichen, Klammern, Schrägstrich, Bindestrich und Buchstaben prüfen; Servervalidierung beibehalten.
- **Auswirkung:** Ungültige Werte passieren die lokale Prüfung und können erst nach dem Versandversuch auffallen. Keine erfolgreiche Zustellung ungültiger Werte behauptet.

### F03 — Drag-and-drop verwirft das sechste Foto ohne Hinweis

- **P2 · Bestätigter Interaktionsfehler · Aufwand: klein.** Drop mit foto1.png bis foto6.png übernimmt nur fünf Dateien; validationMessage bleibt leer, es erscheint kein Hinweis auf das verworfene Foto.
- **Beleg:** `public_html/assets/js/forms/offer-form.js:402–407`: Kürzung mit slice vor der Zahlprüfung; reguläre Dateiauswahl besitzt dagegen eine ausdrückliche Höchstzahlmeldung bei `:348`.
- **Empfehlung:** Bei Überschreitung sichtbar und über die Live-Region erklären, was passiert. Entweder ganzen Drop ablehnen oder bewusste Auswahl anbieten. Dateiauswahl und Drop über dieselben Grenzregeln führen.

### F04 — Servervalidierung akzeptiert negative Flächen und erfundene Auswahlwerte

- **P2 · Bestätigter Validierungsfehler · Aufwand: mittel.** Reiner lokaler Funktionstest ohne Mailtransport: office_area=-100 und office_frequency=NOT-A-REAL-SELECT-OPTION werden bei sonst synthetisch gültigen Pflichtangaben ohne Fehler übernommen.
- **Beleg:** `app/forms/offer-request.php:68–74`; ausgewählte Servicefelder werden überwiegend nur auf Leerwert geprüft. `config/forms/offer.php:65` begrenzt numerische Prüfung auf Polster-Anzahlfelder; mehrere HTML-Selects haben keine entsprechende serverseitige Optionsliste.
- **Empfehlung:** Tatsächliche Select-Werte zentral positiv listen; numerische Flächen/Anzahlen mit Dezimalkomma, plausiblen Bereichen und vorhandenem Schätztoken prüfen. Flexible Beschreibungsfelder wie Fensteranzahl × Flügel weiter ermöglichen.
- **Grenze:** Es folgt eine Plaintext-Mail; dies ist Datenqualität/Missbrauchshärtung und kein nachgewiesener SQL-, HTML- oder Code-Injection-Angriff.

### F05 — Lokale Uploadlimits widersprechen dem Formular und zerstören bei Übergröße das Antwortformat

- **P2 · Lokal bestätigter Betriebs-/Fehlerbehandlungsdefekt · Aufwand: klein bis mittel.** UI erlaubt fünf Fotos, je 5 MiB, insgesamt 15 MiB; lokaler PHP-Container: upload_max_filesize=2M, post_max_size=8M.
- **Reproduktion:** 3-MiB-Datei mit garantiert ungültigen übrigen Daten → 422/JSON, aber nur unspezifischer Uploadfehler. 9-MiB-POST → 200/text-html mit PHP-Startup-/Header-Warnungen und internen Pfaden; dahinter JSON „Unbekannter Formulartyp“. Die Anwendung verwirft das Format als unerwartete Antwort. Kein Versand wurde ausgelöst.
- **Beleg:** `public_html/angebotsanfrage/index.php:175`; `app/forms/photo-upload.php:11,23–25`; `app/forms/contact-handler.php:78–80`; `public_html/assets/js/core/main.js:263`.
- **Empfehlung:** Zuerst Produktivlimits feststellen. UI, PHP, Webserver/Proxy und Mailgrößenlimit abstimmen; Multipart-Overhead berücksichtigen. Übergröße früh mit 413/verständlichem JSON abfangen; produktionsnah PHP-Warnungen serverseitig protokollieren statt anzeigen. MB/MiB-Bezeichnung konsistent machen. 15 MiB Bilder werden als Base64 ungefähr 20 MiB plus Mailheader.
- **Grenze:** Der lokale Negativtest belegt keine identischen Limits oder Fehleranzeigen auf der Live-Website.

### F06 — Kleine Korrekturen aus der Prüfübersicht erfordern erneut alle Folgeschritte

- **P3 · UX-Empfehlung · Aufwand: mittel.** „Ändern“ springt korrekt zum Abschnitt, anschließend führt Weiter wieder sequenziell über die nachfolgenden Schritte.
- **Beleg:** `public_html/assets/js/forms/offer-form.js:76–83,444–456`; praktisch mit Büroanfrage geprüft.
- **Empfehlung:** Nach Bearbeitung aus Schritt 5 eine Aktion „Änderung übernehmen und zur Übersicht“ anbieten. Abhängige Pflichtfelder und geänderte Servicewahl weiterhin vollständig prüfen. Kein Funktionsausfall des vorhandenen Ablaufs.

### F07 — Bei JavaScript-Ausfall fehlt ein brauchbarer Navigations-/Anfragefallback

- **P2 · Bestätigter Robustheitsmangel · Aufwand: mittel.** Ohne JavaScript bleibt bei 390 px die Hauptnavigation unsichtbar; der Hamburger klappt sie nicht nativ auf. Das Angebot bleibt in Schritt 1, weil Weiter ein Button mit JavaScript-Handler ist. Es gibt keine Erklärung im betroffenen Bereich.
- **Beleg:** `resources/css/04-responsive.css:51–73`; `app/templates/header.php:32–33`; `public_html/angebotsanfrage/index.php:47`; `public_html/assets/js/forms/offer-form.js:57`.
- **Empfehlung:** Navigation erst nach erfolgreicher Initialisierung einklappen; Anfrage progressiv verbessern oder bei Ausfall einen sichtbaren direkten Kontaktweg erklären. Footer-/WhatsApp-Alternativen existieren bereits, helfen aber erst nach Auffinden.
- **Einordnung:** JavaScript-Nutzung ist nicht automatisch ein Accessibility-Verstoß. Der Befund betrifft blockierte Aufgaben bei Scriptladefehlern oder deaktiviertem JavaScript.

## 3. Barrierefreiheit und verständliche Zustände

### A01 — Formularhinweise unterschreiten den Textkontrast

- **P2 · Bestätigter Kontrastfehler · Aufwand: klein.** Schritt 2, hellblaue Einsatzortkarte: Optionaltext #6a7681 auf #edf5fa bei 14 px fett = **4,21:1**; Firmenhinweis #66737e auf demselben Hintergrund bei 14 px normal = **4,40:1**. WCAG 1.4.3 verlangt hier mindestens 4,5:1; 14 px fett zählt nicht als großer Text.
- **Beleg:** `resources/css/08-offer-conversion.css:10`; `resources/css/05-offer-form.css:206,248`; Markup `public_html/angebotsanfrage/index.php:54–55`. Computed Styles und Axe in geöffnetem Schritt bestätigt.
- **Empfehlung:** Hinweis-/Optionalfarben passend zum realen Hintergrund abdunkeln, mit Reserve zum Mindestwert. Alle Wizardzustände erneut prüfen, einschließlich readonly, Fehler und Auswahl.

### A02 — Telefonnummer und E-Mail im Footer sind enge Touch-Ziele

- **P2 · Gemessener Bedienbarkeitsbefund · Aufwand: klein.** Footer-Telefonlink ca. **99,8 × 19 px**, sicherer Abstandskreis nur ca. 21,6 px. Axe target-size meldet denselben Link auf allen 22 geprüften Routen; die E-Mail folgt unmittelbar in der nächsten Zeile.
- **Beleg:** `app/templates/footer.php:18`; `resources/css/03-pages.css:372,402`.
- **Empfehlung:** Kontaktaktionen als separate höhere Zeilen mit ausreichend Abstand gestalten; 44 px ist ein sinnvolles Komfortziel.
- **Grenze:** Die Inline-Ausnahme von WCAG 2.5.8 muss manuell eingeordnet werden. Deshalb kein pauschales abschließendes Konformitätsurteil aus diesem automatisierten Hinweis.

### A03 — Das mobile Menü mischt modales Fokusverhalten mit normalem Navigationsmodell

- **P3 · Semantik-/Screenreader-Prüfpunkt · Aufwand: mittel.** Öffnen sperrt Body-Scroll und hält Tab in Menü/Schließen. Der Hintergrund bleibt im Accessibility Tree aktiv; keine Dialogsemantik oder inert. Escape und Fokus-Rückgabe funktionieren.
- **Beleg:** `public_html/assets/js/core/main.js:26–45,82–95`; `app/templates/header.php:32–33`.
- **Empfehlung:** Ein Modell wählen: nichtmodale Navigation ohne erzwungenen Fokuskreis oder modale Oberfläche mit passender Semantik/inaktivem Hintergrund. Mit VoiceOver/TalkBack und virtuellem Cursor prüfen. Vor einer solchen Prüfung keinen konkreten Screenreader-Ausfall behaupten.

### A04 — Informationsgehalt der stummen Videos braucht eine gleichwertige Textalternative

- **P2 · Belegter Beschreibungsbedarf, Einzelabnahme offen · Aufwand: mittel.** Alle acht MP4s sind reine H.264-Videostreams ohne Audiostream. Je zwei gesichtete Frames zeigen konkrete Handlungen und Reinigungsspuren: etwa Abziehen des Schaums, Absaugen von Polstern und freigelegte Graffitistreifen. Vorhandene kurze allgemeine Bildunterschriften benennen überwiegend nur die Leistung; eine genauere Beschreibung von Ablauf/Ergebnis fehlt unmittelbar am Clip.
- **Beleg:** `public_html/galerie/index.php:91–92`; beispielsweise `content/services/solaranlagenreinigung/body.php:11`.
- **Empfehlung:** Wenn der Clip zusätzliche Reinigungsschritte oder Ergebnisse vermittelt, diese gleichwertig als Text bzw. geeignete auditive Alternative erklären (WCAG 1.2.1). Bei rein illustrativer Alternative zu bereits gleichwertigem Text diesen Zusammenhang klar machen.
- **Grenze:** Keine fehlenden Sprachuntertitel behaupten: Es gibt keine Audiospur. Eine rechtssichere Bewertung der Gleichwertigkeit erfordert inhaltliche Einzelabnahme.

## 4. Performance, Medien und Auslieferung

### Messbedingungen

Chromium 154.0.8037.57, Headless/Linux, lokaler Apache/PHP-8.4.26-Container. Mobil 390 × 844, DPR 3, Touch/Mobile aktiviert, CPU-Drosselung 4×; Netzwerk per CDP auf 1,6 Mbit/s Download, 750 kbit/s Upload und 150 ms Latenz eingestellt. Neuer Kontext und deaktivierter Cache je Lauf; Messfenster bis Netzwerkruhe plus zwei Sekunden, ohne Scrollen/Videoaktion. Home und Galerie je drei Läufe, andere Seiten je ein Lauf. Desktop 1440 × 1000 ohne Drosselung.

| Route | Profil | LCP | Initiales CLS | Initialer Transfer |
|---|---|---:|---:|---:|
| / | Mobil, 3 Läufe | 2,204 / 2,248 / 2,264 s; Median **2,248 s** | 0 | 342.314 B |
| / | Desktop | 0,312 s | 0 | 342.314 B |
| /leistungen/ | Mobil | 2,644 s | 0 | 1.019.418 B |
| /leistungen/fassadenreinigung/ | Mobil | 2,692 s | 0 | 444.030 B |
| /galerie/ | Mobil, 3 Läufe | 4,352 / 4,324 / 4,316 s; Median **4,324 s** | 0 | 764.690 B |
| /angebotsanfrage/ | Mobil | 1,272 s | 0 | 68.935 B |

PerformanceObserver/Performance API; Transfer zählt Navigation und im Messfenster abgeschlossene Ressourcen, nicht den späteren Gesamtdownload. CLS=0 gilt nur für dieses initiale Fenster. Dies sind **lokale synthetische Laborwerte**, keine Live-Feldwerte, kein Lighthouse-Score und kein gemessener INP. TLS/CDN/Produktiv-TTFB fehlen; geteilte Rechenleistung und Emulation begrenzen die Übertragbarkeit. Die Galerie sollte unter identischen Bedingungen nach Änderungen erneut verglichen werden.

### P01 — Alle acht Galerieposter werden sofort geladen

- **P2 · Lokal bestätigt · Aufwand: mittel.** Trotz preload=none der Videos werden ohne Scrollen alle acht Poster angefordert, zusammen **473.922 B**, zusätzlich zur 251.676-B-Hero-Collage. Galerie-LCP in allen drei Läufen 4,316–4,352 s. Der einzelne kausale Anteil der Poster wurde nicht durch Codeänderung/A-B-Test isoliert.
- **Beleg:** `public_html/galerie/index.php:91`; Collage `config/pages/galerie.php:34`. Große Poster: Fensterclip 01 ca. 145,7 kB, Solar ca. 102,4 kB.
- **Empfehlung:** Poster auf den sichtbaren Bedarf optimieren; nachgelagerte Poster erst in Viewportnähe anfordern. Die bestehende Zurückhaltung der MP4-Dateien vor Nutzeraktion erhalten.

### P02 — Responsive Bildvarianten und passende Kartenausschnitte fehlen

- **P2 · Bestätigt · Aufwand: mittel.** Kein srcset/sizes/picture in den zentralen Bildpfaden. Innere Heros laden mobil meist 1920 × 870 bei 362 × 204 CSS-Pixeln. Karten laden 1200 × 800 für teils 360 × 96 große Flächen; das Teppichbild wiegt 337.468 B.
- **Beleg:** `app/helpers/render-components.php:35`; `app/helpers/html.php:28`; `app/helpers/service-discovery.php:53`; `public_html/index.php:9`.
- **Auswirkung:** Native Lazy-Schwellen laden auf der Leistungsübersicht schon fünf Kartenbilder im ersten Messfenster; etwa 1,02 MB initial trotz korrekter Lazy-Attribute.
- **Empfehlung:** Varianten nach tatsächlicher Fläche, DPR und Motivbeschnitt generieren; responsive Kandidaten anbieten und Qualität visuell vergleichen. Eigene mobile Ausschnitte sind beim Home-Hero sinnvoller als blindes Skalieren. WebP ist bereits vorhanden; AVIF nur ergänzend bei erkennbarem Nutzen.

### P03 — JavaScript fällt wegen MIME-Abweichung aus Gzip- und Cacheregeln

- **P2 · Lokaler Headerbefund · Aufwand: klein.** Apache liefert text/javascript; .htaccess behandelt dafür nur application/javascript. Beide Skripte bleiben lokal unkomprimiert und ohne vorgesehene Expires-/Cache-Control-Frist.
- **Beleg:** `public_html/.htaccess:60,67`; Browser bestätigt main.js 13.024 B und offer-form.js 25.947 B jeweils encoded=decoded. CSS dagegen Gzip 11.237 statt 56.144 B und 30-Tage-Cache.
- **Empfehlung:** text/javascript in Expires-/Komprimierungsregeln einbeziehen oder MIME konsistent konfigurieren; echte GET-Header mit Accept-Encoding prüfen, inklusive Vary. Offline-Gzip der beiden Skripte ergäbe zusammen rund 28,6 kB weniger auf der Angebotsseite; dies ist eine Abschätzung.
- **Grenze:** Produktiven MIME-Typ/Header erst prüfen; keine entsprechende Live-Fehlkonfiguration bestätigt.

### P04 — Lange Bildcachezeit ohne neue URL kann spätere Motive veralten lassen

- **P2 · Bestätigtes Wartungsrisiko, aktuell kein falsches Motiv nachgewiesen · Aufwand: mittel.** WebP/SVG bekommen ein Jahr Cachezeit, Bildpfade besitzen jedoch keinen Inhaltshash/Versionsparameter. CSS/JS sind bereits versioniert.
- **Beleg:** `public_html/.htaccess:62–63`; direkte Pfade in `app/helpers/render-components.php:35` und `public_html/index.php:9`; lokaler WebP-Header max-age=31536000.
- **Empfehlung:** Bei geänderten Bildern neue versionierte URLs vergeben. ETag/Last-Modified erzwingen während der Frischeperiode keine Nachprüfung. Lange Cachezeit für unveränderliche Medien beibehalten.

### P05 — Byteidentische Bilder liegen unter mehreren URLs

- **P3 · Bestätigt · Aufwand: mittel.** SHA-256-Inventur: elf Duplikatgruppen, rund **3,58 MB** redundanter Dateispeicher. Beispiel: Leistungsbild 07 und Fassaden-Contentbild jeweils byteidentisch mit 381.432 B; mehrere Ortsseiten nutzen Kopien desselben 81.048-B-Bildes.
- **Beleg:** `public_html/assets/img/pages/leistungen/leistungen-content-07.webp` und `public_html/assets/img/services/fassadenreinigung/fassadenreinigung-content.webp`.
- **Empfehlung:** Gemeinsame Motive zentral und versioniert referenzieren. Speichergröße ist nicht Seitengewicht; der Browsernachteil entsteht beim Wechsel auf andere URLs desselben Bildinhalts. Echte Bildvarianten getrennt belassen.

### P06 — Einzelne kurze Videos haben für mobile Verbindungen hohe Bitraten

- **P3 · Gemessene Optimierungschance · Aufwand: mittel.** Acht MP4s zusammen 28,55 MB. Solar: 5,84 MB/15,73 s, ca. 2,97 Mbit/s; Polster: 2,36 MB/8,80 s, ca. 2,15 Mbit/s. Das übersteigt die simulierten 1,6 Mbit/s und kann Pufferung verursachen; tatsächliche Stalls unter dieser Drosselung wurden nicht gemessen.
- **Beleg:** jeweilige MP4-Quelle, etwa `content/services/solaranlagenreinigung/body.php:11`. Fast Start (moov vor mdat) und lokale Byte-Ranges sind bereits vorhanden.
- **Empfehlung:** Niedrigere Bitraten/kleinere zusätzliche Rendition mit visueller Qualitätskontrolle testen. Für acht kurze Clips ist neue adaptive Streaminginfrastruktur erst bei belegtem Bedarf sinnvoll. Posteroptimierung zuerst bearbeiten.

## 5. Sicherheit und Datenschutz

### S01 — Ein SMTP-Passwortliteral liegt im Git-Repository

- **P1 · Bestätigter vertraulicher Prüfbedarf · Aufwand: klein bis mittel.** `private/smtp-config.php:5` enthält einen nicht leeren Literalwert ohne übliche Platzhaltermarker; die Datei ist getrackt. `private/contact.php:16` übernimmt ihn aus der Konfiguration.
- **Auswirkung:** Bei einem aktiven Wert können Personen mit Repository-/Historien-/Backupzugriff SMTP-Zugang erlangen. **Gültigkeit wurde nicht getestet**, der Wert wurde weder ausgegeben noch in diesen Bericht kopiert. Kein Missbrauch nachgewiesen.
- **Begrenzung:** Die Datei liegt außerhalb des vorgesehenen public_html-DocumentRoot und besitzt zusätzliche Zugriffssperre. Keine öffentliche HTTP-Offenlegung behauptet.
- **Empfehlung:** Vertraulich feststellen, ob der Wert aktiv/wiederverwendet ist; gegebenenfalls rotieren. Neue Credentials nur über nicht versionierte Deployment-Konfiguration/Secrets liefern. Historische Kopien nach Rotation und abgestimmtem Vorgehen behandeln. Keine Geheimnisse in Tickets kopieren.

### S02 — Rate-Limit greift spät und ist nicht atomar

- **P2 · Bestätigte Implementierungsschwäche · Aufwand: mittel.** Uploadprüfung findet vor dem Rate-Limit statt; is_file/filemtime/touch haben keine atomare Sperre. touch-Fehler werden unterdrückt.
- **Beleg:** `app/forms/contact-handler.php:164,180–187`.
- **Auswirkung:** Gleichzeitige Anfragen können die Zeitprüfung gemeinsam passieren; aufwendige ungültige Uploads werden nicht früh begrenzt. Bei Schreibfehlern kann der Schutz unbemerkt ausfallen. Kein Lastangriff oder Versandtest durchgeführt.
- **Empfehlung:** Frühe günstige Requestlimits und atomaren, überwachten Zähler/Schlüssel mit TTL einsetzen. Gemeinsame Büro-/Mobilfunk-IP-Adressen berücksichtigen. Der feste Empfänger begrenzt Missbrauch; kein Open-Mail-Relay-Befund.

### S03 — Fremde Websites können das öffentliche Formular als Sendekanal ansprechen

- **P3 · Missbrauchshärtung · Aufwand: mittel.** Keine Origin-/Fetch-Metadata-Prüfung oder zeitgebundener Formularnachweis; Honeypot kann gezielt leer bleiben.
- **Beleg:** `app/forms/contact-handler.php:14,97`; `config/forms/schemas.php:25`; normaler POST via `public_html/assets/js/core/main.js:258`.
- **Empfehlung:** Passende Herkunfts-/Fetch-Metadata-Prüfung und gegebenenfalls signierten Formularnachweis mit robuster Rate-Begrenzung kombinieren. Ein Token allein stoppt direkte Bots nicht. CAPTCHA nur bei tatsächlichem Bedarf.
- **Grenze:** Kein Login/privilegierter Zustand; fehlender CSRF-Token ist hier allein keine klassische Kontosicherheitslücke. Same-Origin-Policy verhindert einfache fremde HTML-POSTs nicht, nur deren freies Auslesen. Keine solchen POSTs gegen Produktion ausgelöst.

### S04 — Lebensdauer der IP-Prüfsummen ist nicht anwendungsseitig begrenzt

- **P2 · Code-/Datenschutzkonsistenz, Hostregel offen · Aufwand: klein bis mittel.** Leere Temp-Dateien mit SHA-256-IP im Dateinamen werden angelegt, aber nicht von der Anwendung gelöscht. Die 45-Sekunden-Sperre ist keine Löschfrist.
- **Beleg:** `app/forms/contact-handler.php:180–187`; „für kurze Zeit“ in `public_html/datenschutz/index.php:21`.
- **Empfehlung:** Tatsächliche Host-Temp-Bereinigung prüfen, verbindliche TTL festlegen und unabhängig von neuen Anfragen bereinigen. Bei Bedarf HMAC mit Server-Secret verwenden. Ein einfacher IPv4-Hash ist keine Anonymisierung.
- **Grenze:** Ob der Hoster extern bereinigt, ist unbekannt. Deshalb keine unbegrenzte reale Speicherung behaupten; Dateien enthalten keine Formularinhalte.

### S05 — Verarbeitung von Fotos und Metadaten wird zu wenig erklärt

- **P2 · Bestätigte Beschreibungslücke, rechtliche Bewertung offen · Aufwand: klein bis mittel.** Formular und Checkbox erwähnen Fotos; zentrale Datenschutzerklärung unter Formulare nennt sie nicht ausdrücklich. Originaldateien gehen unverändert als Mailanhang weiter; mögliche EXIF-/GPS-Daten bleiben im geprüften Pfad enthalten.
- **Beleg:** `public_html/angebotsanfrage/index.php:168–175,196`; `public_html/datenschutz/index.php:19–21`; `app/forms/photo-upload.php:38–44`; `app/mail/smtp-mailer.php:28–29`.
- **Empfehlung:** Freiwillige Fotos, Zweck, Übermittlung, Empfänger, Löschlogik/Mailbox/Backups und mögliche Metadaten passend zum tatsächlichen Betrieb erklären. Am Upload um notwendige Objektfotos ohne unnötige Personen/Dokumente bitten. Kontrolliertes Metadatenentfernen prüfen.
- **Abnahme:** Datenschutzhinweis, tatsächlicher Datenweg und betriebliche Löschregeln stimmen überein. Keine Kundendaten wurden zum Test hochgeladen.

### S06 — Sperrregexp deckt versteckte und manche Backup-Dateien nicht ab

- **P3 · Bestätigte Härtungslücke, keine aktuelle Exponierung nachgewiesen · Aufwand: klein.** In `public_html/.htaccess:70` wird der Alternativzweig für einen führenden Punkt durch den abschließenden Endanker faktisch auf einen Dateinamen aus genau einem Punkt begrenzt. Normale Dotfiles wie .env.local und großgeschriebene Backupendungen werden nicht wie beabsichtigt erfasst.
- **Empfehlung:** Versteckte Pfadsegmente und Datei-/Backupvarianten gezielt sperren, notwendige .well-known-Ausnahmen eng halten; Deployment-Positivliste nutzen. Mit harmlosen Testdateien isoliert prüfen.
- **Grenze:** Keine entsprechenden sensitiven Dateien im PublicRoot gefunden; .git liegt außerhalb. Apache kann .htaccess zusätzlich global schützen. Kein tatsächlicher Datenabfluss belegt.

### S07 — Bildprüfung kontrolliert MIME und Größe, aber keine strukturellen Grenzen

- **P3 · Härtungsempfehlung · Aufwand: mittel.** finfo und Upload-/Bytegrenzen sind vorhanden, jedoch keine Maximalpixelzahl oder kontrollierte Bilddekodierung. Die Originaldatei wird angehängt.
- **Beleg:** `app/forms/photo-upload.php:23–43`.
- **Empfehlung:** Risikogerecht Dimensionen/Pixellimit und gegebenenfalls ressourcenbegrenztes Re-Encode ergänzen; normalen Anhang-/Malwareschutz auf Empfängerseite sicherstellen.
- **Grenze:** Keine öffentliche Uploadablage, serverseitige Ausführung oder Remote-Code-Ausführung nachgewiesen. Kein Schadbild versendet.

### S08 — Mailbibliothek ist ohne reproduzierbare Paket-/Lizenzverwaltung eingebunden

- **P2 · Wartungs-/Lieferkettenempfehlung · Aufwand: mittel.** Drei PHPMailer-Dateien werden direkt geladen; Quellversion 7.1.1. Keine composer.json/Lockdatei/Installationsmetadaten oder separate Lizenzbeigabe im Repository gefunden.
- **Beleg:** `vendor/autoload.php:4–6`; `vendor/phpmailer/phpmailer/src/PHPMailer.php:772` und Lizenzheader bei `:16`.
- **Empfehlung:** Paketquelle, Integrität und gepinnte Abhängigkeit dokumentieren; Lockdatei/Updateprozess und Sicherheitsmeldungen pflegen; Lizenztexte/Notices entsprechend der tatsächlichen Weitergabe mitliefern.
- **Grenze:** Kein konkreter PHPMailer-CVE oder Lizenzverstoß nachgewiesen. Die Versionsnummer allein beweist weder Sicherheit noch Verwundbarkeit.

### S09 — WhatsApp- und Aufbewahrungsinformationen mit dem Betrieb präzisieren

- **P3 · Transparenz-/Betriebsprüfung · Aufwand: klein.** WhatsApp-Datenschutzhinweis benennt den Dienst allgemein, ohne anklickbaren Anbieter-Datenschutzlink und ohne konkreten eigenen Bearbeitungs-/Löschablauf. Log-/Mailfristen bleiben abstrakt.
- **Beleg:** `public_html/datenschutz/index.php:14–26`; externer Link `app/helpers/actions.php:14–18,40–43`.
- **Empfehlung:** Tatsächlichen Anbieter/Dienst, Eingangsbearbeitung und Löschkriterien fachlich abgleichen; aktuelle Informationen verlinken. Hostervertrag/AVV und Backupabläufe organisatorisch verifizieren.
- **Positiv:** WhatsApp ist nur ein normaler Link; sein Icon wird lokal geladen. Kein belegter WhatsApp-Request beim bloßen Seitenaufruf und kein pauschaler Anlass für einen Cookie-Banner.

## 6. SEO, Inhalte, Vertrauen und Informationsarchitektur

### C01 — Der vorgesehene HTTP-410-Status wird zur 404 überschrieben

- **P2 · Lokal bestätigte Statusinkonsistenz · Aufwand: klein.** /kerpen-bergheim und /kerpen-bergheim/ sollen mit Gone entfernt werden, liefern aber 404.
- **Beleg:** `public_html/.htaccess:4,26–27` verwendet [G] und ErrorDocument 410 /404.php; `public_html/404.php:1` setzt stets http_response_code(404). GET/HEAD bestätigen 404.
- **Empfehlung:** Ursprünglichen Fehlerstatus erhalten oder 410 getrennt rendern. Unbekannte URL → 404, dauerhaft entfernte Ortsseite → gewünschte 410, jeweils mit brauchbarer Fehlerseite.
- **Einordnung:** 404 ist für entfernte Inhalte grundsätzlich zulässig. Keine gravierende Rankingwirkung aus dieser Inkonsistenz behaupten.

### C02 — Ortsseiten brauchen mehr konkreten lokalen Mehrwert

- **P2 · Inhalts-/Vertrauensempfehlung · Aufwand: mittel.** Büro-/Fenster-Ortsseiten unterscheiden sich vor allem durch Stadtbezug/Einleitung; mehrere Leistungslisten sind identisch.
- **Beleg:** `content/locations/bueroreinigung-{koeln,bruehl,bonn}.php:3` und entsprechende Fensterseiten.
- **Empfehlung:** Tatsächlich vorhandene lokale Einsatzbeispiele, Objektarten, Aufgaben und verlässliche Abdeckung erläutern. Allgemeine Leistungsinformationen zentral halten. Keine Stadtteile, Erfahrungen oder Niederlassungen erfinden.
- **Grenze:** Keine Duplicate-Content-Strafe oder gemessene Rankingverschlechterung nachgewiesen. Brühl ist bereits korrekt als Firmensitz bezeichnet.

### C03 — Umfang spezialisierter Leistungen ist zu wenig eingegrenzt

- **P2 · Inhalts-/Betriebsprüfung · Aufwand: mittel.** Hygiene-, Desinfektions-, Reinraum-, Industrie-, EDV-, Wasserschaden- und Messie-Reinigung erscheinen überwiegend als kurze Listeneinträge.
- **Beleg:** `public_html/leistungen/index.php:27–29,54–58`; allgemeine Erläuterung `content/services/grundreinigung/body.php:1–14`.
- **Empfehlung:** Tatsächliches Angebot und Grenzen mit dem Betrieb klären; notwendige Qualifikation/Nachweise nur bei Vorliegen erläutern. Nicht angebotene Schlagwörter entfernen; echte Spezialleistungen bedarfsgerecht erklären.
- **Grenze:** Fehlende öffentliche Nachweise beweisen keine fehlende betriebliche Qualifikation oder falsche Angabe.

### C04 — Textilseiten lassen Vorbereitung und Wiederbenutzung offen

- **P2 · Service-Inhaltsempfehlung · Aufwand: klein bis mittel.** Material-/Fleckprüfung wird erklärt, Vorbereitung, Trocknung, Lüftung und anschließende Nutzbarkeit dagegen kaum.
- **Beleg:** `content/services/teppichreinigung/body.php:4–14`; `content/services/polsterreinigung/body.php:4–14`.
- **Empfehlung:** Fachlich bestätigte Hinweise zu Zugang/Möbelvorbereitung, Einflussfaktoren auf Trocknung, Nutzung nach Freigabe und realistischen Fleckentfernungsgrenzen ergänzen. Keine pauschale Trocknungs- oder Erfolgsgarantie.

### C05 — Entrümpelung erklärt Transport- und Entsorgungsumfang zu wenig

- **P2 · Service-Inhalts-/Betriebsprüfung · Aufwand: klein bis mittel.** Räumung und besenreine Übergabe sind beschrieben. Formularoptionen umfassen Abtransport/Entsorgung sowie Transport/Räumung; Notizbeispiel erwähnt Sondermüll.
- **Beleg:** `content/services/entruempelung/body.php:4–14`; `public_html/angebotsanfrage/index.php:141–142`.
- **Empfehlung:** Tatsächlich angebotenen Entsorgungsumfang, ausgeschlossene/gesondert zu prüfende Stoffe, Verantwortlichkeiten, Kalkulation und Übergabe erklären. Die Formularnotiz allein beweist keine Zusage zur Sondermüllentsorgung.

### C06 — Bewerber können Arbeitszeit und Bewerbungsumfang nicht ausreichend einschätzen

- **P2 · Recruiting-Empfehlung · Aufwand: klein.** Start, unbefristeter Vertrag und übertarifliche Bezahlung sind genannt; Wochenstunden, Voll-/Teilzeit, typische Zeiten, Einsatzregion und benötigte Unterlagen fehlen.
- **Beleg:** `config/pages/jobs.php:41–46`; `public_html/jobs/index.php:21–30`.
- **Empfehlung:** Tatsächliche Rahmenbedingungen, Ansprechpartner und nächsten Schritt ergänzen. Beschäftigungsart passend auch im JobPosting pflegen. Kein bestätigter Ausschluss aus Google Jobs allein wegen optionaler Angaben.

### C07 — Nach der Angebotsanfrage fehlt ein belastbarer Antwortzeitrahmen

- **P3 · Conversion-/Textempfehlung · Aufwand: klein.** Eingang und weiteres Prüfen sind verständlich erklärt; ein verlässlicher Rückmeldezeitraum wird nicht genannt. E-Mail als regulärer Antwortkanal ist bereits im Telefonhinweis genannt.
- **Beleg:** `public_html/angebotsanfrage/index.php:189,203–206`; `public_html/faq/index.php:10–13`.
- **Empfehlung:** Intern realistisch erfüllbare Erwartung nennen. Keine erfundene 24-Stunden-Zusage. Hinweis auf unverbindlichen Wunschtermin beibehalten.

### C08 — FAQ-Antworten wiederholen sich und sind gleichrangig aufgereiht

- **P3 · Informationsarchitektur-Empfehlung · Aufwand: klein.** Kostenfaktoren, Anfrageablauf, hilfreiche Angaben und Angebotserstellung überschneiden sich; zehn geschlossene Einträge ohne Themengruppen.
- **Beleg:** `public_html/faq/index.php:9–18`.
- **Empfehlung:** Kosten/Anfrage, Ausführung/Turnus und Region gruppieren; redundante Antworten straffen und konkrete Servicefragen mit Leistungsseiten verbinden. Native Details-Bedienung und passende Schemaantworten erhalten.

### C09 — Tatsächliche Unternehmensprofile bei Vorliegen verknüpfen

- **P3 · Lokale-SEO-/Vertrauensempfehlung · Aufwand: klein, falls vorhanden.** Im Crawl ist wa.me die einzige externe Web-Domain; kein öffentlich verknüpftes Unternehmens-/Bewertungsprofil und kein sameAs im Unternehmensschema.
- **Beleg:** `app/templates/head.php:8–40`; vollständiger Linkbestand.
- **Empfehlung:** Falls Betreiberbestätigt vorhanden, zutreffendes Unternehmensprofil/echte Bewertungen verlinken und Stammdaten abgleichen. Keine Bewertungen, Sterne, Profile oder zusätzlichen Standorte erfinden. Existenz/Qualität eines solchen Profils wurde nicht geprüft.

### C10 — Social-Vorschauen verwenden allgemeine Bildmotive ohne gezielte Share-Komposition

- **P3 · Visual-/Metadatenempfehlung · Aufwand: mittel.** OG-Bildziele sind erreichbar, meist allgemeine Hero-Motive; Bildmaße/-Alt und og:site_name fehlen.
- **Beleg:** `app/templates/head.php:87–93`; etwa 1920 × 870-Hero in `config/pages/leistungen-teppichreinigung.php:50–53`.
- **Empfehlung:** Für wichtige Einstiege markengerechte Share-Motive mit sicheren Rändern, etwa 1200 × 630, und Bildbeschreibung/Maßen pflegen. Im echten Zielkanal kontrollieren. Eine aktuell falsche Vorschau wurde nicht beobachtet.

## 7. Pflege, Betrieb und noch offene Abnahmen

### O01 — Reproduzierbarer Build und Inbetriebnahme sind nicht dokumentiert

- **P2 · Wartbarkeitsempfehlung · Aufwand: mittel.** CSS-Quellen liegen in zehn Modulen unter resources/css, ausgeliefert wird eine gemeinsame styles.css. Im Stand final4 fehlen Buildskript, README und normale Paket-/Prüfkonfiguration für diese Schritte.
- **Beleg:** Repository-Dateiinventar; `resources/css/00-tokens.css` bis `09-local-pages.css`, `public_html/assets/css/styles.css`; Einbindung `app/templates/head.php:95`.
- **Empfehlung:** Einen nachvollziehbaren Erzeugungsweg für CSS, Sitemap und Deployment dokumentieren; lokale Startanleitung, erforderliche PHP-Erweiterungen/INI, Secrets und Prüfkommandos festhalten. Kleine relevante Checks für kritische Formular-/Headerregeln einrichten.
- **Grenze:** Kein aktueller Unterschied zwischen Quell-CSS und ausgeliefertem CSS behauptet. Ein Framework oder umfangreicher Buildprozess ist dafür nicht erforderlich.

### O02 — Gültigkeitsdatum der Stelle und sichtbaren Status zusammen pflegen

- **P3 · Pflegepunkt, aktuell kein abgelaufener Job · Aufwand: klein.** JobPosting gilt bis **10.11.2026**. Danach unterdrückt das Template korrekt das abgelaufene Markup, die sichtbare Stellenanzeige bleibt aber bestehen.
- **Beleg:** `config/pages/jobs.php:30`; `app/templates/head.php:60–70`.
- **Empfehlung:** Vor Ablauf betrieblich entscheiden: verlängern, schließen oder Initiativbewerbung anbieten. Sichtbaren Inhalt und strukturierten Status gemeinsam aktualisieren.

### O03 — Getrennte SEO-/Inhaltsquellen brauchen eine konsistente Pflege

- **P3 · Wartungsrisiko, aktuell kein Mismatch · Aufwand: klein bis mittel.** Sichtbare FAQ und Schemaantworten liegen getrennt; Sitemap-lastmod steht statisch auf 30.09.2026.
- **Beleg:** `public_html/faq/index.php:9–18`; `config/pages/faq.php:28–129`; `public_html/sitemap.xml:5,9,13`.
- **Empfehlung:** FAQ möglichst aus gemeinsamer Inhaltsquelle ableiten oder Synchronitätscheck nutzen. lastmod nur nach tatsächlicher substanzieller Inhaltsänderung pflegen oder ohne gesicherten Änderungsbezug weglassen. FAQ stimmt jetzt exakt überein; das vorhandene lastmod wurde nicht als falsch nachgewiesen.

### O04 — Komponenten-/Responsive-Regeln sind über mehrere CSS-Schichten verteilt

- **P3 · Wartbarkeitsempfehlung · Aufwand: mittel.** Formularbasis, Wizard und Conversion-Regeln liegen in drei Dateien; globale em-Breakpoints und spätere px-Breakpoints sind gemischt. Hintergrund-/Hinweisfarben laufen dadurch leichter auseinander, wie A01 konkret zeigt.
- **Beleg:** `resources/css/03-pages.css`, `04-responsive.css`, `05-offer-form.css:571`, `06-service-pages.css:141`, `07-gallery-faq.css:35`, `08-offer-conversion.css:187`, `09-local-pages.css:119`.
- **Empfehlung:** Pro Komponente Zustand/Responsive-Regeln zusammenführen oder klare Kaskadenebenen dokumentieren; auf Hintergründe abgestimmte Texttokens verwenden. Bei späterer Bereinigung visuelle Vergleiche durchführen. Keine blinde CSS-Löschung aus einzelnen Coverage-Läufen.

### O05 — Produktiv- und Unternehmensabnahmen bleiben offen

- **P2 · Offene Abnahme, kein bestätigter Rechts-/Produktionsfehler.** Unternehmensstatus, USt-ID/Register-/Aufsichtspflichten und gegebenenfalls Streitschlichtungsangaben lassen sich aus dem Code nicht entscheiden.
- **Beleg:** `public_html/impressum/index.php:8` enthält Betreiber, Anschrift, Telefon, E-Mail und DDG-Bezug. `public_html/datenschutz/index.php:14–24` enthält Aussagen zu Hoster und Löschfristen, deren betriebliche Umsetzung nicht beobachtbar war.
- **Erforderliche Folgeprüfung:** Tatsächlich einschlägige Impressumsangaben, Hosting-/Mail-AVV, Berechtigungen, Lösch-/Backupregeln, Referenz-/Bildrechte und real angebotene Spezialleistungen fachlich abnehmen. Keine Nummern, Zertifikate oder rechtlichen Pflichten erfinden.
- **Technische Live-Abnahme:** TLS/Zertifikate, Redirects, Schutzheader/CSP/HSTS, Body-/Upload-/Mailgrenzen, Fehleranzeige, unterstützte PHP-Version, Backup/Wiederherstellung und Monitoring prüfen. Nach gesonderter Versandfreigabe echte Empfängerzustellung, Reply-To, Anhänge, Fehler/Bounce sowie SPF/DKIM/DMARC kontrollieren. Echte Browser/Screenreader und Feldperformance ergänzen.

## 8. Positiv geprüft – was bereits trägt

- Alle 27 regulären Routen lokal HTTP 200; Fehlerseite und erfundener Pfad korrekt 404. Kein defekter interner Link oder Fragmentanker im Crawl. Keine reguläre Seite verwaist.
- Jede HTML-Seite genau eine H1; eindeutige Titel/Descriptions, passende HTTPS-www-Canonicals, gültiges JSON-LD. Sitemap deckt exakt die 27 regulären Seiten ab; Fehlerseite ist noindex. FAQ-Text und FAQ-Schema stimmen überein.
- Geprüfte Altpfade und explizite index.php-URLs leiten korrekt per 301. HTTPS-/www-Regel funktioniert lokal mit passendem Host-Header. C01 ist die gesonderte 410-Ausnahme.
- Keine sichtbaren horizontalen Überläufe in den 144 Breitenkombinationen. Automatisch markierte Offscreen-Honeypots sind absichtlich versteckt und wurden nicht als Layoutfehler gezählt. Keine abgeschnittenen normalen Inhalte in den vollständigen Desktop-/Mobilaufnahmen festgestellt; D01 betrifft gezielt geringe Höhe.
- Lesbare Typografie, zentrale Basistokens, wiederkehrende Komponenten, ruhige Oberflächen und gute Kontraste in vielen Standardzuständen. Hauptinhalte sind serverseitig verfügbar. Bilder besitzen Maßangaben; Systemschriften vermeiden zusätzliche Fontdownloads.
- Skip-Link, sichtbarer Fokus, eigene Fokusfarbe auf dunklen Flächen, native FAQ/Dropdowns, Reduced Motion, kein Autoplay. Mobiles Menü bei 320/390 px mit Escape/Fokus-Rückgabe und Tab-Verhalten bedienbar.
- Formularschritte, dynamische Pflichtfelder, irrelevante deaktivierte Felder, Schätzoption, Service-/Ortskontext, Review und Bearbeiten funktionieren im geprüften Ablauf. Keine ungelabelten sichtbaren Felder, doppelten IDs oder Bilder ohne alt-Attribut im DOM-Check; Sprachqualität/Einordnung dekorativer Bilder bleibt separat zu beurteilen.
- Mock-Fehler behalten Eingaben; Feldfehler zeigen zum passenden Schritt/Feld. Mock-Erfolg fokussiert Bestätigung, blendet den Wizard aus und entfernt persönliche Eingaben; Neubeginn startet leer. Doppelklick führte im geprüften Mock-Ablauf nicht zu doppeltem Request. Dies ersetzt keine echte Zustellprüfung.
- Kleine Skriptbasis ohne Framework-Bundle, defer, separates Formularskript nur auf Angebotsseite. Alle 144 PHP-Dateien und beide Skripte syntaxfehlerfrei. Initiales CLS in zehn Performance-Läufen 0; keine daraus abgeleitete Aussage über alle späteren Interaktionen.
- Medien lokal, keine initial beobachteten Drittanbieterrequests, keine Analyse-/Marketingcookies oder nicht notwendige lokale Speicherung im geprüften Code. Ohne neue Tools gibt es keinen belegten Grund für einen allgemeinen Cookie-Banner.
- API erzwingt POST; feste Mailadresse/From, validierte Reply-To, Plaintext-Mail und normalisierte Anhänge. Uploadlimits, is_uploaded_file und finfo vorhanden. Keine permanente öffentliche Uploadablage gefunden.
- Private Konfiguration und Vendor außerhalb DocumentRoot, zusätzliche Deny-Regeln. Schutzheader/CSP, Frame-Schutz, HSTS für HTTPS, Referrer-/Permissions-Policy und deaktiviertes Directory Listing konfiguriert. Lokale Wirksamkeit geprüft; Produktivwirkung offen.

## 9. Empfohlene Reihenfolge für spätere Änderungen

Dieser Abschnitt ist eine priorisierte Arbeitsliste; **keine Änderung wurde hier umgesetzt**.

1. **Vertraulich klären:** S01 – aktiven/recycelten SMTP-Wert prüfen und gegebenenfalls rotieren; künftig aus Versionsverwaltung heraushalten.
2. **Bestätigte Fehler beheben:** D01, F02–F05, A01; Footer-Zielgröße A02 verbessern. Produktionslimits und lokale Annahmen vor Hostingänderungen abgleichen.
3. **Mobile Hauptwege straffen:** D02–D07 und F01. Früher sichtbare Leistungen, sinnvoller Bildausschnitt, kompakterer Anfrageeinstieg und bessere Reihenfolge der mobilen Zusammenfassung.
4. **Medienauslieferung optimieren:** P01–P04; besonders Galerieposter und Kartenbilder. Unter identischen Laborbedingungen vergleichen, visuelle Qualität erhalten.
5. **Vertrauen und Entscheidungsinformationen verbessern:** D08, C02–C07. Reale Ansprechpartner/Beispiele und fachlich korrekte Leistungsgrenzen ergänzen.
6. **Robustheit und Pflege:** F06–F07, A03–A04, S02–S09, C08–C10 und O01–O05. Danach echte Geräte/Screenreader, Produktivheader, Zustellung und Feldperformance abnehmen.

## 10. Routenmatrix und Nachweise

Alle folgenden regulären Routen wurden als vollständige Seite bei 1440/390 px erfasst, im HTTP-/SEO-Crawl geprüft und an den vier gemeinsamen Zusatzbreiten untersucht. Status 200, genau eine H1, Titel/Description eindeutig, Canonical passend, JSON-LD gültig:

| Gruppe | Vollständig geprüfte Routen |
|---|---|
| Hauptseiten | / · /ueber-uns/ · /leistungen/ · /galerie/ · /faq/ · /jobs/ · /kontakt/ · /angebotsanfrage/ · /impressum/ · /datenschutz/ |
| Leistungen | /leistungen/buero-und-gewerberaumreinigung/ · /leistungen/glas-und-fensterreinigung/ · /leistungen/grundreinigung/ · /leistungen/teppichreinigung/ · /leistungen/polsterreinigung/ · /leistungen/entruempelung/ · /leistungen/fassadenreinigung/ · /leistungen/solaranlagenreinigung/ |
| Gebäudereinigung lokal | /gebaeudereinigung-bruehl/ · /gebaeudereinigung-koeln/ · /gebaeudereinigung-bonn/ |
| Büroreinigung lokal | /bueroreinigung-bruehl/ · /bueroreinigung-koeln/ · /bueroreinigung-bonn/ |
| Fensterreinigung lokal | /fensterreinigung-bruehl/ · /fensterreinigung-koeln/ · /fensterreinigung-bonn/ |
| Fehlerfälle | /404.php und erfundene URL → 404/noindex; /kerpen-bergheim/ → aktuell 404, siehe C01 |

Zusätzlich geprüft: /index.php, /kontakt/index.php, /kontakt ohne Slash, /teppichreinigung/, /polsterreinigung/index.html, alte Solar-/Photovoltaikpfade einschließlich codiertem Umlaut, /jobs/jobs.aspx und /angebot-anfordern/angebot-anfordern.aspx. Diese leiten lokal zum vorgesehenen Ziel um.

Die im Bericht genannten Datei-/Zeilenbelege beziehen sich auf den oben genannten Basiscommit. Manche PHP-Inhalte stehen in einer einzigen langen Zeile; eine genaue Komponente kann deshalb dieselbe Zeilennummer wie mehrere andere Abschnitte haben.

Im begleitenden Belegpaket sind ausgewählte Desktop-/Mobilaufnahmen, der Sticky-Laptopnachweis, zentrale Messdaten und dieser Bericht enthalten. Ganzseiten-Screenshots können bei vorherigem Scrollen Sticky-Elemente an einer ungewohnten Stelle abbilden; solche Aufnahmeeffekte wurden nicht als Websitefehler gewertet. Für D01 wurden reale Viewportaufnahmen und DOM-Koordinaten verwendet. Für die genaue Formularfokusprüfung wurden zusätzlich Viewportaufnahmen ohne Größenwechsel erstellt.

**Unverändertheitsnachweis:** Vor Erstellung dieser Dokumentation war git status sauber und final5 exakt auf dem final4-Commit. Der abschließende Gitvergleich zu origin/final4 weist ausschließlich `docs/deep-audit-final5.md` als neue Dokumentation aus. Zusätzlich wurden die unveränderten Inhalte aller ursprünglich getrackten Dateien gegen den Basisstand geprüft. Keine CSS-, JavaScript-, PHP-, Konfigurations-, Medien- oder Abhängigkeitsdatei wurde für diesen Audit geändert. Die Dokumentation wird als eigener lokaler Commit auf final5 gespeichert; kein Remote-Push wurde ausgeführt.
