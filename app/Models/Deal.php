<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;
    protected $table = "deals";

    protected $fillable = [
        'user_id',
        'customer_id',
        'account_id',
        'compaign_id',
        'name',
        'type',
        'lead_src',
        'stage_id',
        'amount',
        'probability',
        'description',
        'closedate',
    ];

    protected $with = ['user','account'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }
}
