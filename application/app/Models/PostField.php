<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostField extends Model
{
    use HasFactory;
    protected $table = 'posts_field';
    protected $fillable = [
        'term_type',
        'term_taxonomy_type',
        'field_name',
      	'field_type',
      	'field_key',
      	'field_value',
    ];


}