<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MeetupSchemaTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_database_has_extected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('meetups', [
                'id', 'name', 'cover_path', 'date', 'place', 'description', 'quantity', 'sold', 'created_by'
            ]), 
        1);
    }
}
