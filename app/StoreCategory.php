<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{
    protected $table = 'user_category';

    protected $fillable = ['name', 'status'];

    /** Relationships */
    public function users(){

        return $this->hasMany(User::class);
    }
}
