
<?php

require_once __DIR__ . '/../config/mongodb.php';

try {
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $mongoDB->executeCommand('admin', $command);

    echo "Connexion MongoDB réussie !";

} catch (Exception $e) {
    echo "Erreur MongoDB : " . $e->getMessage();
}
