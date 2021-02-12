<?php

namespace Larapie\Larapie\Entities;

use Illuminate\Support\Str;

final class Middlewares
{
    private array $middlewares;
    private bool $authRequired = false;

    /**
     * Middlewares constructor.
     * @param  array  $middlewares
     */
    public function __construct(array $middlewares)
    {
        $this->middlewares = $middlewares;

        foreach ($this->middlewares as &$middleware) {
            $middleware = Str::afterLast($middleware, '\\');
            if ($middleware === 'auth' || Str::startsWith($middleware, 'auth:')) {
                $this->authRequired = true;
                break;
            }
        }
    }

    /**
     * @return array
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @return bool
     */
    public function isAuthRequired(): bool
    {
        return $this->authRequired;
    }
}