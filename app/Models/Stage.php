<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $table = "stages";
    protected $fillable = [
        'name'
    ];


    protected $with = ['deals'];

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

}
