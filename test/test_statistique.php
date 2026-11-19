
<?php

require_once __DIR__ . '/../config/mongodb.php';
require_once __DIR__ . '/../app/Services/StatistiqueService.php';

$service = new StatistiqueService($mongoDB);

// Ajouter des commandes de test
$service->enregistrerCommande(1);
$service->enregistrerCommande(1);
$service->enregistrerCommande(2);

// Afficher les statistiques
$resultats = $service->compterCommandesParMenu();

foreach ($resultats as $resultat) {
    echo "Menu : " . $resultat->_id;
    echo " | Commandes : " . $resultat->nombre_commandes . "\n";
}
