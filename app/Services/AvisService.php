
<?php

class AvisService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Ajouter un avis
    public function ajouterAvis($note, $description, $utilisateurId)
    {
        if ($note < 1 || $note > 5) {
            throw new Exception("La note doit être comprise entre 1 et 5.");
        }

        $sql = "INSERT INTO avis (note, description, statut, utilisateur_id)
                VALUES (?, ?, 'en attente', ?)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $note,
            $description,
            $utilisateurId
        ]);
    }

    // Afficher les avis validés
    public function afficherAvisValides()
    {
        $sql = "SELECT avis.*, utilisateur.prenom
                FROM avis
                JOIN utilisateur
                ON avis.utilisateur_id = utilisateur.utilisateur_id
                WHERE avis.statut = 'validé'";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Afficher les avis en attente
    public function afficherAvisEnAttente()
    {
        $sql = "SELECT * FROM avis WHERE statut = 'en attente'";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Valider un avis
    public function validerAvis($avisId)
    {
        $sql = "UPDATE avis SET statut = 'validé' WHERE avis_id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$avisId]);
    }

    // Refuser un avis
    public function refuserAvis($avisId)
    {
        $sql = "UPDATE avis SET statut = 'refusé' WHERE avis_id = ?";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$avisId]);
    }
}
