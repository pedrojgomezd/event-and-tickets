<?php

namespace App\Models;

use App\Events\TicketCreated;
use App\Events\TicketCreating;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'meetup_id', 'code', 'is_used', 'sold_by'];
    
    protected static function booted()
    {
        static::creating(function ($ticket) {
            $ticket->code = $ticket->code ?: Str::random(9);
        });
        
        static::created(function ($ticket) {
            $ticket->meetup->increment('sold');
        });
    }

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

    public function switchUsed()
    {
        if(!$this->is_used) {
            $this->update([
                'is_used' => true
            ]);
            return true;
        }
        return false;
    }
}
