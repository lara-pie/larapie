<?php

namespace Larapie\Larapie\Parser;

use Illuminate\Routing\Route;
use Illuminate\Support\Str;

class CheckIfIgnoredRoute
{
    protected $ignoredControllers = [
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

    public function check(Route $route): bool
    {
        $controller = Str::before($route->getAction('controller'), '@');
        return in_array($controller, $this->ignoredControllers);
    }
}
