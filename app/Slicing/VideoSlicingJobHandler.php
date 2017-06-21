<?php

namespace App\Slicing;

use App\Jobs\SlicingJob;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class VideoSlicingJobHandler
 * @package App\Slicing
 */
class VideoSlicingJobHandler
{
    /**
     * @var VideoSlicingService
     */
    protected $videoSlicingService;

    /**
     * VideoSlicingJobHandler constructor.
     * @param VideoSlicingService $videoSlicingService
     */
    public function __construct(VideoSlicingService $videoSlicingService)
    {
        $this->videoSlicingService = $videoSlicingService;
    }

    /**
     * @param SlicingJob $job
     * @throws \Exception
     */
    public function handleSlicingJob(SlicingJob $job)
    {
        try {
            $job->onStarted();

            foreach ($job->getSlices() as $slice) {
                $this->videoSlicingService->slice('/home/ubuntu/Downloads/oceans.mp4', $slice['offset'], $slice['duration'], '/home/ubuntu/Downloads/oceans-' . $slice['id'] . '.mp4');
            }

            $job->onCompleted();
        } catch (Exception $e) {
            $job->onFailed();
            throw $e;
        }
    }
}
