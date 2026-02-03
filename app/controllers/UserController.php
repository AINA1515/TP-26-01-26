<?php

namespace app\controllers;

use app\models\UserModel;
use flight\Engine;

class UserController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}

	public function getAllUsers()
	{
		$users = UserModel::getAllUser();
		return $users;
	}

	public function getUserById($id)
	{
		$user = UserModel::getUserById($id);
		if ($user) {
			return $user;
		} else {
			return ['error' => 'User not found'];
		}
	}

	public function getUserByUsername($username)
	{
		$user = UserModel::getUserByUsername($username);
		if ($user) {
			return $user;
		} else {
			return ['error' => 'User not found'];
		}
	}

	public function createUser($username, $password, $email, $avatar = null)
	{
		$result = UserModel::createUser($username, $password, $email, $avatar);
		if ($result) {
			return ['success' => 'User created successfully'];
		} else {
			return ['error' => 'Failed to create user'];
		}
	}

	public function login($username)
	{
		$user = UserModel::getUserByUsername($username);

		if ($user !== false && $user !== null) {
			$_SESSION['user_id'] = $user['id'];
			return [
				'success' => 'Login successful',
				'user' => $user
			];
		} else {
			$created = UserModel::createUser($username, null, null, null);
			if ($created) {
				$user = UserModel::getUserByUsername($username);
				$_SESSION['user_id'] = $user['id'];
				return [
					'success' => 'Utilisateur créé et connecté',
					'user' => $user
				];
			} else {
				return [
					'error' => 'Impossible de créer l’utilisateur'
				];
			}
		}
	}


	public function logout()
	{
		if (isset($_SESSION['user_id'])) {
			unset($_SESSION['user_id']);
			session_destroy();
			session_start();
		}
		return ['success' => 'Logout successful'];
	}

	public function getAllUsersExceptCurrent()
	{
		if (!isset($_SESSION['user_id'])) {
			echo json_encode([
				'status' => 'error',
				'message' => 'User not authenticated'
			]);
			return;
		}

		$currentUserId = $_SESSION['user_id'];
		$allUsers = UserModel::getAllUser();
		
		// Filter out current user
		$users = array_filter($allUsers, function($user) use ($currentUserId) {
			return $user['id'] != $currentUserId;
		});

		// Reindex array
		$users = array_values($users);

		echo json_encode([
			'status' => 'success',
			'data' => $users
		]);
	}
}
