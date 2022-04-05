<?php

namespace Neoan\Framework\Foundation;

use Dotenv\Dotenv;
use Neoan\Framework\Container\Container;
use Psr\Log\LoggerInterface;

class Core extends Container
{
    /**
     * The Neoan framework version
     *
     * @var string
     */
    const VERSION = '4.0.9';

    /**
     * The base path for the Neoan installation
     *
     * @var string
     */
    protected string $basePath;

    /**
     * Create a new Neoan Foundation Core instance.
     *
     * @param  string|null  $basePath
     */
    public function __construct(?string $basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }

        self::setInstance($this);

        $this->loadEnvironmentVariables();

        $this->registerManagerContainerSingletons();
    }

    /**
     * Set the base path for the application.
     *
     * @param  string  $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        return $this;
    }

    /**
     * Get the base path of the Neoan installation.
     *
     * @param  string  $path
     * @return string
     */
    public function basePath(string $path = '')
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . ltrim($path, '\/') : $path);
    }

    /**
     * Load the environment variables from the .env file
     */
    protected function loadEnvironmentVariables() : void
    {
        $dotenv = Dotenv::createImmutable($this->basePath());
        $dotenv->safeLoad();
    }

    /**
     * Register the framework managers as container singletons
     */
    protected function registerManagerContainerSingletons()
    {
        $this->singleton('config', \Neoan\Framework\Config\Manager::class);

        $this->singleton(LoggerInterface::class, \Neoan\Framework\Log\Manager::class);
    }
}