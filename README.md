# TechAmz Laravel Generator (CRUD)

## Ensure composer detect new namespace

Go to root larave app. Run

```
composer dumpautoload

```

## Generator commands:

```
php artisan techamz.scaffold:controller YourModel
php artisan techamz:model YourModel
php artisan techamz:scaffold YourModel
php artisan techamz:rollback YourModel scaffold
```

## Publish Laravel Generator Templates

```
php artisan vendor:publish --tag=flex-laravel-generator-templates
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
