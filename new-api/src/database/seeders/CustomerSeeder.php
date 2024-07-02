<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $timestamp = Carbon::now()->toDateTimeString();
        DB::table('customers')->insert([
            'full_name' => 'John Doe',
            'username' => 'john',
            'email' => 'john@email.com',
            'phone_number' => '08123456789',
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}
