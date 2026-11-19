<?php

require_once __DIR__ . '/../app/Services/CommandeService.php';

$commande = new CommandeService();

// Test du prix du menu
$prixMenu = $commande->calculerPrixMenu(20, 15, 10);
echo "Prix du menu : " . $prixMenu . " €\n";

// Test de la livraison hors Bordeaux
$prixLivraison = $commande->calculerPrixLivraison(10, false);
echo "Prix livraison : " . $prixLivraison . " €\n";