
<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../app/Controllers/UtilisateurController.php';
require_once __DIR__ . '/../app/Controllers/MenuController.php';
require_once __DIR__ . '/../app/Controllers/CommandeController.php';
require_once __DIR__ . '/../app/Controllers/AvisController.php';
require_once __DIR__ . '/../app/Controllers/StatistiqueController.php';
require_once __DIR__ . '/../app/Controllers/HoraireController.php';
require_once __DIR__ . '/../app/Controllers/PlatController.php';
require_once __DIR__ . '/../app/Middleware/Auth.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$methode = $_SERVER['REQUEST_METHOD'];

// ACCUEIL
if ($uri === '/' || $uri === '/index.php') {
    echo json_encode(['message' => 'Bienvenue sur Vite & Gourmand']);
}

// MENUS
elseif ($uri === '/menus' && $methode === 'GET') {
    $controller = new MenuController($pdo);
    echo json_encode($controller->afficherMenus());
}
elseif (preg_match('#^/menu/([0-9]+)$#', $uri, $matches) && $methode === 'GET') {
    $controller = new MenuController($pdo);
    echo json_encode($controller->afficherMenu($matches[1]));
}
elseif ($uri === '/menu' && $methode === 'POST') {
    verifierRole(['employe', 'administrateur']);
    $controller = new MenuController($pdo);
    echo json_encode(['success' => $controller->ajouterMenu()]);
}
elseif ($uri === '/menu' && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $controller = new MenuController($pdo);
    echo json_encode(['success' => $controller->modifierMenu()]);
}
elseif ($uri === '/menu/stock' && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $controller = new MenuController($pdo);
    echo json_encode(['success' => $controller->modifierStock()]);
}
elseif (preg_match('#^/menu/([0-9]+)$#', $uri, $matches) && $methode === 'DELETE') {
    verifierRole(['employe', 'administrateur']);
    $controller = new MenuController($pdo);
    echo json_encode(['success' => $controller->supprimerMenu($matches[1])]);
}

// PLATS ET ALLERGENES
elseif ($uri === '/plats' && $methode === 'GET') {
    $controller = new PlatController($pdo);
    echo json_encode($controller->afficherPlats());
}
elseif ($uri === '/allergenes' && $methode === 'GET') {
    $controller = new PlatController($pdo);
    echo json_encode($controller->afficherAllergenes());
}
elseif (preg_match('#^/plat/([0-9]+)/allergenes$#', $uri, $matches) && $methode === 'GET') {
    $controller = new PlatController($pdo);
    echo json_encode($controller->afficherAllergenesPlat($matches[1]));
}
elseif (preg_match('#^/plat/([0-9]+)$#', $uri, $matches) && $methode === 'GET') {
    $controller = new PlatController($pdo);
    echo json_encode($controller->afficherPlat($matches[1]));
}
elseif ($uri === '/plat' && $methode === 'POST') {
    verifierRole(['employe', 'administrateur']);
    $controller = new PlatController($pdo);
    echo json_encode($controller->ajouterPlat());
}
elseif (preg_match('#^/plat/([0-9]+)$#', $uri, $matches) && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $controller = new PlatController($pdo);
    echo json_encode($controller->modifierPlat($matches[1]));
}
elseif (preg_match('#^/plat/([0-9]+)$#', $uri, $matches) && $methode === 'DELETE') {
    verifierRole(['employe', 'administrateur']);
    $controller = new PlatController($pdo);
    echo json_encode($controller->supprimerPlat($matches[1]));
}
elseif ($uri === '/plat/menu' && $methode === 'POST') {
    verifierRole(['employe', 'administrateur']);
    $controller = new PlatController($pdo);
    echo json_encode($controller->associerMenu());
}
elseif ($uri === '/plat/allergene' && $methode === 'POST') {
    verifierRole(['employe', 'administrateur']);
    $controller = new PlatController($pdo);
    echo json_encode($controller->associerAllergene());
}

// HORAIRES
elseif ($uri === '/horaires' && $methode === 'GET') {
    $controller = new HoraireController($pdo);
    echo json_encode($controller->afficherHoraires());
}
elseif ($uri === '/horaire' && $methode === 'POST') {
    verifierRole(['employe', 'administrateur']);
    $controller = new HoraireController($pdo);
    echo json_encode(['success' => $controller->ajouterHoraire()]);
}
elseif ($uri === '/horaire' && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $controller = new HoraireController($pdo);
    echo json_encode(['success' => $controller->modifierHoraire()]);
}
elseif (preg_match('#^/horaire/([0-9]+)$#', $uri, $matches) && $methode === 'DELETE') {
    verifierRole(['employe', 'administrateur']);
    $controller = new HoraireController($pdo);
    echo json_encode(['success' => $controller->supprimerHoraire($matches[1])]);
}

// AVIS
elseif ($uri === '/avis' && $methode === 'GET') {
    $controller = new AvisController($pdo);
    echo json_encode($controller->afficherAvisValides());
}
elseif ($uri === '/avis' && $methode === 'POST') {
    verifierRole(['utilisateur']);
    $_POST['utilisateur_id'] = $_SESSION['utilisateur']['utilisateur_id'];
    $controller = new AvisController($pdo);
    echo json_encode(['success' => $controller->ajouterAvis()]);
}
elseif ($uri === '/avis/en-attente' && $methode === 'GET') {
    verifierRole(['employe', 'administrateur']);
    $controller = new AvisController($pdo);
    echo json_encode($controller->afficherAvisEnAttente());
}
elseif (preg_match('#^/avis/([0-9]+)/valider$#', $uri, $matches) && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    $controller = new AvisController($pdo);
    echo json_encode(['success' => $controller->validerAvis($matches[1])]);
}
elseif (preg_match('#^/avis/([0-9]+)/refuser$#', $uri, $matches) && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    $controller = new AvisController($pdo);
    echo json_encode(['success' => $controller->refuserAvis($matches[1])]);
}

// UTILISATEURS
elseif ($uri === '/inscription' && $methode === 'POST') {
    $controller = new UtilisateurController($pdo);
    echo json_encode([
        'success' => $controller->inscrire(),
        'message' => 'Inscription réussie'
    ]);
}
elseif ($uri === '/connexion' && $methode === 'POST') {
    $controller = new UtilisateurController($pdo);
    $utilisateur = $controller->connecter();

    if ($utilisateur) {
        echo json_encode(['success' => true, 'utilisateur' => $utilisateur]);
    } else {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Identifiants incorrects']);
    }
}
elseif ($uri === '/deconnexion' && $methode === 'POST') {
    verifierConnexion();
    $controller = new UtilisateurController($pdo);
    echo json_encode(['success' => $controller->deconnecter()]);
}
elseif ($uri === '/utilisateurs' && $methode === 'GET') {
    verifierRole(['administrateur']);
    $controller = new UtilisateurController($pdo);
    echo json_encode($controller->afficherUtilisateurs());
}
elseif ($uri === '/employe' && $methode === 'POST') {
    verifierRole(['administrateur']);
    $controller = new UtilisateurController($pdo);
    echo json_encode(['success' => $controller->creerEmploye()]);
}
elseif ($uri === '/utilisateur/role' && $methode === 'PUT') {
    verifierRole(['administrateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $controller = new UtilisateurController($pdo);
    echo json_encode(['success' => $controller->modifierRole()]);
}

// COMMANDES
elseif ($uri === '/commande' && $methode === 'POST') {
    verifierRole(['utilisateur']);
    $_POST['utilisateur_id'] = $_SESSION['utilisateur']['utilisateur_id'];
    $controller = new CommandeController($pdo, $mongoDB);
    echo json_encode([
        'success' => $controller->creerCommande(),
        'message' => 'Commande enregistrée'
    ]);
}
elseif (preg_match('#^/commandes/utilisateur/([0-9]+)$#', $uri, $matches) && $methode === 'GET') {
    verifierConnexion();

    $idConnecte = (int) $_SESSION['utilisateur']['utilisateur_id'];
    $role = $_SESSION['utilisateur']['role'];

    if ($role === 'utilisateur' && $idConnecte !== (int) $matches[1]) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Accès interdit']);
        exit;
    }

    verifierRole(['utilisateur', 'employe', 'administrateur']);
    $controller = new CommandeController($pdo, $mongoDB);
    echo json_encode($controller->afficherCommandesUtilisateur($matches[1]));
}
elseif ($uri === '/commandes' && $methode === 'GET') {
    verifierRole(['employe', 'administrateur']);
    $controller = new CommandeController($pdo, $mongoDB);
    echo json_encode($controller->afficherToutesCommandes());
}
elseif ($uri === '/commande/modifier' && $methode === 'PUT') {
    verifierConnexion();
    parse_str(file_get_contents('php://input'), $_POST);

    $role = $_SESSION['utilisateur']['role'];

    if ($role === 'utilisateur') {
        $stmt = $pdo->prepare("SELECT utilisateur_id FROM commande WHERE numero_commande = ?");
        $stmt->execute([$_POST['numero_commande'] ?? '']);
        $commande = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$commande || (int) $commande['utilisateur_id'] !== (int) $_SESSION['utilisateur']['utilisateur_id']) {
            http_response_code(403);
            echo json_encode(['success' => false, 'message' => 'Accès interdit']);
            exit;
        }
    } elseif (!in_array($role, ['employe', 'administrateur'], true)) {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Accès interdit']);
        exit;
    }

    $controller = new CommandeController($pdo, $mongoDB);
    echo json_encode(['success' => $controller->modifierCommande()]);
}
elseif ($uri === '/commande/annuler' && $methode === 'PUT') {
    verifierRole(['utilisateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $_POST['utilisateur_id'] = $_SESSION['utilisateur']['utilisateur_id'];
    $controller = new CommandeController($pdo, $mongoDB);
    echo json_encode(['success' => $controller->annulerCommande()]);
}
elseif ($uri === '/commande/statut' && $methode === 'PUT') {
    verifierRole(['employe', 'administrateur']);
    parse_str(file_get_contents('php://input'), $_POST);
    $controller = new CommandeController($pdo, $mongoDB);
    echo json_encode(['success' => $controller->modifierStatut()]);
}

// STATISTIQUES
elseif ($uri === '/statistiques' && $methode === 'GET') {
    verifierRole(['administrateur']);
    $controller = new StatistiqueController($mongoDB);
    echo json_encode($controller->afficherStatistiques());
}

// ROUTE INCONNUE
else {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Route introuvable']);
}
