<?php

namespace App\Jobs\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Job
 * @property int $id
 * @property int $parent_id
 * @property int $job_id
 * @property string $payload
 * @property string $progress
 * @property string $log
 * @property string $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $result
 */
class Job extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'job_models';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['parent_id', 'job_id', 'payload', 'progress', 'log', 'status', 'result'];
}
