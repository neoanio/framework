<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('add', 'Add a package to your app')]
class PackageCommand extends Command
{
    public function __invoke()
    {
        // ...
    }
}