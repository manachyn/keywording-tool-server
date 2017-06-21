<?php

namespace App\Jobs;

use App\Jobs\Models\Job as JobModel;
use App\Jobs\Models\SlicingJob as SlicingJobModel;
use App\Slicing\VideoSlicingJobHandler;
use Exception;
use Illuminate\Queue\SerializesModels;
use ReflectionClass;

/**
 * Class SlicingJob
 * @package App\Jobs
 */
class SlicingJob extends Job
{
    use SerializesModels;

    /**
     * @var JobModel
     */
    protected $model;

    /**
     * @var array
     */
    protected $slices;

    /**
     * SlicingJob constructor.
     * @param array $slices
     */
    public function __construct(array $slices)
    {
        $this->slices = $slices;
    }

    /**
     * Execute the job.
     *
     * @param VideoSlicingJobHandler $handler
     * @return void
     */
    public function handle(VideoSlicingJobHandler $handler)
    {
        $handler->handleSlicingJob($this);
    }

    /**
     * @return array
     */
    public function getSlices()
    {
        return $this->slices;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->model->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        parent::setStatus($status);
        $this->model->status = $status;
        $this->model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function setLog($log)
    {
        parent::setLog($log);
        $this->model->log = $log;
        $this->model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeDispatch()
    {
        parent::beforeDispatch();

        $this->model = SlicingJobModel::create([
            'payload' => serialize(clone $this),
            'status' => JobStatus::STATUS_QUEUED
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function __wakeup()
    {
        foreach ((new ReflectionClass($this))->getProperties() as $property) {
            try {
                $value = $this->getRestoredPropertyValue($this->getPropertyValue($property));
                $property->setValue($this, $value);
            } catch (Exception $exception) {

            }
        }
    }
}