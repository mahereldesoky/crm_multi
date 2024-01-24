<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;
    protected $table = "accounts";

    protected $fillable = [
        'user_id',
        'acc_name',
        'acc_site',
        'acc_number',
        'acc_type',
        'acc_industry',
        'rating',
        'phone',
        'address',
        'description'
    ];


    protected $with = ['user'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
