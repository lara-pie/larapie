<?php

namespace Larapie\Larapie\Parser;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;

class CheckIfIgnoredRoute
{
    protected array $ignoredControllers = [
        'Facade\Ignition\Http\Controllers\HealthCheckController',
        'Facade\Ignition\Http\Controllers\ExecuteSolutionController',
        'Facade\Ignition\Http\Controllers\ShareReportController',
        'Facade\Ignition\Http\Controllers\ScriptController',
        'Facade\Ignition\Http\Controllers\StyleController',
        'Larapie\Larapie\Http\Controllers\LarapieController',
        'Laravel\Telescope\Http\Controllers\MailController',
        'Laravel\Telescope\Http\Controllers\MailHtmlController',
        'Laravel\Telescope\Http\Controllers\MailEmlController',
        'Laravel\Telescope\Http\Controllers\ExceptionController',
        'Laravel\Telescope\Http\Controllers\DumpController',
        'Laravel\Telescope\Http\Controllers\LogController',
        'Laravel\Telescope\Http\Controllers\NotificationsController',
        'Laravel\Telescope\Http\Controllers\QueueController',
        'Laravel\Telescope\Http\Controllers\QueueBatchesController',
        'Laravel\Telescope\Http\Controllers\EventsController',
        'Laravel\Telescope\Http\Controllers\GatesController',
        'Laravel\Telescope\Http\Controllers\CacheController',
        'Laravel\Telescope\Http\Controllers\QueriesController',
        'Laravel\Telescope\Http\Controllers\ModelsController',
        'Laravel\Telescope\Http\Controllers\RequestsController',
        'Laravel\Telescope\Http\Controllers\ViewsController',
        'Laravel\Telescope\Http\Controllers\CommandsController',
        'Laravel\Telescope\Http\Controllers\ScheduleController',
        'Laravel\Telescope\Http\Controllers\RedisController',
        'Laravel\Telescope\Http\Controllers\ClientRequestController',
        'Laravel\Telescope\Http\Controllers\MonitoredTagController',
        'Laravel\Telescope\Http\Controllers\RecordingController',
        'Laravel\Telescope\Http\Controllers\EntriesController',
        'Laravel\Telescope\Http\Controllers\HomeController',
    ];

    protected array $ignoredNames = [];

    protected ?array $prefixes = null;

    public function __construct()
    {
        $routeNames = config('larapie.ignore.route-names');
        $controllers = config('larapie.ignore.controllers');
        $routePrefixes = config('larapie.parser.route-prefixes');

        if (is_array($routeNames)) {
            $this->ignoredNames = array_merge($this->ignoredNames, $routeNames);
        }

        if (is_array($controllers)) {
            $this->ignoredControllers = array_merge($this->ignoredControllers, $controllers);
        }

        if (is_array($routePrefixes) && count($routePrefixes)) {
            $this->prefixes = $routePrefixes;
        }
    }

    /**
     * @param  Route  $route
     * @return bool
     */
    public function check(Route $route): bool
    {
        if ($this->ignoreByController($route)) {
            return true;
        }

        if ($this->ignoreByName($route)) {
            return true;
        }

        if ($this->ignoreByPrefix($route)) {
            return true;
        }

        return false;
    }

    /**
     * @param  Route  $route
     * @return bool
     */
    #[Pure] public function ignoreByPrefix(Route $route): bool
    {
        if (!$this->prefixes) {
            return false;
        }

        $uri = $route->uri;

        foreach ($this->prefixes as $prefix) {
            if (Str::startsWith($uri, $prefix)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  Route  $route
     * @return bool
     */
    public function ignoreByController(Route $route): bool
    {
        $controller = Str::before($route->getAction('controller'), '@');

        return in_array($controller, $this->ignoredControllers);
    }

    /**
     * @param  Route  $route
     * @return bool
     */
    public function ignoreByName(Route $route): bool
    {
        $name = $route->getName();

        if ($name && in_array($name, $this->ignoredNames)) {
            return true;
        }

        return false;
    }
}
