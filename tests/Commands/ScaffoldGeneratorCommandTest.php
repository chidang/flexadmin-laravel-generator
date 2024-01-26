<?php

use Techamz\Generator\Commands\Scaffold\ScaffoldGeneratorCommand;
use Techamz\Generator\Facades\FileUtils;
use Techamz\Generator\Generators\API\APIControllerGenerator;
use Techamz\Generator\Generators\API\APIRequestGenerator;
use Techamz\Generator\Generators\API\APIRoutesGenerator;
use Techamz\Generator\Generators\API\APITestGenerator;
use Techamz\Generator\Generators\FactoryGenerator;
use Techamz\Generator\Generators\MigrationGenerator;
use Techamz\Generator\Generators\ModelGenerator;
use Techamz\Generator\Generators\RepositoryGenerator;
use Techamz\Generator\Generators\RepositoryTestGenerator;
use Techamz\Generator\Generators\Scaffold\ControllerGenerator;
use Techamz\Generator\Generators\Scaffold\MenuGenerator;
use Techamz\Generator\Generators\Scaffold\RequestGenerator;
use Techamz\Generator\Generators\Scaffold\RoutesGenerator;
use Techamz\Generator\Generators\Scaffold\ViewGenerator;
use Techamz\Generator\Generators\SeederGenerator;
use Mockery as m;

use function Pest\Laravel\artisan;

afterEach(function () {
    m::close();
});

it('generates all files for scaffold from console', function () {
    FileUtils::fake();

    $shouldHaveCalledGenerators = [
        MigrationGenerator::class,
        ModelGenerator::class,
        RepositoryGenerator::class,
        RequestGenerator::class,
        ControllerGenerator::class,
        ViewGenerator::class,
        RoutesGenerator::class,
        MenuGenerator::class,
    ];

    mockShouldHaveCalledGenerateMethod($shouldHaveCalledGenerators);

    $shouldNotHaveCalledGenerator = [
        SeederGenerator::class,
        APIRequestGenerator::class,
        APIControllerGenerator::class,
        APIRoutesGenerator::class,
        RepositoryTestGenerator::class,
        APITestGenerator::class,
        FactoryGenerator::class,
    ];

    mockShouldNotHaveCalledGenerateMethod($shouldNotHaveCalledGenerator);

    artisan(ScaffoldGeneratorCommand::class, ['model' => 'Post'])
        ->expectsQuestion('Field: (name db_type html_type options)', 'title body text')
        ->expectsQuestion('Enter validations: ', 'required')
        ->expectsQuestion('Field: (name db_type html_type options)', 'exit')
        ->expectsQuestion(PHP_EOL.'Do you want to migrate database? [y|N]', false)
        ->assertSuccessful();
});

it('generates all files for scaffold from fields file', function () {
    $fileUtils = FileUtils::fake([
        'createFile'                => true,
        'createDirectoryIfNotExist' => true,
        'deleteFile'                => true,
    ]);

    $shouldHaveCalledGenerators = [
        MigrationGenerator::class,
        ModelGenerator::class,
        RepositoryGenerator::class,
        RequestGenerator::class,
        ControllerGenerator::class,
        ViewGenerator::class,
        RoutesGenerator::class,
        MenuGenerator::class,
        FactoryGenerator::class,
    ];

    mockShouldHaveCalledGenerateMethod($shouldHaveCalledGenerators);

    $shouldNotHaveCalledGenerator = [
        RepositoryTestGenerator::class,
        APITestGenerator::class,
        APIRequestGenerator::class,
        APIControllerGenerator::class,
        APIRoutesGenerator::class,
        SeederGenerator::class,
    ];

    mockShouldNotHaveCalledGenerateMethod($shouldNotHaveCalledGenerator);

    config()->set('flex_laravel_generator.options.factory', true);

    $modelSchemaFile = __DIR__.'/../fixtures/model_schema/Post.json';

    $fileUtils->shouldReceive('getFile')
        ->withArgs([$modelSchemaFile])
        ->andReturn(file_get_contents($modelSchemaFile));
    $fileUtils->shouldReceive('getFile')
        ->andReturn('');

    artisan(ScaffoldGeneratorCommand::class, ['model' => 'Post', '--fieldsFile' => $modelSchemaFile])
        ->expectsQuestion(PHP_EOL.'Do you want to migrate database? [y|N]', false)
        ->assertSuccessful();
});
