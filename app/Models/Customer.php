<?php

namespace App\Models;

use App\QueryFilters\CustomerFilters;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'document', 'birth_day', 'email', 'phone'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function meetups()
    {
        return $this->belongsToMany(Meetup::class, Ticket::class);
    }

    public function scopeFilter($query, CustomerFilters $filter)
    {
        return $filter->apply($query);
    }
}
