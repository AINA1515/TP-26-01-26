<?php

use app\controllers\ApiExampleController;
use app\controllers\MessagesController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	$router->get('/', function() use ($app) {
		$app->render('welcome', [ 'message' => 'You are gonna do great things!' ]);
	});

	$router->get('/message', function() use ($app) {
		$app->render('message', [ 'csp_nonce' => $app->get('csp_nonce') ]);
	});


	$router->get('/hello-world/@name,@surname', function($name, $surname) {
		echo '<h1>Hello world! Oh hey '.$name.' '. $surname .' !</h1>';
	});

	$router->group('/api', function() use ($router) {
		// Messages API routes
		$router->get('/messages', [ MessagesController::class, 'getAllConversations' ]);
		$router->get('/messages/@userId:[0-9]', [ MessagesController::class, 'getConversation' ]);
		$router->post('/messages', [ MessagesController::class, 'sendMessage' ]);
		$router->get('/messages/unread', [ MessagesController::class, 'getUnreadCount' ]);
	});
	
}, [ SecurityHeadersMiddleware::class ]); 