<?php

namespace Larapie\Larapie;

class LarapieHelper
{
    protected bool $optional = false;

    /**
     * @param  bool  $optional
     */
    public function setOptional(bool $optional)
    {
        $this->optional = $optional;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function safe($value): mixed
    {
        return $this->optional ? optional($value) : $value;
    }
}
