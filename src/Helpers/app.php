<?php

ini_set('display_errors', 1);

use Dotenv\Dotenv;
use Akhenaton\Helpers\Request;


// Use $_ENV['APP_URL'] or getenv('APP_URL') for example
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

require 'functions.php';
require 'constants.php';

// Carrega as rotas
require '../routes/web.php';

// Instancia o Request para capturar a URI e o método HTTP da requisição
$request = new Request();

// Dispara o roteamento
$router->handle($request);
