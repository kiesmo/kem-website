# FAQ und Sitemap pflegen

Die zehn Fragen und Antworten der FAQ werden ausschließlich in `content/faq.php`
als Klartext gepflegt. `config/pages/faq.php` erzeugt daraus die strukturierten
FAQPage-Daten; `public_html/faq/index.php` rendert dieselben Einträge mit
HTML-Escaping. Reihenfolge und Texte müssen daher nur einmal geändert werden.
HTML-Tags gehören nicht in diese Klartextfelder.

In `public_html/sitemap.xml` wird `lastmod` nur für die tatsächlich inhaltlich
geänderte URL gepflegt. Dazu zählen geänderte oder ergänzte Leistungstexte sowie
inhaltliche Änderungen an Überschriften, SEO-Titeln oder strukturierten Daten.
Reine Änderungen an CSS, Layout, PHP-Dateiaufteilung oder Deployment rechtfertigen
kein neues Datum. Auch das Zusammenführen unveränderter FAQ-Texte ändert den
Inhaltsstand der FAQ nicht.

Das Datum muss sich auf die belegbare Inhaltsänderung beziehen. Nicht pauschal
alle Einträge auf heute setzen und keine Requestzeit oder Datei-mtime verwenden.
Fehlt ein belastbares Datum für einen neuen Eintrag, kann das optionale
`lastmod` entfallen. Vorhandene ältere Angaben werden nicht ohne neue Erkenntnisse
umgeschrieben.

Die Aktualisierung in Punkt 54 verwendet die UTC-Zeitpunkte der inhaltlichen
Commits im W3C-Format: `9151460` für die vier seither textlich unveränderten
Leistungsseiten, `5b0b89f` für Leistungsübersicht und Grundreinigung, `efb12c7`
für Teppich- und Polsterreinigung sowie `2a24a74` für Entrümpelung. Die übrigen
Sitemap-Einträge behalten ihren bisherigen Wert.
