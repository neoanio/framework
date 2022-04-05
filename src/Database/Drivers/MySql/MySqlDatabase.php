<?php

namespace Neoan\Framework\Database\Drivers\MySql;

use Exception;
use Neoan\Framework\Database\Database;
use Neoan3\Apps\DbException;
use Neoan3\Apps\DbOOP;

class MySqlDatabase extends DbOOP implements Database
{
    /**
     * @param  array  $arguments
     * @throws DbException
     */
    public function connect(array $arguments = [])
    {
        $this->setEnvironment($arguments);
    }

    /**
     * @param  string  $sql
     * @param  array|null  $conditions
     * @param  array|null  $extra
     * @return mixed
     * @throws \Exception
     */
    public function pure(string $sql, ?array $conditions = null, ?array $extra = null)
    {
        try {
            return $this->smart('>' . $sql, $conditions, $extra);
        } catch (DbException $e) {
            throw new Exception($e->getMessage());
        }

    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getNextId()
    {
        try {
            return $this->smart('>SELECT UPPER(REPLACE(UUID(),"-","")) as id')[0]['id'];
        } catch (DbException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $selectString
     * @param  array  $conditions
     * @param  array  $callFunctions
     * @return array|int|mixed|string
     * @throws Exception
     */
    public function easy($selectString, $conditions = [], $callFunctions = [])
    {
        try {
            return parent::easy($selectString, $conditions, $callFunctions);
        } catch (DbException $e) {
            throw new Exception($e->getMessage());
        }
    }
}