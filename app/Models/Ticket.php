<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $casts = [
        'is_used' => 'boolean'
    ];

    public function meetup()
    {
        return $this->belongsTo(Meetup::class);
    }
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function seller()
    {
        return $this->belongsTo(User::class, 'sold_by');
    }
}
