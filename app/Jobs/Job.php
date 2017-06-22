<?php

namespace App\Jobs;

use App\Jobs\Interfaces\JobInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class Job
 * @package App\Jobs
 */
abstract class Job implements ShouldQueue, JobInterface
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "queueOn" and "delay" queue helper methods.
    |
    */

    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $log;

    /**
     * @var mixed
     */
    protected $result;

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * {@inheritdoc}
     */
    public function setLog($log)
    {
        $this->log = $log;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDispatch()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function afterDispatch()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function onStarted()
    {
        $this->setStatus(JobStatus::STATUS_IN_PROGRESS);
        $this->setLog('');
    }

    /**
     * {@inheritdoc}
     */
    public function onCompleted()
    {
        $this->setStatus(JobStatus::STATUS_COMPLETED);
    }

    /**
     * {@inheritdoc}
     */
    public function onFailed(\Throwable $exception = null)
    {
        $this->setStatus(JobStatus::STATUS_FAILED);
        if ($exception) {
            $this->setLog($exception->getMessage());
        }
    }
}
