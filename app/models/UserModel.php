<?php

namespace app\models;

use Flight;

class UserModel
{

    public function __construct() {}

    public static function getAllUser()
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getUserById($id)
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function getUserByUsername($username)
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function createUser($username, $password, $email, $avatar = null)
    {
        $hashedPassword = null;
        $db = Flight::db();
        $stmt = $db->prepare("INSERT INTO users (username, mdp, email, photoProfil) VALUES (:username, :password, :email, :photoProfil)");
        $stmt->bindParam(':username', $username);
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':photoProfil', $avatar);
        return $stmt->execute();
    }
}
