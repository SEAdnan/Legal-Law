CREATE DATABASE legal_help;

USE legal_help;

CREATE TABLE Lawyers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    specialization VARCHAR(255),
    endorsement TEXT,
    address TEXT,
    self_description TEXT,
    years_of_experience INT,
    win_rate DECIMAL(5,2),
    phone_number TEXT, 
    degrees TEXT, 
    type ENUM('Advocate', 'Barrister'),
    law_firm varchar(255)
);

CREATE TABLE Clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    endorsement TEXT,
    address TEXT,
    phone_number VARCHAR(15),
    payment_info TEXT, 
    is_paid BOOLEAN DEFAULT FALSE
);

CREATE TABLE Interns (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    years_of_experience INT,
    law_firm VARCHAR(100),
    phone_number VARCHAR(15),
    university VARCHAR(100),
    address TEXT
);

CREATE TABLE Basic_Law (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(100),
    description TEXT
);

CREATE TABLE Ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lawyer_id INT,
    client_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    FOREIGN KEY (lawyer_id) REFERENCES Lawyers(id),
    FOREIGN KEY (client_id) REFERENCES Clients(id)
);
CREATE TABLE Messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_email VARCHAR(255) NOT NULL,
    receiver_id INT NOT NULL,
    message_body TEXT NOT NULL,
    sender_phone VARCHAR(15) NOT NULL;
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (receiver_id) REFERENCES Interns(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE Appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lawyer_id INT NOT NULL,
    client_email VARCHAR(255) NOT NULL,
    payment_amount DECIMAL(10, 2) NOT NULL,
    appointment_date DATETIME NOT NULL,
    FOREIGN KEY (lawyer_id) REFERENCES Lawyers(id)
);

CREATE TABLE Admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);