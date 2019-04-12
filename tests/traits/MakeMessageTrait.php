<?php

namespace Tests\Traits;

use Faker\Factory as Faker;
use App\Models\Message;
use App\Repositories\MessageRepository;

trait MakeMessageTrait
{
    /**
     * Create fake instance of Message and save it in database
     *
     * @param array $messageFields
     * @return Message
     */
    public function makeMessage($messageFields = [])
    {
        /** @var MessageRepository $messageRepo */
        $messageRepo = \App::make(MessageRepository::class);
        $theme       = $this->fakeMessageData($messageFields);

        return $messageRepo->create($theme);
    }

    /**
     * Get fake instance of Message
     *
     * @param array $messageFields
     * @return Message
     */
    public function fakeMessage($messageFields = [])
    {
        return new Message($this->fakeMessageData($messageFields));
    }

    /**
     * Get fake data of Message
     *
     * @param array $messageFields
     * @return array
     */
    public function fakeMessageData($messageFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'parent_id'  => $fake->randomDigitNotNull,
            'user_id'    => $fake->randomDigitNotNull,
            'title'      => $fake->word,
            'content'    => $fake->text,
            'is_reply'   => $fake->randomDigitNotNull,
            'is_public'  => $fake->randomDigitNotNull,
            'updated_at' => $fake->date('Y-m-d H:i:s'),
            'created_at' => $fake->date('Y-m-d H:i:s'),
            // 'deleted_at' => $fake->date('Y-m-d H:i:s')
        ], $messageFields);
    }
}
