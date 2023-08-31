<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'id_outlet' => '1',
                'nama' => 'EginAdmin',
                'username' => 'Egin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123'),
                'role' => 'admin',
                'foto' => 'Admin.jpg'
            ],
            [
                'id_outlet' => '1',
                'nama' => 'KrisnaAdmin',
                'username' => 'Krisna',
                'email' => 'krisna@gmail.com',
                'password' => bcrypt('123'),
                'role' => 'admin',
                'foto' => 'Admin.jpg'
            ],
        ];
        foreach ($user as $key => $values)
            User::create($values);
    }
}
