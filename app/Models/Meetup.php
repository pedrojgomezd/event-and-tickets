<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meetup extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cover_path', 'date', 'place', 'description', 'quantity', 'sold'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, Ticket::class);
    }
}
