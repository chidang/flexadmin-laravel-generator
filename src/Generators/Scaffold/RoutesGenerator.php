<?php

namespace Techamz\Generator\Generators\Scaffold;

use Illuminate\Support\Str;
use Techamz\Generator\Generators\BaseGenerator;

class RoutesGenerator extends BaseGenerator
{
    public function __construct()
    {
        parent::__construct();

        $this->path = $this->config->paths->routes;
    }

    public function generate()
    {
        $routeContents = g_filesystem()->getFile($this->path);

        $routes = view('flex-laravel-generator::scaffold.routes')->render();

        if (Str::contains($routeContents, $routes)) {
            $this->config->commandInfo(techamz_nl().'Route '.$this->config->modelNames->snakePlural.' already exists, Skipping Adjustment.');

            return;
        }

        $routeContents .= techamz_nl().$routes;

        g_filesystem()->createFile($this->path, $routeContents);
        $this->config->commandComment(techamz_nl().$this->config->modelNames->snakePlural.' routes added.');
    }

    public function rollback()
    {
        $routeContents = g_filesystem()->getFile($this->path);

        $routes = view('flex-laravel-generator::scaffold.routes')->render();

        if (Str::contains($routeContents, $routes)) {
            $routeContents = str_replace($routes, '', $routeContents);
            g_filesystem()->createFile($this->path, $routeContents);
            $this->config->commandComment('scaffold routes deleted');
        }
    }
}
