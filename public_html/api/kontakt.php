<?php
declare(strict_types=1);

// Öffentlicher Endpunkt bleibt bewusst schlank; Validierung und Versand liegen außerhalb des Document Roots.
require dirname($_SERVER['DOCUMENT_ROOT']) . '/app/forms/contact-handler.php';
