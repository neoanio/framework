<?php

namespace Neoan\Framework\Console\Commands;

use Neoan\Framework\Console\Command;
use Neoan\Framework\Foundation\Application;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand('serve', 'Serve the application locally')]
class ServeCommand extends Command
{
    public function __invoke()
    {
        exec('cd public && php -S localhost:8090 index.php');
    }
}