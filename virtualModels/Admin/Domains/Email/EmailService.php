<?php

namespace app\virtualModels\Admin\Domains\Email;

class EmailService
{
    public function send(EmailDTO $emailDTO)
    {
        $mail = Email::create([
            'to_email' => $emailDTO->getToEmail(),
            'from_email' => $emailDTO->getFromEmail(),
            'bcc' => $emailDTO->getBcc(),
            'subject' => $emailDTO->getSubject(),
            'body' => $emailDTO->getBody(),
        ])->send();
    }
}