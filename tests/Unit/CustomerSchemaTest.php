<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CustomerSchemaTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_customer_database_has_extected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('customers', [
                'id', 'name', 'document', 'birth_day', 'email', 'phone', 'created_by'
            ]), 
        1);
    }
}
