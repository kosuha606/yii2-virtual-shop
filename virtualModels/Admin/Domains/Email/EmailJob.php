<?php

namespace app\virtualModels\Admin\Domains\Email;

use app\virtualModels\Admin\Domains\Queue\QueueJobInterface;
use kosuha606\VirtualModelHelppack\ServiceManager;

class EmailJob implements QueueJobInterface
{
    public function run($arguments = [])
    {
        $dto = (new EmailDTO())
            ->setFromEmail($arguments['from_email'])
            ->setToEmail($arguments['to_email'])
            ->setBody($arguments['body'])
            ->setSubject($arguments['subject'])
        ;

        if (isset($arguments['bcc'])) {
            $dto->setBcc($arguments['bcc']);
        }

        $emailService = ServiceManager::getInstance()->get(EmailService::class);
        $emailService->send($dto);
    }
}