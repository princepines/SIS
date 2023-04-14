<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sisdb');
define('DB_PORT', '3306');
 
/* Attempt to connect to MySQL database */
$mysqli = new mysqli (DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
} else {
    // create database and tables for users, subjects, payments, and grades
    $sql = "CREATE DATABASE IF NOT EXISTS sisdb";
    if($mysqli->query($sql) === true){
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
            firstname VARCHAR(255) NOT NULL,
            lastname VARCHAR(255) NOT NULL,
            username VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        )";
        if($mysqli->query($sql) === true){
            $sql = "CREATE TABLE IF NOT EXISTS subjects (
                id INT NOT NULL,
                subject VARCHAR(255) NOT NULL PRIMARY KEY,
                PRIMARY KEY (subject),
                FOREIGN KEY (id) REFERENCES users(id)
            )";
            if($mysqli->query($sql) === true){
                $sql = "CREATE TABLE IF NOT EXISTS payments (
                    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                    studentid INT NOT NULL,
                    amount INT NOT NULL,
                    paymenttype VARCHAR(100) NOT NULL,
                    date DATE NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (studentid) REFERENCES users(id)
                )";
                if($mysqli->query($sql) === true){
                    $sql = "CREATE TABLE IF NOT EXISTS grades (
                        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        studentid INT NOT NULL,
                        subject VARCHAR(255) NOT NULL,
                        grade INT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (studentid) REFERENCES users(id),
                        FOREIGN KEY (subject) REFERENCES subjects(subject)
                    )";
                    if($mysqli->query($sql) === true){
                        echo "";
                    } else {
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                }
            } else {
                echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
        }
    } else {
        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
    }
}

$path = $_SERVER['DOCUMENT_ROOT'] . '/SIS/';
?>