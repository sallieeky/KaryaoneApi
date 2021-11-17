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
        User::create([
            'nama' => 'Admin',
            'jabatan' => 'Admin',
            'nip' => '123456789',
            'email' => 'admin@karyaone',
            'password' => bcrypt('admin'),
            'foto' => 'foto.png'
        ]);
    }
}
