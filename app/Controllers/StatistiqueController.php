
<?php

require_once __DIR__ . '/../Services/StatistiqueService.php';

class StatistiqueController
{
    private $service;

    public function __construct($mongoDB)
    {
        $this->service = new StatistiqueService($mongoDB);
    }

    public function enregistrerCommande($menuId, $numeroCommande)
    {
        return $this->service->enregistrerCommande(
            $menuId,
            $numeroCommande
        );
    }

    public function afficherStatistiques()
    {
        return $this->service->compterCommandesParMenu();
    }
}
