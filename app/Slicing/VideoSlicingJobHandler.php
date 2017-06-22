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
            $video = $job->getVideo();
            $uploadsDir = env('UPLOADS_DIR', '/tmp');
            $outputDir = $uploadsDir . DIRECTORY_SEPARATOR . 'slices';
            if (!file_exists($outputDir)) {
                mkdir($outputDir, 0777, true);
            }
            $result = [];
            foreach ($job->getSlices() as $slice) {
                $input = $uploadsDir . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $video['uuid'] . DIRECTORY_SEPARATOR . $video['name'];
                $output = $outputDir . DIRECTORY_SEPARATOR . pathinfo($video['name'], PATHINFO_FILENAME) . '-' . $slice['id'] . '.' . pathinfo($video['name'], PATHINFO_EXTENSION);
                $this->videoSlicingService->slice($input, $slice['offset'], $slice['duration'], $output);
                $result[] = env('STORAGE_URL') . str_replace(app()->basePath('public'), '', $output);
            }
            $job->setResult($result);
            $job->onCompleted();
        } catch (Exception $e) {
            $job->onFailed();
            throw $e;
        }
    }
}
