
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Services/MenuService.php';

$service = new MenuService($pdo);

// Test affichage des menus
$menus = $service->afficherMenus();

echo "Liste des menus :\n";
print_r($menus);
