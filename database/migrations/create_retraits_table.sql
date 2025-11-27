CREATE TABLE retraits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    montant DECIMAL(10,2),
    date_demande DATE,
    statut ENUM('En attente','Approuvé','Rejeté') DEFAULT 'En attente',
    FOREIGN KEY (user_id) REFERENCES users(id)
);
