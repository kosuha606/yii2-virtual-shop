<?php

namespace app\virtualModels\Admin\Domains\Email;

use kosuha606\VirtualModel\VirtualModel;

class Email extends VirtualModel
{
    const KEY = 'email';

    public static function providerType()
    {
        return self::KEY;
    }

    public function attributes(): array
    {
        return [
            'id',
            'to_email',
            'from_email',
            'bcc',
            'subject',
            'body',
        ];
    }

    public function send()
    {
        $ids = $this->save();

        return parent::send($ids);
    }
}