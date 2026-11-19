
<?php

require_once __DIR__ . '/../Services/MenuService.php';

class MenuController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new MenuService($pdo);
    }

    public function afficherMenus()
    {
        return $this->service->afficherMenus();
    }

    public function afficherMenu($menuId)
    {
        return $this->service->afficherMenu($menuId);
    }

    public function ajouterMenu()
    {
        return $this->service->ajouterMenu(
            $_POST['titre'],
            $_POST['nombre_personne_minimum'],
            $_POST['prix_par_personne'],
            $_POST['regime_id'],
            $_POST['description'],
            $_POST['quantite_restante'],
            $_POST['theme_id']
        );
    }

    public function modifierMenu()
    {
        return $this->service->modifierMenu(
            $_POST['menu_id'],
            $_POST['titre'],
            $_POST['nombre_personne_minimum'],
            $_POST['prix_par_personne'],
            $_POST['regime_id'],
            $_POST['description'],
            $_POST['quantite_restante'],
            $_POST['theme_id']
        );
    }

    public function modifierStock()
    {
        return $this->service->modifierStock(
            $_POST['menu_id'],
            $_POST['quantite_restante']
        );
    }

    public function supprimerMenu($menuId)
    {
        return $this->service->supprimerMenu($menuId);
    }
}
