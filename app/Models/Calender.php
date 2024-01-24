<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calender extends Model
{
    use HasFactory;
    protected $table = "calender";
    protected $fillable = [
        // 'user_id',
        // 'customer_id',
        'title',
        // 'type',
        // 'comments',
        'start',
        'end'
    ];

    // public function user(): BelongsTo
    // {
    //     return $this->belongsTo(User::class);
    // }
 
    // public function customer(): BelongsTo
    // {
    //     return $this->belongsTo(Customer::class);
    // }
}
