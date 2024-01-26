@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->controller }};

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\BaseControllerConcerns;
@if(config('flex_laravel_generator.tables') === 'datatables')
use {{ $config->namespaces->dataTables }}\{{ $config->modelNames->name }}DataTable;
@endif

class {{ $config->modelNames->name }}Controller extends Controller
{
    use BaseControllerConcerns;

    private static function resourceClassName(){
        return '{{ $config->modelNames->name }}';
    }

    private static function createRules(){
        return [
          {!! $rules !!}
        ];
    }

    private static function updateRules(){
        return self::createRules();
    }
}
