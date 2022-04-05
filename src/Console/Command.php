<?php

namespace Neoan\Framework\Console;

use Neoan\Framework\Console\Capabilities\InteractsWithIO;
use Neoan\Framework\Container\Container;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
    use InteractsWithIO;

    /**
     * Run the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output) : int
    {
        $this->setInput($input);
        $this->setOutput($output);

        return parent::run($this->input, $this->output);
    }

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return (int) Container::getInstance()->call($this);
    }
}