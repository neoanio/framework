<?php

namespace Neoan\Framework\Database;

interface Database
{
    function connect(array $arguments = []);

    function easy(string $selectString, ?array $conditions = [], ?array $callFunctions = []);

    function smart(string $tableOrString, ?array $conditions = null, ?array $callFunctions = null);
}