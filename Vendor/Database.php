<?php

namespace Simple\Vendor;

use Exception;
use Simple\Vendor\Medoo;
use PDO;

/**
 * Class Database.
 */
class Database extends Medoo
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var PDO
     */
    public $pdo;

    /**
     * Database constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = null)
    {
        $this->config = $options;

        parent::__construct($this->config);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
    }

    /**
     * reconnect database.
     */
    public function reconnect()
    {
        $this->__construct($this->config);
    }

    /**
     * @param $query
     *
     * @return bool|\PDOStatement
     */
    public function query($query)
    {
        try {
            return parent::query($query);
        } catch (Exception $e) {
            $this->reconnect();
            return parent::query($query);
        }
    }

    /**
     * @param $query
     *
     * @return bool|int
     *
     * @throws \ErrorException
     */
    public function exec($query)
    {
        try {
            return parent::exec($query);
        } catch (Exception $e) {
            $this->reconnect();

            return parent::exec($query);
        }
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function findOne($sql) {
        $query = $this->query($sql);
        return $query->fetch($query);
    }

    /**
     * @param $sql
     * @return array
     */
    public function findAll($sql) {
        $query = $this->query($sql);
        return $query->fetchAll($query);
    }
    
    /**
     * @param $table
     * @param $join
     * @param null $where
     *
     * @return bool
     */
    public function has($table, $join, $where = null)
    {
        $column = null;

        $query = $this->query('SELECT EXISTS('.$this->selectContext($table, $join, $column, $where, 1).')');

        if ($query && 1 === intval($query->fetchColumn())) {
            return true;
        }

        return false;
    }
}
