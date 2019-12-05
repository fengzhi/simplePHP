<?php

namespace Simple\Models;

use Simple\Vendor\Database;

class User extends Model {

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

    public function __construct(Database $database)
    {
        foreach($this->getAttributes() as $attribute) {
            $this->$attribute = $attribute;
        }
        parent::__construct($database);
    }




}