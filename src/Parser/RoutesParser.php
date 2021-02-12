<?php

namespace Larapie\Larapie\Parser;

use Larapie\Larapie\Entities\Middlewares;
use Larapie\Larapie\Entities\PathVariables;
use Larapie\Larapie\Entities\Rules;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

final class RoutesParser
{
    /**
     * @var Router
     */
    private Router $router;
    private RulesParser $rulesParser;
    private array $routes;
    /**
     * @var MiddlewaresParser
     */
    private MiddlewaresParser $middlewaresParser;
    /**
     * @var RequestClassParser
     */
    private RequestClassParser $requestClassParser;

    /**
     * RoutesParser constructor.
     * @param  Router  $router
     * @param  RulesParser  $rulesParser
     * @param  MiddlewaresParser  $middlewaresParser
     * @param  RequestClassParser  $requestClassParser
     */
    public function __construct(
        Router $router,
        RulesParser $rulesParser,
        MiddlewaresParser $middlewaresParser,
        RequestClassParser $requestClassParser
    ) {
        $this->router = $router;
        $this->rulesParser = $rulesParser;
        $this->middlewaresParser = $middlewaresParser;
        $this->requestClassParser = $requestClassParser;
    }

    /**
     * @return array
     */
    public function parse(): array
    {
        foreach ($this->router->getRoutes() as $route) {
            $this->handleRoute($route);
        }

        return $this->routes;
    }

    /**
     * @param  Route  $route
     */
    private function handleRoute(Route $route)
    {
        $requestClass = $this->requestClassParser->getRequestClass($route);
        $middlewares = $this->getMiddlewares($route->getAction('middleware'));

        $this->routes[] = [
            'uri'            => $route->uri,
            'methods'        => $route->methods,
            'name'           => $route->getName(),
            'rules'          => $this->getRules($requestClass),
            'path_variables' => $this->getPathVariables($route),
            'middlewares'    => $middlewares,
            'auth_required'  => $middlewares ? $middlewares->isAuthRequired() : false,
        ];
    }

    /**
     * @param  Route  $route
     * @return PathVariables|null
     */
    private function getPathVariables(Route $route): ?PathVariables
    {
        $variables = $route->compiled ? $route->compiled->getPathVariables() : null;

        return $variables ? new PathVariables($variables) : null;
    }

    /**
     * @param  string|null  $requestClass
     * @return Rules|null
     */
    private function getRules(?string $requestClass): ?Rules
    {
        return $requestClass ? $this->rulesParser->parse($requestClass) : null;
    }

    /**
     * @param  array|null  $middlewares
     * @return Middlewares|null
     */
    private function getMiddlewares(?array $middlewares): ?Middlewares
    {
        return $middlewares ? $this->middlewaresParser->parse($middlewares) : null;
    }
}