<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function create($name, $email, $password, $role) {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $password, $role]);
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM users ORDER BY role");
        return $stmt->fetchAll();
    }

    public function getParticipants() {
        $stmt = $this->pdo->query("SELECT id, name FROM users WHERE role = 'Participant'");
        return $stmt->fetchAll();
    }

    public function countByRole($role) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM users WHERE role = ?");
        $stmt->execute([$role]);
        return $stmt->fetch()['total'] ?? 0;
    }
}
