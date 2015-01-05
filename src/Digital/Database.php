<?php

namespace Digital;

/*
 * classe contem somente os metodos que nao estao implementados ainda via doctrine
 * esta classe sera removida em breve
 */

class Database
{
    private $driver;

    public function __construct($driver)
    {

        if (!$driver instanceof \PDO) {
            throw new \PDOException();
        }
        $this->driver = $driver;
        $this->driver->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    }

    public function configureDriver()
    {

        return $this->driver;

    }

    public function select($sql, $unique = false, array $valuesToBind = [])
    {

        $st = $this->driver->prepare($sql);
        if (count($valuesToBind) > 0) {
            foreach ($valuesToBind as $bind => $value) {
                foreach ($value as $k => $v) {
                    $st->bindParam($bind, $k, $v);
                }
            }
        }
        $st->execute();
        return $unique ? $st->fetch(\PDO::FETCH_ASSOC) : $st->fetchAll(\PDO::FETCH_ASSOC);

    }

    function exec($sql)
    {

        $st = $this->driver->exec($sql);
        return $st > 0;

    }

    function nextID($table)
    {

        $st = $this->driver->query("select max(id) from $table");
        $id = $st->fetch(\PDO::FETCH_ASSOC);
        $id = $id['max(id)'] + 1;
        return $id;

    }

}
