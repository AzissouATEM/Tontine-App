-- Création de la base
CREATE DATABASE tontine_app CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tontine_app;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Participant', 'Caissier', 'Administrateur', 'Président', 'Secretaire', 'Conseiller') NOT NULL DEFAULT 'Participant',
    statut ENUM('Actif', 'En attente', 'Rejeté') NOT NULL DEFAULT 'En attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des cotisations
CREATE TABLE cotisations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_cotisation DATE NOT NULL DEFAULT CURRENT_DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des retraits
CREATE TABLE retraits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    date_demande DATE NOT NULL DEFAULT CURRENT_DATE,
    statut ENUM('En attente', 'Approuvé', 'Rejeté') NOT NULL DEFAULT 'En attente',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table des logs d'activité (optionnelle)
CREATE TABLE logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    action VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Index pour performance
CREATE INDEX idx_user_role ON users(role);
CREATE INDEX idx_retrait_statut ON retraits(statut);
CREATE INDEX idx_cotisation_date ON cotisations(date_cotisation);
