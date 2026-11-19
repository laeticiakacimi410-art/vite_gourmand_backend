
<?php

require_once __DIR__ . '/../Services/AvisService.php';

class AvisController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new AvisService($pdo);
    }

    public function ajouterAvis()
    {
        return $this->service->ajouterAvis(
            (int) $_POST['note'],
            $_POST['description'],
            (int) $_POST['utilisateur_id']
        );
    }

    public function afficherAvisValides()
    {
        return $this->service->afficherAvisValides();
    }

    public function afficherAvisEnAttente()
    {
        return $this->service->afficherAvisEnAttente();
    }

    public function validerAvis($avisId)
    {
        return $this->service->validerAvis($avisId);
    }

    public function refuserAvis($avisId)
    {
        return $this->service->refuserAvis($avisId);
    }
}
