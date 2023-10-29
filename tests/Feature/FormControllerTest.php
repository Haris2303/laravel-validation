<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormControllerTest extends TestCase
{
    public function testLoginFailed()
    {
        $this->post('/form/login', [
            'username' => '',
            'password' => ''
        ])->assertStatus(400);
    }

    public function testLoginSuccess()
    {
        $response = $this->post('/form/login/', [
            'username' => 'ucup',
            'password' => 'ucup'
        ]);

        $response->assertStatus(200);
    }

    public function testFormFailed()
    {
        $this->post('/form', [
            'username' => '',
            'password' => ''
        ])->assertStatus(302);
    }

    public function testFormSuccess()
    {
        $response = $this->post('/form', [
            'username' => 'ucup',
            'password' => 'ucup'
        ]);

        $response->assertStatus(200);
    }
}
