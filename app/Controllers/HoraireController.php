
<?php

require_once __DIR__ . '/../Services/HoraireService.php';

class HoraireController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new HoraireService($pdo);
    }

    public function afficherHoraires()
    {
        return $this->service->afficherHoraires();
    }

    public function ajouterHoraire()
    {
        return $this->service->ajouterHoraire(
            $_POST['jour'],
            $_POST['heure_ouverture'],
            $_POST['heure_fermeture']
        );
    }

    public function modifierHoraire()
    {
        return $this->service->modifierHoraire(
            $_POST['horaire_id'],
            $_POST['jour'],
            $_POST['heure_ouverture'],
            $_POST['heure_fermeture']
        );
    }

    public function supprimerHoraire($id)
    {
        return $this->service->supprimerHoraire($id);
    }
}
