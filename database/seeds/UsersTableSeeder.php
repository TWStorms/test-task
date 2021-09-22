<?php

/**
 * Created by PhpStorm.
 * Waleed Bin Khalid
 * Date: 19/09/2021
 */

use App\Helpers\GeneralHelper;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * @var \Faker\Generator
     */
    private $_faker;

    public function __construct()
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        // Create Admin
        $adminUser = array(
            'first_name' => "admin",
            'last_name' => "admin",
            'password' => Hash::make('admin'),
            'email' => 'admin@gmail.com',
            'verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => GeneralHelper::STR_RANDOM(50),
            'email_verification_code' => GeneralHelper::STR_RANDOM(50),
            'verify' => \App\Helpers\IUserStatus::VERIFIED,
            'status' => \App\Helpers\IUserStatus::ACTIVE,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        );
        $admin = User::create($adminUser);
        $admin->assignRole('admin');

    }
}
