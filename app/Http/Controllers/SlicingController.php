<?php

namespace App\Http\Controllers;

use App\Jobs\Models\SlicingJob as SlicingJobModel;
use App\Jobs\SlicingJob;
use Illuminate\Http\Request;

/**
 * Class SlicingController
 * @package App\Http\Controllers
 */
class SlicingController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request)
    {
        $this->validate($request, [
            'video' => 'required',
            'slices' => 'required'
        ]);

        $video = $request->input('video');
        $slices = $request->input('slices');

        $job = new SlicingJob($video, $slices);
        $job->onQueue('slicing');

        $job->beforeDispatch();
        dispatch($job);
        $job->afterDispatch();

        return response()->json(['jobId' => $job->getId()]);
    }

    /**
     * @param Request $request
     * @param int $jobId
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request, $jobId) {

        $job = SlicingJobModel::find($jobId);
        $job->result = json_decode($job->result, true);

        return response()->json($job);
    }
}
