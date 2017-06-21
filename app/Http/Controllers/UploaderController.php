<?php

namespace App\Http\Controllers;

use App\Uploader\ChunkingUploaderInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UploaderController
 * @package App\Http\Controllers
 */
class UploaderController extends Controller
{
    /**
     * Handle file uploading options.
     *
     * @return \Illuminate\Http\Response
     */
    public function preflight()
    {
        return (new Response())
            ->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'POST, DELETE',
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => 'Content-Type, X-Requested-With, Cache-Control',
            ]);
    }

    /**
     * Handle file uploading.
     *
     * @param Request $request
     * @param ChunkingUploaderInterface $uploader
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request, ChunkingUploaderInterface $uploader)
    {
        return response()->json($uploader->handleUpload($request))->withHeaders([
            'Access-Control-Allow-Origin' => '*',
            'Content-Type' => 'text/plain'
        ]);
    }

    /**
     * Combine uploaded chunks.
     *
     * @param Request $request
     * @param ChunkingUploaderInterface $uploader
     * @return \Illuminate\Http\Response
     */
    public function combine(Request $request, ChunkingUploaderInterface $uploader)
    {
        return response()->json($uploader->combineChunks($request))->withHeaders([
            'Access-Control-Allow-Origin' => '*',
            'Content-Type' => 'text/plain'
        ]);
    }

    /**
     * Delete file.
     *
     * @param Request $request
     * @param ChunkingUploaderInterface $uploader
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, ChunkingUploaderInterface $uploader)
    {
        return response()->json($uploader->handleDelete($request))->withHeaders([
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
}
