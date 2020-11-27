<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TicketSchemaTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_database_has_extected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('tickets', [
                'id', 'customer_id', 'meetup_id', 'code', 'is_used', 'sold_by'
            ]), 
        1);
    }
}
