<?php

namespace Neoan\Framework\Console;

use Neoan\Framework\Error\ExceptionHandler;
use Neoan\Framework\Foundation\Core;
use Symfony\Component\Console\Application as BaseApplication;
use Throwable;

class Application extends BaseApplication
{
    private string $name = 'Neoan CLI';

    /**
     * Create a new Neoan Http Core instance.
     *
     * @param  \Neoan\Framework\Error\ExceptionHandler  $exceptionHandler
     */
    public function __construct(
        private ExceptionHandler $exceptionHandler,
    ) {
        parent::__construct($this->name, Core::VERSION);
    }

    /**
     * Create a new Neoan Console Core instance.
     *
     * @param  \Neoan\Framework\Console\Input  $input
     * @param  \Neoan\Framework\Console\Output  $output
     * @return int
     */
    public function handle(Input $input, Output $output) : int
    {
        try {

            return $this->sendInputToCommandLine($input, $output);

        } catch (Throwable $exception) {

            $this->reportException($exception);

            $this->renderException($output, $exception);

            return Command::FAILURE;
        }
    }

    protected function sendInputToCommandLine(Input $input, Output $output) : int
    {
        $commands = [
            \Neoan\Framework\Console\Commands\PackageCommand::class,
            \Neoan\Framework\Console\Commands\CreationCommand::class,
            \Neoan\Framework\Console\Commands\TestCommand::class,
            \Neoan\Framework\Console\Commands\SetCommand::class,
            \Neoan\Framework\Console\Commands\MigrateCommand::class,
            \Neoan\Framework\Console\Commands\CredentialsCommand::class,
            \Neoan\Framework\Console\Commands\ServeCommand::class,
        ];

        foreach ($commands as $command) {
            $this->add(Core::getInstance()->make($command));
        }

        $this->run($input, $output);

        return Command::SUCCESS;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Throwable  $exception
     */
    protected function reportException(Throwable $exception)
    {
        $this->exceptionHandler->report($exception);
    }

    /**
     * Render the given exception.
     *
     * @param  \Neoan\Framework\Console\Output  $output
     * @param  \Throwable  $exception
     * @return mixed
     */
    protected function renderException(Output $output, Throwable $exception)
    {
        return $this->exceptionHandler->renderForConsole($this, $output, $exception);
    }
}