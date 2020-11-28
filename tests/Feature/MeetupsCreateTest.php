<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MeetupsCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_cant_register_meetups()
    {
        $response = $this->postJson('api/meetups');

        $response->assertUnauthorized();
    }

    public function test_a_user_can_register_meetups()
    {
        Storage::fake('covers');

        $user = $this->singInApi();

        $data = [
            'name' => 'Concierto Metallica',
            'date' => '2020-12-31',
            'place' => 'Parque de las luces',
            'description' => 'Concierto de metallica, para disfrutar de musica de calidad',
            'quantity' => 10,
            'cover' => UploadedFile::fake()->image('cover-meetups.png'),
        ];

        $response = $this->postJson('api/meetups', $data);
        
        $response->assertCreated();
        
        unset($data['cover']);

        $response->assertJson(['data' => $data]);
    }
}
