<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->call(DefaultLangSeeder::class);
        $this->call(DefaultRouteSeeder::class);
        $this->call(DefaultRoleSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(DefaultUserAccountSeeder::class);
        $this->call(DefaultBotMissionSeeder::class);
        $this->call(DefaultMessageSeeder::class);
    }
}
