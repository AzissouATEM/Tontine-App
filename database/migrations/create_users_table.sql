CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('Administrateur','Caissier','Conseiller','Président','Secretaire','Participant') DEFAULT 'Participant',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
