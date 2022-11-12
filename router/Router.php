<?php
require_once('./Route.php');

class Router {
    private $routeTable = [];
    private $defaultRoute;

    public function __construct() {}

    public function route($url, $verb) {
        foreach ($this->routeTable as $route) {
            if($route->match($url, $verb)){
                $route->run();
                return;
            }
        }
        if ($this->defaultRoute != null)
            $this->defaultRoute->run();
        else
            echo "<h1>Error 404: Page not found</h1>";
    }

    public function addRoute ($url, $verb, $controller, $method) {
        $this->routeTable[] = new Route($url, $verb, $controller, $method);
    }


    public function setDefaultRoute($controller, $method) {
        $this->defaultRoute = new Route("", "", $controller, $method);
    }
}

