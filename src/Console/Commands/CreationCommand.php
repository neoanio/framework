<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('new', 'Create a file automatically')]
class CreationCommand extends Command
{
    public function __invoke()
    {
        // ...
    }
}