<?php

namespace App\Slicing;

/**
 * Class VideoSlicingCommandBuilder
 * @package App\Slicing
 */
abstract class VideoSlicingCommandBuilder
{
    /**
     * @var string
     */
    protected $input;

    /**
     * @var string
     */
    protected $output;

    /**
     * @var float
     */
    protected $startTime;

    /**
     * @var float
     */
    protected $duration;

    /**
     * @param $path
     * @return $this
     */
    public function input($path)
    {
        $this->input = $path;

        return $this;
    }

    public function output($path)
    {
        $this->output = $path;

        return $this;
    }

    /**
     * @param float $second
     * @return $this
     */
    public function startFrom($second)
    {
        $this->startTime = $second;

        return $this;
    }

    /**
     * @param float $seconds
     * @return $this
     */
    public function duration($seconds)
    {
        $this->duration = $seconds;

        return $this;
    }

    /**
     * @return string
     */
    abstract public function build();
}