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

        // Create Admin info@yachtregistration.company
        $adminUser = array(
            'username' => "al-man traders",
            'password' => Hash::make('admin'),
            'email' => 'alaman@gmail.com',
            'phone_number' => '12345678',
            'parent_id' => null,
            'verified_at' => now()->format('Y-m-d H:i:s'),
            'remember_token' => GeneralHelper::STR_RANDOM(50),
            'email_verification_code' => GeneralHelper::STR_RANDOM(50),
            'level_completed' => 0,
            'referer_code' => GeneralHelper::STR_RANDOM(50),
            'registration_code' => GeneralHelper::STR_RANDOM(50),
            'child_count' => 0,
            'verify' => 1,
            'status' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        );
        $admin = User::create($adminUser);
        $admin->assignRole('super_admin');
    }
}
