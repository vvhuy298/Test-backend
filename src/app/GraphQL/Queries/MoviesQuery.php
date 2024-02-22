<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Movie;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class MoviesQuery extends Query
{
    protected $attributes = [
        'name' => 'movies',
    ];

    public function type(): Type
    {

        return Type::listOf(GraphQL::type('Movie'));
    }

    public function args(): array
    {
        return [
            'imdbid' => [
                'name' => 'id',
                'type' => Type::string()
            ],
            'poster' => [
                'name' => 'name',
                'type' => Type::string()
            ],
            'title' => [
                'name' => 'email',
                'type' => Type::string()
            ],
            'uuid' => [
                'name' => 'age',
                'type' => Type::string()
            ],
            'year' => [
                'name' => 'country',
                'type' => Type::string()
            ],
            'favorited' => [
                'name' => 'country',
                'type' => Type::boolean()
            ]
        ];
    }

    public function resolve($root, $args)
    {
        dd('123');
        return Movie::all();
    }
}
