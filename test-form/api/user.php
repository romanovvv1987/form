<?php
include_once "PDOClass.php";

/**
 * пример простейший, с PDO оберткой, без дополнительной валидации итп
 */
const HOST = 'sql11.freesqldatabase.com';
const DBNAME = 'sql11435381';
const USERNAME = 'sql11435381';
const PASSWORD = 'VS1cwad4bP';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'] ?? null;
    $firstName = $_POST['lastName'] ?? null;
    $lastName = $_POST['firstName'] ?? null;

    try {
        $database = PDOClass::getInstance();
        $database->query("INSERT INTO `users` (lastName, firstName, email,) VALUES (:lastName,:firstName :email)");
        $database->bind(':email', $email);
        $database->bind(':lastName', $lastName);
        $database->bind(':firstName', $firstName);
        $database->execute();
    } catch (Exception $e) {

        //тут можно вернуть исклчения которые возникли
            $errorMessages = [
                "errors" => [
                    "password" => [
                        "can't be blank"
                    ],
                    "firstName" => [
                        "can't be blank",
                    ]
                ]
            ];

        header('Content-type: application/json');
        echo json_encode($errorMessages);


    }


}