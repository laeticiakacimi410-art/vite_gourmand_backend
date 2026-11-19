 <?php

require_once __DIR__ . '/../Services/PlatService.php';

class PlatController
{
    private $service;

    public function __construct($pdo)
    {
        $this->service = new PlatService($pdo);
    }

    public function afficherPlats()
    {
        return $this->service->afficherPlats();
    }

    public function afficherPlat($id)
    {
        return $this->service->afficherPlat($id);
    }

    public function ajouterPlat()
    {
        $titre = $_POST['titre_plat'] ?? '';
        $photo = isset($_POST['photo']) ? base64_decode($_POST['photo']) : null;

        if (empty($titre)) {
            return ['success' => false, 'message' => 'Titre obligatoire'];
        }

        $id = $this->service->ajouterPlat($titre, $photo);

        return ['success' => true, 'plat_id' => $id];
    }

    public function modifierPlat($id)
    {
        $titre = $_POST['titre_plat'] ?? '';

        if (empty($titre)) {
            return ['success' => false, 'message' => 'Titre obligatoire'];
        }

        $photo = isset($_POST['photo'])
            ? base64_decode($_POST['photo'])
            : null;

        return [
            'success' => $this->service->modifierPlat($id, $titre, $photo)
        ];
    }

    public function supprimerPlat($id)
    {
        return [
            'success' => $this->service->supprimerPlat($id)
        ];
    }

    public function associerMenu()
    {
        return [
            'success' => $this->service->associerMenu(
                $_POST['plat_id'],
                $_POST['menu_id']
            )
        ];
    }

    public function associerAllergene()
    {
        return [
            'success' => $this->service->associerAllergene(
                $_POST['plat_id'],
                $_POST['allergene_id']
            )
        ];
    }

    public function afficherAllergenes()
    {
        return $this->service->afficherAllergenes();
    }

    public function afficherAllergenesPlat($id)
    {
        return $this->service->afficherAllergenesPlat($id);
    }
}