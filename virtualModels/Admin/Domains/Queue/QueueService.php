<?php

namespace app\virtualModels\Admin\Domains\Queue;

class QueueService
{
    /**
     * @param QueueJobInterface $job
     * @param array $args
     * @throws \Exception
     */
    public function pushJob(QueueJobInterface $job, $args = [])
    {
        QueueVm::create([
            'job_class' => get_class($job),
            'arguments' => json_encode($args, JSON_UNESCAPED_UNICODE),
            'created_at' => date('Y-m-d H:i:s'),
        ])->save();
    }

    /**
     * @param QueueVm $queueVm
     * @return mixed
     */
    public function runJob(QueueVm $queueVm)
    {
        $jobClass = $queueVm->job_class;

        try {
            $args = json_decode($queueVm->arguments, true);
        } catch (\Exception $exception) {
            $args = [];
        }

        /** @var QueueJobInterface $job */
        $job = new $jobClass();

        return $job->run($args);
    }

    /**
     * @throws \Exception
     */
    public function popAndRunAllJobs()
    {
        /** @var QueueVm[] $queues */
        $queues = QueueVm::many([
            'where' => [['all']],
            'orderBy' => ['created_at' => SORT_ASC],
        ]);

        foreach ($queues as $queue) {
            $this->runJob($queue);
        }
    }
}