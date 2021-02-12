<?php

namespace Larapie\Larapie\Http\Controllers;

use Larapie\Larapie\Parser\LarapieRoutes;

class LarapieController extends Controller
{
    /**
     * @param  LarapieRoutes  $larapieRoutes
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(LarapieRoutes $larapieRoutes)
    {
        $routes = $larapieRoutes->getRoutes();

        return view('larapie::index', compact('routes'));
    }
}