<?php

namespace Techamz\Generator\Generators\Scaffold;

use Techamz\Generator\Generators\BaseGenerator;
use Techamz\Generator\Generators\ModelGenerator;

class RequestGenerator extends BaseGenerator
{
    private string $createFileName;

    private string $updateFileName;

    public function __construct()
    {
        parent::__construct();

        $this->path = $this->config->paths->request;
        $this->createFileName = 'Create'.$this->config->modelNames->name.'Request.php';
        $this->updateFileName = 'Update'.$this->config->modelNames->name.'Request.php';
    }

    public function generate()
    {
        //disable request generation
        $this->config->commandComment(techamz_nl().'Request generation disabled.');

        return;
        $this->generateCreateRequest();
        $this->generateUpdateRequest();
    }

    protected function generateCreateRequest()
    {
        $templateData = view('flex-laravel-generator::scaffold.request.create', $this->variables())->render();

        g_filesystem()->createFile($this->path.$this->createFileName, $templateData);

        $this->config->commandComment(techamz_nl().'Create Request created: ');
        $this->config->commandInfo($this->createFileName);
    }

    protected function generateUpdateRequest()
    {
        $modelGenerator = new ModelGenerator();
        $rules = $modelGenerator->generateUniqueRules();

        $templateData = view('flex-laravel-generator::scaffold.request.update', [
            'uniqueRules' => $rules,
        ])->render();

        g_filesystem()->createFile($this->path.$this->updateFileName, $templateData);

        $this->config->commandComment(techamz_nl().'Update Request created: ');
        $this->config->commandInfo($this->updateFileName);
    }

    public function rollback()
    {
        if ($this->rollbackFile($this->path, $this->createFileName)) {
            $this->config->commandComment('Create Request file deleted: '.$this->createFileName);
        }

        if ($this->rollbackFile($this->path, $this->updateFileName)) {
            $this->config->commandComment('Update Request file deleted: '.$this->updateFileName);
        }
    }
}
