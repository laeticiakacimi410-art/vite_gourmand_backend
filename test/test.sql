
--horairs
INSERT INTO horaire (jour, heure_ouverture, heure_fermeture)
VALUES
('Lundi', '09:00', '18:00'),
('Mardi', '09:00', '18:00'),
('Mercredi', '09:00', '18:00'),
('Jeudi', '09:00', '18:00'),
('Vendredi', '09:00', '18:00'),
('Samedi', '10:00', '17:00'),
('Dimanche', 'Fermé', 'Fermé');

--menus
INSERT INTO regime (libelle)
VALUES ('Classique'), ('Végétarien'), ('Vegan');

INSERT INTO theme (libelle)
VALUES ('Traditionnel'), ('Italien'), ('Gastronomique');

INSERT INTO menu (
    titre,
    nombre_personne_minimum,
    prix_par_personne,
    regime_id,
    description,
    quantite_restante,
    theme_id
)
VALUES
('Menu Traditionnel', 4, 25, 1, 'Cuisine traditionnelle', 20, 1),
('Menu Italien', 2, 30, 1, 'Saveurs italiennes', 15, 2),
('Menu Vegan', 4, 28, 3, 'Cuisine 100% végétale', 10, 3);