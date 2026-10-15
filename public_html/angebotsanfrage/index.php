<!DOCTYPE html>

<html lang="de"><?php $pageKey = '/angebotsanfrage/'; require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/head.php'; ?><body><?php
$navActive = ['offer'];
$servicesCurrent = false;
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/header.php';
$offerContext = kem_offer_context_from_query($_GET);
$offerCity = kem_offer_cities()[$offerContext['city'] ?? ''] ?? '';
?>
<main id="main"><?php kem_render_breadcrumbs($pageKey); ?><section class="section soft offer-builder-section">
<div class="container offer-builder-shell">
<div class="offer-builder-intro" data-offer-intro="">
<span class="eyebrow">Angebotsanfrage</span>
<h1>Angebot anfordern</h1>
<p class="offer-intro-note">Kostenlos und unverbindlich. Fotos können Sie freiwillig ergänzen.</p>
</div>
<form action="/api/kontakt.php" class="offer-builder" data-ajax="" data-multistep="" data-offer-form="" data-offer-state="editing" data-offer-policy="<?= kem_h(json_encode(kem_offer_client_policy(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>" enctype="multipart/form-data" method="post" novalidate="">
<input name="form_type" type="hidden" value="angebot"/>
<input id="cleaning_types" name="cleaning_types" type="hidden" value=""/>
<div aria-hidden="true" class="hp"><label>Website<input autocomplete="off" name="website" tabindex="-1"/></label></div>
<ol aria-label="Formularfortschritt" class="offer-steps">
<li aria-current="step" class="step-dot is-current" data-step-label="Leistung"><b aria-hidden="true" class="step-index">1</b><span class="step-label">Leistung</span><span class="sr-only" data-step-state="">Aktuell</span></li>
<li class="step-dot is-upcoming" data-step-label="Objekt"><b aria-hidden="true" class="step-index">2</b><span class="step-label">Objekt</span><span class="sr-only" data-step-state="">Noch offen</span></li>
<li class="step-dot is-upcoming" data-step-label="Termin"><b aria-hidden="true" class="step-index">3</b><span class="step-label">Termin</span><span class="sr-only" data-step-state="">Noch offen</span></li>
<li class="step-dot is-upcoming" data-step-label="Kontakt"><b aria-hidden="true" class="step-index">4</b><span class="step-label">Kontakt</span><span class="sr-only" data-step-state="">Noch offen</span></li>
<li class="step-dot is-upcoming" data-step-label="Prüfen"><b aria-hidden="true" class="step-index">5</b><span class="step-label">Prüfen</span><span class="sr-only" data-step-state="">Noch offen</span></li>
</ol>
<p class="offer-current-step" data-offer-current-step="">Schritt 1 von 5: Leistung</p>
<section class="form-step active" data-step-name="Leistung">
<div class="step-heading"><span>Schritt 1 von 5</span><h2>Was dürfen wir für Sie reinigen?</h2><p>Wählen Sie eine oder mehrere Leistungen aus.</p></div>
<fieldset class="field full service-choice-fieldset" data-service-choice-group="">
<legend>Leistungen auswählen&nbsp;*</legend>
<p class="field-hint" data-offer-context-city=""<?= $offerCity === '' ? ' hidden' : '' ?>>Einsatzort: <span data-offer-context-city-value=""><?= kem_h($offerCity) ?></span>. Im nächsten Schritt änderbar.</p>
<div class="service-choice-grid">
<label class="service-choice"><input data-cleaning-type="office" name="type_office" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'office' ? ' checked' : '' ?>/><span><b>Büro- und Gewerberaumreinigung</b><small>Regelmäßig oder einmalig</small></span></label>
<label class="service-choice"><input data-cleaning-type="window" name="type_window" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'window' ? ' checked' : '' ?>/><span><b>Glas- und Fensterreinigung</b><small>Glasflächen, Rahmen und Falze</small></span></label>
<label class="service-choice"><input data-cleaning-type="general" name="type_general" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'general' ? ' checked' : '' ?>/><span><b>Grund- und Spezialreinigung</b><small>Intensive Reinigung für besondere Anlässe</small></span></label>
<label class="service-choice"><input data-cleaning-type="carpet" name="type_carpet" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'carpet' ? ' checked' : '' ?>/><span><b>Teppichreinigung</b><small>Lose und festverlegte Teppiche</small></span></label>
<label class="service-choice"><input data-cleaning-type="upholstery" name="type_upholstery" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'upholstery' ? ' checked' : '' ?>/><span><b>Polsterreinigung</b><small>Sofas, Sessel, Stühle und Hocker</small></span></label>
<label class="service-choice"><input data-cleaning-type="clearance" name="type_clearance" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'clearance' ? ' checked' : '' ?>/><span><b>Entrümpelung</b><small>Wohnungen, Keller, Büros und Lager</small></span></label>
<label class="service-choice"><input data-cleaning-type="graffiti" name="type_graffiti" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'graffiti' ? ' checked' : '' ?>/><span><b>Fassaden- und Graffitireinigung</b><small>Graffitientfernung und Außenflächen</small></span></label>
<label class="service-choice"><input data-cleaning-type="solar" name="type_solar" type="checkbox" value="1"<?= ($offerContext['service'] ?? null) === 'solar' ? ' checked' : '' ?>/><span><b>Solar- und Photovoltaikanlagenreinigung</b><small>Module und Solaranlagen</small></span></label>
<label class="service-choice"><input data-cleaning-type="other" name="type_other" type="checkbox" value="1"/><span><b>Sonstige Leistung</b><small>Individuelle Reinigungsanfrage</small></span></label>
</div>
<p aria-live="polite" class="field-error" data-service-choice-error=""></p>
</fieldset>
<div class="form-actions"><span></span><button class="btn" data-next="" type="button">Weiter zum Objekt</button></div>
</section>
<section class="form-step" data-step-name="Objekt und Details">
<div class="step-heading"><span>Schritt 2 von 5</span><h2>Objekt und Umfang</h2><p>Ein paar Angaben zum Einsatzort helfen uns, den Aufwand realistisch einzuschätzen. Mit * markierte Felder benötigen wir für die ausgewählte Leistung. Alle anderen Angaben sind optional.</p></div>
<div class="conditional-card object-location-card">
<h3>Einsatzort</h3>
<div class="form-grid">
<div class="field full"><label for="cleaning_company">Firma / Objektbezeichnung am Einsatzort <span class="optional-label">(optional)</span></label><input aria-describedby="cleaning-company-hint" autocomplete="section-object organization" id="cleaning_company" maxlength="120" name="cleaning_company" placeholder="z. B. Büro Köln"/><p class="field-hint" id="cleaning-company-hint">Bezeichnung des zu reinigenden Objekts; der Auftraggeber kann davon abweichen.</p></div>
<div class="field full"><label for="cleaning_street">Straße und Hausnummer <span class="optional-label">(optional)</span></label><input autocomplete="section-object street-address" id="cleaning_street" maxlength="160" name="cleaning_street" placeholder="z. B. Musterstraße 12"/></div>
<div class="field"><label for="cleaning_postcode">PLZ&nbsp;*</label><input autocomplete="section-object postal-code" id="cleaning_postcode" inputmode="numeric" maxlength="5" name="cleaning_postcode" pattern="[0-9]{5}" required=""/></div>
<div class="field"><label for="cleaning_city">Ort&nbsp;*</label><input autocomplete="section-object address-level2" id="cleaning_city" maxlength="100" name="cleaning_city" required="" value="<?= kem_h($offerCity) ?>"/></div>
</div>
</div>
<div class="form-grid object-basics-new">
<div class="field"><label for="object_type">Objektart&nbsp;*</label><select id="object_type" name="object_type" required=""><option value="">Bitte auswählen</option><option>Wohnung</option><option>Einfamilienhaus</option><option>Mehrfamilienhaus</option><option>Büro / Gewerbe</option><option>Praxis / Kanzlei</option><option>Gastronomie / Hotel</option><option>Öffentliche Einrichtung</option><option>Industrie / Lager</option><option>Sonstiges Objekt</option></select></div>
<div class="field" data-offer-optional-field="floor"><label for="floor">Etage / Zugang zum Einsatzort <span class="optional-label">(optional)</span></label><input aria-describedby="floor-hint" id="floor" maxlength="180" name="floor" placeholder="z. B. EG, 3. OG oder Zugang über den Hof"/><p class="field-hint" id="floor-hint">Gilt für alle gewählten Leistungen am selben Einsatzort. Mehrere Etagen oder Zugänge können Sie gemeinsam angeben.</p></div>
<div class="field full" data-offer-optional-field="furnishing"><label for="furnishing">Art der Möblierung <span class="optional-label">(optional)</span></label><select id="furnishing" name="furnishing"><option value="">Bitte auswählen</option><option>Unmöbliert / leer</option><option>Teilweise möbliert</option><option>Voll möbliert</option><option>Nicht relevant</option></select></div>
</div>
<div class="service-detail-empty" data-service-detail-empty="">Bitte wählen Sie im vorherigen Schritt mindestens eine Reinigungsart aus.</div>
<section class="service-detail-panel" data-service-panel="office" hidden="">
<div class="detail-panel-heading"><span>01</span><div><h3>Büro- und Gewerberaumreinigung</h3><p>Angaben zu Fläche, Turnus, Räumen und Verschmutzung.</p></div></div>
<div class="form-grid">
<div class="field"><label for="office_area">Fläche in m²&nbsp;*</label><input data-required-when-active="" id="office_area" inputmode="decimal" maxlength="20" name="office_area" placeholder="z. B. 250"/><label class="estimate-option" for="office_area_estimate"><input aria-controls="office_area" data-estimate-for="office_area" id="office_area_estimate" type="checkbox"/><span>Weiß ich nicht – bitte vor Ort einschätzen</span></label></div>
<div class="field"><label for="office_frequency">Gewünschter Turnus&nbsp;*</label><select data-required-when-active="" id="office_frequency" name="office_frequency"><option value="">Bitte auswählen</option><option>Einmalig</option><option>Täglich</option><option>Mehrmals pro Woche</option><option>Wöchentlich</option><option>14-täglich</option><option>Monatlich</option><option>Nach Vereinbarung</option></select></div>
<div class="field"><label for="office_rooms">Räume / Bereiche <span class="optional-label">(optional)</span></label><input id="office_rooms" maxlength="160" name="office_rooms" placeholder="z. B. 8 Büros, Küche und Sanitär"/></div>
<div class="field"><label for="office_soiling">Grad der Verschmutzung <span class="optional-label">(optional)</span></label><select id="office_soiling" name="office_soiling"><option value="">Bitte auswählen</option><option>Leicht</option><option>Mittel</option><option>Stark</option><option>Sehr stark / Sonderverschmutzung</option><option>Weiß ich nicht</option></select></div>
<div class="field full"><label for="office_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="office_notes" maxlength="2000" name="office_notes" placeholder="Nutzungszeiten, Schlüsselregelung oder besondere Bereiche"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="general" hidden="">
<div class="detail-panel-heading"><span>01</span><div><h3>Allgemeine Reinigung</h3><p>Angaben zur Fläche, zum Anlass und zur Verschmutzung.</p></div></div>
<div class="form-grid">
<div class="field"><label for="general_area">Fläche in m²&nbsp;*</label><input data-required-when-active="" id="general_area" inputmode="decimal" maxlength="20" name="general_area" placeholder="z. B. 250"/><label class="estimate-option" for="general_area_estimate"><input aria-controls="general_area" data-estimate-for="general_area" id="general_area_estimate" type="checkbox"/><span>Weiß ich nicht – bitte vor Ort einschätzen</span></label></div>
<div class="field"><label for="general_reason">Anlass der Reinigung&nbsp;*</label><select data-required-when-active="" id="general_reason" name="general_reason"><option value="">Bitte auswählen</option><option>Regelmäßige Unterhaltsreinigung</option><option>Einmalige Grundreinigung</option><option>Einzug / Auszug</option><option>Bauzwischen- / Bauendreinigung</option><option>Nach Veranstaltung</option><option>Sonstiger Anlass</option></select></div>
<div class="field"><label for="general_soiling">Grad der Verschmutzung <span class="optional-label">(optional)</span></label><select id="general_soiling" name="general_soiling"><option value="">Bitte auswählen</option><option>Leicht</option><option>Mittel</option><option>Stark</option><option>Sehr stark / Sonderverschmutzung</option><option>Weiß ich nicht</option></select></div>
<div class="field full"><label for="general_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="general_notes" maxlength="2000" name="general_notes" placeholder="Welche Räume oder Bereiche sollen gereinigt werden?"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="window" hidden="">
<div class="detail-panel-heading"><span>02</span><div><h3>Fensterreinigung</h3><p>Angaben zu Höhe, Fensteranzahl und gewünschtem Umfang.</p></div></div>
<div class="form-grid">
<div class="field"><label for="window_max_height">Maximale Raum- / Arbeitshöhe <span class="optional-label">(optional)</span></label><input id="window_max_height" maxlength="40" name="window_max_height" placeholder="z. B. 2,5 m oder 4 m"/></div>
<div class="field"><label for="window_sashes">Fensterflügel&nbsp;*</label><input data-required-when-active="" id="window_sashes" maxlength="80" name="window_sashes" placeholder="Fensteranzahl × Flügel"/><label class="estimate-option" for="window_sashes_estimate"><input aria-controls="window_sashes" data-estimate-for="window_sashes" id="window_sashes_estimate" type="checkbox"/><span>Weiß ich nicht – bitte vor Ort einschätzen</span></label></div>
<div class="field"><label for="window_scope">Reinigungswunsch&nbsp;*</label><select data-required-when-active="" id="window_scope" name="window_scope"><option value="">Bitte auswählen</option><option>Glas innen</option><option>Glas außen</option><option>Glas innen und außen</option><option>Glas und Rahmen</option><option>Glas, Rahmen und Falze</option></select></div>
<div class="field"><label for="window_soiling">Grad der Verschmutzung <span class="optional-label">(optional)</span></label><select id="window_soiling" name="window_soiling"><option value="">Bitte auswählen</option><option>Leicht</option><option>Mittel</option><option>Stark</option><option>Sehr stark / Sonderverschmutzung</option><option>Weiß ich nicht</option></select></div>
<div class="field full"><label for="window_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="window_notes" maxlength="2000" name="window_notes" placeholder="Zugänglichkeit, Wintergarten, Dachfenster oder besondere Glasflächen"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="carpet" hidden="">
<div class="detail-panel-heading"><span>03</span><div><h3>Teppichreinigung</h3><p>Lose Teppiche und festverlegte Teppichflächen können gemeinsam angegeben werden.</p></div></div>
<div class="form-grid">
<div class="field"><label for="carpet_loose_count">Lose Teppiche <span class="optional-label">(optional)</span></label><input id="carpet_loose_count" inputmode="numeric" maxlength="10" name="carpet_loose_count" placeholder="Anzahl"/></div>
<div class="field"><label for="carpet_loose_area">Gesamtfläche lose Teppiche <span class="optional-label">(optional)</span></label><input id="carpet_loose_area" inputmode="decimal" maxlength="20" name="carpet_loose_area" placeholder="in m²"/></div>
<div class="field"><label for="carpet_fitted_area">Festverlegter Teppich <span class="optional-label">(optional)</span></label><input id="carpet_fitted_area" inputmode="decimal" maxlength="20" name="carpet_fitted_area" placeholder="Fläche in m²"/></div>
<div class="field"><label for="carpet_scope">Reinigungswunsch&nbsp;*</label><select data-required-when-active="" id="carpet_scope" name="carpet_scope"><option value="">Bitte auswählen</option><option>Auffrischung</option><option>Tiefenreinigung</option><option>Fleckenbehandlung</option><option>Geruchsbehandlung</option><option>Komplettreinigung</option></select></div>
<div class="field"><label for="carpet_soiling">Grad der Verschmutzung&nbsp;*</label><select data-required-when-active="" id="carpet_soiling" name="carpet_soiling"><option value="">Bitte auswählen</option><option>Leicht</option><option>Mittel</option><option>Stark</option><option>Sehr stark / Sonderverschmutzung</option><option>Weiß ich nicht</option></select></div>
<div class="field full"><label for="carpet_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="carpet_notes" maxlength="2000" name="carpet_notes" placeholder="Material, Fleckenart, Haustiere oder besondere Hinweise"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="upholstery" hidden="">
<div class="detail-panel-heading"><span>04</span><div><h3>Polsterreinigung</h3><p>Bitte tragen Sie jeweils die Anzahl der zu reinigenden Möbel ein.</p></div></div>
<div class="form-grid compact-grid">
<div class="field"><label for="upholstery_two_seater">2-Sitzer <span class="optional-label">(optional)</span></label><input id="upholstery_two_seater" inputmode="numeric" min="0" name="upholstery_two_seater" type="number"/></div>
<div class="field"><label for="upholstery_three_seater">3-Sitzer <span class="optional-label">(optional)</span></label><input id="upholstery_three_seater" inputmode="numeric" min="0" name="upholstery_three_seater" type="number"/></div>
<div class="field"><label for="upholstery_corner_small">Ecksofa klein <span class="optional-label">(optional)</span></label><input id="upholstery_corner_small" inputmode="numeric" min="0" name="upholstery_corner_small" type="number"/></div>
<div class="field"><label for="upholstery_corner_large">Ecksofa groß <span class="optional-label">(optional)</span></label><input id="upholstery_corner_large" inputmode="numeric" min="0" name="upholstery_corner_large" type="number"/></div>
<div class="field"><label for="upholstery_armchair">Sessel <span class="optional-label">(optional)</span></label><input id="upholstery_armchair" inputmode="numeric" min="0" name="upholstery_armchair" type="number"/></div>
<div class="field"><label for="upholstery_stool">Hocker <span class="optional-label">(optional)</span></label><input id="upholstery_stool" inputmode="numeric" min="0" name="upholstery_stool" type="number"/></div>
<div class="field"><label for="upholstery_chair_seat">Polsterstuhl ohne Polsterlehne <span class="optional-label">(optional)</span></label><input id="upholstery_chair_seat" inputmode="numeric" min="0" name="upholstery_chair_seat" type="number"/></div>
<div class="field"><label for="upholstery_chair_back">Polsterstuhl mit Polsterlehne <span class="optional-label">(optional)</span></label><input id="upholstery_chair_back" inputmode="numeric" min="0" name="upholstery_chair_back" type="number"/></div>
<div class="field"><label for="upholstery_custom_seats">Individuelles Sofa <span class="optional-label">(optional)</span></label><input id="upholstery_custom_seats" inputmode="numeric" min="0" name="upholstery_custom_seats" placeholder="Sitzflächen" type="number"/></div>
<div class="field"><label for="upholstery_scope">Reinigungswunsch&nbsp;*</label><select data-required-when-active="" id="upholstery_scope" name="upholstery_scope"><option value="">Bitte auswählen</option><option>Auffrischung</option><option>Tiefenreinigung</option><option>Fleckenbehandlung</option><option>Geruchsbehandlung</option><option>Komplettreinigung</option></select></div>
<div class="field"><label for="upholstery_soiling">Grad der Verschmutzung&nbsp;*</label><select data-required-when-active="" id="upholstery_soiling" name="upholstery_soiling"><option value="">Bitte auswählen</option><option>Leicht</option><option>Mittel</option><option>Stark</option><option>Sehr stark / Sonderverschmutzung</option><option>Weiß ich nicht</option></select></div>
<div class="field full"><label for="upholstery_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="upholstery_notes" maxlength="2000" name="upholstery_notes" placeholder="Material, Fleckenart, Haustiere oder besondere Hinweise"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="graffiti" hidden="">
<div class="detail-panel-heading"><span>05</span><div><h3>Fassaden- und Graffitireinigung</h3><p>Angaben zur Fläche, zum Untergrund und zum gewünschten Umfang.</p></div></div>
<div class="form-grid">
<div class="field"><label for="graffiti_area">Fläche in m²&nbsp;*</label><input data-required-when-active="" id="graffiti_area" inputmode="decimal" maxlength="20" name="graffiti_area" placeholder="z. B. 12"/><label class="estimate-option" for="graffiti_area_estimate"><input aria-controls="graffiti_area" data-estimate-for="graffiti_area" id="graffiti_area_estimate" type="checkbox"/><span>Weiß ich nicht – bitte vor Ort einschätzen</span></label></div>
<div class="field"><label for="graffiti_surface">Untergrund&nbsp;*</label><select data-required-when-active="" id="graffiti_surface" name="graffiti_surface"><option value="">Bitte auswählen</option><option>Putz</option><option>Klinker / Ziegel</option><option>Beton</option><option>Naturstein</option><option>Metall</option><option>Glas</option><option>Kunststoff</option><option>Unbekannt / Sonstiges</option></select></div>
<div class="field"><label for="graffiti_scope">Reinigungswunsch <span class="optional-label">(optional)</span></label><select id="graffiti_scope" name="graffiti_scope"><option value="">Bitte auswählen</option><option>Graffiti entfernen</option><option>Fassade grundreinigen</option><option>Schutzbeschichtung erneuern</option><option>Reinigung und Schutzbeschichtung</option></select></div>
<div class="field full"><label for="graffiti_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="graffiti_notes" maxlength="2000" name="graffiti_notes" placeholder="Zugänglichkeit, Höhe, Alter des Graffitis oder sonstige Hinweise"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="solar" hidden="">
<div class="detail-panel-heading"><span>06</span><div><h3>Solar- und Photovoltaikanlagenreinigung</h3><p>Angaben zu Modulen, Fläche und Erreichbarkeit.</p></div></div>
<div class="form-grid">
<div class="field"><label for="solar_modules">Anzahl der Module <span class="optional-label">(optional)</span></label><input id="solar_modules" inputmode="numeric" maxlength="10" name="solar_modules"/></div>
<div class="field"><label for="solar_area">Ungefähre Fläche <span class="optional-label">(optional)</span></label><input id="solar_area" inputmode="decimal" maxlength="20" name="solar_area" placeholder="in m²"/></div>
<div class="field"><label for="solar_access">Zugänglichkeit&nbsp;*</label><select data-required-when-active="" id="solar_access" name="solar_access"><option value="">Bitte auswählen</option><option>Flachdach</option><option>Schrägdach</option><option>Freiflächenanlage</option><option>Carport / Überdachung</option><option>Noch unklar</option></select></div>
<div class="field"><label for="solar_soiling">Grad der Verschmutzung&nbsp;*</label><select data-required-when-active="" id="solar_soiling" name="solar_soiling"><option value="">Bitte auswählen</option><option>Leicht</option><option>Mittel</option><option>Stark</option><option>Moos / Flechten / Vogelkot</option></select></div>
<div class="field full"><label for="solar_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="solar_notes" maxlength="2000" name="solar_notes" placeholder="Dachhöhe, Wasseranschluss, Wechselrichter oder besondere Zugangsbedingungen"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="clearance" hidden="">
<div class="detail-panel-heading"><span>07</span><div><h3>Entrümpelung</h3><p>Angaben zum Umfang und zur Entsorgung. Etage und Zugang können Sie oben für den Einsatzort angeben.</p></div></div>
<div class="form-grid">
<div class="field"><label for="clearance_area">Objektfläche&nbsp;*</label><input data-required-when-active="" id="clearance_area" inputmode="decimal" maxlength="20" name="clearance_area" placeholder="in m²"/><label class="estimate-option" for="clearance_area_estimate"><input aria-controls="clearance_area" data-estimate-for="clearance_area" id="clearance_area_estimate" type="checkbox"/><span>Weiß ich nicht – bitte vor Ort einschätzen</span></label></div>
<div class="field"><label for="clearance_volume">Geschätztes Volumen <span class="optional-label">(optional)</span></label><input id="clearance_volume" maxlength="80" name="clearance_volume" placeholder="z. B. 1 Kellerraum oder 20 m³"/></div>
<div class="field"><label for="clearance_elevator">Aufzug vorhanden? <span class="optional-label">(optional)</span></label><select id="clearance_elevator" name="clearance_elevator"><option value="">Bitte auswählen</option><option>Ja</option><option>Nein</option><option>Nicht erforderlich</option></select></div>
<div class="field"><label for="clearance_scope">Gewünschter Umfang&nbsp;*</label><select data-required-when-active="" id="clearance_scope" name="clearance_scope"><option value="">Bitte auswählen</option><option>Abtransport und Entsorgung</option><option>Entrümpelung besenrein</option><option>Entrümpelung mit Endreinigung</option><option>Nur Transport / Räumung</option></select></div>
<div class="field full"><label for="clearance_notes">Zusätzliche Informationen <span class="optional-label">(optional)</span></label><textarea id="clearance_notes" maxlength="2000" name="clearance_notes" placeholder="Sperrige Gegenstände, Sondermüll, Parkmöglichkeit oder sonstige Hinweise"></textarea></div>
</div>
</section><section class="service-detail-panel" data-service-panel="other" hidden="">
<div class="detail-panel-heading"><span>08</span><div><h3>Sonstige Leistung</h3><p>Beschreiben Sie kurz, wobei wir Sie unterstützen dürfen.</p></div></div>
<div class="form-grid"><div class="field full"><label for="other_details">Beschreibung&nbsp;*</label><textarea data-required-when-active="" id="other_details" maxlength="3000" name="other_details" placeholder="Art der Fläche, Umfang und gewünschtes Ergebnis"></textarea></div></div>
</section>
<div class="form-actions"><button class="btn secondary" data-prev="" type="button">Zurück</button><button class="btn" data-next="" type="button">Weiter zum Termin</button></div>
</section>
<section class="form-step" data-step-name="Termin und Fotos">
<div class="step-heading"><span>Schritt 3 von 5</span><h2>Wann soll die Reinigung stattfinden?</h2><p>Eine grobe Angabe reicht aus. Fotos sind freiwillig, helfen uns aber bei einer schnelleren und genaueren Einschätzung.</p></div>
<fieldset class="appointment-card">
<legend>Terminwunsch&nbsp;*</legend>
<div class="appointment-choice-grid">
<label class="appointment-choice"><input name="appointment_preference" required="" type="radio" value="Schnellstmöglich"/><span><b>So schnell wie möglich</b><small>Wir schlagen Ihnen den frühestmöglichen Termin vor.</small></span></label>
<label class="appointment-choice"><input name="appointment_preference" required="" type="radio" value="Flexibel"/><span><b>Ich bin flexibel</b><small>Wir stimmen einen passenden Termin gemeinsam ab.</small></span></label>
<label class="appointment-choice"><input name="appointment_preference" required="" type="radio" value="Konkreter Termin"/><span><b>Konkreter Termin</b><small>Sie haben bereits ein Wunschdatum.</small></span></label>
</div>
</fieldset>
<div class="conditional-card exact-date-card" data-exact-date-fields="" hidden="">
<h3>Gewünschter Reinigungstermin</h3>
<div class="form-grid">
<div class="field"><label for="desired_date">Wunschdatum&nbsp;*</label><input data-min-today="" data-required-when-visible="" id="desired_date" name="desired_date" type="date"/></div>
<div class="field"><label for="desired_time">Tageszeit&nbsp;*</label><select data-required-when-visible="" id="desired_time" name="desired_time"><option value="">Bitte auswählen</option><option>Vormittags</option><option>Nachmittags</option><option>Abends</option><option>Flexibel</option></select></div>
</div>
</div>
<div class="field full appointment-note-field"><label for="appointment_notes">Hinweis zum Termin <span class="optional-label">(optional)</span></label><textarea id="appointment_notes" maxlength="1000" name="appointment_notes" placeholder="z. B. KW 34, werktags vormittags oder Zugang nur nach 17 Uhr"></textarea></div>
<div class="field full upload-field">
<label for="photos">Fotos hinzufügen <span class="optional-label">(optional)</span></label>
<p class="field-hint" id="photos-help">Fotos helfen uns, Fläche, Verschmutzung und Zugänglichkeit besser einzuschätzen.</p>
<div class="upload-dropzone" data-upload-dropzone="">
<input accept="image/jpeg,image/png,image/webp" aria-describedby="photos-help photos-limits" id="photos" multiple="" name="photos[]" type="file"/>
<span aria-hidden="true" class="upload-icon">＋</span>
<b>Fotos aufnehmen oder auswählen</b>
<small id="photos-limits">JPG, PNG oder WebP · maximal 5 Dateien · je 5 MB · insgesamt maximal 15 MB</small>
</div>
<ul aria-live="polite" class="upload-file-list upload-preview-list" data-upload-file-list=""></ul>
</div>
<div class="form-actions"><button class="btn secondary" data-prev="" type="button">Zurück</button><button class="btn" data-next="" type="button">Weiter zum Kontakt</button></div>
</section>
<section class="form-step" data-step-name="Kontaktdaten">
<div class="step-heading"><span>Schritt 4 von 5</span><h2>Wie dürfen wir Sie erreichen?</h2><p>Wir benötigen nur die Kontaktdaten, die wir für Rückfragen und die Zusendung Ihres unverbindlichen Angebots brauchen.</p></div>
<div class="form-grid">
<div class="field"><label for="salutation">Anrede <span class="optional-label">(optional)</span></label><select autocomplete="section-customer honorific-prefix" id="salutation" name="salutation"><option value="">Bitte auswählen</option><option>Frau</option><option>Herr</option><option>Divers</option><option>Keine Angabe</option></select></div>
<div class="field"><label for="company">Firma des Auftraggebers <span class="optional-label">(optional)</span></label><input aria-describedby="company-hint" autocomplete="section-customer organization" id="company" maxlength="120" name="company" placeholder="z. B. Muster GmbH"/><p class="field-hint" id="company-hint">Nur falls Sie im Namen eines Unternehmens anfragen.</p><p class="field-hint" data-object-company-preview="" hidden="">Angabe am Einsatzort: <span data-object-company-value=""></span></p><button class="offer-company-copy" data-copy-object-company="" hidden="" type="button">Angabe vom Einsatzort übernehmen</button></div>
<div class="field"><label for="first_name">Vorname&nbsp;*</label><input autocomplete="section-customer given-name" id="first_name" maxlength="80" name="first_name" required=""/></div>
<div class="field"><label for="last_name">Nachname&nbsp;*</label><input autocomplete="section-customer family-name" id="last_name" maxlength="80" name="last_name" required=""/></div>
<div class="field full"><label for="offer-email">E-Mail-Adresse&nbsp;*</label><input autocomplete="section-customer email" id="offer-email" maxlength="160" name="email" required="" type="email"/></div>
<div class="field full"><label for="offer-phone">Telefon <span class="optional-label">(optional)</span></label><input aria-describedby="offer-phone-hint" autocomplete="section-customer tel" id="offer-phone" maxlength="30" name="phone" pattern="[0-9+\(\) /.\-]{6,30}" type="tel"/><p class="field-hint contact-hint" id="offer-phone-hint">Praktisch für kurze Rückfragen – wir antworten sonst per E-Mail.</p></div>
</div>
<div class="form-actions"><button class="btn secondary" data-prev="" type="button">Zurück</button><button class="btn" data-next="" type="button">Angaben prüfen</button></div>
</section>
<section class="form-step" data-step-name="Prüfen und senden">
<div class="step-heading"><span>Schritt 5 von 5</span><h2>Angaben prüfen und Anfrage senden</h2><p>Hier sehen Sie Ihre vollständigen Angaben. Über „Ändern“ springen Sie direkt zum jeweiligen Abschnitt.</p></div>
<div class="offer-review" data-offer-review=""></div>
<div class="field full checkbox privacy-box"><input id="offer-privacy" name="privacy" required="" type="checkbox" value="1"/><label for="offer-privacy">Ich habe die <a href="/datenschutz/" rel="noopener" target="_blank"><u>Datenschutzerklärung</u></a> zur Kenntnis genommen. Meine Angaben und hochgeladenen Fotos werden zur Bearbeitung meiner Angebotsanfrage verarbeitet.&nbsp;*</label></div>
<div class="form-actions"><button class="btn secondary" data-prev="" type="button">Zurück</button><button class="btn" type="submit">Kostenloses Angebot anfordern</button></div>
</section>
<div aria-live="polite" class="form-status" role="status"></div>
</form>
<section aria-labelledby="offer-success-title" class="offer-success" data-offer-success="" hidden="">
<span aria-hidden="true" class="offer-success-icon">✓</span>
<h2 id="offer-success-title" tabindex="-1">Ihre Anfrage wurde gesendet</h2>
<p data-offer-success-message="">Vielen Dank. Ihre Angebotsanfrage wurde erfolgreich gesendet.</p>
<p>Wir prüfen Ihre Angaben und melden uns bei Ihnen.</p>
<p>Ein angegebener Wunschtermin ist noch keine Terminbestätigung.</p>
<div class="offer-success-actions"><button class="btn" data-offer-new-request="" type="button">Neue Anfrage beginnen</button><a class="action-link" href="/kontakt/">Kontakt für Rückfragen</a></div>
</section>
<p class="offer-contact-alternative" data-offer-help="">Fragen zur Anfrage? Alternativ können Sie uns <?php kem_render_action(kem_whatsapp_action($pageKey, 'per WhatsApp schreiben'), 'inline'); ?>.</p>
</div>
</section></main><?php require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/templates/footer.php'; ?><script defer="" src="/assets/js/forms/offer-form.js?v=<?= kem_h($kem['asset_version']) ?>"></script></body></html>
