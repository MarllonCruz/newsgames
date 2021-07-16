<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function post() {

        return $this->hasOne(Post::class, 'id', 'id_post');

    }
}
