<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Entities\UuidTrait;

class Movie extends Model
{
    use HasFactory;
    use UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'year',
        'imdbid',
        'poster'
    ];
}
