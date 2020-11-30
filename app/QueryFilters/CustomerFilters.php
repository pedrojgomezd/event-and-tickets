<?php

namespace App\QueryFilters;

class CustomerFilters extends Filters 
{
    protected $filters = ['tickets', 'meetup'];

    protected function tickets()
    {
        return $this->builder->with('tickets');
    }

    public function meetup()
    {
        return $this->builder->with('tickets.meetup');
    }
}
