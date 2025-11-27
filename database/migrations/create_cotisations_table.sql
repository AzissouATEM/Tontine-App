CREATE TABLE cotisations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    montant DECIMAL(10,2),
    date_cotisation DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
