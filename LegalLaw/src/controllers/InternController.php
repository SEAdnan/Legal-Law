<?php

require 'src/models/Intern.php';

class InternController {
    private $internModel;

    public function __construct($pdo) {
        $this->internModel = new Intern($pdo);
    }

    //new intern
    public function createIntern($data) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $years_of_experience = $data['years_of_experience'];
        $law_firm = $data['law_firm'];
        $phone_number = $data['phone_number'];
        $university = $data['university'];
        $address = $data['address'];

        return $this->internModel->create($name, $email, $password, $years_of_experience, $law_firm, $phone_number, $university, $address);
    }

    //intern by ID
    public function getIntern($intern_id) {
        return $this->internModel->getById($intern_id);
    }

    //update intern information
    public function updateIntern($intern_id, $data) {
        $name = $data['name'];
        $email = $data['email'];
        $years_of_experience = $data['years_of_experience'];
        $law_firm = $data['law_firm'];
        $phone_number = $data['phone_number'];
        $university = $data['university'];
        $address = $data['address'];

        return $this->internModel->update($intern_id, $name, $email, $years_of_experience, $law_firm, $phone_number, $university, $address);
    }

    //delete an intern
    public function deleteIntern($intern_id) {
        return $this->internModel->delete($intern_id);
    }

    //get all interns
    public function getAllInterns() {
        return $this->internModel->getAll();
    }

    //interns by name
    public function searchInterns($name) {
        return $this->internModel->searchByName($name);
    }
}