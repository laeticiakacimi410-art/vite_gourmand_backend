<?php

class PlatService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function afficherPlats()
    {
        $sql = "SELECT * FROM plat ORDER BY plat_id DESC";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficherPlat($id)
    {
        $sql = "SELECT * FROM plat WHERE plat_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ajouterPlat($titre, $photo = null)
    {
        $sql = "INSERT INTO plat (titre_plat, photo) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$titre, $photo]);

        return $this->pdo->lastInsertId();
    }

    public function modifierPlat($id, $titre, $photo = null)
    {
        if ($photo === null) {
            $sql = "UPDATE plat SET titre_plat = ? WHERE plat_id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$titre, $id]);
        }

        $sql = "UPDATE plat SET titre_plat = ?, photo = ? WHERE plat_id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titre, $photo, $id]);
    }

    public function supprimerPlat($id)
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare(
                "DELETE FROM menu_plat WHERE plat_id = ?"
            );
            $stmt->execute([$id]);

            $stmt = $this->pdo->prepare(
                "DELETE FROM plat_allergene WHERE plat_id = ?"
            );
            $stmt->execute([$id]);

            $stmt = $this->pdo->prepare(
                "DELETE FROM plat WHERE plat_id = ?"
            );
            $stmt->execute([$id]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function associerMenu($platId, $menuId)
    {
        $sql = "INSERT INTO menu_plat (menu_id, plat_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$menuId, $platId]);
    }

    public function associerAllergene($platId, $allergeneId)
    {
        $sql = "INSERT INTO plat_allergene (plat_id, allergene_id)
                VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$platId, $allergeneId]);
    }

    public function afficherAllergenes()
    {
        $sql = "SELECT * FROM allergene ORDER BY libelle";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function afficherAllergenesPlat($platId)
    {
        $sql = "SELECT a.allergene_id, a.libelle
                FROM allergene a
                INNER JOIN plat_allergene pa
                ON a.allergene_id = pa.allergene_id
                WHERE pa.plat_id = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$platId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}