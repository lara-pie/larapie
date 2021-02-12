<?php

namespace Larapie\Larapie\Services;

final class RouteViewService
{
    /**
     * @param  string  $method
     * @return string
     */
    public static function guessBackground(string $method): string
    {
        switch (mb_strtolower($method)) {
            case 'get':
            case 'head':
                return 'info';
            case 'post':
                return 'success';
            case 'put':
            case 'patch':
                return 'warning';
            case 'delete':
                return 'danger';
            default:
                return 'secondary';
        }
    }
}