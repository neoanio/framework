<?php

namespace Neoan\Framework\Log;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Stringable;

class Manager implements LoggerInterface
{
    /**
     * The Logger instance.
     *
     * @var \Monolog\Logger
     */
    private Logger $logger;

    /**
     * Create the Neoan Log Manager instance.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->logger = new Logger('neoan');

        $handler = new StreamHandler(
            base_path(config('logging.path', 'logs/neoan.log')),
            Logger::DEBUG
        );

        // Now add some handlers
        $this->logger->pushHandler($handler);
    }

    /**
     * Log an emergency message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function emergency(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function alert(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * og a critical message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function critical(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function error(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function warning(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function notice(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function info(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function debug(Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a message to the logs.
     *
     * @param  mixed  $level
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @param  array  $context
     */
    public function log($level, Arrayable|Jsonable|Stringable|array|string $message, array $context = []) : void
    {
        $this->writeLog($level, $message, $context);
    }

    /**
     * Write a message to the log.
     *
     * @param  string  $level
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string
     * @param  array  $context
     */
    protected function writeLog($level, Arrayable|Jsonable|Stringable|array|string $message, array $context) : void
    {
        $this->logger->{$level}(
            $this->formatMessage($message),
            $context
        );
    }

    /**
     * Format the parameters for the logger.
     *
     * @param  \Illuminate\Contracts\Support\Arrayable|\Illuminate\Contracts\Support\Jsonable|\Stringable|array|string  $message
     * @return string
     */
    protected function formatMessage($message) : string
    {
        if (is_array($message)) {
            return var_export($message, true);
        }

        if ($message instanceof Jsonable) {
            return $message->toJson();
        }

        if ($message instanceof Arrayable) {
            return var_export($message->toArray(), true);
        }

        return (string) $message;
    }
}