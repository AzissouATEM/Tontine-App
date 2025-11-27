<?php
class Retrait {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function demande($user_id, $montant, $date) {
        $stmt = $this->pdo->prepare("INSERT INTO retraits (user_id, montant, date_demande) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $montant, $date]);
    }

    public function enAttente() {
        $stmt = $this->pdo->query("SELECT COUNT(*) AS pending FROM retraits WHERE statut = 'En attente'");
        return $stmt->fetch()['pending'] ?? 0;
    }

    public function approuvesTotal() {
        $stmt = $this->pdo->query("SELECT SUM(montant) AS total FROM retraits WHERE statut = 'Approuvé'");
        return $stmt->fetch()['total'] ?? 0;
    }

    public function recent($limit = 5) {
        $stmt = $this->pdo->prepare("
            SELECT u.name, r.montant, r.statut 
            FROM retraits r 
            JOIN users u ON r.user_id = u.id 
            ORDER BY r.date_demande DESC 
            LIMIT ?
        ");
        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function byUser($user_id) {
        $stmt = $this->pdo->prepare("SELECT montant, date_demande, statut FROM retraits WHERE user_id = ? ORDER BY date_demande DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
}
