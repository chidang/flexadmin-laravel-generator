Route::resource('{{ $config->prefixes->getRoutePrefixWith('/') }}{{ $config->modelNames->snakePlural }}', {{ $config->namespaces->controller }}\{{ $config->modelNames->name }}Controller::class)@if(!$config->prefixes->route);@endif
@if($config->prefixes->route){!! techamz_nl_tab().'->names(['.techamz_nl_tab(1, 2).implode(','.techamz_nl_tab(1, 2), create_resource_route_names($config->prefixes->getRoutePrefixWith('.').$config->modelNames->camelPlural, true)).techamz_nl_tab().']);' !!}@endif