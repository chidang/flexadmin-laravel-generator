<?php

use Techamz\Generator\Commands\RollbackGeneratorCommand;
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

it('fails with invalid rollback type', function () {
    artisan(RollbackGeneratorCommand::class, ['model' => 'User', 'type' => 'random'])
        ->assertExitCode(1);
});

function mockShouldHaveCalledRollbackGenerator(array $shouldHaveCalledGenerators): array
{
    $mockedObjects = [];

    foreach ($shouldHaveCalledGenerators as $generator) {
        $mock = m::mock($generator);

        $mock->shouldReceive('rollback')
            ->once()
            ->andReturn(true);

        app()->singleton($generator, function () use ($mock) {
            return $mock;
        });

        $mockedObjects[] = $mock;
    }

    return $mockedObjects;
}

function mockShouldNotHaveCalledRollbackGenerators(array $shouldNotHaveCalledGenerator): array
{
    $mockedObjects = [];

    foreach ($shouldNotHaveCalledGenerator as $generator) {
        $mock = m::mock($generator);

        $mock->shouldNotReceive('rollback');

        app()->singleton($generator, function () use ($mock) {
            return $mock;
        });

        $mockedObjects[] = $mock;
    }

    return $mockedObjects;
}

it('validates that all files are rolled back for api_scaffold', function () {
    $shouldHaveCalledGenerators = [
        MigrationGenerator::class,
        ModelGenerator::class,
        RepositoryGenerator::class,
        APIRequestGenerator::class,
        APIControllerGenerator::class,
        APIRoutesGenerator::class,
        RequestGenerator::class,
        ControllerGenerator::class,
        ViewGenerator::class,
        RoutesGenerator::class,
        MenuGenerator::class,
        FactoryGenerator::class,
        RepositoryTestGenerator::class,
        APITestGenerator::class,
    ];

    mockShouldHaveCalledRollbackGenerator($shouldHaveCalledGenerators);

    $shouldNotHaveCalledGenerator = [
        SeederGenerator::class,
    ];

    mockShouldNotHaveCalledRollbackGenerators($shouldNotHaveCalledGenerator);

    config()->set('flex_laravel_generator.options.tests', true);

    artisan(RollbackGeneratorCommand::class, ['model' => 'User', 'type' => 'api_scaffold']);
});

it('validates that all files are rolled back for api', function () {
    $shouldHaveCalledGenerators = [
        MigrationGenerator::class,
        ModelGenerator::class,
        APIRequestGenerator::class,
        APIControllerGenerator::class,
        APIRoutesGenerator::class,
        FactoryGenerator::class,
        SeederGenerator::class,
    ];

    mockShouldHaveCalledRollbackGenerator($shouldHaveCalledGenerators);

    $shouldNotHaveCalledGenerator = [
        RepositoryGenerator::class,
        RequestGenerator::class,
        ControllerGenerator::class,
        ViewGenerator::class,
        RoutesGenerator::class,
        MenuGenerator::class,
    ];

    mockShouldNotHaveCalledRollbackGenerators($shouldNotHaveCalledGenerator);

    config()->set('flex_laravel_generator.options.repository_pattern', false);
    config()->set('flex_laravel_generator.options.factory', true);
    config()->set('flex_laravel_generator.options.seeder', true);

    artisan(RollbackGeneratorCommand::class, ['model' => 'User', 'type' => 'api']);
});

it('validates that all files are rolled back for scaffold', function () {
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

    mockShouldHaveCalledRollbackGenerator($shouldHaveCalledGenerators);

    $shouldNotHaveCalledGenerator = [
        APIRequestGenerator::class,
        APIControllerGenerator::class,
        APIRoutesGenerator::class,
    ];

    mockShouldNotHaveCalledRollbackGenerators($shouldNotHaveCalledGenerator);

    config()->set('flex_laravel_generator.options.tests', true);

    artisan(RollbackGeneratorCommand::class, ['model' => 'User', 'type' => 'scaffold']);
});
