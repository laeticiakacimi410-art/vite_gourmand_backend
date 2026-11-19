
<?php

function verifierConnexion()
{
    if (!isset($_SESSION['utilisateur'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Connexion obligatoire.'
        ]);
        exit;
    }
}

function verifierRole($rolesAutorises)
{
    verifierConnexion();

    $role = $_SESSION['utilisateur']['role'] ?? '';

    if (!in_array($role, $rolesAutorises, true)) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Accès interdit.'
        ]);
        exit;
    }
}
