<?php

use app\controllers\MessagesController;
use app\controllers\UserController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function (Router $router) use ($app) {

	$router->get('/login', function () use ($app) {
		if (isset($_SESSION['user_id'])) {
			unset($_SESSION['user_id']);
			session_destroy();
			session_start();
		}
		$app->render('login');
	});

	$router->post('/login', function () use ($app) {
		if (isset($_POST["pseudo"])) {
			$username = $_POST["pseudo"];
			$userController = new UserController($app);
			$result = $userController->login($username);
			if (isset($result['success']) && isset($result['user'])) {
				$_SESSION['user_id'] = $result['user']['id'];
				$app->render('message', ['csp_nonce' => $app->get('csp_nonce'), "user" => $userController->getUserById($result['user']['id'])]);
			} else {
				$app->render('login', ['error' => $result['error']]);
			}
		}
	});

	$router->get('/message', function() use ($app) {
		$app->render('message', [ 'csp_nonce' => $app->get('csp_nonce') ]);
	});

	$router->get('/logout', function () use ($app) {
		$userController = new UserController($app);
		$result = $userController->logout();
		if (isset($result['success'])) {
			$app->render('login');
		} else {
			$app->render('welcome', ['error' => $result['error']]);
		}
	});

	// Message API Routes
	$router->get('/api/messages', function() use ($app) {
		$messagesController = new MessagesController($app);
		$messagesController->getAllConversations();
	});

	$router->get('/api/messages/@userId', function($userId) use ($app) {
		$messagesController = new MessagesController($app);
		$messagesController->getConversation($userId);
	});

	$router->post('/api/messages', function() use ($app) {
		$messagesController = new MessagesController($app);
		$messagesController->sendMessage();
	});

	$router->get('/api/messages/read/@userId', function($userId) use ($app) {
		$messagesController = new MessagesController($app);
		$messagesController->markConversationRead($userId);
	});

	$router->get('/api/messages/unread', function() use ($app) {
		$messagesController = new MessagesController($app);
		$messagesController->getUnreadCount();
	});

	$router->get('/api/users/all', function() use ($app) {
		$userController = new UserController($app);
		$userController->getAllUsersExceptCurrent();
	});

}, [SecurityHeadersMiddleware::class]);



