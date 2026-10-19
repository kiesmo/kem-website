<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/leistungen/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['services'];
$servicesCurrent = true;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><?php kem_render_breadcrumbs($pageKey); ?>
<?php kem_render_page_intro($pageKey); ?><section class="section service-discovery-section" aria-labelledby="leistungen-auswahl">
<div class="container">
<h2 id="leistungen-auswahl">Leistungen auf einen Blick</h2>
<?php kem_render_service_discovery('overview'); ?>
</div>
</section>
<section class="section soft service-discovery-extras" aria-labelledby="weitere-reinigungsarbeiten">
<div class="container">
<h2 id="weitere-reinigungsarbeiten">Weitere Reinigungsarbeiten</h2>
<p class="prose">Welche Leistungen sinnvoll sind, hängt von Ihrem Objekt, der Nutzung und dem gewünschten Umfang ab. Reinigungsintervalle und Einsatzzeiten stimmen wir vorab mit Ihnen ab. Bei Bedarf sind nach Abstimmung auch kurzfristige Termine möglich.</p>
<div class="service-discovery-groups">
<details class="service-discovery-group">
<summary class="service-discovery-group__summary">Objekt- &amp; Gewerbereinigung</summary>
<ul class="service-discovery-group__terms">
<li>Büroreinigung aller Art und Größen</li>
<li>Reinigung frei zugänglicher Arbeitsplatzoberflächen</li>
<li>Reinigung von Gewerbeflächen, Lagern und Ladenlokalen</li>
<li>Treppenhäuser</li>
<li>Reinigung von Sanitäranlagen</li>
<li>Praxis- und Gastronomiereinigung</li>
<li>Messe- und Eventreinigung</li>
</ul>
</details>
<details class="service-discovery-group">
<summary class="service-discovery-group__summary">Glas, Fassade &amp; Außenbereiche</summary>
<ul class="service-discovery-group__terms">
<li>Glas- und Fensterreinigung</li>
<li>Fensterrahmen- und Fensterbretterreinigung</li>
<li>Dachfenster und Oberlichter</li>
<li>Jalousien- und Lamellenreinigung</li>
<li>Wintergartenreinigung</li>
<li>Fassadenreinigung</li>
<li>Graffiti-Entfernung</li>
<li>Terrassen- und Steinreinigung</li>
<li>Eingangsbereiche und Außentreppen</li>
<li>Reinigung moosbefallener Flächen</li>
<li>Solar- und Photovoltaikanlagenreinigung</li>
</ul>
</details>
<details class="service-discovery-group">
<summary class="service-discovery-group__summary">Grund-, Bau- &amp; Spezialreinigung</summary>
<ul class="service-discovery-group__terms">
<li>Grundreinigung</li>
<li>Endreinigung</li>
<li>Bau- und Umzugsreinigung</li>
<li>Hygienische Reinigung von Sanitär- und Gemeinschaftsbereichen</li>
<li><strong>Desinfektionsreinigung:</strong> Desinfektion vereinbarter Flächen und Bereiche nach den jeweiligen Hygieneanforderungen.</li>
<li><strong>Reinraumreinigung:</strong> Reinigung nach objektspezifischen Vorgaben und vorab abgestimmten Reinigungsmitteln und Arbeitsabläufen.</li>
<li>Nikotinreinigung</li>
<li>Reinigungsarbeiten nach Wasserschäden – Umfang nach Besichtigung</li>
<li>Räumung und intensive Reinigung stark verschmutzter Räume – nach Besichtigung</li>
</ul>
</details>
<details class="service-discovery-group">
<summary class="service-discovery-group__summary">Textilien, Haushalt &amp; Räumung</summary>
<ul class="service-discovery-group__terms">
<li>Teppichreinigung</li>
<li>Polsterreinigung</li>
<li>Haushalts-, Haus- und Wohnungsreinigung</li>
<li>Entrümpelungen</li>
</ul>
</details>
</div>
</div>
</section><section class="section soft">
<div class="container">
<span class="eyebrow">Einsatzgebiete</span>
<h2>Reinigungsservice in Brühl, Köln und Bonn</h2>
<p>Unsere Leistungen können je nach Objekt und Auftrag in Brühl, Köln, Bonn und Umgebung angefragt werden. Für die drei Kerngebiete finden Sie eigene Seiten mit weiteren lokalen Informationen.</p>
<nav aria-label="Einsatzgebiete" class="service-nav">
<a href="/gebaeudereinigung-bruehl/">Gebäudereinigung Brühl</a>
<a href="/gebaeudereinigung-koeln/">Gebäudereinigung Köln</a>
<a href="/gebaeudereinigung-bonn/">Gebäudereinigung Bonn</a>
</nav>
</div>
</section><?php kem_render_page_cta($pageKey); ?></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>
