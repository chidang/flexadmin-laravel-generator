<?php

namespace Techamz\Generator\Generators\Scaffold;

use Illuminate\Support\Str;
use Techamz\Generator\Generators\BaseGenerator;

class MenuGenerator extends BaseGenerator
{
    private string $templateType;

    public function __construct()
    {
        parent::__construct();

        $this->path = config('flex_laravel_generator.path.menu_file', resource_path('views/layouts/menu.blade.php'));
        $this->templateType = config('flex_laravel_generator.templates', 'flexadmin-templates');
    }

    public function generate()
    {
        $menuContents = g_filesystem()->getFile($this->path);

        $menu = view($this->templateType.'::templates.layouts.menu_template')->render();

        if (Str::contains($menuContents, $menu)) {
            $this->config->commandInfo(techamz_nl().'Menu '.$this->config->modelNames->humanPlural.' already exists, Skipping Adjustment.');

            return;
        }

        $menuContents .= techamz_nl().$menu;

        g_filesystem()->createFile($this->path, $menuContents);
        $this->config->commandComment(techamz_nl().$this->config->modelNames->dashedPlural.' menu added.');
    }

    public function rollback()
    {
        $menuContents = g_filesystem()->getFile($this->path);

        $menu = view($this->templateType.'::templates.layouts.menu_template')->render();

        if (Str::contains($menuContents, $menu)) {
            g_filesystem()->createFile($this->path, str_replace($menu, '', $menuContents));
            $this->config->commandComment('menu deleted');
        }
    }
}
