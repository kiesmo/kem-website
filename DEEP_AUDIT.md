# Design- und UX-Audit

## 1. Kurzes Gesamturteil, Prüfumfang und Einschränkungen

**Stand: 15. Oktober 2026.** Geprüft wurde die unveränderte Website von KEM Gebäudereinigung auf dem neu angelegten Branch `final4`, ausgehend von `final3`, Commit `3d09c3f68474841429f790810b6e1cba2b52ef6a`.

**Gesamturteil:** Der Auftritt unterstützt sein erkennbares Ziel bereits gut: Interessierte können Leistung und Einsatzgebiet verstehen und eine kostenlose, unverbindliche Anfrage stellen. Navigation, Seitenaufbau, Typografie und Anfrageformular bilden ein konsistentes System. Es gibt keinen belegten Anlass für eine grundlegende Neugestaltung. Das Audit identifiziert **eine notwendige Korrektur mittlerer Priorität** und **zwei optionale Verfeinerungen niedriger Priorität**. Ein hochpriorisierter, den Anfrageweg blockierender Gestaltungsfehler wurde im geprüften Umfang nicht festgestellt.

**Bewertungskontext und Annahmen:** Inhalte und CTAs adressieren Privatkunden sowie Verantwortliche für Büros, Praxen, Gewerbeflächen und Wohnobjekte im Raum Brühl, Köln und Bonn. Daraus wird als Hauptziel die qualifizierte Angebotsanfrage abgeleitet; Telefon, E-Mail und WhatsApp sind ergänzende Kontaktwege. Die Jobs-Seite verfolgt ein eigenes Bewerbungsziel. Dass Besucher unterschiedlich viel Fachwissen über Flächen, Materialien und Reinigungsverfahren mitbringen, ist eine begründete Annahme, keine Erkenntnis aus Nutzerinterviews. Maßstab sind Verständlichkeit und Erreichbarkeit dieser Aufgaben innerhalb der bestehenden sachlichen, blau geprägten Designsprache.

### Tatsächlich geprüfte Darstellung

Die PHP-Website wurde über den vorhandenen lokalen Apache-/PHP-Container unter `http://127.0.0.1:8080` in **Chromium 154.0.8037.57 auf Linux** gerendert. Die Prüfung umfasste Screenshots, tatsächliches Scrollen einschließlich nachladender Bilder, visuelle Sichtung und ergänzende Messungen im gerenderten DOM. Code wurde zur Zuordnung und Erklärung der Befunde herangezogen.

Alle folgenden **28 Routen** wurden bei **1440 × 1000**, **390 × 844** und **320 × 740 CSS-Pixeln** geprüft:

| Bereich | Geprüfte Routen |
| --- | --- |
| Einstieg und Übersicht | `/`, `/leistungen/` |
| Acht Leistungsdetailseiten | `/leistungen/buero-und-gewerberaumreinigung/`, `/leistungen/glas-und-fensterreinigung/`, `/leistungen/grundreinigung/`, `/leistungen/teppichreinigung/`, `/leistungen/polsterreinigung/`, `/leistungen/entruempelung/`, `/leistungen/fassadenreinigung/`, `/leistungen/solaranlagenreinigung/` |
| Lokale Gebäudereinigung | `/gebaeudereinigung-bruehl/`, `/gebaeudereinigung-koeln/`, `/gebaeudereinigung-bonn/` |
| Lokale Büroreinigung | `/bueroreinigung-bruehl/`, `/bueroreinigung-koeln/`, `/bueroreinigung-bonn/` |
| Lokale Fensterreinigung | `/fensterreinigung-bruehl/`, `/fensterreinigung-koeln/`, `/fensterreinigung-bonn/` |
| Vertrauen und Information | `/ueber-uns/`, `/galerie/`, `/faq/`, `/jobs/` |
| Kontakt und Anfrage | `/kontakt/`, `/angebotsanfrage/` |
| Rechtliches und Fehlerseite | `/impressum/`, `/datenschutz/`, `/404.php` |

Ergänzende Stichproben:

- Startseite und Header bei **768 × 1024**, **1024 × 768**, **1081 × 800**, **1100 × 800**, **1200 × 900**, **1280 × 900** und **1920 × 1080**; insbesondere Übergang zum kompakten Menü ohne Überschneidungen.
- Alle acht Leistungs- und neun lokalen Seiten bei **1280 × 720** zur Prüfung der festen Seitenleiste; Scrollpositionen 1000 und 1300 Pixel.
- Desktop-Dropdown per Hover und Tastatur, Escape, sichtbarer Tastaturfokus, Sprunglink und geöffnete FAQ. Mobil zusätzlich Menüscrollen, Dropdown, Fokusführung, Rückgabe des Fokus und Ausschluss geschlossener Menüpunkte aus der Tab-Reihenfolge.
- Angebotsformular bis einschließlich Schritt 5: Vorbelegung über `?service=window&city=koeln`, leere Pflichtangaben, Schätzoption, Terminwahl, Kontaktdaten, Zusammenfassung und Rücksprung über „Ändern“. Mobil bei beiden Breiten zusätzlich eine kombinierte Büro-/Fensteranfrage mit Bonn. Es wurde nichts abgesendet; der API-Versand war zusätzlich im Prüfkontext blockiert.
- Alle acht Galerie-Videos lokal gestartet und pausiert; dekodierte Bildmaße und fortschreitende Wiedergabe bestätigt. Eine nicht vorhandene URL lieferte die vorgesehene Fehleransicht.

### Grenzen der Aussagen

Die Mobilprüfung ist Browseremulation mit Touch-Eigenschaften, kein Test auf physischen Geräten. Safari/iOS, Firefox, Bildschirmtastaturen, Screenreader und sämtliche Zoom-/Schriftgrößeneinstellungen wurden nicht umfassend geprüft. Die Ergebnisse sind kein vollständiger Barrierefreiheitsnachweis. Textkontraste wurden für zentrale tatsächlich gerenderte Kombinationen gemessen; daraus folgt keine Vollprüfung sämtlicher Medienpixel und Zustände.

Nicht geprüft wurden der produktive Server, Zustellung von Anfragen/Bewerbungen, echte Telefon-/WhatsApp-Aufrufe, Uploads mit realen Dateien sowie Versand-, Erfolgs- und Serverfehlerzustände. Auch Bildherkunft, tatsächliche Kundenreferenzen und rechtliche Vollständigkeit wurden nicht verifiziert. Es liegen keine Nutzertests oder Conversion-Daten vor: Die beschriebenen Auswirkungen sind fachliche Bewertungen der beobachteten Gestaltung, keine gemessenen Abbruchquoten.

Screenshots dienten außerhalb des Repositorys als Prüfhilfe. Die folgenden Belege verwenden reproduzierbare Browserzustände, Messwerte und Codeverweise, damit im Projekt ausschließlich diese Audit-Datei entsteht. Alle Codepfade und Zeilennummern beziehen sich auf den oben genannten Commit.

## 2. Was gut funktioniert und unverändert bleiben sollte

| Lösung und Fundstelle | Warum sie erhalten bleiben sollte |
| --- | --- |
| **Konkreter Einstieg auf `/`:** Leistung und drei Städte in der H1, Objekttypen und „regelmäßig oder einmalig“ unmittelbar darunter. Weißer Angebotsbutton und untergeordneter, unterstrichener Leistungslink auf dem blauen Bildpanel. | Besucher erkennen Zuständigkeit und nächste Schritte ohne Interpretation einer Werbeformel. Auch bei 390 Pixeln bleibt das Textpanel vom Foto getrennt lesbar und die Hauptaktion vollständig sichtbar. Diese Hierarchie und die konkrete Aussage bewahren. Beleg: `public_html/index.php:9`. |
| **Wiedererkennbare Seitenstruktur:** Breadcrumbs, H1 mit Einführung, fachliche Abschnitte, Anfrageabschluss; auf lokalen Seiten zusätzlich konkrete Stadt-FAQ. | Das gemeinsame Muster erleichtert den Wechsel zwischen Leistungen und Orten. Unterschiedliche Inhalte benötigen kein jeweils neues Bedienmodell. Die klare Trennung von Übersicht, Detail und lokalem Angebot erhalten. Belege: `app/templates/service-template.php:13`, `app/templates/location-template.php:16`. |
| **Lesbare Grundtypografie:** Systemschrift, Fließtext 16 Pixel mit etwa 26,4 Pixel Zeilenhöhe; größere Einleitungen und abgestufte Überschriften. Detailtexte überwiegend in begrenzten Textspalten. | Die Informationsseiten bleiben auch bei längeren Erläuterungen gut lesbar. Die Typorollen unterscheiden Überschrift, Erklärung und Metainformation; es gibt keinen sachlichen Grund für einen Schriftwechsel oder eine allgemeine Verkleinerung. Ausnahme bei sehr schmalen Wortumbrüchen: B02. Belege: `resources/css/00-tokens.css:27`, `resources/css/01-base.css:11`, `resources/css/01-base.css:149`. |
| **Funktionale Farbverteilung:** Navy für Rahmen/Navigation, Blau für Überschriften und Anfrageaktionen, Grün für WhatsApp, helle Flächen zur Abschnittstrennung. | Kontaktkanäle und Inhaltsbereiche lassen sich wiedererkennen. Gemessene Kernkontraste auf Weiß: Fließtext `#172534` **15,55:1**, sekundärer Text `#526372` **6,20:1**, Blau `#0969b5` **5,68:1**; Weiß auf WhatsApp-Grün `#0a7c3b` **5,30:1**. Eine pauschale Änderung der Palette ist nicht begründet. Beleg: `resources/css/00-tokens.css:3`. |
| **Sichtbare Links und bedienbare Navigation:** unterstrichene Textlinks, aktive Navigationsmarkierung, sichtbare Fokusringe, aufklappbare Leistungsnavigation. | Interaktionen bleiben ohne Hover erkennbar. Desktop-Dropdown und FAQ reagieren auf Tastatur; das mobile Menü führt den Fokus hinein, hält ihn im geöffneten Menü und gibt ihn beim Schließen zurück. Das geschlossene Menü wird beim Tabben übersprungen. Diese funktionierenden Zustände bewahren. Belege: `resources/css/01-base.css:38`, `resources/css/01-base.css:63`, `public_html/assets/js/core/main.js:26`. |
| **Responsive Stapelung und Abstände:** Bilder, Textspalten, Leistungskarten und Formularfelder ordnen sich mobil nachvollziehbar untereinander. | Bei 320 und 390 Pixeln wurde keine unbeabsichtigte horizontale Überbreite festgestellt. Schaltflächen und Beschriftungen bleiben erreichbar; die Navigation besitzt bei geöffnetem Leistungsmenü eine eigene Scrollfläche. Die großzügigeren Abschnittsabstände dienen der Orientierung und müssen nicht pauschal verdichtet werden. |
| **Passende Bilder und Icons:** reinigungsbezogene Motive, gleichartige Leistungskarten und beschriftete Icons; Galerie mit Hochformatvideos und nativen Steuerelementen. | Bilder unterstützen die Unterscheidung von Leistungen. Icons tragen die Aussage zusammen mit Text, nicht allein. Die Galerie zeigt Arbeitsschritte in einem passenden Format und verweist zur jeweiligen Leistung; alle acht Videos konnten lokal abgespielt werden. Nach vollständigem Scrollen waren alle geprüften Bilder geladen. Authentizität wird damit nicht behauptet. Belege: `public_html/galerie/index.php:88`, `resources/css/06-service-pages.css:10`. |
| **Kontextbezogene Anfrage- und Abschlussaktionen:** kostenlos/unverbindlich ist klar; WhatsApp wird in Abschlussbändern als Alternative benannt. Jobs führt zur Bewerbung, FAQ zu Kontakt. | Die Aktion entspricht dem jeweiligen Besuchszweck. Kontakt- und Angebotsseite wiederholen keinen zusätzlichen allgemeinen Angebotsbutton im Header. Die Anfrage übernimmt Leistung/Stadt; im Browser waren „Glas- und Fensterreinigung“ und „Köln“ korrekt vorgewählt. Header und Abschluss müssen deshalb nicht durch weitere konkurrierende Aktionen ergänzt werden. Belege: `app/helpers/actions.php:21`, `app/helpers/offers.php:20`, `content/ctas/startseite.php:1`. |
| **Fünfstufiges Formular mit Prüfung vor Versand:** Fortschritt, sprechende Weiter-Buttons, klar optionale Angaben, freiwillige Fotos, „Weiß ich nicht – bitte vor Ort einschätzen“, Zusammenfassung mit „Ändern“. | Interessierte ohne genaue Objektmaße können weiterkommen. Der Browsertest bestätigte Vor-/Zurücknavigation, kontextabhängige Felder und Erhalt der Angaben beim Ändern. Diese Hilfen sind für die breit gefasste Zielgruppe wertvoller als ein optisch kürzeres, aber informationsärmeres Formular. Belege: `public_html/angebotsanfrage/index.php:21`, `public_html/angebotsanfrage/index.php:87`, `public_html/angebotsanfrage/index.php:193`. |
| **Kontakt und Jobs bleiben aufgabenbezogen:** direkte Erreichbarkeit vor Kontaktformular; Trennung von allgemeiner Nachricht und Angebot; Stellenfakten vor Aufgaben und Anforderungen. | Besucher können selbst einen geeigneten Weg wählen. Die Erklärung von Telefonzeiten gegenüber vereinbarten Einsatzzeiten verhindert Missverständnisse. Die Jobs-Seite verwendet einen Bewerbungsabschluss statt eines Reinigungsangebots. Belege: `public_html/kontakt/index.php:15`, `public_html/kontakt/index.php:25`, `public_html/jobs/index.php:14`. |

## 3. Übergreifende Befunde

### B01 – Feste Seitenleiste berücksichtigt die verfügbare Fensterhöhe nicht

**Priorität: mittel · Einordnung: notwendige Korrektur**

**Fundstellen:** Die rechte Karte `.service-summary-card` mit Kurzüberblick, Bild und Anfragebutton auf **allen acht Leistungsdetailseiten und allen neun lokalen Seiten** aus Abschnitt 1. Nicht betroffen sind die Leistungsübersicht und das mobile, einspaltige Layout.

**Konkrete Beobachtung:** Bei **1280 × 720** bleibt die Karte während eines Teils des Lesens 134 Pixel unter dem oberen Fensterrand stehen. Ihre Höhe beträgt je nach Inhalt etwa **677 bis 730 Pixel**; verfügbar sind dort nur 586 Pixel. Ihr Anfragebutton liegt deshalb vollständig unterhalb des sichtbaren Fensters. Beispiel `/leistungen/glas-und-fensterreinigung/`: Karte **y = 134**, Höhe **703,78**, Button **y = 759,78 bis 804,78**. Auch nach Scrollen von 1000 auf 1300 Pixel bleiben Karte und Button an diesen Fensterkoordinaten. Bei Grundreinigung liegt der Button noch tiefer, bei etwa **786 bis 831 Pixeln**. Auf kürzeren Inhaltsseiten endet die Haftung früher am unteren Containerrand; das behebt den vorangehenden unsichtbaren Zustand nicht.

**Auswirkung:** Der als begleitende Orientierung angelegte Kurzüberblick ist nur teilweise lesbar, und die darin angebotene Anfrageaktion lässt sich während dieser Haftungsphase mit Maus oder Touchpad nicht direkt erreichen. Header- und Abschlussaktionen bleiben verfügbar; der Anfrageweg insgesamt ist daher nicht blockiert. Das begründet mittlere statt hohe Priorität.

**Empfehlung:** Die Karte nur dann haften lassen, wenn sie vollständig in die verfügbare Fensterhöhe unter dem Header passt. Bei zu geringer Höhe soll sie im normalen Dokumentfluss mitscrollen. Die Entscheidung muss die Kartenhöhe einschließlich umbrechender Texte und den Headerabstand berücksichtigen. Dafür keine Inhalte entfernen und keine zweite Scrollfläche innerhalb der Karte einführen.

**Belege:** `resources/css/06-service-pages.css:98` setzt die Haftung und den oberen Abstand; die Ausnahme ab `:141` berücksichtigt nur die Breite. Gemeinsame Karte: `app/templates/service-template.php:16`; lokale Verwendung beispielsweise `content/locations/fensterreinigung-koeln.php:7`.

**Abnahme für eine spätere Umsetzung:** Auf allen 17 Fundstellen bei 1280 × 720 müssen Bild, Kurztext, Fakten und Anfragebutton durch gewöhnliches Seitenscrollen ohne Warten auf das Containerende erreichbar sein. Bei ausreichend hohen Desktopfenstern darf die bisher hilfreiche Haftung bestehen bleiben; Mobilansicht und Anfrageziele bleiben erhalten.

### B02 – Sehr schmale Überschriften brechen Wörter ohne Trennzeichen auf

**Priorität: niedrig · Einordnung: optionaler Feinschliff**

**Fundstellen:** Besonders klar reproduzierbar bei **320 × 740**: H1 auf `/leistungen/`, `/leistungen/entruempelung/` und `/datenschutz/`. Ergänzend: `/angebotsanfrage/`, Schritt 2 „Objekt und Umfang“, Überschrift des Detailabschnitts „Büro- und Gewerberaumreinigung“ bei kombinierter Büro-/Fensteranfrage.

**Konkrete Beobachtung:** In der geprüften Chromium-/Linux-Darstellung wird „Reinigungsleistungen“ als **„Reinigungsleistun“ / „gen“**, „Haushaltsauflösung“ als **„Haushaltsauflösun“ / „g“** und „Datenschutzerklärung“ als **„Datenschutzerklär“ / „ung“** umbrochen. Im genannten Formularabschnitt steht „Gewerberaumreinigung“ als **„Gewerberaumrein“ / „igung“**. Es fehlt jeweils ein sichtbares Trennzeichen. Die Texte werden nicht abgeschnitten; es handelt sich um eine unsaubere Trennung, nicht um fehlenden Inhalt. `hyphens: auto` ist bereits gesetzt, erzeugt hier aber keine sprachgerechte Trennung.

**Auswirkung:** Einzelne Restbuchstaben erschweren das schnelle Erkennen eines Titels und unterbrechen die ansonsten klare typografische Hierarchie. Der Inhalt und die Anfrage bleiben verständlich und bedienbar; ein Funktionshindernis wurde nicht beobachtet.

**Empfehlung:** Für die nachgewiesenen langen Begriffe geeignete bedingte Trennstellen als Fallback zur automatischen deutschen Silbentrennung vorsehen. Die vorhandene Notumbruchregel für wirklich untrennbare Inhalte erhalten. Nicht die gesamte Typografieskala verkleinern und keine festen Zeilenumbrüche für nur eine Bildschirmbreite einbauen. Vor einer breiteren Anpassung dieselben Begriffe auf weiteren Browsern prüfen.

**Belege:** `resources/css/01-base.css:105` mit `overflow-wrap: anywhere` und `hyphens: auto`; Titelquellen `config/pages/leistungen.php:27`, `config/services/entruempelung.php:18`, `public_html/datenschutz/index.php:9` und `public_html/angebotsanfrage/index.php:67`. Die Aussage zur tatsächlichen Trennung gilt für die geprüfte Browserumgebung, nicht pauschal für alle Geräte.

**Abnahme für eine spätere Umsetzung:** Die drei genannten Titel und die langen Formularbezeichnungen bei 320 und 390 Pixeln auf sprachgerechte Umbrüche prüfen; Desktopdarstellung und ungekürzter Wortlaut bleiben erhalten.

## 4. Seitenspezifische Befunde

### B03 – Die zwei Rückwege der Fehlerseite berühren sich nach dem Umbruch

**Priorität: niedrig · Einordnung: optionaler Feinschliff**

**Fundstelle:** `/404.php`, Aktionspaar **„Zur Startseite“ / „Zu den Leistungen“** unter der Fehlererklärung.

**Konkrete Beobachtung:** Bei **320 × 740** brechen die beiden Inline-Buttons auf zwei Zeilen um. Zwischen dem gefüllten oberen Button und dem umrandeten unteren Button fehlt ein sichtbarer vertikaler Abstand; die Rundungen berühren sich. Bei 390 Pixeln stehen die Buttons nebeneinander. Beide Ziele sind weiterhin anklickbar und vollständig beschriftet.

**Auswirkung:** Die beiden eigenständigen Rückwege erscheinen im schmalen Layout optisch zusammengeklebt. Das erschwert ihre visuelle Trennung etwas, ohne die Fehlerbehebung zu verhindern.

**Empfehlung:** Das Aktionspaar als gemeinsam ausgerichtete, umbrechende Gruppe mit explizitem Zeilenabstand von etwa 12 Pixeln behandeln. Die gefüllte Startseitenaktion und den untergeordneten Leistungsbutton sowie ihre Beschriftungen beibehalten. Die vorhandene `.action-group` bietet hierfür bereits ein passendes Muster.

**Belege:** `public_html/404.php:6` enthält zwei Buttons in einem Absatz ohne Gruppenlayout; `resources/css/02-components.css:69` definiert das anderweitig verwendete Muster mit `gap`.

**Abnahme für eine spätere Umsetzung:** Bei 320 Pixeln klar getrennter vertikaler Abstand, bei 390 Pixeln und auf Desktop weiterhin saubere Ausrichtung; beide Links mit Tastatur und Zeiger erreichbar.

### Einordnung der übrigen Seiten ohne zusätzliche Änderungsbefunde

Wiederkehrende Probleme werden nicht erneut als Einzelprobleme gezählt. Die folgende Übersicht hält die seitenspezifische Bewertung und die Grenze des Änderungsbedarfs fest.

| Seite / Seitengruppe | Bewertung aus der gerenderten Prüfung |
| --- | --- |
| **Startseite** | Das Bild führt in den Leistungskontext; das kontrastreiche Panel trägt die eigentliche Aussage. Intro, Leistungswahl, Einsatzgebiete und Anfrageabschluss bilden eine nachvollziehbare Reihenfolge. Die drei Ortskarten führen zu passenden lokalen Seiten. Kein zusätzlicher begründeter Änderungsbefund. |
| **Leistungsübersicht** | Alle acht Kernleistungen sind in gleichartigen, beschrifteten Karten auffindbar; die Überschrift jeder Karte ist als Link erkennbar. Fotos erleichtern die Zuordnung, zusätzliche Arbeitsarten stehen nachgeordnet. B02 betrifft den schmalen Titel; weder eine neue Kartensprache noch zusätzliche Haupt-CTAs sind erforderlich. |
| **Acht Leistungsdetailseiten** | Inhaltliche Fragen, Tätigkeitslisten, Objekttypen und benötigte Anfragedaten werden sinnvoll getrennt. Die sechs Seiten mit Praxisvideo ergänzen die Erklärung durch beobachtbare Arbeitsschritte. B01 gemeinsam korrigieren; B02 betrifft insbesondere Entrümpelung. Die Leistungsunterschiede nicht durch eine pauschale Inhaltskürzung einebnen. |
| **Neun lokale Seiten** | Stadtbezug, Leistungsumfang und passende lokale FAQ bleiben erkennbar. „Firmensitz“ wird bei Brühl von weiteren Einsatzgebieten unterschieden. Seitenleistenproblem ist vollständig in B01 erfasst; keine neun Wiederholungen desselben Befunds. |
| **Über uns** | Arbeitsweise, regionale Zuständigkeit und Zielkunden sind vor dem Abschluss verständlich. Bildkarte und Text folgen der vorhandenen Gestaltung. Die tatsächliche Herkunft der Team-/Arbeitsbilder bleibt unverifiziert; daraus wird kein Designmangel abgeleitet. |
| **Galerie** | Titel und Erklärung ordnen die beispielhaften Arbeitssituationen ein. Beschriftete Hochformatvideos lassen sich steuern und führen zur passenden Leistung. Die acht Beiträge erfordern mobil längeres Scrollen; angesichts des sichtbaren Videoformats und der jeweiligen Beschriftung ist daraus allein kein Änderungsbedarf begründbar. |
| **FAQ** | Konkrete Fragen zu Preisbildung, Unverbindlichkeit, Ablauf und Einsatzzeiten sind direkt erkennbar. Ganze Zeilen öffnen per Klick beziehungsweise Enter, Plus/Minus zeigen den Zustand, der Tastaturfokus bleibt sichtbar. Ein zusätzlicher Such- oder Filtermechanismus ist für diese überschaubare Liste nicht begründet. |
| **Jobs** | Stellenfakten, Aufgaben, Anforderungen und Leistungen des Arbeitgebers sind klar gegliedert. Die E-Mail-Bewerbung ist sowohl früh als auch abschließend erreichbar und ausdrücklich beschriftet. Keine zusätzliche Reinigungsanfrage im Inhalt erforderlich. Zustellung der Bewerbung wurde nicht getestet. |
| **Kontakt** | Telefon, E-Mail und telefonische Erreichbarkeit sind früh sichtbar. Das Formular ist als allgemeine Nachricht erklärt, die detaillierte Angebotsanfrage separat verlinkt. Labels und Feldränder sind erkennbar; Standort und Einsatzgebiet folgen mobil im normalen Lesefluss. Kein belegter zusätzlicher Änderungsbedarf. |
| **Angebotsanfrage** | Einzel- und kombinierte Leistungsanfrage sind bis zur Zusammenfassung bedienbar. Schätzoptionen, flexible Terminwahl, freiwillige Fotos und abschnittsbezogenes „Ändern“ unterstützen die Aufgabe. Fehlende Pflichtangaben verhindern den nächsten Schritt; leere Leistungswahl erhält eine konkrete Meldung. B02 gilt für einzelne schmale Wortumbrüche. Versand, Upload und Erfolgszustand bleiben ausdrücklich ungeprüft. |
| **Impressum / Datenschutz** | Ruhiges Textlayout und gegliederte Abschnitte passen zum Lesezweck; Kontaktverknüpfungen sind erkennbar. B02 betrifft die Datenschutz-H1. Keine gestalterische Empfehlung zur Änderung rechtlicher Inhalte. |
| **Fehlerseite** | Verständliche Fehlererklärung mit zwei passenden Rückwegen; B03 betrifft ausschließlich deren Abstand im schmalen Layout. Die tatsächliche Aufrufprobe einer unbekannten URL zeigte diese Fehleransicht. |

## 5. Priorisierte Maßnahmenliste

Die Reihenfolge richtet sich nach Erreichbarkeit der Anfrage, Zahl der betroffenen Seiten und Schwere der beobachteten Einschränkung. Es wird keine zusätzliche Arbeit allein zur Modernisierung der Optik empfohlen.

| Rang | Befund und konkrete Maßnahme | Priorität | Einordnung | Umfang / Nachprüfung |
| --- | --- | --- | --- | --- |
| 1 | **B01:** Haftende Kurzüberblickskarte von verfügbarer Höhe abhängig machen; andernfalls normal mitscrollen lassen. | **mittel** | **notwendige Korrektur** | Gemeinsame Regel für acht Leistungs- und neun lokale Seiten. Bei 1280 × 720 alle Inhalte und den Karten-CTA erreichen; Verhalten bei hohen Desktopfenstern und auf Mobilgeräten erhalten. |
| 2 | **B02:** Sprachgerechte bedingte Trennstellen für die nachgewiesenen langen Titel und Formularbegriffe ergänzen, automatische Silbentrennung browserübergreifend nachprüfen. | **niedrig** | **optionaler Feinschliff** | Mit den drei benannten Titeln beginnen; 320/390 Pixel und weitere Browser prüfen. Keine globale Schriftverkleinerung oder Textkürzung. |
| 3 | **B03:** 404-Rückwege in eine umbrechende Aktionsgruppe mit explizitem Zeilenabstand setzen. | **niedrig** | **optionaler Feinschliff** | Nur Fehlerseite; bei 320/390 Pixeln und Desktop prüfen. Ziele, Hierarchie und Beschriftungen erhalten. |

**Änderungsumfang dieser Übergabe:** Es wurden keine Empfehlungen umgesetzt. Im Projekt wurde ausschließlich `DEEP_AUDIT.md` neu angelegt. Der Ausgangszustand war sauber; vorhandene Branches und lokale Dateien wurden nicht überschrieben oder verworfen. `final4` bleibt aktiv und basiert unverändert auf dem oben genannten `final3`-Commit.
