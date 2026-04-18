<?php

require 'src/models/Lawyer.php';

class LawyerController {
    private $lawyerModel;

    public function __construct($pdo) {
        $this->lawyerModel = new Lawyer($pdo);
    }

    //new lawyer
    public function createLawyer($data) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $endorsement = $data['endorsement'];
        $address = $data['address'];
        $self_description = $data['self_description'];
        $years_of_experience = $data['years_of_experience'];
        $win_rate = $data['win_rate'];
        $phone_numbers = $data['phone_numbers'];
        $degrees = $data['degrees'];
        $type = $data['type'];

        return $this->lawyerModel->create($name, $email, $password, $endorsement, $address, $self_description, $years_of_experience, $win_rate, $phone_numbers, $degrees, $type);
    }

    //lawyer by ID
    public function getLawyer($lawyer_id) {
        return $this->lawyerModel->getById($lawyer_id);
    }

    //update lawyer information
    public function updateLawyer($lawyer_id, $data) {
        $name = $data['name'];
        $email = $data['email'];
        $endorsement = $data['endorsement'];
        $address = $data['address'];
        $self_description = $data['self_description'];
        $years_of_experience = $data['years_of_experience'];
        $win_rate = $data['win_rate'];
        $phone_numbers = $data['phone_numbers'];
        $degrees = $data['degrees'];

        return $this->lawyerModel->update($lawyer_id, $name, $email, $endorsement, $address, $self_description, $years_of_experience, $win_rate, $phone_numbers, $degrees);
    }

    //delete a lawyer
    public function deleteLawyer($lawyer_id) {
        return $this->lawyerModel->delete($lawyer_id);
    }

    //get all lawyers
    public function getAllLawyers() {
        return $this->lawyerModel->getAll();
    }

    //search lawyers by name
    public function searchLawyers($name) {
        return $this->lawyerModel->searchByName($name);
    }

    //average rating of a lawyer
    public function getLawyerAverageRating($lawyer_id) {
        return $this->lawyerModel->getAverageRating($lawyer_id);
    }
}