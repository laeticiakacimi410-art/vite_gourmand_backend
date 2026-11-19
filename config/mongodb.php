
<?php

try {
    $mongoDB = new MongoDB\Driver\Manager(
        'mongodb://localhost:27017'
    );

} catch (Exception $e) {
    die("Erreur de connexion MongoDB : " . $e->getMessage());
}
