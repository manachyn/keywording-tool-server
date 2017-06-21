<?php

namespace App\Slicing\FFMpeg;

use App\Slicing\VideoSlicingCommandBuilder;

/**
 * Class FFMpegVideoSlicingCommandBuilder
 * @package App\Slicing\FFMpeg
 */
class FFMpegVideoSlicingCommandBuilder extends VideoSlicingCommandBuilder
{
    /**
     * @var string
     */
    protected $ffmpegBinaries;

    /**
     * FFMpegVideoSlicingCommandBuilder constructor.
     * @param $ffmpegBinaries
     */
    public function __construct($ffmpegBinaries)
    {
        $this->ffmpegBinaries = $ffmpegBinaries;
    }

    /**
     * {@inheritDoc}
     */
    public function build()
    {
        $parts = [
            $this->ffmpegBinaries,
            '-ss',
            $this->startTime,
            '-i',
            $this->input,
            '-t',
            $this->duration,
            '-c',
            'copy',
            $this->output
        ];

        return implode(' ', $parts);
    }
}