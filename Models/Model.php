<?php

namespace Simple\Models;

use Simple\Application;
use Simple\Vendor\Database;

Abstract class Model {

    protected $db;

    public $tableName;

    abstract public function getAttributes();

    /**
     * Model constructor.
     * @param Database $database
     */
    public function __construct(Database $database=null) {
        if(empty($database)) {
            $database = Application::$app->get('db');
        }
        foreach($this->getAttributes() as $attribute) {
            $this->$attribute = $attribute;
        }
        $this->db = $database;
    }

    /**
     * @return Database
     */
    public function getDatabase() {
        return $this->db;
    }

    /**
     * @param mixed $columns
     * @param null $where
     * @return array
     */
    public function select($columns, $where=null) {
       return  $this->db->select($this->tableName, $columns, $where);
    }

    /**
     * @param mixed $columns
     * @param null $where
     * @return bool|mixed
     */
    public function get($columns, $where=null) {
        return $this->db->get($this->tableName,$columns,$where);
    }
}