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
		$app->render('login');
	});

	$router->post('/login', function () use ($app) {
		if (isset($_POST["pseudo"])) {
			$username = $_POST["pseudo"];
			$userController = new UserController($app);
			$result = $userController->login($username);
			if (isset($result['success']) && isset($result['user'])) {
				$_SESSION['user_id'] = $result['user']['id'];
				$app->render('welcome');
			} else {
				$app->render('login', ['error' => $result['error']]);
			}
		}
	});

	$router->get('/message', function() use ($app) {
		$app->render('message', [ 'csp_nonce' => $app->get('csp_nonce') ]);
	});


	$router->get('/hello-world/@name,@surname', function($name, $surname) {
		echo '<h1>Hello world! Oh hey '.$name.' '. $surname .' !</h1>';
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
}, [SecurityHeadersMiddleware::class]);

