<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function autor()
    {
        return $this->hasOne( related: User::class, foreignKey: 'id', localKey: 'created_user');
    }
}
