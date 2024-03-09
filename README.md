# FlexAdmin Laravel Generator (CRUD)

## Ensure composer detect new namespace

Go to root larave app. Run

```
composer dumpautoload

```

## Generator commands:

```
php artisan flex.scaffold:controller YourModel
php artisan flex:model YourModel
php artisan flex:scaffold YourModel
php artisan flex:rollback YourModel scaffold
```

## Publish Laravel Generator Templates

```
php artisan vendor:publish --tag=flex-laravel-generator-templates
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
