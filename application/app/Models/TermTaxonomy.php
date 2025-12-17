<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TermTaxonomy extends Model
{
    use HasFactory;
    protected $table = 'term_taxonomy';
    protected $fillable = [
        'name',
        'slug',
        'type',
        'term_type',
    ];
}
