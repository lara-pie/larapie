<?php

namespace Larapie\Larapie\Entities;

final class PathVariables
{
    private array $pathVariables;

    /**
     * PathVariables constructor.
     * @param  array  $pathVariables
     */
    public function __construct(array $pathVariables)
    {
        $this->pathVariables = $pathVariables;
    }

    /**
     * @return array
     */
    public function getPathVariables(): array
    {
        return $this->pathVariables;
    }
}