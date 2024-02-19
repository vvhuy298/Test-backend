<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DB;
use Str;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    private $users;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'id' => $i,
                'uuid' => Str::uuid()->toString(),
                'email' => 'user' . sprintf('%02d', $i) . '@example.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('users')->insert($users);
    }
}
