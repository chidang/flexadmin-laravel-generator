<?php

use Illuminate\Support\Str;
use Techamz\Generator\Common\FileSystem;

if (!function_exists('g_filesystem')) {
    /**
     * @return FileSystem
     */
    function g_filesystem()
    {
        return app(FileSystem::class);
    }
}

if (!function_exists('techamz_tab')) {
    function techamz_tab(int $spaces = 4): string
    {
        return str_repeat(' ', $spaces);
    }
}

if (!function_exists('techamz_tabs')) {
    function techamz_tabs(int $tabs, int $spaces = 4): string
    {
        return str_repeat(techamz_tab($spaces), $tabs);
    }
}

if (!function_exists('techamz_nl')) {
    function techamz_nl(int $count = 1): string
    {
        return str_repeat(PHP_EOL, $count);
    }
}

if (!function_exists('techamz_nls')) {
    function techamz_nls(int $count, int $nls = 1): string
    {
        return str_repeat(techamz_nl($nls), $count);
    }
}

if (!function_exists('techamz_nl_tab')) {
    function techamz_nl_tab(int $lns = 1, int $tabs = 1): string
    {
        return techamz_nls($lns).techamz_tabs($tabs);
    }
}

if (!function_exists('model_name_from_table_name')) {
    function model_name_from_table_name(string $tableName): string
    {
        return Str::ucfirst(Str::camel(Str::singular($tableName)));
    }
}

if (!function_exists('create_resource_route_names')) {
    function create_resource_route_names($name, $isScaffold = false): array
    {
        $result = [
            "'index' => '$name.index'",
            "'store' => '$name.store'",
            "'show' => '$name.show'",
            "'update' => '$name.update'",
            "'destroy' => '$name.destroy'",
        ];

        if ($isScaffold) {
            $result[] = "'create' => '$name.create'";
            $result[] = "'edit' => '$name.edit'";
        }

        return $result;
    }
}
