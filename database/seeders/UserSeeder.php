<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(20)->create();

        $users = [
            ["first_name"=>"admin",
            "last_name"=>"admin",
            "email"=>"admin@test.io",
            "role_id"=>1
            ],
            ["first_name"=>"editor",
            "last_name"=>"editor",
            "email"=>"editor@test.io",
            "role_id"=>2
            ],
            ["first_name"=>"viewer",
            "last_name"=>"viewer",
            "email"=>"viewer@test.io",
            "role_id"=>3
            ]
        ];
        foreach($users as $user){
            User::factory()->create($user);
        }
    }
}
