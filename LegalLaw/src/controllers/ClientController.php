<?php

require 'src/models/Client.php';

class ClientController {
    private $clientModel;

    public function __construct($pdo) {
        $this->clientModel = new Client($pdo);
    }

    //new client
    public function createClient($data) {
        $name = $data['name'];
        $email = $data['email'];
        $password = $data['password'];
        $endorsement = $data['endorsement'];
        $address = $data['address'];
        $phone_number = $data['phone_number'];
        $is_paid = $data['is_paid'];
        $payment_info = isset($data['payment_info']) ? $data['payment_info'] : null;

        return $this->clientModel->create($name, $email, $password, $endorsement, $address, $phone_number, $is_paid, $payment_info);
    }

    //client by ID
    public function getClient($client_id) {
        return $this->clientModel->getById($client_id);
    }

    //update client information
    public function updateClient($client_id, $data) {
        $name = $data['name'];
        $email = $data['email'];
        $endorsement = $data['endorsement'];
        $address = $data['address'];
        $phone_number = $data['phone_number'];
        $is_paid = $data['is_paid'];
        $payment_info = isset($data['payment_info']) ? $data['payment_info'] : null;

        return $this->clientModel->update($client_id, $name, $email, $endorsement, $address, $phone_number, $is_paid, $payment_info);
    }

    //delete a client
    public function deleteClient($client_id) {
        return $this->clientModel->delete($client_id);
    }

    //get all clients
    public function getAllClients() {
        return $this->clientModel->getAll();
    }

    //search clients by name
    public function searchClients($name) {
        return $this->clientModel->searchByName($name);
    }
}