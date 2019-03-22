<?php

use Illuminate\Database\Seeder;
use App\Models\Route;
use App\Models\Role;

class DefaultRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name'   => 'user',
                'slug'   => 'user',
                'routes' => ['plurk', 'plurk.info', 'plurk.friend']
            ]
        ];

        foreach ($roles as $role) {
            //
            $routes = Route::whereIn('name', $role['routes'])->get();
            unset($role['routes']);

            $res = Role::create($role);

            foreach ($routes as $route) {
                DB::table('role_routes')->insert([
                    'role_id'  => $res->id,
                    'route_id' => $route->id
                ]);
            }
        }
    }
}
