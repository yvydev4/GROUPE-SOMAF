USE somaf_materiel;

CREATE TABLE postes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO postes (nom) VALUES ('Employé'), ('Mécanicien'), ('Chargé du matériel'), ('Technicien');

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin', 'employe') DEFAULT 'employe',
  poste VARCHAR(100),
  statut ENUM('actif', 'invitation_pending', 'refuse') DEFAULT 'invitation_pending',
  invitation_token VARCHAR(255),
  token_expiration DATETIME,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (nom, email, password, role, poste, statut) VALUES
('Admin SOMAF', 'admin@somaf.com', '', 'admin', 'Administrateur', 'actif'),
('Pierre Dupont', 'pierre@somaf.com', '', 'employe', 'Employé', 'actif'),
('Jean Martin', 'jean@somaf.com', '', 'employe', 'Employé', 'actif'),
('Marc Legrand', 'marc@somaf.com', '', 'employe', 'Mécanicien', 'actif'),
('Sylvie Rousseau', 'sylvie@somaf.com', '', 'employe', 'Chargé du matériel', 'actif');

CREATE TABLE equipment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nom VARCHAR(150) NOT NULL,
  matricule VARCHAR(30) UNIQUE,
  categorie VARCHAR(100),
  etat ENUM('disponible', 'emprunte', 'panne', 'en_maintenance', 'hors_service') DEFAULT 'disponible',
  description TEXT,
  photo VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO equipment (nom, matricule, categorie, etat, description) VALUES
('Camionnette Renault', 'SMF-VH0001', 'Véhicule', 'disponible', 'Utilitaire 1.5T'),
('Perceuse Bosch', 'SMF-OT0002', 'Outillage', 'disponible', 'Sans fil 18V'),
('Excavatrice', 'SMF-EG0003', 'Engin lourd', 'disponible', '20T'),
('Echafaudage', 'SMF-EQ0004', 'Équipement', 'disponible', '4m'),
('Marteau piqueur', 'SMF-OT0005', 'Outillage', 'panne', 'En réparation'),
('Compresseur', 'SMF-EQ0006', 'Équipement', 'disponible', '50L'),
('Scie circulaire', 'SMF-OT0007', 'Outillage', 'disponible', 'Professionnelle'),
('Générateur', 'SMF-EQ0008', 'Équipement', 'disponible', '3000W'),
('Échelle', 'SMF-EQ0009', 'Équipement', 'disponible', '6m'),
('Meuleuse', 'SMF-OT0010', 'Outillage', 'disponible', '125mm');

CREATE TABLE loans (
  id INT PRIMARY KEY AUTO_INCREMENT,
  equipment_id INT NOT NULL,
  user_id INT NOT NULL,
  date_emprunt DATE NOT NULL,
  date_retour_prevue DATE,
  date_retour_reel DATE,
  statut ENUM('en_attente', 'en_cours', 'refuse', 'retour_demande', 'termine') DEFAULT 'en_attente',
  motif VARCHAR(255),
  site_nom VARCHAR(150),
  site_adresse VARCHAR(255),
  site_ville VARCHAR(100),
  site_categorie VARCHAR(100),
  motif_refus TEXT,
  commentaire_retour TEXT,
  validated_by INT,
  validated_at DATETIME,
  return_validated_by INT,
  return_validated_at DATETIME,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (equipment_id) REFERENCES equipment(id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (validated_by) REFERENCES users(id),
  FOREIGN KEY (return_validated_by) REFERENCES users(id)
);

CREATE TABLE notifications (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  loan_id INT,
  type VARCHAR(50),
  titre VARCHAR(255),
  message TEXT,
  lu BOOLEAN DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (loan_id) REFERENCES loans(id)
);
