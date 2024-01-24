<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaigns extends Model
{
    use HasFactory;
    protected $table = "campaigns";
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'start_at',
        'end_at',
        'status',
        'exp_revenue',
        'Act_cost',
        'bud_cost',
        'num_sent',
        'type',
        'expect_res'

    ];







    public function user(){
        return $this->belongsTo(User::class);
    }
}
