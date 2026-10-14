<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/datenschutz/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body ><?php
$headerMode = 'opaque';
$navActive = [];
$servicesCurrent = false;
$footerVariant = 'full';
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
?>
<main id="main"><?php kem_render_breadcrumbs($pageKey); ?><section class="section legal"><div class="container narrow">
<h1>Datenschutzerklärung</h1>
<p><strong>Stand: August 2026</strong></p>
<h2>1. Verantwortlicher</h2>
<p>KEM Gebäudereinigung<br/>Inhaber: Kian Motlagh<br/><?= kem_h($kem['street']) ?><br><?= kem_h($kem['postal_code']) ?> <?= kem_h($kem['city']) ?><br><?= kem_h($kem['country']) ?><br/>Telefon: <a href="tel:<?= kem_h($kem['phone_href']) ?>"><?= kem_h($kem['phone_display']) ?></a><br/>E-Mail: <a href="mailto:<?= kem_h($kem['email']) ?>"><?= kem_h($kem['email']) ?></a></p>
<h2>2. Hosting, E-Mail und Server-Logfiles</h2>
<p>Diese Website sowie das für Kontakt- und Formularnachrichten verwendete E-Mail-Postfach werden bei Hostinger betrieben. Dienstleister ist Hostinger International Ltd., 61 Lordou Vironos Street, 6023 Larnaca, Zypern.</p>
<p>Beim Aufruf der Website verarbeitet der Hostingdienstleister technisch erforderliche Verbindungsdaten. Dazu können insbesondere IP-Adresse, Zeitpunkt des Zugriffs, aufgerufene Datei, Referrer, Browser und Betriebssystem gehören. Die Verarbeitung dient der sicheren, stabilen und fehlerfreien Bereitstellung der Website. Rechtsgrundlage ist Art. 6 Abs. 1 lit. f DSGVO.</p>
<p>Server-Logdaten werden nur so lange verarbeitet, wie dies für den technischen Betrieb, die Sicherheit und die Fehleranalyse erforderlich ist. Eine längere Aufbewahrung erfolgt nur, wenn gesetzliche Pflichten bestehen oder ein sicherheitsrelevanter Vorfall aufgeklärt werden muss.</p>
<h2>3. Cookies und lokale Speicherung</h2>
<p>Diese Website setzt selbst keine Analyse- oder Marketing-Cookies ein. Für Navigation und Formulare ist keine nicht notwendige lokale Speicherung vorgesehen.</p>
<h2>4. Kontakt- und Angebotsformulare</h2>
<p>Wenn Sie uns über ein Formular kontaktieren, verarbeiten wir die von Ihnen eingegebenen Angaben zur Bearbeitung und Beantwortung Ihrer Anfrage. Dazu können insbesondere Name, E-Mail-Adresse, Telefonnummer, Einsatzort sowie Angaben zum gewünschten Auftrag gehören. Rechtsgrundlage ist Art. 6 Abs. 1 lit. b DSGVO bei vorvertraglichen Anfragen beziehungsweise Art. 6 Abs. 1 lit. f DSGVO bei allgemeinen Anliegen.</p>
<p>Formulardaten werden serverseitig geprüft und über den bei Hostinger betriebenen E-Mail-Dienst an die für die Bearbeitung vorgesehene Adresse übermittelt. Eine Speicherung in einer Website-Datenbank ist nicht vorgesehen. Zum Schutz vor automatisiertem Missbrauch kann für kurze Zeit eine aus der IP-Adresse abgeleitete technische Prüfsumme verwendet werden. Die Anfrageangaben werden gelöscht, sobald sie für die Bearbeitung nicht mehr erforderlich sind und keine gesetzlichen Aufbewahrungspflichten entgegenstehen.</p>
<h2>5. Kontaktaufnahme und Bewerbungen</h2>
<p>Bei einer Kontaktaufnahme per E-Mail oder Telefon verarbeiten wir die übermittelten Angaben zur Bearbeitung des jeweiligen Anliegens.</p>
<p>Bei einer Bewerbung verarbeiten wir die übermittelten Daten ausschließlich zur Durchführung des Bewerbungsverfahrens. Rechtsgrundlage ist Art. 6 Abs. 1 lit. b DSGVO in Verbindung mit § 26 BDSG. Bei einer erfolglosen Bewerbung werden die Unterlagen spätestens drei Monate nach Abschluss des Bewerbungsverfahrens gelöscht, sofern keine gesetzlichen Pflichten, die Geltendmachung oder Abwehr von Rechtsansprüchen oder eine ausdrücklich vereinbarte längere Aufbewahrung entgegenstehen.</p>
<h2>6. WhatsApp-Verlinkung</h2>
<p>Die Website enthält einen Link zum externen Nachrichtendienst WhatsApp. Erst wenn Sie diesen Link anklicken, verlassen Sie unsere Website und es kann eine Verbindung zu WhatsApp hergestellt werden. Dabei können Daten durch den Anbieter des Dienstes verarbeitet werden. Für diese Verarbeitung gelten die Datenschutzinformationen von WhatsApp.</p>
<h2>7. Lokale Medien und Systemschriften</h2>
<p>Bilder, Logo und Icons werden vom eigenen Webspace geladen. Die Website verwendet auf dem Endgerät vorhandene Systemschriften. Es werden keine Schriftdateien von Google Fonts oder anderen externen Schriftanbietern geladen.</p>
<h2>8. Ihre Rechte</h2>
<p>Betroffene Personen haben nach Maßgabe der gesetzlichen Voraussetzungen Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung der Verarbeitung, Datenübertragbarkeit und Widerspruch. Soweit eine Verarbeitung auf Ihrer Einwilligung beruht, können Sie diese mit Wirkung für die Zukunft widerrufen. Außerdem besteht ein Beschwerderecht bei einer Datenschutzaufsichtsbehörde.</p>
<h2>9. SSL-/TLS-Verschlüsselung</h2>
<p>Für die verschlüsselte Übertragung der Website und der Formularangaben wird HTTPS eingesetzt.</p>
<h2>10. Änderungen</h2>
<p>Diese Datenschutzerklärung wird angepasst, wenn sich die eingesetzten Funktionen, Dienstleister oder Verarbeitungsvorgänge ändern.</p>
</div></section></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?></body></html>
