<?php

use Illuminate\Database\Seeder;
use App\Models\Message;

class DefaultMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $messages = [
            [
                'user_id'   => 1,
                // 'parent_id' => 0,
                'title'     => 'string',
                'content'   => 'string',
                'reply'     => [
                    [
                        'user_id'   => 2,
                        'title'     => 'string',
                        'content'   => 'string',
                    ],
                    [
                        'user_id'   => 1,
                        'title'     => 'string',
                        'content'   => 'string',
                    ]
                ]
            ],
            [
                'user_id'   => 2,
                // 'parent_id' => 0,
                'title'     => 'string',
                'content'   => 'string',
                'reply'     => [
                    [
                        'user_id'   => 1,
                        'title'     => 'string',
                        'content'   => 'string',
                    ],
                    [
                        'user_id'   => 1,
                        'title'     => 'string',
                        'content'   => 'string',
                    ]
                ]
            ],
        ];

        foreach ($messages as $message) {
            $this->createMessage($message);
        }
    }

    public function createMessage($message)
    {
        $children = $message['reply'] ?? false;
        unset($message['reply']);

        $res = Message::create($message);
        $id  = $res->id;

        if ($children) {
            foreach ($children as $value) {
                $value['parent_id'] = $id;
                $this->createMessage($value);
            }
        }
    }
}
