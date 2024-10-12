<?php

namespace Akhenaton\Library;

use Akhenaton\Exceptions\RouterException;
use Akhenaton\Interfaces\DispatcherInterface;

class Dispatcher implements DispatcherInterface
{
    protected function isAuthenticated()
    {
        return isset($_SESSION['user']);
    }

    public function dispatch($controller, $method, $auth = null, $params = [])
    {
        if ($auth && !$this->isAuthenticated()) {
            // Redireciona para login
            header('Location: /login');
            exit();
        }

        if (!method_exists($controller, $method)) {
            throw new RouterException("Call to undefined method {$method}");
        }

        // Invoca o método do controlador com os parâmetros
        return call_user_func_array([$controller, $method], $params);
    }
}
