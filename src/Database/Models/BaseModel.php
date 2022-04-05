<?php

namespace Neoan\Framework\Database\Models;

use Neoan\Framework\Container\Container;
use Neoan\Framework\Database\Capabilities\InitialisesProvider;
use Neoan\Framework\Database\Model;
use Neoan\Framework\Database\Transformers\Transform;

class BaseModel implements Model
{
    use InitialisesProvider;

    /**
     * Get the table name of the model per convention.
     *
     * @return string
     */
    public static function tableName() : string
    {
        return strtolower(basename(str_replace(['\\', 'Model'], ['/', ''], static::class)));
    }

    /**
     * Create a new Transform instance for the model.
     *
     * @return \Neoan\Framework\Database\Transformers\Transform
     */
    public static function transform() : Transform
    {
        return new Transform(self::tableName(), self::$db ?? Container::getInstance()->db);
    }

    /**
     * Forward static calls to the transform instance
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     */
    public static function __callStatic(string $method, array $args)
    {
        $transform = self::transform();

        return $transform->$method(...$args);
    }
}