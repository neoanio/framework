<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('test', 'Test the application with coverage')]
class TestCommand extends Command
{
    public function __invoke()
    {
        dump(config());

        // ...
    }
}