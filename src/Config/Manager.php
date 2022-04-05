<?php

namespace Neoan\Framework\Config;

use Illuminate\Config\Repository as BaseManager;
use Neoan\Framework\Container\Container;

class Manager extends BaseManager
{
    /**
     * Manager constructor
     *
     * @param  array  $items
     */
    public function __construct(array $items = [])
    {
        foreach (glob(Container::getInstance()->basePath('config/*.php')) as $config) {
            $items[basename($config, '.php')] = require_once $config;
        }

        parent::__construct($items);
    }
}