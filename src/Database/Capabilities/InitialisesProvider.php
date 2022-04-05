<?php

namespace Neoan\Framework\Database\Capabilities;

use Neoan\Framework\Database\Database;

trait InitialisesProvider
{
    /**
     * The database provider for the model.
     *
     * @var \Neoan\Framework\Database\Database|null
     */
    protected static ?Database $db = null;

    /**
     * Initialise the model database provider.
     *
     * @param  array  $providers
     */
    public static function init(array $providers)
    {
        foreach ($providers as $provider) {
            if ($provider instanceof Database) {
                self::$db = $provider;
            }
        }
    }
}