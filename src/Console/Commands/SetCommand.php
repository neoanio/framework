<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('set', 'Set a default variable')]
class SetCommand extends Command
{
    public function __invoke()
    {
        // ...
    }
}