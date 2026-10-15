# KEM Gebäudereinigung – Deep Design Audit

**Datum:** 15. Oktober 2026, Europe/Berlin

**Repository:** `kiesmo/kem-website`

**Geprüfte Basis:** Branch `final`, Commit [`00f1fe3b7750e0315f3ec0224a887f1a0e74b2d1`](https://github.com/kiesmo/kem-website/commit/00f1fe3b7750e0315f3ec0224a887f1a0e74b2d1)

**Arbeitsbranch:** `final3`, neu von dieser Basis erstellt

**Quellcode-Gegenprüfung:** 15. Oktober 2026 gegen `final3` / Dokumentationscommit `48273b01ab4eba318c1a9083530caac930834904`. Der Website-Code ist gegenüber `00f1fe3` unverändert. Korrekturen und neue Präzisierungen stehen in Abschnitt 11; der detaillierte Folgeplan steht in [implementation-plan-final3.md](implementation-plan-final3.md).

**Umsetzungsstand:** Die folgenden Befunde dokumentieren die ursprüngliche Basis. Die inzwischen umgesetzten B1-Korrekturen und ihre Prüfgrenzen sind separat in [b1-implementation.md](b1-implementation.md) festgehalten; B2–B9 sind noch nicht begonnen.

**Ursprünglicher Audit-Auftrag:** Detaillierte Prüfung von Design, visueller und inhaltlicher Hierarchie, Typografie, Farben, Layout, Seitenstruktur, Primary CTA und Final CTA. Diese Auditphase war ausschließlich Dokumentation ohne Websiteänderungen; spätere Umsetzung ist separat verzeichnet.

## 1. Gesamturteil

Die Website besitzt bereits eine brauchbare gestalterische Grundlage: eine zusammenhängende blau-navyfarbene Identität, überwiegend gut lesbare Grundfarben, wiederkehrende Karten, kontrollierte Abstände, responsive Grids und eine sinnvoll aufgebaute Angebotsstrecke. Ein vollständiger Austausch des Erscheinungsbilds ist durch die Befunde nicht begründet.

Der größte Verbesserungsbedarf liegt in der **Reihenfolge und Gewichtung**. Große Bilder, wiederholte Rubrikbezeichnungen und umfangreiche Auswahlblöcke erhalten viel Aufmerksamkeit, während zentrale Fragen später beantwortet werden: Was passt zu meinem Objekt? Warum dieses Unternehmen? Wie starte ich? Auf Mobilgeräten fehlt die dauerhaft sichtbare Angebotsaktion aus dem Desktopheader. Gleichzeitig tritt WhatsApp durch Farbe, feste Position und Wiederholung stark hervor.

Besonders relevant sind drei Muster:

1. **Der Einstieg erklärt das Thema, führt aber zu spät zur Aufgabe.** Auf der Startseite gibt es im Hero keinen Angebots-CTA. Auf vielen Unterseiten beginnt das eigentliche H1 erst unter einem großen Bild, einem Rubrikbadge und den Breadcrumbs.
2. **Viele Bereiche erscheinen gleich wichtig.** Acht Leistungen, drei Städte, mehrere Kontaktkanäle und wiederholte Planungsargumente konkurrieren um Aufmerksamkeit. Die Seite wirkt ordentlich, priorisiert jedoch wenig.
3. **Die Details der Bedienbarkeit bleiben hinter der sauberen Oberfläche zurück.** Inhaltslinks sind teilweise kaum als Links erkennbar. Uploadfokus, helle Feldkonturen und gelbe Fokuslinien auf Weiß brauchen gezielte Korrekturen. Der feste WhatsApp-Kreis überlagert mobile Inhalte.

Die empfohlene Richtung lautet: **früher zur passenden Handlung führen, Belege sichtbar machen, bestehende Gestaltung vereinfachen und die Bedienzustände verbessern.** Aussagen über höhere Conversion sind dabei Arbeitshypothesen. Es wurden keine Besucher- oder Funnel-Daten ausgewertet.

### Wichtigste Entscheidungen auf einen Blick

| Rang | Befund | Priorität | Empfehlung |
|---|---|---|---|
| 1 | Kein primärer Startseiten-CTA bei der Einstiegsbotschaft | P1 | Angebot direkt bei H1/Lead erreichbar machen; A01 |
| 2 | Große Unterseiten-Heroes vor eigentlicher Aufgabe | P1 | Hero und Seitenkopf je Seitenzweck neu gewichten; A02 |
| 3 | Fester WhatsApp-Kreis überdeckt mobile Inhalte | P1 | Überlagerung konstruktiv lösen und im Anfrageflow reduzieren; A03 |
| 4 | WhatsApp erhält auf der Angebotsseite vor dem Formular eine Hauptfläche | P1 | Formularstart vorziehen, Alternative sekundär behandeln; A04 |
| 5 | Leistungs-/Ortskontext geht beim Anfragebeginn verloren | P1 | Sichtbare, änderbare Vorwahl übernehmen; A05 |
| 6 | Inhaltslinks teilweise ohne erkennbares Linkmerkmal | P1 | Dauerhafte Kennzeichnung im Fließtext; A10 |
| 7 | Schwacher Fokuskontrast, unsichtbarer Uploadfokus, schwache Feldränder | P1 | Zustands- und Feldtokens gezielt korrigieren; A11–A13 |
| 8 | Visuelle H1-/H2-Hierarchie auf Startseite verkehrt sich mobil | P2 | Typografische Rollen und erste Blickführung stärken; A07–A08 |
| 9 | Doppelte Leistungskataloge und große Medien verzögern Antworten | P2 | Auswahl und Leistungsumfang früher zeigen; A15–A17 |
| 10 | Wenig konkrete sichtbare Vertrauensbelege | P2 | Belegte Menschen, Fälle und Arbeitsnachweise priorisieren; A18 |
| 11 | Kontakt, Jobs und FAQ nutzen zu stark dasselbe Verkaufs-/Bildschema | P2 | Primäre Aufgabe der jeweiligen Seite führen lassen; A25–A27 |
| 12 | Breakpoints verändern CTA-Verfügbarkeit und Bildkomposition abrupt | P2/P3 | Komponentenübergänge gezielt abstimmen; A28–A29 |

**Prioritäten:** P1 = zentrale Orientierung, Handlung oder Bedienbarkeit zuerst verbessern. P2 = merkliche Struktur-/Hierarchieschwäche im nächsten Design-Durchgang. P3 = Feinschliff, Systempflege oder ergänzende Validierung. Es wurde kein P0-Ausfall der Website festgestellt. Prioritäten bewerten den Designauftrag, keine rechtliche Compliance.

## 2. Prüfgrundlage und Aussagekraft

### Vorgehen

- Quellprüfung der CSS-Module, des tatsächlich ausgelieferten CSS-Bundles, der gemeinsamen Templates, Navigation, Footer, Inhaltsdateien und Formularskripte.
- Renderprüfung über die lokale Apache/PHP-Umgebung mit unverändert eingebundenem Website-Verzeichnis und Chromium/Playwright.
- Alle **28 konfigurierten Routen** bei **1440 × 900** und **390 × 844 CSS-Pixeln** geprüft: 56 Seiten-/Viewport-Kombinationen.
- Zusätzlich Startseite, Glas-/Fensterreinigung, Angebot und Kontakt bei Breiten **320, 375, 560, 768, 820, 1024, 1080, 1081, 1180, 1280 und 1920**, jeweils 900 px hoch: 44 Kombinationen. Zusammen **100 Kombinationen im grundlegenden Layoutcheck**.
- Ergänzende gezielte Prüfung der Start- und Glas-Seite bei **821, 980, 981, 1921 und 2560 px** sowie Vergleich der angrenzenden Zustände.
- Visuelle Gesamtseiten- und Ausschnittprüfung der wichtigsten Seitenfamilien; Messung von Schriftgrößen, Elementpositionen, Inhaltslängen und Overflow.
- Angebotsstrecke für Fensterreinigung auf Desktop und Mobile bis zum Prüfschritt durchlaufen: Leistungsauswahl, Objektangaben, Schätzoption, Terminwahl, Kontaktdaten und Rücksprung über „Ändern“. Nur synthetische lokale Testangaben; **keine Anfrage abgesendet**.
- FAQ geöffnet, Mobilemenü und Escape-Rückkehr geprüft; Upload per Tab fokussiert. Kontraste anhand der definierten sRGB-Farbwerte berechnet.

Die Quellenangaben beziehen sich auf den oben genannten Basiscommit. Einige PHP-Inhalte stehen abschnittsweise auf einer einzigen langen Quellzeile; zusätzlich ist deshalb immer der betroffene Inhaltsbereich genannt. Die zehn CSS-Module ergeben das ausgelieferte Bundle bytegleich.

### Unterscheidung der Befunde

**Beobachtet** bedeutet im Browser oder unmittelbar im Markup nachvollzogen. **Berechnet** bezeichnet konkrete CSS-Größen oder Farbkontraste. **Empfehlung/Hypothese** beschreibt die daraus abgeleitete Gestaltungsrichtung; sie ist keine gemessene Wirkung auf echte Besucher. Ein technisch funktionierendes Element kann trotzdem schwach priorisiert sein.

Nicht Bestandteil dieser Prüfung: echter Nachrichten-/E-Mail-Versand, produktiver Serverbetrieb, Rechtsprüfung, vollständiger Screenreader- und Browsermatrix-Test, vollständige WCAG-Zertifizierung, Medienherkunft, Bildrechte, Performancebenchmark unter Mobilfunk oder Nutzertests. Fehlende sichtbare Nachweise bedeuten nicht, dass das Unternehmen keine Nachweise besitzt.

### Seitenabdeckung

| Seitenfamilie | Geprüfte Routen |
|---|---|
| Start | `/` |
| Leistungsübersicht | `/leistungen/` |
| Acht Leistungsdetails | `/leistungen/buero-und-gewerberaumreinigung/`, `/leistungen/glas-und-fensterreinigung/`, `/leistungen/grundreinigung/`, `/leistungen/teppichreinigung/`, `/leistungen/polsterreinigung/`, `/leistungen/entruempelung/`, `/leistungen/fassadenreinigung/`, `/leistungen/solaranlagenreinigung/` |
| Neun lokale Seiten | Jeweils `/gebaeudereinigung-{bruehl,koeln,bonn}/`, `/bueroreinigung-{bruehl,koeln,bonn}/`, `/fensterreinigung-{bruehl,koeln,bonn}/` |
| Unternehmen und Belege | `/ueber-uns/`, `/galerie/` |
| Hilfe und Recruiting | `/faq/`, `/jobs/` |
| Kontakt und Anfrage | `/kontakt/`, `/angebotsanfrage/` |
| Utility | `/impressum/`, `/datenschutz/`, `/404.php` |

## 3. Was ausdrücklich bleiben sollte

| Element | Warum es trägt | Leitplanke für spätere Änderungen |
|---|---|---|
| Navy als Rahmen, Blau als Marke/Aktion | Wiedererkennbar, sachlich und passend zur Dienstleistung | Palette erhalten; Rollen und Aktionsgewicht verbessern |
| Dunkle Textfarbe und gedämpftes Grau | Gute rechnerische Kontraste auf Weiß | Hilfstext nicht weiter aufhellen |
| Systemschrift, 16-px-Basis, 1,65 Zeilenhöhe | Solide Lesebasis ohne externe Font-Nachladeabhängigkeit | Größenrollen konsolidieren, keinen Fontwechsel ohne Nutzen erzwingen |
| Fluid skalierende Überschriften | Grundsätzlich flexible Darstellung | Ausnahmen auf Startseite und Komponenten bewusst einordnen |
| 1240-px-Container, Kartenradius 16 px, dezente Schatten | Zusammenhängende Formsprache und kontrolliertes Grid | Weniger gleichgewichtige Boxen; keine zusätzliche Schattenfamilie |
| Helle, zusammenhängende Bildfarbstimmung | Reinigung wird unmittelbar verständlich | Reale Belege und sinnvolle Zuschnitte stärker gewichten |
| Beschreibende Leistungslinks | Ziele verständlicher als identische „Mehr erfahren“-Links | Lange Formulierungen kürzen, wenn der Kartenkontext bereits eindeutig ist |
| Native FAQ-/Navigations-Details | Robuste Zustandsdarstellung und Tastaturbedienung | Semantik bei visueller Überarbeitung erhalten |
| Skiplink, benannte Navigation, Escape-/Fokuslogik | Bereits gute Grundlagen für zugängliche Bedienung | Nicht durch rein visuelle Neulösungen verlieren |
| Große Auswahlkarten und Formularfelder | Bessere Trefferflächen als nur kleine native Checkboxen | Vertikale Strecke reduzieren, Klickflächen erhalten |
| Fünf Formularphasen mit Prüfung und „Ändern“ | Komplexe Anfrage wird gegliedert und vor Versand kontrollierbar | Phasen nicht ohne Nutzertest zusammenwerfen; Felder relevanter machen |
| Optionales Telefon, freiwillige Fotos, Schätzoption | Senkt unnötige Eingabehürden | Keine zusätzlichen Pflichtdaten aus rein gestalterischen Gründen |
| Kurzes Kontaktformular neben ausführlicher Anfrage | Unterschiedliche Anliegen erhalten passende Wege | Die beiden Wege im Einstieg klarer erklären |
| Freiwillige Videos mit Controls, Poster und `preload="none"` | Kein erzwungener Medienkonsum | Kein Autoplay zur vermeintlichen Aufwertung einführen |
| Transparente Region: Firmensitz Brühl, Einsatzgebiet Köln/Bonn | Konsistente und glaubwürdige Einordnung | Keine zusätzlichen Standorte suggerieren |
| Footer mit Adresse, Kontakten, Zeiten und Rechtlichem | Vollständige Rückfallebene | Mobile verdichten, wesentliche Angaben erhalten |
| Sachlicher Ton ohne pauschale Ergebnisgarantien | Erwartungen bleiben objektspezifisch | „Qualitätskontrolle auf Wunsch“ nicht ungeprüft zur allgemeinen Zusage steigern |

## 4. Messwerte zur aktuellen Hierarchie

Die folgenden y-Werte sind gerundete **Dokumentkoordinaten ab Seitenanfang bei Erstaufruf**, keine für alle Geräte festen Designwerte. Unterschiedliche Höhen, Schriften und Textumbrüche verändern sie. Sie machen die Reihenfolge des geprüften Zustands greifbar.

| Element | Desktop 1440 × 900 | Mobile 390 × 844 | Bedeutung |
|---|---:|---:|---|
| Startseiten-H1 | y 573, 34,56 px | y 409, 21,6 px | Aussage liegt im Bildpanel; keine Aktion daneben |
| Startseiten-Final-CTA-Band beginnt | y 3419 | y 5965 | Erster Angebotsabschluss im Hauptinhalt sehr spät |
| Startseiten-Angebotsbutton im Hauptinhalt | y 3618 | y 6213 | Header-/Menü-/Footerlinks sind hier separat zu betrachten |
| Startseiten-Leistungsbereich | 1216 px hoch | 2851 px hoch | Acht gleichrangige Karten erzeugen mobil viel Strecke |
| Glas-Seite: eigentliches H1 | y 938, 52 px | y 712, 31,2 px | Auf Desktop unter dem ersten 900-px-Viewport |
| Glas-Seite: erster Angebotsbutton im Inhalt | Sidebar y 1506 | mobile CTA y 1128 | Auch mit vorhandener Zusatz-CTA beginnt die Handlung spät |
| Kontakt-H1 | y 938 | y 681 | Bild-/Orientierungsaufbau vor Kontaktaufgabe |
| FAQ-H1 | y 938 | y 681 | Fragenliste folgt noch später |
| Jobs-H1 | y 938 | y 703 | Eigentliche Stelle ist nicht der erste visuelle Inhalt |
| Angebot-H1 | y 285 | y 211 | Bereits wesentlich direkter als Foto-Unterseiten |
| Angebot: „Weiter zum Objekt“ | y 1671 | y 2269 | Schon erster Schritt verlangt erhebliche Scrollstrecke |
| Fensteranfrage, Schritt 2 | 13 sichtbare Inputs/Selects/Textareas; ca. 1402 px Abschnittshöhe | 13; ca. 1956 px | Schätzcheckbox eingeschlossen; optionale Felder prägen die Länge mit |
| Galerie-Gesamthöhe | – | ca. 8661 px | Acht Portraitmedien in einer mobilen Spalte |

**Positiv:** In den 100 grundlegenden Seiten-/Viewport-Kombinationen wurde kein horizontaler Seiten-Overflow gemessen. Reguläre Routen lieferten HTTP 200; die ausdrücklich aufgerufene 404-Seite HTTP 404. Das bestätigt eine robuste Basis, ersetzt aber keine vollständige Browser-/Zoomprüfung.

## 5. Detaillierte Befunde

### A01 · P1 · Die Startseite braucht eine primäre Aktion an der Einstiegsbotschaft

**Ist-Zustand:** Der Hero nennt Leistung und Region und erklärt die Objektarten, enthält aber keinen Link. Auch das Unternehmensintro bietet keinen Angebotsweg. Der erste Angebotsbutton im Hauptinhalt kommt nach acht Leistungen und drei Ortskarten. Auf Desktop hilft der sichtbare Header-CTA; bis einschließlich 1080 px liegt er nur im geöffneten Menü. Der schwimmende WhatsApp-Link bleibt als auffälliger Kontaktweg übrig.

**Wirkung:** Das Einstiegsversprechen hat keine unmittelbar zugehörige Handlung. Besonders mobil müssen Besucher selbst entscheiden, ob sie das Menü öffnen, lange scrollen oder auf WhatsApp wechseln.

**Ändern:** Direkt bei H1/Subline einen klaren primären Anfrage-CTA vorsehen. Optional eine ruhige zweite Aktion zur Leistungsauswahl. Die Wirkung von zwei gefüllten Buttons vermeiden. Den späteren Abschluss-CTA beibehalten.

**Abnahme:** Bei 390, 768, 1024 und 1440 px stehen Aussage und primäre Aktion räumlich zusammen. Nach dem Lesen ist ein eindeutiger nächster Schritt erreichbar. Keine neue fixe Leiste ohne Prüfung der Inhaltsüberdeckung.

**Quellen:** `public_html/index.php:9–12,44`; `content/ctas/startseite.php:1`; `app/templates/header.php:53–56`; `resources/css/04-responsive.css:30–60`.

### A02 · P1 · Unterseiten beginnen mit zu viel Bild und zu wenig Aufgabe

**Ist-Zustand:** Der gemeinsame Ablauf lautet häufig Foto → blaues Rubrikbadge → Breadcrumb → Abstand → Eyebrow → H1/Lead. Auf Desktop beginnen Kontakt-, FAQ-, Jobs- und Glas-H1 jeweils ungefähr bei y 938. Auf Mobile nimmt das Foto bei 390 px Breite 470 px Höhe ein. Titel und Kontakt-/Fragenaufgabe starten deutlich später.

**Wirkung:** Das Motiv transportiert Atmosphäre und Thema, aber kaum Entscheidungsinformation. Beim Wechsel zwischen Leistungen oder Städten wiederholt sich dieselbe große Hürde. Kontakt und FAQ werden wie Präsentationsseiten behandelt.

**Ändern:** Seitenfamilien unterscheiden. Kontakt/FAQ/Jobs mit kompaktem Titelbereich und frühem Zugang zur Aufgabe; Leistungs-/Unternehmensseiten dürfen großzügiger visualisieren, sollten H1, Nutzen und Handlung früher zusammenführen. Nicht überall zwanghaft Text über Bilder legen. Das Foto kann neben oder unter einer klaren Aussage stehen.

**Beibehalten:** Zusammenhängende Motivwelt, Breadcrumbs und Konfiguration der Bildschwerpunkte. Die Bildhöhe sollte vom Informationswert der Seite abhängen.

**Abnahme:** Der erste Viewport beantwortet auf den wichtigsten Seitentypen Thema, Eignung und nächsten Schritt. Die H1 muss nicht auf jedem Gerät vollständig über der Falz liegen; dekorative Wiederholung darf sie jedoch nicht systematisch verdrängen.

**Quellen:** `app/helpers/render-components.php:3–10`; `app/templates/service-template.php:14–16`; `app/templates/location-template.php:17–19`; `public_html/kontakt/index.php:8`; `resources/css/04-responsive.css:176–179,233–240`; `resources/css/09-local-pages.css:269–288`.

### A03 · P1 · Der feste WhatsApp-Kreis überdeckt mobile Inhalte

**Ist-Zustand:** Bei 390 × 844 px sitzt der 56-px-Kreis ungefähr bei x 320–376 und y 774–830. Visuell bestätigt sind Überlagerungen von Kontakt-Fließtext, Angebotseinstieg, FAQ- und Galerie-Inhalten. Das Element bleibt während des Scrollens über unterschiedlichen Textstellen liegen.

**Wirkung:** Teile von Wörtern oder Bedienelementen geraten hinter den Kontaktbutton. Die Überlagerung betrifft die eigentliche Aufgabe, nicht nur leere Randfläche.

**Ändern:** Ein Konzept wählen, das Überdeckung verhindert: gut platzierte Inline-Kontakte, ein eigener reservierter Bereich oder eine platzsparende Hilfe außerhalb der relevanten Eingaben. Auf Kontakt und Angebot ist die schwebende Wiederholung besonders entbehrlich. Eine bloße Verschiebung um wenige Pixel verhindert keine Kollision an anderen Scrollpositionen.

**Abnahme:** Bei 320/390 px, mit geöffnetem Menü, in sämtlichen Formularschritten, bei vergrößertem Text und mit Bildschirmtastatur werden keine Inhalte oder fokussierten Elemente verdeckt. Safe-Area-Abstände erhalten.

**Quellen:** `app/templates/footer.php:17`; `resources/css/03-pages.css` im Bereich `.whatsapp-chat`; `resources/css/04-responsive.css:356–375`; Browserprüfung der mobilen Kontakt-, Angebots-, FAQ- und Galerieseiten.

### A04 · P1 · Die Angebotsseite priorisiert vor dem Formular einen anderen Kanal

**Ist-Zustand:** Vor dem ersten Schritt stehen große H1, drei Vorteile, WhatsApp-Erklärung, gefüllter grüner Button, Dauerbadge und Stepper. Auf Mobile beginnen die eigentlichen Leistungsoptionen erst etwa unter y 1090. Gleichzeitig gibt es den schwebenden WhatsApp-Kreis und einen erneuten Angebotslink im globalen Navigationsbereich: oberhalb 1080 px als sichtbaren Headerbutton, darunter im geöffneten Menü.

**Wirkung:** Wer bereits „Angebot anfordern“ gewählt hat, muss vor der Auswahl erneut einen Kanalentscheid treffen. Grün, Schatten und Wiederholung geben WhatsApp viel Gewicht. Das Formular wirkt dadurch wie eine nachfolgende Alternative.

**Ändern:** Kurzer Titel, kompakte Sicherheitshinweise und erster Schritt enger zusammenführen. WhatsApp als optionale Hilfe oder ruhigen Alternativlink behandeln. Den leeren ersten Formularzustand nicht mit einem zusätzlichen großen Marketingblock verlängern.

**Abnahme:** Im ersten mobilen Viewport ist die eigentliche Auswahlaufgabe erkennbar und erreichbar. Ein klarer Fokus pro Entscheidungsbereich; Hilfekanal bleibt zugänglich. Keine Behauptung, dass die bisherige Platzierung messbar Abbrüche verursacht – das wäre zu testen.

**Quellen:** `public_html/angebotsanfrage/index.php:10–36`; `resources/css/05-offer-form.css:12–80`; Browsermessungen.

### A05 · P1 · Service- und Orts-CTAs müssen ihren Kontext in die Anfrage mitnehmen

**Ist-Zustand:** Präzise benannte Anfragen wie Glasreinigung oder eine lokale Leistung führen generisch zu `/angebotsanfrage/`. Das Formular beginnt wieder mit neun gleich offenen Leistungsoptionen; Ort wird später neu erfragt. Im gelesenen Skript ist kein Einstieg über Leistungs-/Ortsparameter vorgesehen.

**Wirkung:** Die Benutzerabsicht wird auf der Detailseite aufgebaut und am Übergang verworfen. Der CTA klingt spezifischer als der folgende Einstieg.

**Ändern:** Ausgewählte Leistung und gegebenenfalls den ausdrücklich gewählten Ort sichtbar und änderbar übernehmen. Der generische Header-Einstieg bleibt offen. Mehrfachauswahl erhalten; weder Adresse noch PLZ aus Vermutungen vorfüllen.

**Implementierungspräzisierung:** Die Formularschlüssel sind nicht identisch mit den URL-Slugs: `general` steht für Grund-/Spezialreinigung, `graffiti` für Fassade/Graffiti, `window` für Glas/Fenster. Eine allgemeine Gebäudereinigungs-Ortsseite darf deshalb nicht automatisch `general` auswählen; dort nur den Ort übernehmen. Service-Summaries werden aktuell ohne dynamische Tokenersetzung gerendert. Kontextlinks benötigen einen expliziten gemeinsamen PHP-URL-Helper oder einen ausdrücklich erweiterten Rendervertrag, keine neuen Platzhalter allein.

**Abnahme:** Einstieg von einer Service- und einer Ortsseite zeigt korrekten Kontext; direkter Formularaufruf funktioniert allgemein; falsche Vorwahl lässt sich ohne Neustart ändern.

**Quellen:** `content/services/*/summary.php:1`; `content/ctas/leistungen-*.php`; `content/locations/bueroreinigung-koeln.php:8`; `app/templates/service-template.php:16`; `app/helpers/html.php:34–47`; `public_html/angebotsanfrage/index.php:31–49`; `public_html/assets/js/forms/offer-form.js:79–103,144–167`.

### A06 · P2 · Final CTA braucht einen klaren Abschluss und abgestufte Alternativen

**Ist-Zustand:** Die Abschlussbänder sind als eigener Bereich gut erkennbar. Genau neun der 23 Bänder – Startseite und acht Leistungsdetails – enthalten blauen Angebotsbutton, erneuten WhatsApp-Erklärungstext und ebenfalls gefüllten grünen Button. Die neun Ortsseiten, Leistungsübersicht, Über uns, Galerie, FAQ und Jobs enthalten keinen zusätzlichen Inline-WhatsApp-Button im Abschlussband; ihre vorhandenen Alternativen und Ziele unterscheiden sich. Danach kommt global im Footer noch einmal „Kostenloses Angebot“ sowie der schwebende WhatsApp-Link. Auf Service-Seiten stehen sieben andere Leistungen vor dem Abschluss; auf Ortsseiten kommen weitere Ortswechsel hinzu.

**Wirkung:** Nach dem Lesen wird erneut Auswahl angeboten. Der Abschluss wirkt wie ein weiterer Kontaktkatalog. Die kräftige Alternative kann stärker wirken als der beabsichtigte Hauptpfad.

**Ändern:** Eine Hauptaktion mit kurzem, zum Seiteninhalt passendem Nutzen und Erwartungshinweis. WhatsApp als knappe sekundäre Option. Abschluss direkt nach den entscheidenden Antworten; verwandte Leistungen und andere Städte optisch nachgeordnet. Footeraktion als Rückfallebene ruhig halten.

**Beibehalten:** Eigener Abschlussbereich, klare Angebotsbeschriftung, Kostenfreiheit/Unverbindlichkeit, sofern diese Zusagen gelten. Jobs behält einen eigenen Bewerbungsabschluss. Die FAQ führt nach offenen Fragen sinnvoll zu „Kontakt aufnehmen“ statt zwingend in die ausführliche Angebotsstrecke. Kontakt, Angebot und Utility-Seiten benötigen kein zusätzliches allgemeines Verkaufsband.

**Abnahme:** Der Blick folgt Überschrift → kurzer Erwartung → einer dominanten Aktion. Auf verkaufsorientierten Service-/Ortsseiten führen Primary und Final CTA zum selben nachvollziehbaren Angebotsprozess; die Abschlussbotschaft greift die jeweilige Leistung auf. Auf FAQ und Jobs darf der Abschluss bewusst zur passenden Hilfe beziehungsweise Bewerbung führen.

**Quellen:** `content/ctas/startseite.php:1`; `content/ctas/leistungen-*.php:1`; `content/ctas/faq.php:1`; `content/ctas/jobs.php:1`; `app/templates/service-template.php:17–18`; `app/templates/location-template.php:20`; `content/locations/gebaeudereinigung-koeln.php:36–48`; `content/locations/bueroreinigung-koeln.php:9–10`; `config/pages/{kontakt,angebotsanfrage,impressum,datenschutz,404}.php` für die fünf `cta => NULL`-Fälle; `resources/css/02-components.css:500–508`; `resources/css/09-local-pages.css:242–267`.

### A07 · P2 · Die Startseiten-H1 ist mobil schwächer als nachfolgende H2

**Ist-Zustand:** Bei 390 px ist die Hero-H1 21,6 px groß; reguläre H2 beginnen bei 24,8 px. Auf Desktop liegt die Start-H1 bei 34,56 px, während die reguläre H1 auf Unterseiten bis 52 px erreicht. Das Panel ist lesbar, die visuelle Einstiegsbotschaft aber relativ klein.

**Ergänzung aus der Gegenprüfung:** Auch bei 1440 px ist die Start-H1 mit 34,56 px etwas kleiner als die reguläre H2 mit 36 px. Auffälliger ist die Grenze 980/981 px: Die Start-H1 fällt beim einen Pixel breiteren Layout von 31,2 auf 24,8 px, also um ungefähr 20,5 %. Ursache sind die unterschiedlich definierten `clamp()`-Rollen vor und nach Ende der 980-px-Ausnahme. Dieser Sprung ist ein konkreter Kaskadenbefund, keine Forderung, dass semantische Überschriftsebenen grundsätzlich überall dieselbe optische Reihenfolge haben müssen.

**Wirkung:** Das Foto und der nachfolgende Unternehmensabschnitt können die erste Aussage überwiegen. Region, Leistung und Nutzen erhalten weniger Gewicht als ihre Bedeutung nahelegt. Semantische H1 und optische Hierarchie fallen auseinander.

**Ändern:** Für den Startseiten-Einstieg eine bewusst definierte Display-/H1-Rolle vorsehen. Als Entwurfsbereich etwa 28–34 px mobil prüfen, abhängig von Panelbreite und Textlänge; dies ist ein Startpunkt, keine verbindliche Spezifikation. Subline kürzen oder breiter führen, statt alles zusammen zu verkleinern.

**Abnahme:** Bei 320/390 px sind Aussage und CTA als erster Schwerpunkt erkennbar; kein ungünstiger Wortrest und keine unnötigen Trennungen. Ein kleineres H1 kann in Spezialfällen sinnvoll sein, braucht hier aber eine klare kompositorische Begründung.

**Quellen:** `resources/css/00-tokens.css:22–24`; `resources/css/09-local-pages.css:151–171,226–234`; gemessene Schriftgrößen.

### A08 · P2/P3 · Typografische Rollen statt vieler lokaler Größen festlegen

**Ist-Zustand:** H1/H2/H3-Tokens sind vorhanden. Daneben existieren 38 verschiedene `font-size`-Deklarationswerte einschließlich `inherit`, Tokenreferenzen und `clamp()`-Ausdrücken. Acht Schriftgewichte und zahlreiche Zeilenhöhen verteilen sich über die Module. Basisbuttons liegen bei 13,12 px, Desktop-Dropdownlinks bei etwa 12,48 px, Stepperbeschriftungen bei etwa 11,68 px. H3 liegt mobil oft nur bei 16,8 px gegenüber 16 px Body.

**Bewertung:** Die Anzahl allein beweist keinen sichtbaren Fehler. Zusammen mit unterschiedlich großen Aktionsbeschriftungen, sehr kleinen Metatexten und der Start-H1-Ausnahme zeigt sie jedoch fehlende Rollenabgrenzung.

**Ändern:** Rollen für Display/H1, Section H2, Card H3, Lead, Body, Label, Meta und Action definieren. Für Kernaktionen eher 14–16 px prüfen. Meta darf kleiner sein, muss aber lesbar und untergeordnet bleiben. Gewichte reduzieren; 650/750 sind je Systemschrift nicht garantiert eigenständige sichtbare Stufen.

**Beibehalten:** Systemschrift, flüssige Skalierung und grundsätzliche H1/H2/H3-Staffelung. Footer-H2 muss optisch nicht so groß wie eine Section-H2 werden.

**Abnahme:** Start, Service, Ort, Kontakt und Angebot zeigen dieselben erkennbaren Rollen. Lange deutsche Bezeichnungen bleiben bei 320 px und 200 % Vergrößerung verständlich.

**Quellen:** `resources/css/00-tokens.css:22–24`; `resources/css/01-base.css:11–18,94–118`; `resources/css/02-components.css:12,187,215`; `resources/css/05-offer-form.css:92,148`. Diese Werte bezeichnen die jeweiligen CSS-Rollen; die zusätzlich wirksame Label-Kaskade auf Auswahlkarten ist in A23 beschrieben.

### A09 · P2 · Gleich große Karten erzeugen wenig geschäftliche Priorität

**Ist-Zustand:** Acht Startleistungen erhalten dasselbe Kartenformat, große Icons und ähnliche Mindesthöhen. Bei 390 px ist das Kartenraster etwa 2568 px hoch; die gesamte Leistungssektion inklusive Überschrift, Abständen und „Alle Leistungen“-Aktion umfasst etwa 2851 px. Die drei Städte werden danach ebenfalls als gleichwertige Karten präsentiert. Introargumente erhalten nochmals eigene Boxen.

**Wirkung:** Die Gestaltung vermittelt vor allem Angebotsbreite. Häufige Anliegen, passende Zielgruppen und der wichtigste nächste Schritt heben sich kaum ab. Viele Container erzeugen eine Folge gleicher visueller Einheiten.

**Ändern:** Mit echten Anfragedaten zwei bis drei Haupteinstiege bestimmen oder nach einer verständlichen Nutzerentscheidung gliedern, etwa regelmäßig/einmalig. Weitere Leistungen kompakter erreichbar halten. Unterschiedliche Bedeutung durch Gruppierung, Flächenanteil und Reihenfolge ausdrücken; nicht jede Stärke braucht eine eigene Karte.

**Abnahme:** Ein neuer Besucher kann die passende Leistungsgruppe schnell wählen. Alle acht Leistungen bleiben auffindbar. Keine fachliche Priorisierung allein aus Designgeschmack ableiten.

**Quellen:** `public_html/index.php:10–40`; `resources/css/03-pages.css:40–54,135–161`; `resources/css/04-responsive.css:305–328`.

### A10 · P1 · Links im Fließtext müssen ohne Hover erkennbar sein

**Ist-Zustand:** Die globale Regel übernimmt die Textfarbe und entfernt Unterstreichungen. Nicht alle Inhaltsbereiche ergänzen einen Ersatz. Beispiele sind das „Angebotsformular“ im Kontaktintro und Ortslinks im Über-uns-Text. Sie sehen beim Lesen wie normaler Text aus.

**Ändern:** Inhaltslinks dauerhaft unterstreichen, mit ruhigem Offset und klaren Hover-/Fokuszuständen. Navigations-, Button- und Kartenmuster separat behandeln. Nur Blau reicht nicht überall: Primary-Blau gegenüber dem Standardtext erreicht lediglich etwa 2,74:1 Farbunterschied.

**Abnahme:** Links sind beim Lesen ohne Mausbewegung und in Graustufen auffindbar. Keine pauschale Unterstreichung sämtlicher Header- oder Buttontexte.

**Quellen:** `resources/css/01-base.css:32–35`; `public_html/kontakt/index.php:8`; `public_html/ueber-uns/index.php:8`; `public_html/datenschutz/index.php:12`.

### A11 · P1 · Fokuslinien brauchen auf hellen Flächen mehr Kontrast

**Ist-Zustand:** Der globale 3-px-Ring ist gelb `#ffbf00`, mit 3 px Abstand. Gegen Weiß erreicht er 1,65:1, gegen Surface-soft 1,47:1. Auf Navy funktioniert Gelb mit 8,77:1 deutlich besser. FAQ setzt den Ring innen auf die weiße Karte.

**Ändern:** Auf hellen Flächen einen dunkleren Ring oder eine zweifarbige Lösung verwenden; Gelb auf dunklem Header kann bleiben. Stärke und Abstand sind grundsätzlich brauchbar. Bei `overflow:hidden` gezielt auf abgeschnittene Ringe achten.

**Abnahme:** Auf Weiß, Grau, Blau und Navy ist der Fokus deutlich sichtbar; für den notwendigen Zustandsindikator 3:1 zur angrenzenden Fläche prüfen. Das ist eine gezielte Zustandskorrektur, keine Begründung für eine neue Markenpalette.

**Quellen:** `resources/css/01-base.css:64–67`; `resources/css/07-gallery-faq.css:80–82`.

### A12 · P1 · Der Foto-Upload hat einen unsichtbaren Tastaturfokus

**Ist-Zustand:** Im Terminschritt erreicht Tab das Dateiinput `#photos`. Der Browser bestätigt `:focus-visible` und einen gelben Ring; das Input liegt jedoch mit `opacity:0` über der Uploadzone. Auch der Ring verschwindet dadurch. Der sichtbare Container hat keinen Ersatzring oder Schatten.

**Ändern:** Deutlich sichtbaren Fokus an der Uploadzone, beispielsweise über `:focus-within`, ergänzen. Native Eingabe, Labelbeziehung, Dateifilter und große Klickfläche erhalten.

**Abnahme:** Mit Tab vom Terminhinweis zum Upload ist vor Öffnen des Dateidialogs klar erkennbar, wo der Fokus liegt. Bei 100/200 % Zoom und auf heller Fläche prüfen.

**Quellen:** `public_html/angebotsanfrage/index.php:171–180`; `resources/css/05-offer-form.css:341–367`; gezielter Keyboard-Browsertest.

### A13 · P1 · Eingabefelder benötigen stärkere funktionale Grenzen

**Ist-Zustand:** Weiße Felder auf weißer Fläche nutzen eine 1-px-Kontur `#dce5ec`. Sie erreicht 1,28:1 gegen Weiß und 1,13:1 gegen Surface-soft. Der gleiche helle Token dient auch dekorativen Kartenrändern.

**Wirkung:** Die Ausdehnung noch leerer, nicht fokussierter Eingaben ist schwach erkennbar. Sichtbare Labels helfen bei der Benennung, ersetzen aber nicht die Feldgrenze.

**Ändern:** Einen eigenen Token für funktionale Feldkonturen verwenden. Kartenränder und dekorative Linien können hell bleiben. Alternativ eine klar erkennbare Feldfläche vorsehen, die die Grenze ausreichend trägt.

**Abnahme:** Leere Inputs, Selects und Textareas sind ohne Fokus deutlich als Eingaben identifizierbar. Für erforderliche UI-Grenzen 3:1 prüfen. Fehler- und Fokuszustand zusätzlich erhalten.

**Quellen:** `resources/css/00-tokens.css:15`; `resources/css/03-pages.css:222–230`.

### A14 · P2 · Lesebreite und Layoutbreite als getrennte Rollen behandeln

**Ist-Zustand:** `.narrow` erlaubt bis 870 px und wird unter anderem für Rechtstexte verwendet. Der reguläre Contentcontainer ist bis 1240 px breit. Leistungsartikel sind teils länger als die Begleitkarte. Oberhalb 980 px folgt die Karte innerhalb des Grids sticky; bis 980 px ist sie statisch. Besonders zwischen 821 und 980 px sollte deshalb geprüft werden, ob die verbleibende zweispaltige Anordnung die Textlänge sinnvoll trägt.

**Ändern:** Für lange Prosa einen eigenen Richtwert von etwa 60–75 Zeichen pro Zeile prüfen. Grid-/Bildcontainer können breiter bleiben. Vor Eingriffen in Begleitbereiche zuerst Stickyverhalten, Kartenhöhe und tatsächliche Scrollansicht prüfen; keinen neuen Inhalt allein zum Füllen von Weißraum ergänzen. Basistext perspektivisch relativ skalieren, da `body` derzeit fest 16 px nutzt.

**Abnahme:** Rechtstext und lange Serviceabschnitte lassen sich ohne übermäßig weite Augensprünge lesen. Erhöhte Browser-Standardschrift und 200 % Textvergrößerung bleiben kohärent. Die Pixelbreite allein wird nicht als Nachweis einer unlesbaren Zeilenlänge gewertet.

**Quellen:** `resources/css/00-tokens.css:13`; `resources/css/01-base.css:16,121–123`; `resources/css/02-components.css:412–417`; `resources/css/06-service-pages.css:94–97,135–138`; `public_html/datenschutz/index.php:8`.

### A15 · P2 · Die Leistungsübersicht zeigt zwei Kataloge hintereinander

**Ist-Zustand:** Vor den acht verlinkten Fotokarten stehen vier Gruppen mit insgesamt 30 Leistungsnennungen. Die 30 Begriffe sind reine Listenpunkte, keine unmittelbaren Links. Die Fotokarten folgen später mit H3, ohne eigenen klaren H2-Einstieg für diesen Auswahlbereich. Die globale Navigation bietet bereits Leistungsziele; dieser Befund betrifft die Auswahl im Hauptinhalt.

**Wirkung:** Im Hauptinhalt steht der Breitenkatalog vor der verlinkten Hauptauswahl. Die Gruppen und tatsächlichen Detailziele passen nicht vollständig zusammen. Sehr spezielle Nennungen wie Reinraum- oder Wasserschadenreinigung wecken zusätzliche Erwartungen.

**Ändern:** Die acht Hauptleistungen früh als primäre Navigation anbieten. Spezialarbeiten kompakt unter den passenden Gruppen erläutern oder bei Bedarf aufklappen. Leistungsumfang und Voraussetzungen spezieller Angebote fachlich bestätigen. Kartenbereich strukturell und sichtbar benennen.

**Beibehalten:** Verständliche Anwendungsgruppen und die vorhandenen acht Detailziele; keine neue Seite für jeden Listenbegriff allein zur Vergrößerung des Katalogs.

**Abnahme:** Eine Person mit konkretem Anliegen erreicht die passende Detailseite ohne vorher 30 Punkte lesen zu müssen. Zusätzliche Arbeiten bleiben auffindbar und fachlich korrekt eingeordnet.

**Quellen:** `public_html/leistungen/index.php:8–13`.

### A16 · P2 · Portraitvideos sollten Antworten belegen, statt sie zu verzögern

**Ist-Zustand:** Sechs der acht Detailseiten starten ihren Artikelbody mit einem 9:16-Video vor dem ersten sachlichen H2. Bei 380 px Breite wird allein der Frame bis etwa 676 px hoch. Büro und Entrümpelung beginnen dagegen direkt mit Leistungsinformationen.

**Ändern:** Erst kurz erklären, was enthalten beziehungsweise abzustimmen ist, und den Anfrageweg zeigen. Anschließend Video dort platzieren, wo es ein Verfahren oder Ergebnis nachvollziehbar macht. Desktop gegebenenfalls kompakter neben erklärendem Text; Mobile mit bewusstem Verhältnis zum Textumfang.

**Beibehalten:** Praxisbezug, Poster, freiwilliger Start, Controls und `playsinline`. Keine Wiedergabefehler aus Ladesymbolen in Einzelbildern ableiten.

**Abnahme:** Die erste konkrete Leistungsantwort ist ohne Durchscrollen eines langen Medienblocks erreichbar. Wer das Video überspringt, versteht das Angebot weiterhin vollständig.

**Quellen:** `content/services/{glas-und-fensterreinigung,grundreinigung,teppichreinigung,polsterreinigung,fassadenreinigung,solaranlagenreinigung}/body.php:1`; `resources/css/06-service-pages.css:2–41`.

### A17 · P2 · Die Galerie braucht Auswahl und erklärenden Projektkontext

**Ist-Zustand:** Acht große Portraitvideokarten stehen mobil untereinander; Gesamthöhe etwa 8661 px. Die ersten drei behandeln Glas/Fenster. Überschriften und Beschreibungen ähneln sich („in der Praxis“, „kurzer Einblick“). Die Seite bezeichnet das Material selbst als beispielhafte Arbeitssituationen.

**Ändern:** Frühe Themenübersicht oder Sprunglinks; zunächst unterschiedliche Leistungen zeigen. Kurze Bildunterschriften mit belegter Objektart, Aufgabe, Verfahren und beobachtbarem Ergebnis. Bereits innerhalb der langen Strecke eine passende Anfrage ermöglichen. Beispiele nicht ungeprüft in konkrete Kundenreferenzen umbenennen.

**Medienbudget:** Im Repository liegen acht Videos mit zusammen ca. 27,22 MiB; die größten Einzeldateien sind Fassade ca. 6,55 MiB und Solar ca. 5,57 MiB. Das ist **nicht** die gemessene Anfangslast einer Seite: `preload="none"` ist bereits sinnvoll. Spätere Optimierung anhand tatsächlicher Abrufe, Videodauer und langsamer Verbindung prüfen. 60 Bilddateien umfassen zusammen ca. 8,46 MiB; auch dies ist kein Seitenladebudget.

**Abnahme:** Ohne acht Videos abspielen zu müssen, lässt sich Relevanz erkennen. Poster und Beschriftung vermitteln den Inhalt. Keine Autowiedergabe. Relevante Audioinformationen benötigen eine Text-/Untertitelalternative; Vorhandensein relevanten Tons wurde nicht geprüft.

**Quellen:** `public_html/galerie/index.php:8–93`; `resources/css/07-gallery-faq.css:2–28`; Dateigrößen der lokalen Assets.

### A18 · P2 · Die Marke braucht sichtbare Belege für ihre allgemeinen Aussagen

**Ist-Zustand:** Klare Absprachen, flexible Zeiten und Kontrolle auf Wunsch werden mehrfach erläutert. Im sichtbaren Unternehmensinhalt treten konkrete Menschen, benannter Ansprechpartner, nachvollziehbarer Objektfall und freigegebene Referenzen kaum hervor. Referenzen werden auf Anfrage angeboten.

**Wirkung:** Der Auftritt ist seriös, aber austauschbar. Die große Bildfläche schafft Atmosphäre, während die Gründe für die konkrete Anbieterwahl abstrakt bleiben.

**Ändern:** Einen kompakten belegbaren Vertrauensbereich priorisieren: tatsächlicher Ansprechpartner mit Rolle, echter Arbeitsablauf, freigegebener Fall mit Umfang/Ergebnis oder relevante nachweisbare Qualifikation. Auf Über uns und Jobs stärker das konkrete Unternehmen zeigen. Bildherkunft und Einwilligungen vor Veröffentlichung entsprechender Belege prüfen.

**Beibehalten:** Sachliche Formulierungen und ehrliche Auftragsgrenzen. Keine Kundenlogos, Sterne, Jahreszahlen, Mitarbeitendenzahlen, Zertifikate oder Garantien erfinden. Aus dem Bildstil lässt sich keine Stock-/KI-Herkunft beweisen.

**Abnahme:** Mindestens ein konkreter, überprüfbarer Grund für die Anbieterwahl steht vor dem Abschluss. Herkunft und Aussage des Belegs sind intern bestätigt.

**Quellen:** `public_html/index.php:10`; `public_html/ueber-uns/index.php:8`; Service-Summaries und lokale Inhalte.

### A19 · P2 · Lokale Seiten benötigen eigenständigen Nutzwert

**Ist-Zustand:** Alle neun lokalen Seiten nutzen ähnliche Leistungs-, Zielgruppen- und Planungsabschnitte sowie je drei FAQs. Bei Büro- und Fensterseiten unterscheiden sich häufig eher Ortsnamen als die Entscheidungshilfe. Einige weiterführende Linkabschnitte erläutern im Fließtext die Seitenorganisation („Diese Seite behandelt gezielt …“).

**Ändern:** Tatsächlich vorhandene lokale Informationen vorziehen: Einsatzbeispiele, logistische Besonderheiten, bestätigte Abdeckung oder Terminregeln. Fehlen solche Fakten, kürzer und klarer bleiben. Die Gliederung nicht mit allgemein gültigen Serviceerklärungen vervielfachen. Interne Seitenlogik durch nutzerbezogene Formulierungen ersetzen.

**Beibehalten:** Brühl als Firmensitz ausdrücklich nennen; Köln/Bonn bleiben Einsatzgebiete. Ortsverknüpfungen als Orientierung erhalten, nach erfolgter Ortswahl aber sekundär behandeln.

**Abnahme:** Jede Ortsseite beantwortet mindestens eine konkrete örtliche Frage zusätzlich zur allgemeinen Service-Seite oder ist bewusst als kompakte lokale Einstiegsseite gestaltet. Keine neuen Standorte oder Leistungszusagen erfinden.

**Quellen:** `app/templates/location-template.php:17–20`; `content/locations/bueroreinigung-{bruehl,koeln,bonn}.php:2–10`; `content/locations/fensterreinigung-{bruehl,koeln,bonn}.php:2–10`; `content/locations/gebaeudereinigung-{bruehl,koeln,bonn}.php:4–46`.

### A20 · P2/P3 · Wiederholte Planungsformeln durch klare Nutzerfragen ersetzen

**Ist-Zustand:** Umfang, Material, Zustand, Zugänglichkeit und „nach Vereinbarung“ erscheinen häufig im Lead, in Listen, Body und Sidebar. Auf Startseite wiederholt die Stärke „Klare Absprachen“ einen Teil des Leads.

**Ändern:** Jede Seite anhand von vier Fragen gliedern: Für wen/was geeignet? Was wird gemacht und was vorher geprüft? Wie läuft die Abstimmung ab? Wie starte ich? Leistungsunterschiede konkretisieren und Wiederholungen bündeln. Für Preisunsicherheit kann ein fachlich validiertes Muster des Angebotsaufbaus helfen, auch ohne Preiszahl.

**Beibehalten:** Nützliche Leistungslisten, Materialgrenzen und bedingte Zusagen. Nicht jede Wiederholung ist überflüssig; Sidebar und Haupttext dürfen für unterschiedliche Lesepfade kurz überlappen.

**Abnahme:** Jeder Abschnitt beantwortet eine neue Frage. Kein erfundener Einheitspreis und keine allgemeine Garantie aus einer bedingten Formulierung.

**Quellen:** `public_html/index.php:10`; `config/services/solaranlagenreinigung.php:17–20` als Beispiel eines Service-Leads; `content/services/*/body.php`; `content/services/*/summary.php`; allgemeine Preis-FAQ in `public_html/faq/index.php:8`.

### A21 · P2 · Die Anfrage soll ihr Versprechen „Nur relevante Angaben“ genauer einlösen

**Ist-Zustand:** Leistungsspezifische Panels funktionieren und reduzieren den Umfang. Davor stehen jedoch universell Objektart, Stockwerk und Möblierung – auch bei reiner PV-Anfrage. Objektfirma und Auftraggeberfirma werden an getrennten Stellen erfragt. Im geprüften Fensterfall enthält Schritt 2 inklusive Schätzoption 13 sichtbare Eingabeelemente.

**Ändern:** Etage/Möblierung nur bei passenden Leistungen zeigen; Zusatzfelder bei Bedarf anbieten. Auftraggeber und Objekt verständlich unterscheiden und Übereinstimmung einfach übernehmen lassen. Neun Servicekarten im ersten Schritt kompakter gestalten, ohne ihre großen Trefferflächen zu verlieren.

**Implementierungspräzisierung:** `object_type` ist im Markup und im PHP-Handler für jede Angebotsanfrage verpflichtend; nicht allein per CSS verstecken. Sichtbarkeit, `disabled`/`required`, Schrittvalidierung, Review und E-Mail-Zeilen müssen zusammenpassen. Etage existiert aktuell als allgemeines `floor` und zusätzlich als `clearance_floor` im Entrümpelungsbereich. Eine spätere Zusammenlegung darf widersprüchliche Doppelangaben nicht nur optisch kaschieren. Bestehende POST-Feldnamen werden über eine Allowlist geprüft; neue Felder benötigen eine abgestimmte Schemaänderung.

**Beibehalten:** Mehrfachauswahl, PLZ/Ort statt zwingender Volladresse, optionales Telefon, freiwillige Fotos und „Weiß ich nicht – bitte vor Ort einschätzen“.

**Abnahme:** Szenarien Fenster privat, Büro regelmäßig, Polster und PV enthalten keine offensichtlich sachfremden Felder. Mehrfachaufträge bleiben vollständig erfassbar. Die Angabe „2–3 Minuten“ mit diesen Szenarien zeitlich prüfen; bisher wurde keine reale Bearbeitungszeit gemessen.

**Quellen:** `public_html/angebotsanfrage/index.php:13–19,53–75,137–145,153–200`; `public_html/assets/js/forms/offer-form.js:149–167,304–310,361–390`; `app/forms/contact-handler.php:87–90,176–186,297–303,363–370`; `config/forms/schemas.php`; `resources/css/05-offer-form.css`.

### A22 · P2 · Der Stepper soll aktuell und erledigt unterscheiden

**Ist-Zustand:** Das Skript gibt allen bisherigen und dem aktuellen Schritt dieselbe Klasse `active`. Im fünften Schritt sind alle fünf Zahlen gleich blau. Mobile verschwinden die Textlabels; übrig bleiben Zahlen. `aria-current="step"` fehlt. Die Abschnittsüberschrift und eine Live-Region benennen den Schritt bereits korrekt.

**Ändern:** Aktuell, erledigt und kommend visuell unterscheiden, etwa Haken für erledigt und deutliches Label für aktuell. Aktuellen Schritt semantisch markieren. Anzeigen nicht wie frei anklickbare Schaltflächen gestalten, solange sie nicht navigierbar sind.

**Abnahme:** Auch in Schritt 4 ist die aktuelle Station ohne Interpretation mehrerer gleichfarbiger Kreise sofort erkennbar. Mobile bleibt mindestens die aktuelle Bezeichnung sichtbar. Bestehende Live-Ankündigung, Fokus auf Abschnittsüberschrift und Review-Rücksprung bleiben erhalten.

**Quellen:** `public_html/angebotsanfrage/index.php:24–29`; `public_html/assets/js/forms/offer-form.js:7–28`; `resources/css/05-offer-form.css:75–137,480–482`.

### A23 · P2/P3 · Formular-Mikrotypografie braucht weniger gleich starke Hervorhebungen

**Ist-Zustand:** Labels, optionale Zusätze, Kartentitel und Datenschutztext verwenden viel Fettschrift. Bei 390 px kann der Pflichtstern der Leistungsfrage eine eigene Zeile bilden. Checkbox und lange Datenschutzerklärung wirken stellenweise vertikal getrennt. „Ändern“ und „Entfernen“ sind kleiner als die Hauptaktionen, mit ungefähr 35 px Höhe.

**Bestätigte Ursache in der CSS-Kaskade:** `.field label` ist spezifischer als `.service-choice` und `.estimate-option`. Die generische Regel setzt daher auch auf den Auswahlkarten `display:block`, 13,76 px und Gewicht 800 durch, obwohl `.service-choice` ein Flexlayout vorsieht. Im aktuellen Chromium-Rendering wird der Kartentitel durch `<b>` sogar mit Gewicht 900 und der Zusatztext mit ungefähr 11,47 px/800 dargestellt. Beim Schätzlabel werden beabsichtigte `.82rem`/700 durch `.86rem`/800 ersetzt. Ein späteres Stylesheet allein gewinnt nicht gegen den spezifischeren Selektor. Die Privacyzeile verwendet außerdem umbrechendes Flexlayout ohne ausreichend geführte Labelbreite; Checkbox und Text stehen im geprüften Zustand auch auf Desktop untereinander.

**Ändern:** Zuerst die Label-Regeln auf ihren tatsächlichen Zweck begrenzen beziehungsweise die Komponenten gezielt absichern, dann Frage → Option → Zusatz staffeln. Erläuterungen normal gewichten; Pflichtmarkierung an die Frage binden oder einmal zentral erklären. Checkbox und Erklärung optisch als zusammengehörige Einheit ausrichten. Für häufige Touch-Hilfsaktionen ungefähr 44 px komfortable Trefferfläche anstreben. Die ganzen Auswahlkarten bleiben anklickbare Labels.

**Abnahme:** Bei 320/390 px keine alleinstehende Pflichtmarkierung und klare Zuordnung der Datenschutzbestätigung. Hilfsaktionen sind leicht treffbar. Die rund 35 px großen Aktionen werden hier nicht pauschal als Verstoß gegen das 24-px-AA-Mindestziel bewertet.

**Quellen:** `resources/css/03-pages.css:215–230,245–260`; `resources/css/05-offer-form.css:164–166,221–266`; `resources/css/08-offer-conversion.css:10–24,133–143`; `public_html/angebotsanfrage/index.php:34,199–200`; erneute berechnete Browserstile bei der Gegenprüfung.

### A24 · P2 · Nach dem Versand sollte ein eigenständiger Erfolg sichtbar bleiben

**Ist-Zustand aus Code:** Nach erfolgreicher Serverantwort setzt das Skript das Formular zurück, springt zu Schritt 1 und zeigt eine Statusmeldung. Es folgt kein eigener Abschlusszustand. Die Rückmeldeerwartung bleibt allgemein („in Kürze“). Dies wurde ohne echten Versand nur anhand des Codes geprüft.

**Implementierungspräzisierung:** Drei Beteiligte bilden den aktuellen Resetvertrag: `main.js` ruft `form.reset()` auf und sendet `form:success`; der erste Block in `offer-form.js` springt auf Schritt 1 und fokussiert dessen H2; der zweite Block synchronisiert Schätzwerte, Panels, Termin, Upload und Review neu. Eine Angebots-Erfolgsansicht muss diese Reihenfolge bewusst ersetzen und bereinigen. Das separate Kontaktformular darf dabei seinen bestehenden Nachrichtenstatus behalten.

**Ändern:** Klare Bestätigungsansicht mit gesendeter Anfrage, nächstem tatsächlichem Bearbeitungsschritt und Kontaktmöglichkeit bei Rückfragen. Eine neue Anfrage erst auf bewusste Aktion öffnen. Nur eine betrieblich zugesicherte Antwortfrist oder tatsächlich vorhandene Bestätigungsmail versprechen.

**Abnahme:** In einer späteren isolierten Testumgebung Erfolg und Fehlerantwort simulieren: erfolgreiche Anfrage bleibt eindeutig bestätigt; bei Fehlern bleiben Angaben erhalten und die nächste Handlung ist klar. Keine produktive Testanfrage für eine reine Designkontrolle verschicken.

**Quellen:** `public_html/assets/js/core/main.js:177–239`; `public_html/assets/js/forms/offer-form.js:65–68`; `app/forms/contact-handler.php:434–435`.

### A25 · P2 · Kontakt soll direkte Erreichbarkeit früh zeigen

**Ist-Zustand:** Mobil folgt die Karte mit Telefon, E-Mail und Zeiten erst nach dem gesamten Formular. Der erste Formularlabel liegt ungefähr bei y 1053. Davor stehen Foto, Breadcrumb, H1 und zwei erklärende Absätze. Der Link zur ausführlichen Anfrage ist im Fließtext unauffällig.

**Ändern:** Am kompakten Einstieg Kontaktwahl und Erreichbarkeit anbieten: anrufen, schreiben, allgemeine Nachricht. Kurz erklären, wann das umfangreichere Angebot sinnvoll ist. Danach das schlanke Formular. Keine gleich lauten Hauptbuttons für alle Kanäle gleichzeitig.

**Beibehalten:** Name, E-Mail und Nachricht als zentrale Pflichtangaben plus Datenschutz; Telefon optional; vollständige Geschäftsdaten und Öffnungszeiten. Kontaktdaten müssen nicht hinter einem Akkordeon verschwinden.

**Abnahme:** Mobile Nutzer finden Telefon/E-Mail ohne das Formular durchscrollen zu müssen. Allgemeine Frage und konkrete Angebotsanfrage sind klar unterscheidbar.

**Quellen:** `public_html/kontakt/index.php:8`; `resources/css/03-pages.css:199–203`; `resources/css/04-responsive.css:209–213`; Mobileprüfung.

### A26 · P2 · Jobs braucht eine eigene primäre Bewerbungsaktion

**Ist-Zustand:** Die Bewerbung per E-Mail steht erst im Abschlussband. Global dominieren Angebots-CTA und WhatsApp. Der eigentliche Jobtitel beginnt spät; ein kompakter Stellenfaktenblock fehlt. Der Start ist bereits als „zum nächstmöglichen Zeitpunkt“ genannt, ebenso ein unbefristeter Vertrag und übertarifliche Bezahlung. Vor allem Arbeitsumfang, konkrete Einsatzregion und Bewerbungsablauf sind nicht als rasch erfassbare Stellenfakten aufbereitet. Die Seitenkarte fokussiert eher den Firmensitz.

**Ändern:** Bewerbung direkt nach Jobtitel/Kurzprofil und erneut am Ende anbieten. Freigegebene Stellenfakten und benötigte Unterlagen übersichtlich nennen. Sales-CTA auf dieser Seite zurücknehmen; allgemeine Navigation erhalten. Tatsächliches Team/Arbeitsumfeld als Arbeitgeberbeleg wäre hilfreicher als ein weiteres allgemeines Reinigungsmotiv.

**Beibehalten:** Verständlicher Titel, kurze Aufgaben-/Anforderungslisten und einfacher Mailweg mit Betreff. Keine unnötig große Bewerbungsstrecke einführen.

**Abnahme:** Bewerber können früh entscheiden, ob die Stelle grundsätzlich passt, und unmittelbar den nächsten Schritt finden. Fehlende Beschäftigungsdaten geschäftlich bestätigen, nicht redaktionell erfinden.

**Quellen:** `public_html/jobs/index.php:8`; `content/ctas/jobs.php:1`; `app/templates/header.php:56`; `app/templates/footer.php:13`.

### A27 · P2 · FAQ sollte schneller zu Fragen führen und nur einen aktiven Navigationspunkt haben

**Ist-Zustand:** Hero „FAQ“, Breadcrumb, Eyebrow, große H1 und Intro wiederholen die Orientierung vor der eigentlichen Liste. Mobil liegt die erste Frage ungefähr bei y 1000. Zusätzlich setzt die Seite sowohl „Über uns“ als auch „FAQ“ auf `aria-current="page"`; im Browser als zwei aktuelle Links bestätigt.

**Ändern:** Kompakter Titelbereich; erste Fragen direkt anschließend. Preis, Ablauf und Unverbindlichkeit nach tatsächlicher Nachfrage priorisieren. Nur FAQ als aktuelle Seite markieren. Bei späterem Wachstum thematisch gruppieren; derzeit sind zehn allgemeine Fragen noch überschaubar.

**Beibehalten:** Einspaltige ruhige Liste, große Fragezeilen, Plus/Minus und native `details/summary`. Kein komplexes Suchinterface ohne Bedarf.

**Abnahme:** Fragen sind früh erreichbar; öffnen per Maus und Tastatur; genau ein Hauptnav-Ziel ist aktuell. Fokuskorrektur aus A11 mit umsetzen.

**Quellen:** `public_html/faq/index.php:4,8`; `app/templates/header.php:11–14`; `resources/css/07-gallery-faq.css:31–82`; FAQ-Interaktionstest.

### A28 · P2 · Breakpoints stimmen CTA-Verfügbarkeit und Inhaltsgrid nicht vollständig ab

**Ist-Zustand:** Bis 1080 px verschwinden Header-CTA und Topbar-Telefon. Die zusätzliche Artikel-CTA auf Service-/Ortsseiten erscheint erst bis 980 px. Zwischen 981 und 1080 px gibt es daher weder Headeraktion noch diese frühe Artikelbox; die Sidebaraktion bleibt vorhanden, liegt aber weiter unten. Zwischen 821 und 980 px ist die zusätzliche CTA sichtbar, während der Hauptbereich zweispaltig bleibt und die Sidebar nicht mehr sticky ist. Bei 821 px ist die Artikelspalte etwa 447 px breit.

**Wirkung:** Die wichtigste Aktion und die Dichte der beiden Spalten verändern sich unabhängig voneinander. Das ist kein vollständiger Funktionsausfall, aber ein uneinheitlicher Lesepfad an Tabletbreiten.

**Ändern:** Für Header, Inhaltsgrid und Handlungsplatzierung gemeinsam festlegen, welcher CTA an jeder Breite führt. Den zusätzlich bestätigten H1-Sprung bei 980/981 px aus A07 im selben Durchgang beheben. Unterschiedliche Komponentenbreakpoints sind sinnvoll; sie sollten durch konkrete Inhaltsprobleme begründet sein. Nicht alle elf Breitenwerte pauschal auf einen reduzieren.

**Abnahme:** 820/821, 980/981 und 1080/1081 px vergleichen. Kein plötzlicher Verlust des frühen Anfragewegs, keine unnötig doppelte CTA-Box in enger Spalte, weiterhin kein Seiten-Overflow.

**Quellen:** `resources/css/04-responsive.css:27–60,160–213`; `resources/css/06-service-pages.css:94–100,135–164`; `app/helpers/render-components.php:26–29`; `app/templates/service-template.php:16`; `content/locations/gebaeudereinigung-koeln.php:6,27–32`; ergänzende Browsermessungen.

### A29 · P3 · Bei 1921 px wechselt die Bildkomposition abrupt

**Ist-Zustand:** Bis 1920 px verwenden die Hero-Bilder `object-fit:cover`; ab 1921 px `contain`, bei weiterhin maximal 680 px Hero-Höhe. Der Browservergleich bestätigt den Wechsel. Die Bildfläche erhält dadurch seitliche freie Zonen und eine andere Größenwirkung.

**Ändern:** Bewusst entscheiden, ob Ultrawide als eingefasstes Bild oder als flächiger Hero gestaltet wird. Falls eingefasst, Übergang und Hintergrund als sichtbare Komposition gestalten. Keine zufällig wirkenden Randflächen durch einen einzelnen Pixel Breitenänderung.

**Abnahme:** 1920/1921 und 2560 px zeigen eine nachvollziehbare, zusammenhängende Komposition. Aussage und CTA bleiben mit Motiv und Container ausgerichtet.

**Quellen:** `resources/css/09-local-pages.css:269–288`; berechneter und gerenderter Breitenvergleich.

### A30 · P2/P3 · Reduced Motion auch beim Nach-oben-Button berücksichtigen

**Ist-Zustand:** Die CSS-Regel reduziert Animationen und Übergänge bereits. Der Nach-oben-Button ruft jedoch ausdrücklich `scrollTo({ behavior:'smooth' })` auf. Eine CSS-Einstellung für `scroll-behavior` überschreibt diese API-Anweisung nicht zuverlässig.

**Ändern:** Vor programmgesteuertem Scrollen `prefers-reduced-motion` berücksichtigen. Im reduzierten Modus sofort springen. Kurze Hoverbewegungen dürfen im Standardmodus bleiben.

**Abnahme:** Bei aktivierter Bewegungsreduktion keine animierte Seitenfahrt durch die JS-Aktion; im Standardmodus kontrollierte Bewegung. Keine neue Animation einführen, um Hierarchieprobleme zu kompensieren. Bei der Gegenprüfung wurde die animierte Fahrt in Chromium mit emuliertem `prefers-reduced-motion: reduce` tatsächlich reproduziert; andere Browser und reale OS-Einstellungen bleiben zusätzlich zu prüfen.

**Quellen:** `resources/css/04-responsive.css:382–390`; `public_html/assets/js/core/main.js:10`; erneuter Chromium-Interaktionstest bei der Gegenprüfung.

### A31 · P2 · Formularhilfen auch semantisch mit ihren Feldern verbinden

**Ist-Zustand:** Telefonhinweis, Uploadbegründung und Dateigrenzen sind sichtbar, aber nicht vollständig über `aria-describedby` am zugehörigen Input angebunden. Das globale Skript ergänzt Beschreibungen für Fehlermeldungen, nicht für diese bestehenden Hinweise. Zusätzlich ist die sichtbare Uploadhilfe unvollständig: Sie nennt fünf Dateien und je 5 MB, verschweigt aber die in JavaScript und PHP gleichermaßen durchgesetzte Gesamtgrenze von 15 MB.

**Ändern:** Vollständige Uploadvorgaben sichtbar machen, stabile IDs für notwendige Hilfstexte und Beschreibungsreferenzen zusätzlich zu den Fehlerreferenzen setzen. Vorhandene Labels, Live-Regionen und Fehlerverknüpfungen erhalten. Stepperzustand aus A22 ergänzen. Bestehende Dateigrenzen nicht als reine Designänderung lockern.

**Abnahme:** Ein späterer Screenreadertest kündigt am Upload Format-/Anzahl-/Größenvorgaben und am Telefon den Zweck an, ohne doppelte Ansage. Relevante Hinweise bleiben auch visuell beim Feld.

**Quellen:** `public_html/angebotsanfrage/index.php:171–180,192`; `public_html/assets/js/core/main.js:129–142`; `public_html/assets/js/forms/offer-form.js:241–250`; `app/forms/photo-upload.php:10–25`.

### A32 · P3 · Footer verdichten, ohne seine Verlässlichkeit zu verlieren

**Ist-Zustand:** Der dunkle Footer schließt die Seite klar ab. Mobile folgt eine lange vertikale Strecke mit Logo, Unternehmensbeschreibung, Kontakt, Leistungslinks, Zeiten und erneutem Angebotsbutton. Inhalte wiederholen teilweise den vorhergehenden Abschluss.

**Ändern:** Abstände und Gruppen kompakter machen, wiederholte Aussagen reduzieren. Hauptaktion bereits vor dem Footer abschließen. Footer stärker als Kontakt-/Orientierungs- und Rechtsebene führen; Seitenzweck bei Jobs und Angebot berücksichtigen.

**Beibehalten:** Adresse, Telefon, E-Mail, Öffnungszeiten, Region und Rechtliches. Keine Pflicht, alles in Akkordeons zu verstecken. Navy/helles Logo und der klare Seitenschluss funktionieren.

**Abnahme:** Wesentliche Angaben bleiben ohne Rätsel erreichbar; der Footer überlagert nicht die Bedeutung des Final CTA. Mobile wirken die Gruppen zusammengehörig und nicht wie weitere vollständige Sektionen.

**Quellen:** `app/templates/footer.php:5–17`; `resources/css/03-pages.css:332–395`; `resources/css/04-responsive.css:339–354`; mobile Gesamtseitenansichten.

## 6. Farben, Formen und Layoutsystem

### Kontrastwerte und Farbrollen

Berechnet aus den definierten Farben nach relativer sRGB-Luminanz. Für normalen Text dient 4,5:1 als AA-Prüfwert, für große Schrift 3:1. Bei funktional erforderlichen UI-Grenzen/Zustandsindikatoren ist 3:1 ein Prüfwert; dekorative Linien müssen diesen Wert nicht pauschal erreichen. Die Tabelle ist keine vollständige Konformitätserklärung.

| Paar / Verwendung | Kontrast | Entscheidung |
|---|---:|---|
| `#172534` auf Weiß – Body | 15,55:1 | Behalten |
| `#526372` auf Weiß – Muted | 6,20:1 | Behalten |
| Weiß auf `#0d2b45` – Header/Footer | 14,50:1 | Behalten |
| Weiß auf `#0969b5` – Primary | 5,68:1 | Behalten |
| `#0969b5` auf `#edf5fa` | 5,15:1 | Behalten |
| `#6fa8d1` auf Navy – Footerüberschrift | 5,66:1 | Behalten |
| Weiß auf `#147a3a` – WhatsApp | 5,42:1 | Behalten; Prominenz reduzieren, wenn sekundär |
| `#9b001b` auf `#fff0f1` – Fehler | 7,88:1 | Behalten |
| `#6a7681` auf Weiß – inaktives Stepperlabel | 4,64:1 | Nicht weiter aufhellen |
| `#ffbf00` auf Weiß – Fokus | 1,65:1 | Ändern |
| `#ffbf00` auf `#eef2f5` – Fokus | 1,47:1 | Ändern |
| `#ffbf00` auf Navy – Fokus | 8,77:1 | Geeignet für dunkle Fläche |
| `#dce5ec` auf Weiß – Feldkontur | 1,28:1 | Funktionale Kontur ändern |

Das halbtransparente Start-Heropanel trägt die weiße Schrift wesentlich besser als ein ungeschützter Text auf Foto. Seine Fläche kann bleiben. Bei neuen Motiven und Varianten trotzdem den tatsächlichen Textkontrast inklusive halbtransparenter Subline prüfen.

### Formensprache und Abstände

Die vorhandenen Rollen sind sinnvoll: Kartenradius 16 px, Controls 10 px, pillenförmige Buttons, Section-Abstand `clamp(48px,6vw,84px)`, Layoutgap `clamp(24px,4vw,55px)`. Der große Abstand allein ist nicht das Problem. Zu viel Strecke entsteht, wenn sehr große Bilder, Breadcrumbs, Eyebrows, wiederholte Überschriften und große Kartenblöcke addiert werden.

Deshalb zuerst **Reihenfolge, Anzahl und Informationswert** der Elemente korrigieren, anschließend Abstände anpassen. Nicht alle Sektionen pauschal enger setzen. Große Icons dürfen Leistungen erkennbar machen; bei acht gleichgewichtigen Karten benötigen sie mobil weniger Eigenfläche. Die ruhige Linie der Icons passt zur Marke und kann bleiben.

Bei Interaktion konsequent zwischen Navigation, Aktion, Auswahl und Status unterscheiden: eine Servicekarte enthält einen weiterführenden Link; eine Formularkarte wählt aus; ein Stepper zeigt Zustand; ein Button löst die nächste Handlung aus. Im aktuellen Code ist der Service-Artikel selbst kein vollflächiger Link. Ortskarten enthalten mehrere verschiedene Ziele und dürfen nicht pauschal zu einem einzigen Kartenlink werden. Ähnliche pillen-/kartenförmige Flächen sollten diese Unterschiede nicht verwischen.

## 7. Seitenbezogene Entscheidungen

### Hauptseiten

| Seite | Als Nächstes ändern | Darf bleiben |
|---|---|---|
| Start | H1/CTA zusammenführen; Hauptleistungen priorisieren; belegten Vertrauenspunkt ergänzen; Ortsblock kompakter | Region, Ton, Hero-Motivfamilie, klare Leistungslinks, Abschlussband |
| Leistungen | Verlinkte Hauptauswahl vor 30 Textnennungen; Kartensektion klar überschreiben; Spezialangebote einordnen | Acht Zielseiten, Gruppierungsidee, unterschiedliche Leistungsbilder |
| Über uns | Tatsächliche Menschen/Unternehmen und Belege nach vorn; allgemeine Arbeitsweise kürzer; konkreter nächster Schritt | Ehrliche Absprachen, regionale Nähe, Referenzen nur nach tatsächlicher Freigabe |
| Galerie | Themenübersicht; verschiedene Leistungen früher; kompaktere Folge und erklärende Captions; früher Anfrageweg | Freiwillige Medien, Poster, Controls und Leistungslinks |
| FAQ | Bild-/Orientierungsaufbau verkürzen; nur FAQ aktiv markieren; wichtige Fragen früh | Native Aufklappung, große Frageflächen, einspaltige Lesestruktur |
| Jobs | Stellenfakten und Bewerbung am Einstieg; Recruiting statt Sales führen lassen | Kurze Listen, eindeutiger Jobtitel, einfacher E-Mail-Weg |
| Kontakt | Direktkontakte vor langem Formular; Kanalwahl und Angebotswechsel deutlich | Schlanke Pflichtdaten, vollständige Angaben und Öffnungszeiten |
| Angebot | Intro/WhatsApp kürzen; erster Schritt früher; Kontextvorwahl, relevante Felder, Zustände und Fokus verbessern | Mehrfachauswahl, Schätzen, freiwillige Fotos, Review und Editierbarkeit |
| Impressum | Lesebreite/Linkmerkmale bei späterer Typografiepflege prüfen | Direkter Textaufbau ohne dekorativen Foto-Hero |
| Datenschutz | Prosebreite, sichtbare Inhaltslinks, klare Zwischenüberschriften prüfen | Sachliche Textseite; keine rechtliche Bewertung in diesem Audit |
| 404 | Primären Rückweg passend zur Nutzerabsicht klar halten | Verständliche Fehlermeldung und zwei konkrete Rückwege |

### Leistungsdetails: gemeinsame Lösung, gezielte Unterschiede

Für alle acht gelten der frühe H1-/CTA-Einstieg, Kontextübernahme und ein klarer Abschluss. Die Tabelle beschreibt den zusätzlichen Schwerpunkt; keine acht unterschiedlichen Designsysteme aufbauen.

| Leistung | Besonderer Prüf-/Änderungsschwerpunkt | Behalten |
|---|---|---|
| Büro und Gewerbe | Frühe Information zu Turnus, Abläufen und Eignung; lange Bezeichnung in Karten/Navigation staffeln | Direkter Einstieg in Leistungsinhalt ohne vorgeschaltetes Portraitvideo |
| Glas und Fenster | Großes Video nach kurzer Umfangsantwort; Innen/außen, Rahmen/Falze und Zugänglichkeit übersichtlich unterscheiden | Konkrete Leistungscheckliste und passende Objektarten |
| Grund und Spezial | Video vor Leistungsumfang zurücknehmen; Anlässe und Grenzen klar gegenüber laufender Reinigung abgrenzen | Anlassbezogene Orientierung und objektspezifische Abstimmung |
| Teppich | Material, Flecken und Verfahren vor Medieninszenierung priorisieren; Wiederholungen bündeln | Materialgerechte, bedingte Aussagen statt Ergebnisgarantie |
| Polster | Auswahl/Umfang im Formular ergonomisch halten; Möbelzählung und allgemeine Objektdaten auf Relevanz prüfen | Unterschiedliche Möbelarten und freiwillige ergänzende Hinweise |
| Entrümpelung | Eignung, Zugang/Umfang und Anfragekontext klar zusammenführen | Direkter Inhaltsbeginn und eigene Leistungsidentität |
| Fassade/Graffiti | Untergrundprüfung früh erklären; Video als Beleg; größtes Video später unter langsamer Verbindung prüfen | Keine pauschale Zusage ohne Materialprüfung |
| Solar/PV | PV-spezifische Angaben nach vorn; Etage/Möblierung nicht ungeprüft universal zeigen; langes Label mobil prüfen | Zugänglichkeit, Modul-/Flächenangaben und vorsichtiger Materialbezug |

### Lokale Seiten: Matrix für die nächste Überarbeitung

| Ortsfamilie | Brühl | Köln | Bonn |
|---|---|---|---|
| Gebäudereinigung | Bereits genannten Firmensitz als tatsächlichen lokalen Anker erhalten und stärker gewichten | Bereits korrekte Unterscheidung Einsatzgebiet/Firmensitz erhalten; zusätzliche lokale Information nur belegt | Bereits korrekte Unterscheidung Einsatzgebiet/Firmensitz erhalten; zusätzliche lokale Information nur belegt |
| Büroreinigung | Standortbezug mit realem Büro-/Ablaufbeispiel prüfen | Konkreten lokalen Nutzwert ergänzen, wenn vorhanden | Konkreten lokalen Nutzwert ergänzen, wenn vorhanden |
| Fensterreinigung | Leistung und Ort im Anfragekontext übernehmen | Umfang/Zugänglichkeit und bestätigte Ortsinformation bündeln | Umfang/Zugänglichkeit und bestätigte Ortsinformation bündeln |

Alle neun wurden geprüft. Ohne belegte Ortsbesonderheiten ist eine kürzere Seite besser als erfundene Differenzierung. Vorhandene FAQ- und Regionalverlinkung erhalten, aber nicht vor jedem Abschluss nochmals einen großen Ortswechselkatalog bauen.

## 8. Zielhierarchie für die spätere Designarbeit

Diese Abläufe sind Empfehlungen, keine bereits umgesetzten Änderungen. Beispieltexte müssen vor Umsetzung fachlich bestätigt werden.

| Seitentyp | Empfohlene Reihenfolge |
|---|---|
| Start | Leistung + Region + Nutzen + Anfrage → kurze belegte Gründe → priorisierte Leistungen → Arbeits-/Projektbeleg → Einsatzgebiet kompakt → entscheidende Einwände → Final CTA |
| Leistung | H1/kurze Eignung + Anfrage → Umfang und Grenzen → Ablauf/Medienbeleg → passende Objekte → entscheidende Fragen → Final CTA → verwandte Links sekundär |
| Ort | Lokale Leistung + kontextuelle Anfrage → echte lokale Information → passende Leistungen → glaubwürdiger Ablauf/Fall → kurze Ortsfragen → Final CTA |
| Über uns | Tatsächliches Unternehmen/Menschen → Arbeitsweise mit Beleg → Region/Qualifikation → konkreter nächster Schritt |
| Kontakt | Kompakter Titel → direkte Erreichbarkeit und Anliegenwahl → kurzes Formular → hilfreiche Geschäftsdaten |
| Angebot | Kurzer Titel/Sicherheit + sichtbare Kontextvorwahl → aktuelle Aufgabe → relevante Details → Prüfung → eindeutiger Versand → eigener Erfolg |
| Jobs | Titel + bestätigte Stellenfakten + Bewerbung → Aufgaben/Anforderungen → Arbeitgeberbeleg → Ablauf/Kontakt → Bewerbungsabschluss |

### CTA-System

| Rolle | Gestalterische Regel | Mögliche Beschriftung |
|---|---|---|
| Globaler Primary CTA | Ein klarer Markenbutton, keine neue Aktionsfarbe | „Angebot anfordern“ |
| Kontext-CTA Leistung | Gleiches Ziel, Kontext sichtbar übernehmen | „Fensterreinigung anfragen“ |
| Final CTA auf Start-/Leistungs-/Ortsseiten | Konkreter Abschluss nach beantworteten Fragen; kurze Erwartung | „Kostenloses Angebot anfordern“ |
| Final CTA auf FAQ | Passende Hilfe bei weiter offenen Fragen | „Kontakt aufnehmen“ |
| Alternativer Kontakt | Visuell sekundär, externer Kanal erkennbar | „Alternativ per WhatsApp schreiben“ |
| Kontaktformular | Eindeutiger Nachrichtenauftrag | „Nachricht senden“ |
| Recruiting | Eigene primäre Aufgabe auf Jobs | „Bewerbung per E-Mail senden“ |
| Formularkontinuation | Nächste Station benennen | „Weiter zum Objekt“, „Angaben prüfen“ |

Nicht alle Beschriftungen müssen identisch sein. Entscheidend sind derselbe verständliche Angebotsprozess und stimmige Erwartung zwischen Button und Ziel. „Kostenlos/unverbindlich“ sollte dort stehen, wo es Unsicherheit reduziert; nicht als zusätzliche starke Textfläche in jedem Abschnitt.

## 9. Verbindliche Planungsreihenfolge nach der Gegenprüfung

Die ursprünglichen vier Themenpakete waren eine grobe Prioritätsübersicht. Sie werden durch den [detaillierten, codebasierten Batchplan](implementation-plan-final3.md) ersetzt. Insbesondere gehören Schrift-/Leserollen vor die endgültige Layoutabnahme, Ultrawide in den Hero-Umbau und alle drei Resetbeteiligten in denselben Formularabschluss-Batch. Eine späte reine Systempolitur würde bereits abgenommene Layouts erneut verschieben.

| Batch | Zusammengehöriger Implementierungsinhalt |
|---|---|
| B1 | Zugängliche Bedienzustände, Inhaltslinks, Feldgrenzen, Uploadhilfe und Label-Kaskade |
| B2 | Typografie-/Proserollen, gemeinsamer Seitenkopf, Hero- und Breakpointkomposition |
| B3 | Primary-/Final-CTA, nicht überlagernde Kontaktflächen und Footerrollen |
| B4 | Leistungswahl, Katalog und Reihenfolge der Leistungsantworten/Medien |
| B5 | Leistungs-/Ortskontext durch sämtliche Anfragewege bis ins Formular |
| B6 | Relevante Felder samt Frontend-, Server-, Review- und E-Mail-Vertrag |
| B7 | Formulareinstieg, Stepper, Reviewbedienung und vollständiger Erfolgszustand |
| B8 | Aufgabenbezogene Kontakt-, FAQ- und Jobsseiten |
| B9 | Belegte Unternehmens-/Galerieinhalte und ehrliche lokale Differenzierung |

Die Aufteilung folgt gemeinsamen Komponenten und Datenverträgen, keinem gewünschten Dateiumfang. B5 → B6 → B7 werden aufeinander aufbauend umgesetzt; fehlende neue Unternehmensbelege blockieren keine unabhängigen Bedienkorrekturen. Jede Einheit enthält eigene Abnahmekriterien. Eine abschließende Integrationsprüfung ist ein Prüftor, kein künstlicher zusätzlicher Änderungsbatch. Die ursprüngliche Audit-/Planungsphase setzte keinen Batch um; der aktuelle Umsetzungsstand ist am Dokumentanfang verlinkt.

### Verifikation nach einer späteren Umsetzung

- Start, Leistungsübersicht, Service, Ort, Kontakt, Angebot, FAQ, Jobs und Galerie bei 320/390, 768/820/821, 980/981, 1080/1081, 1440 und 1920/1921 px prüfen; nicht jede Änderung benötigt alle Routen.
- 200 % Textvergrößerung und 400 % Zoom beziehungsweise 320-CSS-px-Reflow auf den betroffenen Komponenten testen. Der hier gemessene 320-px-Layoutzustand ist noch kein vollständiger Zoom-/Textspacing-Test.
- Textabstände separat überschreiben: Zeilenhöhe mindestens 1,5, Absatzabstand 2 em, Buchstabenabstand 0,12 em und Wortabstand 0,16 em. Kein Inhalt oder Bedienelement darf dadurch abgeschnitten oder unbedienbar überlagert werden.
- Tastatur: Skiplink, Menü/Dropdown, Escape, FAQ, Leistungswahl, Weiter/Zurück, Upload, Review-Änderung und sichtbare Fokusposition.
- Screenreader gezielt für Labels, Hilfen, Fehler, aktuellen Schritt und Bestätigung; vollständige Prüfung mit passenden assistiven Technologien separat planen.
- Formulare mit Fenster-, Büro-, Polster-/PV- und Mehrfachleistung prüfen. Versand in einer isolierten Umgebung simulieren oder gezielt autorisiert testen.
- Ohne Autoplay, mit Reduced Motion und langsamem Netz Poster, Medienstart und Hilfszustände prüfen. Reale Mobilgeräte ergänzen, insbesondere Bildschirmtastatur und Safe Area.
- Bei vorhandenen Analytics später CTA-Sichtbarkeit, Anfragebeginn, Schrittwechsel und abgeschlossene Anfragen datenschutzgerecht vergleichen. Vorher keine prozentualen Conversionversprechen ableiten.

## 10. Prüfprotokoll und offene Nachweise

| Prüfung | Ergebnis / Grenze |
|---|---|
| Git-Ausgangspunkt | `final` aus Remote geladen; `final3` neu von `00f1fe3` erstellt |
| Websiteänderungen | Für dieses Audit nicht vorgenommen; Dokumentation ist der einzige vorgesehene Repository-Änderungsumfang |
| Seiten und Layout | 28 Routen auf Desktop/Mobile; 100 grundlegende Kombinationen plus gezielte Grenzbreiten |
| Horizontaler Overflow | In den 100 Kombinationen geprüft; kein horizontaler Seiten-Overflow festgestellt |
| Angebotsnavigation | Fensterfall bis Review auf Desktop/Mobile durchlaufen; „Ändern“ führt zurück zur Leistung |
| Leere Leistungswahl | Sichtbare Fehlermeldung „Bitte wählen Sie mindestens eine Reinigungsart aus.“ bestätigt |
| Unbekannte Fensteranzahl | Schätzoption in Review korrekt als Vor-Ort-Einschätzung dargestellt |
| FAQ | Öffnet; doppelte aktuelle Hauptnav-Markierung bestätigt |
| Menü | Öffnen/Schließen und Escape-Fokusrückkehr geprüft; keine vollständige Screenreaderprüfung |
| Upload | Tabfokus erreicht Input; durch Transparenz optisch unsichtbar, fehlender Containerersatz bestätigt |
| Bilder | Auffällige Lazy-Loading-Messungen auf Leistungen/Glas gezielt nachgeprüft: nach explizitem Decode gültig. Kein pauschaler Befund „Bilder kaputt“ |
| Videos | Darstellung, Poster und Markup geprüft; kein vollständiger Wiedergabe-/Audio-/Untertiteltest |
| Kontraste | Statische CSS-Farbpaare berechnet; keine vollständige Pixel-/Zustandsmatrix |
| Produktiver Versand | Nicht ausgeführt; Erfolgssicht aus Code bewertet |
| Bildherkunft, Referenzen, Zusagen | Vor späterer Veröffentlichung entsprechender Änderungen betrieblich zu bestätigen |
| Rechtstexte | Nur Lesestruktur/visuelle Darstellung betrachtet |
| Performance | Dateigrößen betrachtet; kein Lighthouse-/Web-Vitals-/Mobilfunkbenchmark |

Der Bericht ist als Entscheidungsgrundlage und Arbeitsliste für eine spätere Überarbeitung gedacht. **Die vorhandene Markenidentität, die ehrliche regionale Positionierung und die robuste Komponentenbasis sollten erhalten bleiben. Vorrang haben die Handlungsführung, die Relevanz der Inhalte und die sichtbar bedienbaren Zustände.**

## 11. Gegenprüfung gegen den tatsächlichen Code

Alle 32 Befunde wurden gegen die vorhandenen Templates, Inhaltsdateien, Konfigurationen und die aktive CSS-/JS-Kaskade gegengeprüft. Drei unabhängige Teilprüfungen wurden mit der Formular-/Serverprüfung zusammengeführt. Es gab keine Website-Codeänderung zwischen der ursprünglichen Messbasis `00f1fe3` und dem Dokumentationscommit `48273b0`. Die früheren 100 Layoutzustände wurden deshalb nicht vollständig erneut durchlaufen; gezielt wiederholt wurden unter anderem die Schrift-/Kartenmaße, Formular-Computed-Styles und der Reduced-Motion-Konflikt.

### Korrekturen und Präzisierungen

| Referenz | Aufgelöster Fehler / fehlende Abgrenzung | Jetzt dokumentierter Stand |
|---|---|---|
| A07/A28 | Zu enge Einordnung als mobiles Größenproblem | Auch Desktop-H1/H2-Verhältnis genannt; tatsächlicher 31,2→24,8-px-Sprung bei 980/981 px ergänzt |
| A09 | 2851 px als gemeinsame Kartenhöhe bezeichnet | Raster ca. 2568 px; ganze Leistungssektion ca. 2851 px |
| A14 | Rechts neben langen Artikeln pauschal Leerraum nach Kartenende angenommen | Oberhalb 980 px ist die Sidebar sticky; besonders die statische zweispaltige Zone 821–980 px beurteilen, keinen Füllinhalt planen |
| Kontrasttabelle | Rundung von `#6a7681`/Weiß auf 4,65 | Präzise auf zwei Stellen 4,64:1; Bewertung bleibt ausreichend für normalen Text |
| A23 | Mikrotypografie beschrieben, aber Ursache nicht erkannt | Spezifischere `.field label`-Regel überschreibt Auswahl-/Schätzkomponenten; reale Schriftwerte/Layout ergänzt |
| A30 | Nur möglicher Codekonflikt | Animiertes Nach-oben-Verhalten trotz emulierter Bewegungsreduktion in Chromium reproduziert |
| A31 | Sichtbare Uploadgrenzen implizit als vollständig behandelt | Fehlende 15-MB-Gesamtgrenze im Hilfstext ergänzt; JS und PHP setzen sie bereits durch |
| A21 | Relevanzempfehlung ohne vollständigen Datenvertrag | Universelle Serverpflicht für Objektart, zwei Etagenfelder, Schema-/Review-/Mailkopplung ergänzt |
| A24 | Erfolgssicht ohne vollständige Resetabhängigkeit | Globaler Submit und beide Formular-IIFEs müssen zusammen angepasst werden; Kontaktflow separat beachten |
| A05 | Kontextempfehlung ohne Render-/Schlüsselabgrenzung | Echte Formularschlüssel und statische Summaries genannt; allgemeine Gebäudereinigung übernimmt nur Stadt |
| A06 | Wiederholte WhatsApp-Aktion nur mit „häufig“ eingeordnet | Genau 9 von 23 Bändern betroffen; FAQ, Jobs und 5 bandlose Seiten als Ausnahmen erhalten |
| A15 | Auswahlbehauptung konnte globale Navigation einschließen | Auf Hauptinhalt begrenzt; alle 30 Textpunkte sind unverlinkt, 8 Detailziele folgen danach |
| A26 | Faktenblock konnte als fehlender Starttermin gelesen werden | Bereits vorhandenes „zum nächstmöglichen Zeitpunkt“, Vertrags- und Vergütungsaussage ausdrücklich erhalten |
| Ortsmatrix | Schon korrekte Ortsunterscheidung als neue Arbeit lesbar | Brühl/Firmensitz versus Köln/Bonn/Einsatzgebiet als vorhandene Stärke gekennzeichnet |
| Quellen/Rollen | Verkürzte CSS-Pfade, ungenaue Höhen-/Menü-/CTA-Belege; Kartenfläche mit Link gleichsetzbar | Pfade/Spannen ergänzt; vorhandene mehrzielige Karten nicht zu pauschalen Flächenlinks machen |
| Alter Fahrplan | Schriftrollen/Prose und Ultrawide zu spät; Formverträge verteilt | Abschnitt 9 durch abhängigen Neun-Batch-Plan ersetzt |

### Bestätigte Inventargrenzen

28 Routen, 8 Service-Detailseiten, 9 Ortsseiten mit insgesamt 27 lokalen FAQs, 10 allgemeine FAQ-Fragen, 30 Leistungslistenpunkte, 8 Hauptleistungskarten, 6 vorgeschaltete Servicevideos und 8 Galerieeinträge wurden erneut bestätigt. Es gibt 23 separate Abschlussbänder: 21 Angebotsabschlüsse, einen FAQ-Kontaktabschluss und einen Jobs-Bewerbungsabschluss. Kontakt, Angebot, Impressum, Datenschutz und 404 haben kein separates Band. 24 Seiten besitzen tatsächlich einen Foto-Hero: 23 über Konfiguration plus der eigene Start-Hero, dessen `hero`-Konfiguration selbst `NULL` ist.

Die Angaben zu 60 Bildern beziehen sich auf `public_html/assets/img`, ohne Branding-SVGs. Die acht Videodateien sind ein gemeinsamer Medienbestand, den Galerie und Leistungsseiten teilweise zusammen verwenden. Ihre Gesamtgröße ist weder Seitenanfangslast noch ein Nachweis langsamer Wiedergabe.

Die allgemeine FAQ-Seite besitzt eine zweite Antwortquelle im `FAQPage`-Schema ihrer Seitenkonfiguration. Die neun Ortsseiten besitzen dagegen aktuell nur Service-Schema; ihre lokalen FAQs liegen allein im Content. Eine spätere Textkorrektur darf deshalb keine vermeintlich vorhandene lokale FAQ-Schemakopie voraussetzen. Der Batchplan berücksichtigt diese Unterscheidung und erhält vorhandene frühe Mobile-CTAs während des Seitenkopfumbaus, bis der neue Aktionsbereich sie im selben Änderungsschritt ersetzt.

### Noch offene Abnahmen sind keine Code-Widersprüche

Fehlende freigegebene Menschen-/Projektbelege, echte Nachfrageprioritäten, spezielle Ortsfakten, zusätzliche Stellenangaben, eine garantierte Antwortfrist und die gemessene Anfragedauer bleiben fachliche beziehungsweise redaktionelle Abnahmen. Der Folgeplan benennt für jeden solchen Punkt eine sichere Arbeit mit bestehendem Inhalt und die verbleibende Nachweispflicht. Er erklärt sie nicht durch erfundene Angaben für erledigt.
