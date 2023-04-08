<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FirstUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'email' => 'christiantermo84@gmail.com',
            'FirstName' => 'Christian',
            'LastName' => 'Termo',
            'role' => 'admin',
            'country' => '55',
            'dci' => 'x',
            'status' => 'x',
            'torneo' => 'x'
        ]);

        $michele = User::create([
            'email' => 'michiviane@gmail.com',
            'FirstName' => 'Michele',
            'LastName' => 'Vianello',
            'role' => 'admin',
            'country' => '55',
            'dci' => 'x',
            'status' => 'x',
            'torneo' => 'x'
        ]);
    }
}
