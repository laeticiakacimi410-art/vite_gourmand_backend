
<?php

require_once __DIR__ . '/../Services/UtilisateurService.php';

class UtilisateurController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new UtilisateurService($pdo);
    }

    public function inscrire()
    {
        return $this->service->inscrire(
            $_POST['email'],
            $_POST['password'],
            $_POST['prenom'],
            $_POST['telephone'],
            $_POST['ville'],
            $_POST['pays'],
            $_POST['adresse_postale']
        );
    }

    
public function connecter()
{
    $utilisateur = $this->service->connecter(
        $_POST['email'],
        $_POST['password']
    );

    if ($utilisateur) {
        unset($utilisateur['password']);

        session_regenerate_id(true);

        $_SESSION['utilisateur'] = $utilisateur;

        return $utilisateur;
    }

    return false;
}

public function deconnecter()
{
    $_SESSION = [];
    session_destroy();

    return true;
}

    public function creerEmploye()
    {
        return $this->service->creerEmploye(
            $_POST['email'],
            $_POST['password'],
            $_POST['prenom'],
            $_POST['telephone'],
            $_POST['ville'],
            $_POST['pays'],
            $_POST['adresse_postale']
        );
    }

    public function afficherUtilisateurs()
    {
        return $this->service->afficherUtilisateurs();
    }

    public function modifierRole()
    {
        return $this->service->modifierRole(
            $_POST['utilisateur_id'],
            $_POST['role_id']
        );
    }
}
