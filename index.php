<?php

session_start();

require('vendor/autoload.php');

define('INCLUDE_PATH_STATIC', 'http://localhost/teste_anexus/Anexus/Views/pages/');
define('INCLUDE_PATH', 'http://localhost/teste_anexus/');

$app = new Anexus\Application();

$app->run();
