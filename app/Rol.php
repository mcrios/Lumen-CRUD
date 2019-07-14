<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model{


    public $timestamps = false;

    protected $fillable = ['name'];

    public function user(){
        return $this->hasMany(User::class);
    }
}