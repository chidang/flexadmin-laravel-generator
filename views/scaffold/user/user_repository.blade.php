@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ config('flex_laravel_generator.namespace.repository') }};

use {{ config('flex_laravel_generator.namespace.repository') }}\BaseRepository;
use {{ config('flex_laravel_generator.namespace.model') }}\User;

/**
 * Class UserRepository
 * @package {{ config('flex_laravel_generator.namespace.repository') }}
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return User::class;
    }
}
