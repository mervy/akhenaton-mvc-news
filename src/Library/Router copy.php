<?php

namespace Akhenaton\Library;

use Akhenaton\Exceptions\RouterException;

class Router
{
    protected $routes = [];

    public function get($uri, $action)
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post($uri, $action)
    {
        $this->addRoute('POST', $uri, $action);
    }

    protected function addRoute($method, $uri, $action)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }
    public function dispatch($uri, $method)
    {

        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                $action = $route['action'];

                if (is_array($action)) {
                    $controller = new $action[0];
                    $method = $action[1];
                    $auth = $action[2] ?? null;
                    if ($auth && !$this->isAuthenticated()) {
                        redirect('/login');
                    }
                    if(!$controller->$method()){
                        throw new RouterException("Call to undefined method {$method}");
                    }
                    
                    return $controller->$method();
                }
                return $action();
            }
        }
        throw new RouterException("No route found for {$uri}");
    }

    protected function isAuthenticated()
    {
        return isset($_SESSION['user']);
    }
}
