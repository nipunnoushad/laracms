<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Term extends Model
{
    use HasFactory;
    protected $table = 'terms';
    protected $fillable = [
        'name',
        'slug',
    ];

    public function getAll(){
        $data = [];
        if(Schema::hasTable($this->table)){
          $data = Term::get();
        }
        return $data;
    }
    public static function name($term){
        return Term::where('slug', $term)->first()->name;
    }
}
