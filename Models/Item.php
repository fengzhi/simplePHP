<?php

namespace Simple\Models;

class Item extends Model {

    protected $rules;

    public $tableName = "item";

    /**
     * @return array
     */
    public function getAttributes() {
        return [
            "id",
            "itemName",
            "itemPrice"
        ];
    }

    /**
     * @return string
     */
    private function createTable() {
        return "CREATE TABLE `user`.`item` ( `id` INT NOT NULL AUTO_INCREMENT , `itemName` VARCHAR(50) NOT NULL , `itemPrice` INT NOT NULL , UNIQUE `id` (`id`)) ENGINE = InnoDB;";
    }
}