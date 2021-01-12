<?php

use Solver\Request;
use Solver\View;
use Solver\Controller;
use Solver\Controller\Home;

require 'src/config.php';
require 'src/Solver/Request.php';
require 'src/Solver/View.php';
require 'src/Solver/Controller.php';
require 'src/Solver/Controller/Home.php';
header('Content-Type: text/html; charset=utf8');

//view - inject into controller
$view = new View();
$view->addPath( __DIR__ . '/View' );

$request = Request::getGlobals();

include __DIR__ . '/View/header.html';

try {
    $controller = $request->getParam('controller', 'Home');
    $controller = '\\Solver\\Controller\\' . ucfirst($controller);

    $action = $request->getParam('action');
    if ( is_null($action) ) {
        $action = 'view';
    }

    $instance = new $controller( $view );
    $instance->$action( $request );
} catch (\Exception $e) {
    echo $e->getMessage();
}

include __DIR__ . '/View/footer.html';
