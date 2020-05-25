<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Str;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::statement('TRUNCATE TABLE users');
        DB::table('users')->insert([
            'name' => 'Orhan',
            'email' => 'orhan@orhan.com',
            'email_verified_at' => now(),
            'password' => bcrypt(12344321),
            'api_token' => Str::random(80),
            'remember_token' => Str::random(10)
        ]);
        factory(User::class,10)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
