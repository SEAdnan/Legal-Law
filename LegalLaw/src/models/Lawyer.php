<?php

class Lawyer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //new lawyer
    public function create($name, $email, $password, $endorsement, $address, $self_description, $years_of_experience, $win_rate, $phone_numbers, $degrees, $type) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO Lawyers (name, email, password, endorsement, address, self_description, years_of_experience, win_rate, phone_numbers, degrees, type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashed_password, $endorsement, $address, $self_description, $years_of_experience, $win_rate, $phone_numbers, $degrees, $type]);
    }

    //lawyer by ID
    public function getById($lawyer_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Lawyers WHERE Lawyer_id = ?");
        $stmt->execute([$lawyer_id]);
        return $stmt->fetch();
    }

    //update lawyer information
    public function update($lawyer_id, $name, $email, $endorsement, $address, $self_description, $years_of_experience, $win_rate, $phone_numbers, $degrees) {
        $stmt = $this->pdo->prepare("UPDATE Lawyers SET name = ?, email = ?, endorsement = ?, address = ?, self_description = ?, years_of_experience = ?, win_rate = ?, phone_numbers = ?, degrees = ? WHERE Lawyer_id = ?");
        return $stmt->execute([$name, $email, $endorsement, $address, $self_description, $years_of_experience, $win_rate, $phone_numbers, $degrees, $lawyer_id]);
    }

    //delete a lawyer
    public function delete($lawyer_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Lawyers WHERE Lawyer_id = ?");
        return $stmt->execute([$lawyer_id]);
    }

    //all lawyers
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Lawyers");
        return $stmt->fetchAll();
    }

    //lawyers by name
    public function searchByName($name) {
        $stmt = $this->pdo->prepare("SELECT * FROM Lawyers WHERE name LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll();
    }

    //average rating of a lawyer
    public function getAverageRating($lawyer_id) {
        $stmt = $this->pdo->prepare("SELECT AVG(rating) as avg_rating FROM Ratings WHERE lawyer_id = ?");
        $stmt->execute([$lawyer_id]);
        return $stmt->fetchColumn();
    }
}