<?php

namespace Larapie\Larapie\Parser;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use ReflectionException;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionMethod;

final class RequestClassParser
{

    /**
     * @param  Route  $route
     * @return string|null
     */
    public function getRequestClass(Route $route): ?string
    {
        try {
            $reflection = $this->makeReflection($route);
        } catch (\Exception $exception) {
            return null;
        }

        return $this->requestClass($reflection);
    }


    /**
     * @param  Route  $route
     * @return ReflectionFunctionAbstract
     * @throws ReflectionException
     */
    private function makeReflection(Route $route): ReflectionFunctionAbstract
    {
        if ($route->getActionName() === 'Closure') {
            return new ReflectionFunction($route->getAction('uses'));
        } else {
            return new ReflectionMethod(
                Str::before($route->getActionName(), '@'),
                Str::contains($route->getActionName(), '@') ?
                    Str::after($route->getActionName(), '@') : '__invoke'
            );
        }
    }

    /**
     * @param  ReflectionFunctionAbstract  $reflection
     * @return string|null
     */
    private function requestClass(ReflectionFunctionAbstract $reflection): ?string
    {
        foreach ($reflection->getParameters() as $parameter) {
            if ($parameter->getType()) {
                $requestClass = $parameter->getType()->getName();
                if (Str::startsWith($requestClass, 'App\Http\Requests\\')) {
                    return $requestClass;
                }
            }
        }

        return null;
    }
}
