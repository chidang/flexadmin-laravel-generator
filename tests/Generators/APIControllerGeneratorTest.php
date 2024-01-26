<?php

use Techamz\Generator\Facades\FileUtils;
use Techamz\Generator\Generators\API\APIControllerGenerator;
use Mockery as m;

beforeEach(function () {
    FileUtils::fake();
});

afterEach(function () {
    m::close();
});

test('uses repository controller template', function () {
    fakeGeneratorConfig();

    /** @var APIControllerGenerator $generator */
    $generator = app(APIControllerGenerator::class);

    $viewName = $generator->getViewName();

    expect($viewName)->toBe('repository.controller');
});

test('uses model controller template', function () {
    config()->set('flex_laravel_generator.options.repository_pattern', false);

    fakeGeneratorConfig();

    /** @var APIControllerGenerator $generator */
    $generator = app(APIControllerGenerator::class);

    $viewName = $generator->getViewName();

    expect($viewName)->toBe('model.controller');
});

test('used resource repository controller template', function () {
    config()->set('flex_laravel_generator.options.resources', true);

    fakeGeneratorConfig();

    /** @var APIControllerGenerator $generator */
    $generator = app(APIControllerGenerator::class);

    $viewName = $generator->getViewName();

    expect($viewName)->toBe('repository.controller_resource');
});
