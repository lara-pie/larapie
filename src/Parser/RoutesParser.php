<?php

namespace Larapie\Larapie\Parser;

use Larapie\Larapie\Entities\Middlewares;
use Larapie\Larapie\Entities\PathVariables;
use Larapie\Larapie\Entities\Rules;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

final class RoutesParser
{
    private array $routes;

    /**
     * RoutesParser constructor.
     * @param  Router  $router
     * @param  RulesParser  $rulesParser
     * @param  MiddlewaresParser  $middlewaresParser
     * @param  RequestClassParser  $requestClassParser
     * @param  CheckIfIgnoredRoute  $checkIfIgnoredRoute
     */
    public function __construct(
        private Router $router,
        private RulesParser $rulesParser,
        private MiddlewaresParser $middlewaresParser,
        private RequestClassParser $requestClassParser,
        private CheckIfIgnoredRoute $checkIfIgnoredRoute
    ) {
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
        if ($this->checkIfIgnoredRoute->check($route)) {
            return;
        }

        $requestClass = $this->requestClassParser->getRequestClass($route);
        $middlewares = $this->getMiddlewares($route->getAction('middleware'));

        $this->routes[] = [
            'uri'            => $route->uri,
            'methods'        => $route->methods,
            'name'           => $route->getName(),
            'rules'          => $this->getRules($requestClass),
            'path_variables' => $this->getPathVariables($route),
            'middlewares'    => $middlewares,
            'auth_required'  => $middlewares && $middlewares->isAuthRequired(),
        ];
    }

    /**
     * @param  Route  $route
     * @return PathVariables|null
     */
    private function getPathVariables(Route $route): ?PathVariables
    {
        $variables = $route->compiled?->getPathVariables();

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
     * @param  array|string|null  $middlewares
     * @return Middlewares|null
     */
    private function getMiddlewares(array|string|null $middlewares): ?Middlewares
    {
        if (is_string($middlewares)) {
            $middlewares = [$middlewares];
        }

        return $middlewares ? $this->middlewaresParser->parse($middlewares) : null;
    }
}
