
<?php

require_once __DIR__ . '/../Services/CommandeService.php';
require_once __DIR__ . '/../Services/StatistiqueService.php';

class CommandeController
{
    private $service;
    private $statistiqueService;

    public function __construct($pdo, $mongoDB)
    {
        $this->service = new CommandeService($pdo);
        $this->statistiqueService = new StatistiqueService($mongoDB);
    }

    public function creerCommande()
    {
        $numero = $_POST['numero_commande'];
        $menuId = (int) $_POST['menu_id'];

        $resultat = $this->service->creerCommande(
            $numero,
            $_POST['date_prestation'],
            $_POST['heure_livraison'],
            (int) $_POST['nombre_personne'],
            (float) ($_POST['distance_km'] ?? 0),
            filter_var($_POST['est_dans_bordeaux'] ?? false, FILTER_VALIDATE_BOOLEAN),
            (int) $_POST['pret_materiel'],
            (int) $_POST['utilisateur_id'],
            $menuId
        );

        if ($resultat) {
            $this->statistiqueService->enregistrerCommande(
                $menuId,
                $numero
            );
        }

        return $resultat;
    }

    public function afficherCommandesUtilisateur($utilisateurId)
    {
        return $this->service->afficherCommandesUtilisateur($utilisateurId);
    }

    public function afficherToutesCommandes()
    {
        return $this->service->afficherToutesCommandes();
    }

    public function modifierCommande()
    {
        return $this->service->modifierCommande(
            $_POST['numero_commande'],
            $_POST['date_prestation'],
            $_POST['heure_livraison'],
            (int) $_POST['nombre_personne']
        );
    }

    public function annulerCommande()
    {
        return $this->service->annulerCommande(
            $_POST['numero_commande'],
            (int) $_POST['utilisateur_id']
        );
    }

    public function modifierStatut()
    {
        return $this->service->modifierStatut(
            $_POST['numero_commande'],
            $_POST['statut']
        );
    }
}
