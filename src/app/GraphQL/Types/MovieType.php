<?php

namespace App\GraphQL\Types;

use App\Models\Movie;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class MovieType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Movie',
        'description' => 'Collection of Movies',
        'model' => Movie::class
    ];

    public function fields(): array
    {
        /* type MovieType = {
            imdbid: string;
            poster: string;
            title: string;
            uuid: string;
            year: string;
            favorited: boolean;
          }; */
        return [
            'imdbid' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'IMBID of movie'
            ],
            'poster' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Poster  of movie'
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Title of movie'
            ],
            'uuid' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Uuid of movie'
            ],
            'year' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Year of movie'
            ],
            'favorited' => [
                'type' => Type::nonNull(Type::boolean()),
                'description' => 'Favorite status of movie'
            ]
        ];
    }
}