<?php
class Cotisation {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($user_id, $montant, $date) {
        $stmt = $this->pdo->prepare("INSERT INTO cotisations (user_id, montant, date_cotisation) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $montant, $date]);
    }

    public function total() {
        $stmt = $this->pdo->query("SELECT SUM(montant) AS total FROM cotisations");
        return $stmt->fetch()['total'] ?? 0;
    }

    public function recent($limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT u.name, c.montant, c.date_cotisation 
            FROM cotisations c 
            JOIN users u ON c.user_id = u.id 
            ORDER BY c.date_cotisation DESC 
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function byUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT montant, date_cotisation FROM cotisations WHERE user_id = ? ORDER BY date_cotisation DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
}
