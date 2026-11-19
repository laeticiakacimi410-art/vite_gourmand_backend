
<?php

class UtilisateurService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function inscrire($email, $password, $prenom, $telephone, $ville, $pays, $adresse)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateur
                (email, password, prenom, telephone, ville, pays, adresse_postale, role_id)
                VALUES (?, ?, ?, ?, ?, ?, ?,
                (SELECT role_id FROM role WHERE libelle = 'utilisateur' LIMIT 1))";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $email, $passwordHash, $prenom, $telephone,
            $ville, $pays, $adresse
        ]);
    }

    public function connecter($email, $password)
    {
        $sql = "SELECT utilisateur.*, role.libelle AS role
                FROM utilisateur
                JOIN role ON utilisateur.role_id = role.role_id
                WHERE email = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($utilisateur && password_verify($password, $utilisateur['password'])) {
            return $utilisateur;
        }

        return false;
    }

    public function creerEmploye($email, $password, $prenom, $telephone, $ville, $pays, $adresse)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateur
                (email, password, prenom, telephone, ville, pays, adresse_postale, role_id)
                VALUES (?, ?, ?, ?, ?, ?, ?,
                (SELECT role_id FROM role WHERE libelle = 'employe' LIMIT 1))";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $email, $passwordHash, $prenom, $telephone,
            $ville, $pays, $adresse
        ]);
    }

    public function afficherUtilisateurs()
    {
        $sql = "SELECT utilisateur_id, email, prenom, telephone,
                ville, pays, adresse_postale, role_id
                FROM utilisateur";

        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function modifierRole($utilisateurId, $roleId)
    {
        $sql = "UPDATE utilisateur SET role_id = ?
                WHERE utilisateur_id = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$roleId, $utilisateurId]);
    }
}
