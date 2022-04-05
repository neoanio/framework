<?php

namespace Neoan\Framework\Config;

use Illuminate\Config\Repository as BaseManager;

class Manager extends BaseManager
{
    /**
     * Manager constructor
     *
     * @param  array  $items
     */
    public function __construct(array $items = [])
    {
        foreach (glob(base_path('config/*.php')) as $config) {
            $items[basename($config, '.php')] = require_once $config;
        }

        parent::__construct($items);
    }
}