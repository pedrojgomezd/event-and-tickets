<?php

namespace App\QueryFilters;

class MeetupFilters extends Filters 
{
    protected $filters = ['tickets', 'customer'];

    protected function tickets()
    {
        return $this->builder->with('tickets');
    }

    public function customer()
    {
        return $this->builder->with('tickets.customer');
    }
}
