<?php

use Illuminate\Database\Seeder;

class DefaultLangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $langs = [
            [
                'name'  => 'English',
                'codes' => 'en'
            ],
            [
                'name'  => 'Chinese',
                'codes' => 'tw,zh-TW'
            ],
            [
                'name'  => 'Japanese',
                'codes' => 'jp,ja'
            ]
        ];

        DB::table('langs')->insert($langs);
    }
}
