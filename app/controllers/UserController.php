<?php

namespace app\controllers;
use app\models\UserModel;
use flight\Engine;

class UserController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function getAllUsers() {
		$users = UserModel::getAllUser();
		return $users;
	}

	public function getUserById($id) {
		$user = UserModel::getUserById($id);
		if ($user) {
			return $user;
		} else {
			return ['error' => 'User not found'];
		}
	}

	public function getUserByUsername($username) {
		$user = UserModel::getUserByUsername($username);
		if ($user) {
			return $user;
		} else {
			return ['error' => 'User not found'];
		}
	}

	public function createUser($username, $password, $email, $avatar = null) {
		$result = UserModel::createUser($username, $password, $email, $avatar);
		if ($result) {
			return ['success' => 'User created successfully'];
		} else {
			return ['error' => 'Failed to create user'];
		}
	}

	public function login($username) {
		$user = UserModel::getUserByUsername($username);
		if ($user != null ) {
			$_SESSION['user_id'] = $user['id'];
			return ['success' => 'Login successful', 'user' => $user];
		} else {
			$new = UserModel::createUser($username, null,null,null);
			$this->login($username);
		}
	}

	public function logout() {
		session_destroy();
		return ['success' => 'Logout successful'];
	}
}