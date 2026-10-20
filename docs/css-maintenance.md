# CSS pflegen

Die CSS-Dateien direkt in `resources/css/` sind die bearbeitbaren Quellen. Das ausgelieferte
`public_html/assets/css/styles.css` wird daraus erzeugt. Die verbindliche
Reihenfolge steht in `tools/build-css.php`:

| Datei | Zuständigkeit |
| --- | --- |
| `00-tokens.css` | Farben, Abstände, Typografie und gemeinsame Variablen |
| `01-base.css` | Grundelemente, Links und Zugänglichkeit |
| `02-components.css` | Buttons, Header, Navigation und gemeinsame Layouts |
| `03-pages.css` | Seitenaufbau, Leistungskarten, Kontaktlayout und Footer |
| `04-responsive.css` | Gemeinsame Layouts, Navigation und reduzierte Bewegung |
| `05-forms.css` | Gemeinsame Formularfelder, Kontaktformular und Angebotsformular |
| `06-service-pages.css` | Leistungsseiten einschließlich ihrer mobilen Regeln |
| `07-gallery-faq.css` | Galerie und FAQ einschließlich ihrer mobilen Regeln |
| `09-local-pages.css` | Lokale Seiten und ergänzende Inhaltskomponenten |

`05-forms.css` enthält auch die Zustands- und Responsive-Regeln der Formulare.
Die Reihenfolge innerhalb dieser Datei ist beabsichtigt: gemeinsame Basis,
Kontakt-Ausnahmen und mobile Basis, danach Angebots-Wizard samt mobilen Regeln,
zuletzt Angebotsdetails mit ihren mobilen Regeln. Spätere Detailregeln überschreiben
unter anderem Abstände von Termin-, Upload- und Übersichtsbereichen. Mobile Regeln
daher nicht pauschal ans Dateiende verschieben.

Die vorhandenen `em`- und `px`-Breakpoints werden beibehalten. Insbesondere ist
der Navigations-Breakpoint `67.5em` mit `public_html/assets/js/core/main.js`
abgestimmt. Eine Einheitenumstellung ist eine Layoutänderung und braucht eigene
Prüfungen. Gemeinsame Responsive-Regeln bleiben in `04-responsive.css`;
komponentenspezifische Anpassungen stehen bei der jeweiligen Komponente.

Nach Änderungen `php tools/build-css.php` ausführen. Mit
`php tools/build-css.php --check` lässt sich prüfen, ob das Bundle den Quellen
entspricht. Neue CSS-Dateien müssen ausdrücklich in die Buildliste aufgenommen
werden; fehlende oder unberücksichtigte Quellen führen zu einem Fehler.
Quellen und Bundle zusammen committen und bei einer Bundleänderung die
`asset_version` in `config/site.php` erhöhen.

Bei einer Umordnung sind Vorher-/Nachher-Vergleiche erforderlich: Mobil- und
Desktopansicht, angrenzende Breakpoints, vergrößerte Schrift und Formularzustände
einschließlich Fehlern, Schätzung, Upload und Übersicht. Einzelne ungenutzte
Selektoren in einer Coverage-Aufnahme sind kein ausreichender Löschgrund.
