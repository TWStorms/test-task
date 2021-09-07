<?php

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
            'username' => "alaman",
            'password' => Hash::make('admin'),
            'email' => 'alaman@gmail.com',
            'phone_number' => '12345678',
            'parent_id' => null,
            'verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => GeneralHelper::STR_RANDOM(50),
            'email_verification_code' => GeneralHelper::STR_RANDOM(50),
            'level_completed' => 0,
            'child_count' => 0,
            'verify' => \App\Helpers\IUserStatus::VERIFIED,
            'status' => \App\Helpers\IUserStatus::ACTIVE,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        );
        $admin = User::create($adminUser);
        $admin->assignRole('super-admin');

        // Create Sub Admin
        $adminUser = array(
            'username' => "alaman Worker",
            'password' => Hash::make('sub_admin'),
            'email' => 'alamanWorker@gmail.com',
            'phone_number' => config('app.number'),
            'parent_id' => null,
            'verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => GeneralHelper::STR_RANDOM(50),
            'email_verification_code' => GeneralHelper::STR_RANDOM(50),
            'level_completed' => 0,
            'child_count' => 0,
            'verify' => \App\Helpers\IUserStatus::VERIFIED,
            'status' => \App\Helpers\IUserStatus::ACTIVE,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        );
        $admin = User::create($adminUser);
        $admin->assignRole('sub-admin');

        // Create Sub Admin
        $user = array(
            'username' => "waleed",
            'password' => Hash::make('user123'),
            'email' => 'waleedbinkhalid84587@gmail.com',
            'phone_number' => '032292301928',
            'parent_id' => 1,
            'verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => GeneralHelper::STR_RANDOM(50),
            'email_verification_code' => null,
            'level_completed' => 0,
            'child_count' => 0,
            'verify' => \App\Helpers\IUserStatus::VERIFIED,
            'status' => \App\Helpers\IUserStatus::ACTIVE,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        );
        $user = User::create($user);
        $user->assignRole('user');
    }
}
