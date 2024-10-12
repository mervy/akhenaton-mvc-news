<?php

namespace Akhenaton\Interfaces;

interface DispatcherInterface
{
    public function dispatch($controller, $method, $auth = null);
}
