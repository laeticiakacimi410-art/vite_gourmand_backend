
<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Services/UtilisateurService.php';

$service = new UtilisateurService($pdo);

// Test inscription
try {
    $service->inscrire(
        'test@example.com',
        'Test123!abcd',
        'Test',
        '0600000000',
        'Bordeaux',
        'France',
        '10 rue de Bordeaux'
    );

    echo "Inscription réussie !\n";

} catch (PDOException $e) {
    echo "Erreur inscription : " . $e->getMessage() . "\n";
}

// Test connexion
$utilisateur = $service->connecter('test@example.com', 'Test123!abcd');

if ($utilisateur) {
    echo "Connexion réussie !\n";
} else {
    echo "Échec de connexion.\n";
}
