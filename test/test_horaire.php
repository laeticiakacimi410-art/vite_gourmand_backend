
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Services/HoraireService.php';

$service = new HoraireService($pdo);

$horaires = $service->afficherHoraires();

echo "Horaires de l'entreprise :\n";
print_r($horaires);
