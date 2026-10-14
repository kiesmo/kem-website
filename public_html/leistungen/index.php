<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/leistungen/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['services'];
$servicesCurrent = true;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><?php kem_render_page_hero($pageKey); kem_render_breadcrumbs($pageKey); ?><section class="section"><div class="container"><div class="section-head"><div><span class="eyebrow">Reinigung nach Bedarf</span><h2>Die passende Leistung<br>für Ihr Objekt.</h2></div><p>Entdecken Sie unsere acht Leistungsbereiche und erfahren Sie, was für Ihre Räume und Oberflächen sinnvoll sein kann.</p></div><?php kem_render_service_cards(); ?></div></section><section class="section"><div class="container"><span class="eyebrow">Unsere Leistungen</span><p class="lead narrow">KEM übernimmt regelmäßige und einmalige Reinigungsarbeiten für Gewerbe und Privat – von Büro-, Glas- und Grundreinigung bis zu Teppich-, Polster-, Fassaden- und PV-Reinigung sowie Entrümpelung.</p><p class="narrow">Welche Leistungen sinnvoll sind, hängt von Ihrem Objekt, der Nutzung und dem gewünschten Umfang ab. Reinigungsintervalle und Einsatzzeiten stimmen wir vorab mit Ihnen ab. Bei Bedarf sind nach Abstimmung auch kurzfristige Termine möglich.</p><h2>Leistungen auf einen Blick</h2><div class="service-overview-groups">
<article class="service-overview-group"><h3>Objekt- &amp; Gewerbereinigung</h3><ul class="check-grid check-grid--single"><li>Büroreinigung aller Art und Größen</li><li>Gewerbliche Flächen, Lager und Ladenlokale</li><li>Treppenhäuser</li><li>Reinigung von Sanitäranlagen</li><li>Praxis- und Gastronomiereinigung</li><li>Messe- und Eventreinigung</li><li>Industriereinigung</li></ul></article>
<article class="service-overview-group"><h3>Glas, Fassade &amp; Außenbereiche</h3><ul class="check-grid check-grid--single"><li>Glas- und Fensterreinigung</li><li>Fensterrahmen- und Fensterbretterreinigung</li><li>Dachfenster und Oberlichter</li><li>Jalousien- und Lamellenreinigung</li><li>Wintergartenreinigung</li><li>Fassadenreinigung</li><li>Graffiti-Entfernung</li><li>Terrassen- und Steinreinigung</li><li>Eingangsbereiche und Außentreppen</li><li>Reinigung moosbefallener Flächen</li><li>Solar- und Photovoltaikanlagenreinigung</li></ul></article>
<article class="service-overview-group"><h3>Grund-, Bau- &amp; Spezialreinigung</h3><ul class="check-grid check-grid--single"><li>Grundreinigung</li><li>Endreinigung</li><li>Bau- und Umzugsreinigung</li><li>EDV-Anlagenreinigung</li><li>Hygiene-, Desinfektions- und Reinraumreinigung</li><li>Nikotinreinigung</li><li>Reinigung nach Wasserschäden</li><li>Messie-Reinigung</li></ul></article>
<article class="service-overview-group"><h3>Textilien, Haushalt &amp; Räumung</h3><ul class="check-grid check-grid--single"><li>Teppichreinigung</li><li>Polsterreinigung</li><li>Haushalts-, Haus- und Wohnungsreinigung</li><li>Entrümpelungen</li></ul></article>
</div></div></section><section class="section soft">
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
