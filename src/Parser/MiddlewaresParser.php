<?php

namespace Larapie\Larapie\Parser;

use Larapie\Larapie\Entities\Middlewares;

final class MiddlewaresParser
{
    /**
     * @param  array  $middlewares
     * @return Middlewares
     */
    public function parse(array $middlewares): Middlewares
    {
        return new Middlewares($middlewares);
    }
}