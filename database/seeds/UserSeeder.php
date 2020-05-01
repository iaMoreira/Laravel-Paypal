<?php

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
            'name' => 'Ian Moreira',
            'email' => 'ianmoreira80@gmail.com',
            'password' => bcrypt('123123')
        ]);
    }
}
