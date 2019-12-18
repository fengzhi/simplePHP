<?php

namespace Simple\Models;

class Order extends Model {

    protected $rules;

    public $tableName="orderList";

    /**
     * @return array
     */
    public function getAttributes() {
        return [
            "address",
            "guest",
            "tel",
            "totalNumber",
            "totalArea",
            "totalPrice",
            "detail",
            "orderTime"
        ];
    }

    /**
     * @return bool
     */
    public function checkItemDetail($itemDetail) {
        $itemDetailModel = new ItemDetail($itemDetail);
        if($itemDetailModel->check()) {
            return true;
        }else{
            return false;
        }
    }


    private function _create_table() {
       return  "CREATE TABLE `user`. ( `id` INT NOT NULL AUTO_INCREMENT , `address` TEXT NOT NULL , `guest` VARCHAR NOT NULL , `tel` VARCHAR NOT NULL , `totalNumber` INT NOT NULL , `totalArea` FLOAT NOT NULL , `totalPrice` FLOAT NOT NULL , `detail` JSON NOT NULL , PRIMARY KEY (`id`), INDEX `tel_number` (`tel`), INDEX `guest_name` (`guest`)) ENGINE = InnoDB;";
       //ALTER TABLE `orderList` ADD `orderTime` DATE NOT NULL AFTER `detail`, ADD INDEX `time` (`orderTime`);
    }

}
