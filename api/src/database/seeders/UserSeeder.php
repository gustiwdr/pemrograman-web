<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $timestamp = Carbon::now()->toDateTimeString();
        DB::table('users')->insert([
            'username' => 'client',
            // 'password' => Hash::make('password'),
            'password' => 'password',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
