<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Dalnet Test',
        //     'username' => 'dalnet-test',
        //     'email' => 'dalnettest@gmail.com',
        //     'password' => Hash::make('12345678'),
        // ]);
    }
}
