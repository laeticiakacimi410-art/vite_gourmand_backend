
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Services/AvisService.php';

$service = new AvisService($pdo);

$avis = $service->afficherAvisValides();

echo "Avis validés :\n";
print_r($avis);
