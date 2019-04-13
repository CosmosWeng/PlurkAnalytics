<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PlurkUser;
use App\Utils\CustomTokenUtil;

class DefaultUserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
            [
                'uuid'        => '14967202',
                'nick_name'   => 'MgmtTools',
                'email'       => 'MgmtTools@mail.com',
                'token'       => env('PLURK_BOT_KEY'),
                'secret'      => env('PLURK_BOT_SECRET'),
            ]
        ];

        foreach ($users as $user) {
            $this->registered($user);
        }
    }

    public function registered($resp = [])
    {
        $puser = PlurkUser::create([
            'uuid'         => $resp['uuid'],
            'nick_name'    => $resp['nick_name'],
            'display_name' => $resp['nick_name'],
            'token'        => $resp['token'],
            'secret'       => $resp['secret'],
        ]);

        $user = User::create([
            'name'      => $resp['nick_name'],
            'email'     => $resp['email'],
            'password'  => Hash::make($resp['nick_name'].$resp['email'].$resp['uuid']),
            'api_token' => CustomTokenUtil::getAuthApiToken('api')
        ]);
        // Set Role
        $user->setUserRole(['user']);

        //
        $puser->user_id = $user->id;
        $puser->save();
    }
}
