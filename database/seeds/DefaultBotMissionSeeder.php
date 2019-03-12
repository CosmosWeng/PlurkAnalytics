<?php

use Illuminate\Database\Seeder;
use App\Models\PlurkBotMission;

class DefaultBotMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $missions = [
            [
                'name'    => '註冊',
                'type'    => 'base',
                'lang'    => 'zh-TW',
                'code'    => 'RegisterUserJob',
                'keyword' => 'registered',
            ],
            [
                'name'    => '取消註冊',
                'type'    => 'base',
                'lang'    => 'zh-TW',
                'code'    => 'UnRegisterUserJob',
                'keyword' => 'unregistered',
            ],
            [
                'name'    => '骰子比大小',
                'type'    => 'dice',
                'lang'    => 'zh-TW',
                'code'    => 'DiceGameJob',
                'keyword' => '比大小',
            ],
            [
                'name'     => '建立副本',
                'type'     => 'rpg',
                'lang'     => 'zh-TW',
                'code'     => '',
                'keyword'  => '建立副本',
                'children' => [
                    [
                        'name'    => '設定名稱',
                        'type'    => 'rpg',
                        'lang'    => 'zh-TW',
                        'code'    => '',
                        'keyword' => '',
                    ],
                ]
            ],
            [
                'name'    => '開啟副本',
                'type'    => 'rpg',
                'lang'    => 'zh-TW',
                'code'    => '',
                'keyword' => '開啟副本',
            ]
        ];

        foreach ($missions as $mission) {
            $children = [];
            if (isset($mission['children'])) {
                $children = $mission['children'];
                unset($mission['children']);
            }
            $res = PlurkBotMission::create($mission);

            if ($children) {
                $id = $res->id;
                foreach ($children  as $key => $value) {
                    $value['parent'] = $id;
                    PlurkBotMission::create($value);
                }
            }
        }
    }
}
