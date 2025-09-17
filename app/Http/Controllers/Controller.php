<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Route;

abstract class Controller
{
    protected function view($data = [], $mergeData = [])
    {
        $action = Route::currentRouteAction();

        if (!$action) {
            abort(500, 'Cannot determine the current controller action.');
        }

        [$controller, $method] = explode('@', $action);

        $viewPath = str_replace('App\\Http\\Controllers\\', '', $controller);
        $viewPath = str_replace('Controller', '', $viewPath);
        $viewPath = str_replace('\\', '.', $viewPath);

        $viewName = 'pages.' . strtolower($viewPath . '.' . $method);

        if (!view()->exists($viewName)) {
            abort(500, "View [{$viewName}] not found.");
        }

        return view($viewName, $data, $mergeData);
    }
}
