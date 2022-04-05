<?php

use Neoan\Framework\Container\Container;
use Neoan\Framework\Foundation\Core;

it('can instantiate the core', function () {
    expect(new Core())
        ->toBeInstanceOf(Container::class);
});