<?php

namespace App\Slicing;

use App\Slicing\Exceptions\VideoSlicingException;
use App\Slicing\FFMpeg\FFMpegVideoSlicingCommandBuilder;
use Exception;
use Symfony\Component\Process\Process;

/**
 * Class VideoSlicingService
 * @package App\Slicing
 */
class VideoSlicingService
{
    /**
     * @param string $input
     * @param float $from
     * @param float $duration
     * @param string $output
     */
    public function slice($input, $from, $duration, $output)
    {
        $command = $this->getCommandBuilder()
            ->input($input)
            ->startFrom($from)
            ->duration($duration)
            ->output($output)
            ->build();

        $process = new Process($command);

        try {
            $process->run();
        } catch (Exception $e) {
            $this->executionFailure($process->getCommandLine(), $e);
        }

        if (!$process->isSuccessful()) {
            $this->executionFailure($process->getCommandLine());
        }
    }

    /**
     * @return FFMpegVideoSlicingCommandBuilder
     */
    protected function getCommandBuilder()
    {
        return new FFMpegVideoSlicingCommandBuilder(env('FFMPEG_BINARIES', ''));
    }

    /**
     * @param string $command
     * @param Exception|null $e
     * @throws VideoSlicingException
     */
    protected function executionFailure($command, Exception $e = null)
    {
        throw new VideoSlicingException('Command execution failure: ' . $command, $e ? $e->getCode() : null, $e ?: null);
    }
}