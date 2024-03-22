<?php

namespace Ivet\Ac1\Objects;

use PDO;

class CredentialLogics
{

    private array $errors;
    private PDO $connection;

    public function __construct(string $email, string $password)
    {
        $this->errors = $this->isValid($email, $password);
        $this->connection = new PDO('mysql:host=mysql;dbname=PW2_AC1_project_db', 'pw2user', 'pw2pass');
    }

    function isValid(?string $email, ?string $password): array
    {
        $errors = [];
        if (false === filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email "' . $email . '" does not have the proper format. It has to have @ and a .extension at the end';
        }
        if (strlen($password) < 9) {
            $errors[] = 'The password "' . $password . '" is shorter then 9 characters';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'The password "' . $password . '" does not contain any capital letter';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'The password "' . $password . '" does not contain any number';
        }
        return $errors;
    }

    public function checkIfUserExists($email, $password): ?int
    {
        $userId = 0;
        $statement = $this->connection->prepare('SELECT * FROM Users WHERE email=? AND password=?');
        $statement->bindParam(1, $email);
        $statement->bindParam(2, $password);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if ($result != null) {
            foreach ($result as $row) {
                $userId = $row['user_id'];
            }
            return $userId;
        } else {
            return null;
        }
    }

    public function registerUser($email, $password)
    {
        $statement = $this->connection->prepare('INSERT INTO Users(email,password,created_at,updated_at) VALUES (?,?,NOW(),NOW())');
        $statement->bindParam(1, $email);
        $statement->bindParam(2, $password);
        $statement->execute();
    }

    public function getInputFormatErrors(): array
    {
        return $this->errors;
    }

}