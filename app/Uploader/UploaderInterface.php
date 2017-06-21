<?php

namespace App\Uploader;

use App\Uploader\Exceptions\UploadException;
use Illuminate\Http\Request;

/**
 * Interface UploaderInterface
 * @package App\Uploader
 */
interface UploaderInterface
{
    /**
     * @param Request $request
     * @return array
     * @throws UploadException
     */
    public function handleUpload(Request $request);

    /**
     * @param Request $request
     * @return array
     * @throws UploadException
     */
    public function handleDelete(Request $request);
}
