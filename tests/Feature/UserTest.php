<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;


class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

   // без параметров запроса
    public function testRequiredFieldsForUsers()
    {
        $this->json('POST', 'api/v1/users', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "status" => "Error",
                "message" => [
                    "name" => [
                        "The name field is required."
                    ],
                    "email" => [
                        "The email field is required."
                    ]
                ],
                "data" => null

            ]);
    }

// с корректными параметрами запроса

public function testRequiredFieldEmail()
    {
        $userData = [
            "name" => "John Doe",
        ];

        $this->json('POST', 'api/v1/users', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "status" => "Error",
                "message" => [
                    "email" => [
                        "The email field is required."
                    ]
                ],
                "data" => null

            ]);
    }

    public function testCreateUser()
    {

        $ceoData = [
            "name" => "Susan2",
            "email" => "Susan2@gmail.com",
        ];
        $user = User::factory()->create($ceoData);


        $this->json('POST', 'api/v1/users', $ceoData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJson([
                "status"=> "Success",
                "message"=> null,
                "data"=> "User Created"
            
            ]);
    }
    //без обязательного параметра
    public function testQueryParams()
    {
        $data = [
          "name" => "guvandyk"
        ];

        $this->json('GET', 'api/v1/data/',['name'=>'data'], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status"=> "Success",
                "message"=> "data",
                "data"=> "data"
            
            ]);
    }
//без обязательного параметра 
    public function testNotQueryParams()
    {

        $this->json('GET', 'api/v1/data', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "status"=> "Success",
                "message"=> null,
                "data"=> "data isn't id"
            
            ]);
    }
}
