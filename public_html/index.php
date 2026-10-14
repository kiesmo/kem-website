<!DOCTYPE html>
<html lang="de"><?php $pageKey = '/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['home'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main">
<section class="home-hero">
<div class="container home-hero-grid">
<div class="home-copy">
<span class="eyebrow">KEM Gebäudereinigung · Brühl, Köln &amp; Bonn</span>
<h1>Saubere Räume.<br>Klare Absprachen.</h1>
<p class="lead">Gebäudereinigung für Büros, Praxen, Gewerbeflächen, Wohnanlagen und private Objekte – regelmäßig oder einmalig.</p>
<div class="hero-actions"><a class="btn" href="/angebotsanfrage/">Kostenloses Angebot</a><a class="btn secondary" href="/leistungen/">Leistungen entdecken</a></div>
<div class="home-facts"><span>Gewerbe &amp; Privat</span><span>Individuell geplant</span><span>Regional für Sie da</span></div>
</div>
<div class="home-visual"><img alt="" src="/assets/img/pages/startseite/startseite-hero.webp" width="1920" height="870" fetchpriority="high"><div class="home-image-note"><span aria-hidden="true"></span><p>Sauberkeit, die bleibt.<br><strong>Passend zu Ihrem Objekt.</strong></p></div></div>
</div>
<div class="container region-strip"><p>In Brühl zu Hause. In der Region für Sie da.</p><nav aria-label="Unsere Einsatzgebiete"><a href="/gebaeudereinigung-bruehl/">Brühl</a><a href="/gebaeudereinigung-koeln/">Köln</a><a href="/gebaeudereinigung-bonn/">Bonn</a></nav></div>
</section>
<section class="section services-kem"><div class="container">
<div class="section-head"><div><span class="eyebrow">Unsere Leistungen</span><h2>Für jedes Objekt<br>die passende Reinigung.</h2></div><p>Regelmäßige Pflege oder ein einzelner Einsatz: Wir stimmen die Reinigung auf Ihre Räume, Oberflächen und Abläufe ab.</p></div>
<?php kem_render_service_cards('home'); ?>
<p class="services-all"><a class="btn secondary" href="/leistungen/">Alle Leistungen im Überblick</a></p>
</div></section>
<section class="section intro-section"><div class="container intro-showcase">
<div class="intro-image"><img alt="Tablet und Reinigungsequipment bei der Auftragsabstimmung" src="/assets/img/pages/startseite/startseite-content.webp" width="1200" height="800" loading="lazy"></div>
<div class="intro-copy"><span class="eyebrow">So arbeitet KEM</span><h2>Gut abgestimmt.<br>Sorgfältig gereinigt.</h2><p class="lead">Vor Beginn stimmen wir mit Ihnen ab, welche Bereiche gereinigt werden, in welchem Turnus die Reinigung erfolgt und welche Einsatzzeiten zu Ihren Abläufen passen. So ist der vereinbarte Leistungsumfang von Anfang an klar.</p>
<div class="intro-strengths"><div><h3>Klare Absprachen</h3><p>Leistungsumfang, Reinigungsturnus und Einsatzzeiten werden vor Beginn gemeinsam festgelegt.</p></div><div><h3>Qualitätskontrolle auf Wunsch</h3><p>Ausgeführte Leistungen können kontrolliert und dokumentiert werden.</p></div><div><h3>Flexible Einsatzzeiten</h3><p>Früh-, Abend- oder andere Einsatzzeiten sind nach vorheriger Absprache möglich.</p></div></div><a class="btn secondary" href="/ueber-uns/">KEM kennenlernen</a></div>
</div></section>
<section class="section"><div class="container"><span class="eyebrow">Der Weg zu saubereren Räumen</span><h2>Von Ihrer Anfrage<br>bis zum abgestimmten Einsatz.</h2><div class="process-grid"><article><span>01 / Anfrage</span><h3>Ihr Objekt kennenlernen</h3><p>Teilen Sie uns die gewünschte Leistung, den Einsatzort und den ungefähren Umfang mit. Fotos können die erste Einschätzung erleichtern.</p></article><article><span>02 / Abstimmung</span><h3>Den Umfang gemeinsam klären</h3><p>Wir stimmen Leistungen, Turnus und Einsatzzeiten ab. Wenn sinnvoll, vereinbaren wir eine Besichtigung.</p></article><article><span>03 / Reinigung</span><h3>Nach Vereinbarung reinigen</h3><p>Die Reinigung richtet sich nach dem abgestimmten Leistungsumfang. Eine Qualitätskontrolle ist auf Wunsch möglich.</p></article></div></div></section>
<section class="section local-seo-section" id="einsatzgebiete">
<div class="container">
<div class="services-heading">
<span class="eyebrow">Regional für Sie da</span>
<h2>Gebäudereinigung in Brühl, Köln und Bonn</h2>
<p class="lead narrow">KEM hat seinen Firmensitz in Brühl und bietet Reinigungsleistungen für private und gewerbliche Kunden in Brühl, Köln, Bonn und der umliegenden Region an.</p>
</div>
<div class="location-grid">
<article class="location-card">
<span class="location-label"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 21s6-5.3 6-11a6 6 0 1 0-12 0c0 5.7 6 11 6 11Zm0-8.5A2.5 2.5 0 1 1 12 7a2.5 2.5 0 0 1 0 5.5Z"/></svg>Firmensitz &amp; Einsatzgebiet</span>
<h3>Gebäudereinigung Brühl</h3>
<p>Unser Firmensitz befindet sich in Brühl. Von hier aus betreuen wir private und gewerbliche Objekte in Brühl und der umliegenden Region.</p>
<p class="location-services"><span>Beliebte Leistungen:</span> <a href="/gebaeudereinigung-bruehl/">Gebäudereinigung</a> · <a href="/bueroreinigung-bruehl/">Büroreinigung</a> · <a href="/fensterreinigung-bruehl/">Glas- &amp; Fensterreinigung</a></p>
<a class="more" href="/gebaeudereinigung-bruehl/">Gebäudereinigung in Brühl ›</a>
</article>
<article class="location-card">
<span class="location-label"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 21s6-5.3 6-11a6 6 0 1 0-12 0c0 5.7 6 11 6 11Zm0-8.5A2.5 2.5 0 1 1 12 7a2.5 2.5 0 0 1 0 5.5Z"/></svg>Einsatzgebiet</span>
<h3>Gebäudereinigung Köln</h3>
<p>Flexible Reinigungsleistungen für unterschiedlich genutzte private und gewerbliche Objekte in Köln.</p>
<p class="location-services"><span>Beliebte Leistungen:</span> <a href="/gebaeudereinigung-koeln/">Gebäudereinigung</a> · <a href="/bueroreinigung-koeln/">Büroreinigung</a> · <a href="/fensterreinigung-koeln/">Glas- &amp; Fensterreinigung</a></p>
<a class="more" href="/gebaeudereinigung-koeln/">Gebäudereinigung in Köln ›</a>
</article>
<article class="location-card">
<span class="location-label"><svg aria-hidden="true" viewBox="0 0 24 24"><path d="M12 21s6-5.3 6-11a6 6 0 1 0-12 0c0 5.7 6 11 6 11Zm0-8.5A2.5 2.5 0 1 1 12 7a2.5 2.5 0 0 1 0 5.5Z"/></svg>Einsatzgebiet</span>
<h3>Gebäudereinigung Bonn</h3>
<p>Individuell abgestimmte Reinigung für Büros, Praxen, Wohnobjekte und Gewerbeflächen in Bonn.</p>
<p class="location-services"><span>Beliebte Leistungen:</span> <a href="/gebaeudereinigung-bonn/">Gebäudereinigung</a> · <a href="/bueroreinigung-bonn/">Büroreinigung</a> · <a href="/fensterreinigung-bonn/">Glas- &amp; Fensterreinigung</a></p>
<a class="more" href="/gebaeudereinigung-bonn/">Gebäudereinigung in Bonn ›</a>
</article>
</div>
</div>
</section>
<?php kem_render_page_cta($pageKey); ?>
</main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>
