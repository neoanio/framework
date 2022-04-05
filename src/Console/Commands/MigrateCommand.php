<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('migrate', 'Migrate the models up or down')]
class MigrateCommand extends Command
{
    public function __invoke()
    {
        // ...
    }
}