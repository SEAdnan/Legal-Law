<?php

class Intern {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    //new intern
    public function create($name, $email, $password, $years_of_experience, $law_firm, $phone_number, $university, $address) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO Interns (name, email, password, years_of_experience, law_firm, phone_number, university, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashed_password, $years_of_experience, $law_firm, $phone_number, $university, $address]);
    }

    //intern by ID
    public function getById($intern_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Interns WHERE Intern_id = ?");
        $stmt->execute([$intern_id]);
        return $stmt->fetch();
    }

    //update intern information
    public function update($intern_id, $name, $email, $years_of_experience, $law_firm, $phone_number, $university, $address) {
        $stmt = $this->pdo->prepare("UPDATE Interns SET name = ?, email = ?, years_of_experience = ?, law_firm = ?, phone_number = ?, university = ?, address = ? WHERE Intern_id = ?");
        return $stmt->execute([$name, $email, $years_of_experience, $law_firm, $phone_number, $university, $address, $intern_id]);
    }

    //delete an intern
    public function delete($intern_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Interns WHERE Intern_id = ?");
        return $stmt->execute([$intern_id]);
    }

    //get all interns
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Interns");
        return $stmt->fetchAll();
    }

    //search interns by name
    public function searchByName($name) {
        $stmt = $this->pdo->prepare("SELECT * FROM Interns WHERE name LIKE ?");
        $stmt->execute(['%' . $name . '%']);
        return $stmt->fetchAll();
    }
}