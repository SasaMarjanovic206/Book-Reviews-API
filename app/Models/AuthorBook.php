<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorBook extends Model
{
    use HasFactory;

    protected $table = 'author_book';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
