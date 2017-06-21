<?php

namespace App\Uploader;

use App\Uploader\Exceptions\UploadException;
use App\Uploader\FineUploader\UploadHandler;
use Illuminate\Http\Request;

/**
 * Class Uploader
 * @package App\Uploader
 */
class Uploader implements ChunkingUploaderInterface
{
    /**
     * @var string
     */
    protected $chunksDirectory;

    /**
     * @var string
     */
    protected $filesDirectory;

    /**
     * @var UploadHandler
     */
    protected $uploadHandler;

    /**
     * Uploader constructor.
     * @param string $tempDirectory
     */
    public function __construct($tempDirectory = '/tmp')
    {
        $this->chunksDirectory = $tempDirectory . DIRECTORY_SEPARATOR . 'chunks';
        $this->filesDirectory = $tempDirectory . DIRECTORY_SEPARATOR . 'files';
        $this->ensureDirectoriesExist();
    }

    /**
     * {@inheritdoc}
     */
    public function handleUpload(Request $request)
    {
        $uploadHandler = $this->getUploadHandler();
        $result = $uploadHandler->handleUpload($this->filesDirectory);
        if (isset($result['error'])) {
            throw new UploadException($result['error']);
        }
        if ($uploadName = $uploadHandler->getUploadName()) {
            $result['name'] = $uploadName;
            $path = implode(DIRECTORY_SEPARATOR, [
                $this->filesDirectory,
                $result['uuid'],
                $result['name']
            ]);
            $result['url'] = app('url')->asset(str_replace(app()->basePath('public'), '', $path));
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function combineChunks(Request $request)
    {
        $uploadHandler = $this->getUploadHandler();
        $result = $uploadHandler->combineChunks($this->filesDirectory);
        if ($uploadName = $uploadHandler->getUploadName()) {
            $result['name'] = $uploadName;
            $path = implode(DIRECTORY_SEPARATOR, [
                $this->filesDirectory,
                $result['uuid'],
                $result['name']
            ]);
            $result['url'] = app('url')->asset(str_replace(app()->basePath('public'), '', $path));
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function handleDelete(Request $request)
    {
        $uploadHandler = $this->getUploadHandler();

        return $uploadHandler->handleDelete($this->filesDirectory);
    }

    /**
     * @return UploadHandler
     */
    protected function getUploadHandler()
    {
        if (!$this->uploadHandler) {
            $this->uploadHandler = new UploadHandler();
            $this->uploadHandler->chunksFolder = $this->chunksDirectory;
        }

        return $this->uploadHandler;
    }

    /**
     * Create directories.
     */
    protected function ensureDirectoriesExist()
    {
        if (!file_exists($this->chunksDirectory)) {
            @mkdir($this->chunksDirectory, 0777, true);
        }
        if (!file_exists($this->filesDirectory)) {
            @mkdir($this->filesDirectory, 0777, true);
        }
    }
}
