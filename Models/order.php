<?php

namespace Simple\Models;

class Order extends Model {

    protected $rules;

    public $tableName="order";

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
            "detail"
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

}
