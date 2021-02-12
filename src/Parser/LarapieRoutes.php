<?php

namespace Larapie\Larapie\Parser;

final class LarapieRoutes
{
    /**
     * @var RoutesParser
     */
    private RoutesParser $rulesParser;

    /**
     * LarapieRoutes constructor.
     * @param  RoutesParser  $rulesParser
     */
    public function __construct(RoutesParser $rulesParser)
    {
        $this->rulesParser = $rulesParser;
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->rulesParser->parse();
    }
}