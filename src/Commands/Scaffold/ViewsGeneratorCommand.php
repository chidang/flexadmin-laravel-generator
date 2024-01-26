<?php

namespace Techamz\Generator\Commands\Scaffold;

use Techamz\Generator\Commands\BaseCommand;
use Techamz\Generator\Generators\Scaffold\ViewGenerator;

class ViewsGeneratorCommand extends BaseCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'techamz.scaffold:views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create views file command';

    public function handle()
    {
        parent::handle();

        /** @var ViewGenerator $viewGenerator */
        $viewGenerator = app(ViewGenerator::class);
        $viewGenerator->generate();

        $this->performPostActions();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), []);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array_merge(parent::getArguments(), []);
    }
}
