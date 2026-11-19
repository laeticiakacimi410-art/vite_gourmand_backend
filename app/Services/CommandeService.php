
<?php

class CommandeService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function calculerPrixMenu($prixParPersonne, $nombrePersonnes, $minimumPersonnes)
    {
        if ($nombrePersonnes < $minimumPersonnes) {
            throw new Exception("Nombre minimum de personnes non respecté.");
        }

        $prix = $prixParPersonne * $nombrePersonnes;

        if ($nombrePersonnes >= $minimumPersonnes + 5) {
            $prix *= 0.90;
        }

        return round($prix, 2);
    }

    public function calculerPrixLivraison($distanceKm, $estDansBordeaux)
    {
        if ($estDansBordeaux) {
            return 0;
        }

        if ($distanceKm < 0) {
            throw new Exception("Distance invalide.");
        }

        return round(5 + (0.59 * $distanceKm), 2);
    }

    public function creerCommande($numero, $datePrestation, $heureLivraison,
        $nombrePersonnes, $distanceKm, $estDansBordeaux,
        $pretMateriel, $utilisateurId, $menuId)
    {
        $sql = "SELECT prix_par_personne, nombre_personne_minimum
                FROM menu WHERE menu_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$menuId]);
        $menu = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$menu) {
            throw new Exception("Menu introuvable.");
        }

        $prixMenu = $this->calculerPrixMenu(
            $menu['prix_par_personne'],
            $nombrePersonnes,
            $menu['nombre_personne_minimum']
        );

        $prixLivraison = $this->calculerPrixLivraison(
            $distanceKm,
            $estDansBordeaux
        );

        $sql = "INSERT INTO commande (
                    numero_commande, date_commande, date_prestation,
                    heure_livraison, prix_menu, nombre_personne,
                    prix_livraison, statut, pret_materiel,
                    restitution_materiel, utilisateur_id, menu_id
                )
                VALUES (?, CURDATE(), ?, ?, ?, ?, ?, 'en attente', ?, 0, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $numero,
            $datePrestation,
            $heureLivraison,
            $prixMenu,
            $nombrePersonnes,
            $prixLivraison,
            $pretMateriel,
            $utilisateurId,
            $menuId
        ]);
    }

    public function afficherCommandesUtilisateur($utilisateurId)
    {
        $sql = "SELECT * FROM commande WHERE utilisateur_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$utilisateurId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficherToutesCommandes()
    {
        return $this->pdo
            ->query("SELECT * FROM commande")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierCommande($numero, $datePrestation, $heureLivraison, $nombrePersonnes)
    {
        $sql = "SELECT c.menu_id, c.statut, m.prix_par_personne,
                       m.nombre_personne_minimum
                FROM commande c
                JOIN menu m ON c.menu_id = m.menu_id
                WHERE c.numero_commande = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numero]);
        $commande = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$commande || $commande['statut'] !== 'en attente') {
            throw new Exception("Commande introuvable ou non modifiable.");
        }

        $prix = $this->calculerPrixMenu(
            $commande['prix_par_personne'],
            $nombrePersonnes,
            $commande['nombre_personne_minimum']
        );

        $sql = "UPDATE commande
                SET date_prestation = ?, heure_livraison = ?,
                    nombre_personne = ?, prix_menu = ?
                WHERE numero_commande = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $datePrestation,
            $heureLivraison,
            $nombrePersonnes,
            $prix,
            $numero
        ]);
    }

    public function annulerCommande($numero, $utilisateurId)
    {
        $sql = "UPDATE commande
                SET statut = 'annulée'
                WHERE numero_commande = ?
                AND utilisateur_id = ?
                AND statut = 'en attente'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numero, $utilisateurId]);

        return $stmt->rowCount() > 0;
    }

    public function modifierStatut($numero, $statut)
    {
        $statutsAutorises = [
            'accepté',
            'en préparation',
            'en cours de livraison',
            'livré',
            'en attente du retour de matériel',
            'terminée',
            'refusée'
        ];

        if (!in_array($statut, $statutsAutorises, true)) {
            throw new Exception("Statut invalide.");
        }

        $sql = "UPDATE commande SET statut = ? WHERE numero_commande = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$statut, $numero]);
    }
}
