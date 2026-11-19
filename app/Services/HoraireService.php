
<?php

class HoraireService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Afficher les horaires
    public function afficherHoraires()
    {
        $sql = "SELECT * FROM horaire ORDER BY horaire_id";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un horaire
    public function ajouterHoraire($jour, $ouverture, $fermeture)
    {
        $sql = "INSERT INTO horaire (jour, heure_ouverture, heure_fermeture)
                VALUES (?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$jour, $ouverture, $fermeture]);
    }

    // Modifier un horaire
    public function modifierHoraire($id, $jour, $ouverture, $fermeture)
    {
        $sql = "UPDATE horaire
                SET jour = ?, heure_ouverture = ?, heure_fermeture = ?
                WHERE horaire_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $jour,
            $ouverture,
            $fermeture,
            $id
        ]);
    }

    // Supprimer un horaire
    public function supprimerHoraire($id)
    {
        $sql = "DELETE FROM horaire WHERE horaire_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$id]);
    }
}
