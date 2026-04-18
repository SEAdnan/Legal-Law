<?php

class Client {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //new client
    public function create($name, $email, $password, $endorsement, $address, $phone_number, $is_paid, $payment_info = null) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO Clients (name, email, password, endorsement, address, phone_number, is_paid, payment_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashed_password, $endorsement, $address, $phone_number, $is_paid, $payment_info]);
    }

    //client by ID
    public function getById($client_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Clients WHERE Client_id = ?");
        $stmt->execute([$client_id]);
        return $stmt->fetch();
    }

    // update client information
    public function update($client_id, $name, $email, $endorsement, $address, $phone_number, $is_paid, $payment_info = null) {
        $stmt = $this->pdo->prepare("UPDATE Clients SET name = ?, email = ?, endorsement = ?, address = ?, phone_number = ?, is_paid = ?, payment_info = ? WHERE Client_id = ?");
        return $stmt->execute([$name, $email, $endorsement, $address, $phone_number, $is_paid, $payment_info, $client_id]);
    }

    //delete a client
    public function delete($client_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Clients WHERE Client_id = ?");
        return $stmt->execute([$client_id]);
    }

    // all clients
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Clients");
        return $stmt->fetchAll();
    }

    //search clients by name
    public function searchByName($name) {
        $stmt = $this->pdo->prepare("SELECT * FROM Clients WHERE name LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll();
    }
}