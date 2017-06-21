<?php

namespace App\Jobs\Interfaces;

/**
 * Interface JobInterface
 * @package App\Jobs\Interfaces
 */
interface JobInterface
{
    /**
     * Get job status.
     *
     * @return string
     */
    public function getStatus();

    /**
     * Set job status.
     *
     * @param string $status
     */
    public function setStatus($status);

    /**
     * Get job log.
     *
     * @return string
     */
    public function getLog();

    /**
     * Get job log.
     *
     * @param string $log
     */
    public function setLog($log);

    /**
     * Executed before job dispatch.
     */
    public function beforeDispatch();

    /**
     * Executed after job was dispatched.
     */
    public function afterDispatch();

    /**
     * Executed before a queued job is started
     */
    public function onStarted();

    /**
     * Executed when a queued job executes successfully.
     */
    public function onCompleted();

    /**
     * Executed when a queued job was failed.
     * @param \Throwable $exception
     */
    public function onFailed(\Throwable $exception = null);
}
