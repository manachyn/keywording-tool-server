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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(Request $request, $id)
    {
        $slices = $request->input('slices');

        if (!$slices) {
            abort(4001, 'Slices parameter is empty');
        }

        $job = new SlicingJob($slices);
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
    public function getStatus(Request $request, $jobId) {

        $job = SlicingJobModel::find($jobId);

        return response()->json($job);
    }
}
