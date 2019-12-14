<?php

namespace Simple\Models;

class User extends Model {

    protected $rules;

    public $tableName="user";

    /**
     * @return array
     */
    public function getAttributes() {
        return [
            "id",
            "username",
            "passwd"
        ];
    }

}