<?php

namespace Akhenaton\Library;

use Akhenaton\Helpers\Request;
use Akhenaton\Exceptions\RouterException;
use Akhenaton\Interfaces\DispatcherInterface;

class Router
{
    protected $routes = [];
    protected $dispatcher;

    public function __construct(DispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

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
        // Suporte a rotas dinâmicas
        $uri = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $uri);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'action' => $action
        ];
    }

    public function handle(Request $request)
    {
        $uri = $request->getUri();
        $method = $request->getMethod();

        foreach ($this->routes as $route) {
            $routePattern = '#^' . $route['uri'] . '$#';

            if (preg_match($routePattern, $uri, $matches) && $route['method'] === $method) {
                // Remove chaves numéricas
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $action = $route['action'];

                if (is_array($action)) {
                    $controller = new $action[0];
                    $method = $action[1];
                    $auth = $action[2] ?? null;

                    return $this->dispatcher->dispatch($controller, $method, $auth, $params);
                }

                return $action($params);
            }
        }

        throw new RouterException("No route found for {$uri}");
    }
}
