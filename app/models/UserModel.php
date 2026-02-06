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
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function getUserByUsername($username)
    {
        $db = Flight::db();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function createUser($username, $password, $email, $avatar = null)
    {
        $hashedPassword = null;
        $db = Flight::db();
        $stmt = $db->prepare("INSERT INTO users (username, mdp, email, photoProfil) VALUES (:username, :password, :email, :photoProfil)");
        $stmt->bindValue(':username', $username);
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }
        $stmt->bindValue(':password', $hashedPassword);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':photoProfil', $avatar);
        return $stmt->execute();
    }
}
