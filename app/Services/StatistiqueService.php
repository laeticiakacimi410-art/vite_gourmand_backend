
<?php

class StatistiqueService
{
    private $mongoDB;

    public function __construct($mongoDB)
    {
        $this->mongoDB = $mongoDB;
    }

    // Enregistrer une commande réelle dans MongoDB
    public function enregistrerCommande($menuId, $numeroCommande)
    {
        $bulk = new MongoDB\Driver\BulkWrite();

        $bulk->insert([
            'numero_commande' => $numeroCommande,
            'menu_id' => (int) $menuId,
            'date' => date('Y-m-d')
        ]);

        return $this->mongoDB->executeBulkWrite(
            'vite_gourmand.statistiques_menus',
            $bulk
        );
    }

    // Compter les commandes par menu
    public function compterCommandesParMenu()
    {
        $commande = new MongoDB\Driver\Command([
            'aggregate' => 'statistiques_menus',
            'pipeline' => [
                [
                    '$group' => [
                        '_id' => '$menu_id',
                        'nombre_commandes' => ['$sum' => 1]
                    ]
                ],
                [
                    '$sort' => ['_id' => 1]
                ]
            ],
            'cursor' => new stdClass()
        ]);

        $resultat = $this->mongoDB->executeCommand(
            'vite_gourmand',
            $commande
        );

        return $resultat->toArray();
    }
}
