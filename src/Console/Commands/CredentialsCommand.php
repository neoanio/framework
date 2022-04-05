<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('credentials', 'Choose or create a credentials file')]
class CredentialsCommand extends Command
{
    public function __invoke()
    {
        // ...
    }
}