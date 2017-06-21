<?php

namespace App\Uploader;

use Illuminate\Http\Request;

/**
 * Interface ChunkingUploaderInterface
 * @package App\Uploader
 */
interface ChunkingUploaderInterface extends UploaderInterface
{
    /**
     * Combine uploaded chunks.
     *
     * @param Request $request
     * @return array
     */
    public function combineChunks(Request $request);
}
