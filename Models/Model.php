<?php

namespace Simple\Models;

use Simple\Vendor\Database;

Abstract class Model {

    protected  $db;

    /**
     * Model constructor.
     * @param Database $database
     */
    public function __construct(Database $database) {
        $this->db = $database;
    }

    /**
     * @return Database
     */
    public function getDatabase() {
        return $this->db;
    }

    abstract public function getAttributes();

    /**
     * @param $method
     * @param $params
     */
    public function __call($method,$params) {
        if(method_exists($this->db,$method)) {
            return $this->db->$method($params[0]);
        }else{
            return false;
        }
    }
}