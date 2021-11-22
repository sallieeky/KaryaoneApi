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
            'no_telp' => '081234567890',
            'alamat' => 'Jl. Batu Ratna No.56',
            'email' => 'admin@karyaone',
            'password' => bcrypt('admin'),
            'foto' => 'foto.png'
        ]);
        User::create([
            'nama' => 'Alvian',
            'jabatan' => 'Human Resource Development',
            'nip' => '10101010',
            'no_telp' => '081234567890',
            'alamat' => 'Jl. Batu Ratna No.56',
            'email' => 'alvian@karyaone',
            'password' => bcrypt('alvian'),
            'foto' => 'foto.png'
        ]);
    }
}
