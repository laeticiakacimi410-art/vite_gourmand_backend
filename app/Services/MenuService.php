
<?php

class MenuService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Afficher tous les menus
    public function afficherMenus()
    {
        $sql = "SELECT menu.*, regime.libelle AS regime,
                theme.libelle AS theme
                FROM menu
                JOIN regime ON menu.regime_id = regime.regime_id
                JOIN theme ON menu.theme_id = theme.theme_id";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Afficher un menu
    public function afficherMenu($menuId)
    {
        $sql = "SELECT menu.*, regime.libelle AS regime,
                theme.libelle AS theme
                FROM menu
                JOIN regime ON menu.regime_id = regime.regime_id
                JOIN theme ON menu.theme_id = theme.theme_id
                WHERE menu_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$menuId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter un menu
    public function ajouterMenu($titre, $minimum, $prix, $regime, $description, $stock, $theme)
    {
        $sql = "INSERT INTO menu
                (titre, nombre_personne_minimum, prix_par_personne,
                regime_id, description, quantite_restante, theme_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $titre, $minimum, $prix, $regime,
            $description, $stock, $theme
        ]);
    }

    // Modifier un menu
    public function modifierMenu($id, $titre, $minimum, $prix, $regime, $description, $stock, $theme)
    {
        $sql = "UPDATE menu SET
                titre = ?,
                nombre_personne_minimum = ?,
                prix_par_personne = ?,
                regime_id = ?,
                description = ?,
                quantite_restante = ?,
                theme_id = ?
                WHERE menu_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $titre, $minimum, $prix, $regime,
            $description, $stock, $theme, $id
        ]);
    }

    // Modifier le stock
    public function modifierStock($menuId, $quantite)
    {
        $sql = "UPDATE menu SET quantite_restante = ? WHERE menu_id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$quantite, $menuId]);
    }

    // Supprimer un menu
    public function supprimerMenu($menuId)
    {
        $sql = "DELETE FROM menu WHERE menu_id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$menuId]);
    }
}
