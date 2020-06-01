<?php

use app\virtualModels\Admin\Domains\Email\Email;
use app\virtualModels\Admin\Domains\Email\EmailJob;
use app\virtualModels\Admin\Domains\Queue\QueueService;
use app\virtualModels\Admin\Test\TestEmailProvider;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualModelHelppack\Test\VirtualTestCase;

class QueueTest extends VirtualTestCase
{
    /** @var TestEmailProvider  */
    private $emailProvider;

    public function setUp()
    {
        parent::setUp();
        $this->emailProvider = new TestEmailProvider();
        VirtualModelManager::getInstance()->setProvider($this->emailProvider);
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    public function testJob()
    {
        $queueService = ServiceManager::getInstance()->get(QueueService::class);
        $queueService->pushJob(EmailJob::class, [
            'to_email' => 'toemail@email.com',
            'from_email' => 'fromemail@email.com',
            'bcc' => 'bccemails@email.com',
            'subject' => 'testEmail from job',
            'body' => 'body of test email',
        ]);

        $queueService->popAndRunAllJobs();
        // Был отправлен один email
        $this->assertEquals(1, count($this->emailProvider->memoryStorage[Email::class]));
    }
}