<?php

use Illuminate\Database\Seeder;
use App\Models\Route;

class DefaultRouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $routes = [
            [
                'type'     => 'web',
                'name'     => 'index',
                'method'   => 'GET|HEAD',
                'uri'      => '/',
                'redirect' => '/dashboard',
                'meta'     => [
                    'title' => 'Home',
                    'icon'  => 'dashboard'
                ],
            ],
            [
                'type'     => 'web',
                'name'     => 'plurk.login',
                'method'   => 'GET|HEAD',
                'uri'      => '/plurk/login',
                'children' => [
                    [
                        'type'     => 'web',
                        'name'     => 'plurk.login.callback',
                        'method'   => 'GET|HEAD',
                        'uri'      => '/plurk/login/callback',
                        'redirect' => '',
                    ]
                ]
            ],
            [
                'type'     => 'web',
                'name'     => 'plurk',
                'method'   => 'GET|HEAD',
                'uri'      => '/plurk',
                'redirect' => '/plurk/info',
                'meta'     => [
                    'title' => 'Plurk',
                    'icon'  => 'plurk',
                    'roles' => ['user']
                ],
                'children' => [
                    [
                        'name'     => 'plurk.info',
                        'method'   => 'GET|HEAD',
                        'uri'      => '/plurk/info',
                        'meta'     => [
                            'title' => 'Plurk',
                            'icon'  => 'plurk',
                        ],
                    ],
                    [
                        'name'     => 'plurk.friend',
                        'method'   => 'GET|HEAD',
                        'uri'      => '/plurk/friend',
                        'meta'     => [
                            'title' => 'Friend',
                            'icon'  => 'peoples',
                        ],
                    ],
                ]
            ],
            [
                'type'     => 'web',
                'name'     => 'message',
                'method'   => 'GET|HEAD',
                'uri'      => '/message',
                'redirect' => '/message/index',
                'meta'     => [],
                'children' => [
                    [
                        'name'     => 'message.index',
                        'method'   => 'GET|HEAD',
                        'uri'      => '/message/index',
                        'meta'     => [
                            'title' => 'Message',
                            'icon'  => 'message',
                        ],
                    ],
                ]
            ],
            [
                'type'     => 'web',
                'name'     => 'mobile',
                'method'   => 'GET|HEAD',
                'uri'      => '/mobile',
                'redirect' => '/mobile/index',
                'children' => [
                    [
                        'name'     => 'mobile.index',
                        'method'   => 'GET|HEAD',
                        'uri'      => '/mobile/index',
                    ],
                ]
            ],
        ];

        foreach ($routes as $route) {
            $this->createRoute($route);
        }
    }

    public function createRoute($route)
    {
        $children = $route['children'] ?? false;
        unset($route['children']);

        $res = Route::create($route);
        $id  = $res->id;

        if ($children) {
            foreach ($children as $value) {
                $value['parent_id'] = $id;
                $this->createRoute($value);
            }
        }
    }
}
