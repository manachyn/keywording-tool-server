<?php

namespace App\Jobs;

/**
 * Class JobStatus
 * @package App\Jobs
 */
final class JobStatus
{
    const STATUS_NEW = 'new';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_QUEUED = 'queued';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
}
