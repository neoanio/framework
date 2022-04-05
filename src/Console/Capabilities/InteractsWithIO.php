<?php

namespace Neoan\Framework\Console\Capabilities;

use Closure;
use Illuminate\Console\OutputStyle;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;
use Neoan\Framework\Console\Output;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

trait InteractsWithIO
{
    /**
     * The input interface implementation.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected InputInterface $input;

    /**
     * The output interface implementation.
     *
     * @var \Neoan\Framework\Console\Output
     */
    protected Output $output;

    /**
     * The default verbosity of output commands.
     *
     * @var int
     */
    protected int $verbosity = OutputInterface::VERBOSITY_NORMAL;

    /**
     * The mapping between human readable verbosity levels and Symfony's OutputInterface.
     *
     * @var array
     */
    protected array $verbosityMap = [
        'v'      => OutputInterface::VERBOSITY_VERBOSE,
        'vv'     => OutputInterface::VERBOSITY_VERY_VERBOSE,
        'vvv'    => OutputInterface::VERBOSITY_DEBUG,
        'quiet'  => OutputInterface::VERBOSITY_QUIET,
        'normal' => OutputInterface::VERBOSITY_NORMAL,
    ];

    /**
     * Determine if the given argument is present.
     *
     * @param  int|string  $name
     * @return bool
     */
    public function hasArgument(int|string $name) : bool
    {
        return $this->input->hasArgument($name);
    }

    /**
     * Get the value of a command argument.
     *
     * @param  string|null  $key
     * @return string|array|null
     */
    public function argument(string $key = null) : array|string|null
    {
        if (is_null($key)) {
            return $this->input->getArguments();
        }

        return $this->input->getArgument($key);
    }

    /**
     * Get all the arguments passed to the command.
     *
     * @return array
     */
    public function arguments() : array
    {
        return $this->argument();
    }

    /**
     * Determine if the given option is present.
     *
     * @param  string  $name
     * @return bool
     */
    public function hasOption(string $name) : bool
    {
        return $this->input->hasOption($name);
    }

    /**
     * Get the value of a command option.
     *
     * @param  string|null  $key
     * @return string|array|bool|null
     */
    public function option(string $key = null) : bool|array|string|null
    {
        if (is_null($key)) {
            return $this->input->getOptions();
        }

        return $this->input->getOption($key);
    }

    /**
     * Get all the options passed to the command.
     *
     * @return array
     */
    public function options() : array
    {
        return $this->option();
    }

    /**
     * Confirm a question with the user.
     *
     * @param  string  $question
     * @param  bool  $default
     * @return bool
     */
    public function confirm(string $question, bool $default = false) : bool
    {
        return $this->output->confirm($question, $default);
    }

    /**
     * Prompt the user for input.
     *
     * @param  string  $question
     * @param  string|null  $default
     * @return mixed
     */
    public function ask(string $question, string $default = null) : mixed
    {
        return $this->output->ask($question, $default);
    }

    /**
     * Prompt the user for input with autocompletion.
     *
     * @param  string  $question
     * @param  callable|array  $choices
     * @param  string|null  $default
     * @return mixed
     */
    public function anticipate(string $question, callable|array $choices, string $default = null) : mixed
    {
        return $this->askWithCompletion($question, $choices, $default);
    }

    /**
     * Prompt the user for input with autocompletion.
     *
     * @param  string  $question
     * @param  callable|array  $choices
     * @param  string|null  $default
     * @return mixed
     */
    public function askWithCompletion(string $question, callable|array $choices, string $default = null) : mixed
    {
        $question = new Question($question, $default);

        is_callable($choices)
            ? $question->setAutocompleterCallback($choices)
            : $question->setAutocompleterValues($choices);

        return $this->output->askQuestion($question);
    }

    /**
     * Prompt the user for input but hide the answer from the console.
     *
     * @param  string  $question
     * @param  bool  $fallback
     * @return mixed
     */
    public function secret(string $question, bool $fallback = true) : mixed
    {
        $question = new Question($question);

        $question->setHidden(true)->setHiddenFallback($fallback);

        return $this->output->askQuestion($question);
    }

    /**
     * Give the user a single choice from an array of answers.
     *
     * @param  string  $question
     * @param  array  $choices
     * @param  string|null  $default
     * @param  mixed|null  $attempts
     * @param  bool  $multiple
     * @return string|array
     */
    public function choice(string $question, array $choices, string $default = null, mixed $attempts = null, bool $multiple) : array|string
    {
        $question = new ChoiceQuestion($question, $choices, $default);

        $question->setMaxAttempts($attempts)->setMultiselect($multiple);

        return $this->output->askQuestion($question);
    }

    /**
     * Format input to textual table.
     *
     * @param  array  $headers
     * @param  array|\Illuminate\Contracts\Support\Arrayable  $rows
     * @param  string  $tableStyle
     * @param  array  $columnStyles
     * @return void
     */
    public function table(array $headers, array|Arrayable $rows, string $tableStyle = 'default', array $columnStyles = [])
    {
        $table = new Table($this->output);

        if ($rows instanceof Arrayable) {
            $rows = $rows->toArray();
        }

        $table->setHeaders((array) $headers)->setRows($rows)->setStyle($tableStyle);

        foreach ($columnStyles as $columnIndex => $columnStyle) {
            $table->setColumnStyle($columnIndex, $columnStyle);
        }

        $table->render();
    }

    /**
     * Execute a given callback while advancing a progress bar.
     *
     * @param  iterable|int  $totalSteps
     * @param  \Closure  $callback
     * @return mixed|void
     */
    public function withProgressBar(iterable|int $totalSteps, Closure $callback)
    {
        $bar = $this->output->createProgressBar(
            is_iterable($totalSteps) ? count($totalSteps) : $totalSteps
        );

        $bar->start();

        if (is_iterable($totalSteps)) {
            foreach ($totalSteps as $value) {
                $callback($value, $bar);

                $bar->advance();
            }
        } else {
            $callback($bar);
        }

        $bar->finish();

        if (is_iterable($totalSteps)) {
            return $totalSteps;
        }
    }

    /**
     * Write a string as information output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function info(string $string, int|string $verbosity = null)
    {
        $this->line($string, 'info', $verbosity);
    }

    /**
     * Write a string as standard output.
     *
     * @param  string  $string
     * @param  string|null  $style
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function line(string $string, string $style = null, int|string $verbosity = null)
    {
        $styled = $style ? "<$style>$string</$style>" : $string;

        $this->output->writeln($styled, $this->parseVerbosity($verbosity));
    }

    /**
     * Write a string as comment output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function comment(string $string, int|string $verbosity = null)
    {
        $this->line($string, 'comment', $verbosity);
    }

    /**
     * Write a string as question output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function question(string $string, int|string $verbosity = null)
    {
        $this->line($string, 'question', $verbosity);
    }

    /**
     * Write a string as error output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function error(string $string, int|string $verbosity = null)
    {
        $this->line($string, 'error', $verbosity);
    }

    /**
     * Write a string as warning output.
     *
     * @param  string  $string
     * @param  int|string|null  $verbosity
     * @return void
     */
    public function warn(string $string, int|string $verbosity = null)
    {
        if (!$this->output->getFormatter()->hasStyle('warning')) {
            $style = new OutputFormatterStyle('yellow');

            $this->output->getFormatter()->setStyle('warning', $style);
        }

        $this->line($string, 'warning', $verbosity);
    }

    /**
     * Write a string in an alert box.
     *
     * @param  string  $string
     * @return void
     */
    public function alert(string $string)
    {
        $length = Str::length(strip_tags($string)) + 12;

        $this->comment(str_repeat('*', $length));
        $this->comment('*     ' . $string . '     *');
        $this->comment(str_repeat('*', $length));

        $this->newLine();
    }

    /**
     * Write a blank line.
     *
     * @param  int  $count
     * @return $this
     */
    public function newLine(int $count = 1)
    {
        $this->output->newLine($count);

        return $this;
    }

    /**
     * Set the input interface implementation.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @return void
     */
    public function setInput(InputInterface $input)
    {
        $this->input = $input;
    }

    /**
     * Get the output implementation.
     *
     * @return \Illuminate\Console\OutputStyle
     */
    public function getOutput() : OutputStyle
    {
        return $this->output;
    }

    /**
     * Set the output interface implementation.
     *
     * @param  \Neoan\Framework\Console\Output  $output
     */
    public function setOutput(Output $output)
    {
        $this->output = $output;
    }

    /**
     * Set the verbosity level.
     *
     * @param  int|string  $level
     * @return void
     */
    protected function setVerbosity(int|string $level)
    {
        $this->verbosity = $this->parseVerbosity($level);
    }

    /**
     * Get the verbosity level in terms of Symfony's OutputInterface level.
     *
     * @param  int|string|null  $level
     * @return int
     */
    protected function parseVerbosity(int|string $level = null)
    {
        if (isset($this->verbosityMap[$level])) {
            $level = $this->verbosityMap[$level];
        } elseif (!is_int($level)) {
            $level = $this->verbosity;
        }

        return $level;
    }
}