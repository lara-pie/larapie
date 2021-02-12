<?php

namespace Larapie\Larapie\Http\Controllers;

use Larapie\Larapie\Parser\LarapieRoutes;

class LarapieController extends Controller
{
    public function index(LarapieRoutes $larapieRoutes)
    {
        $routes = $larapieRoutes->getRoutes();

        return view('larapie::index', compact('routes'));
    }
}