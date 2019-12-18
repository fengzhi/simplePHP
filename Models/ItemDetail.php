<?php

namespace Simple\Models;

class ItemDetail {

    /**
     * @return array
     */
    public function getAttributes() {
        return [
            "itemName",
            "width",
            "totalWidth",
            "totalLength",
            "area",
            "itemPrice",
            "price",
            "slottedNumber",
            "slottedLength",
            "slottedPrice",
            "slottedTotalPrice",
            "totalPrice",
            "quantity"
        ];
    }

    /**
     * Model constructor.
     * @param Database $database
     */
    public function __construct($itemDetail) {
        foreach($this->getAttributes() as $attribute) {
            $this->$attribute = $itemDetail[$attribute] ?: "";
        }
    }

    public function check() {
         if(
             $this->checkWidth() &&
             $this->checkArea() &&
             $this->checkPrice() &&
             $this->checkSlotted()
         ){
             return true;
         }else{
                 return false;
         }
    }

    public function checkSoltted() {
        return true;
    }

    public function checkPrice() {
        return true;
    }


    public function checkWidth() {
        if(empty($this->width) || empty($this->totalWidth)) {
            return false;
        }else{
            $widths = explode("+",$this->width);
            $sumWidth = array_sum($widths);
            if($sumWidth == $this->totalWidth) {
                return true;
            }else{
                return false;
            }
        }
    }

    public function checkArea() {
        if(empty($this->totalLength) || empty($this->area)) {
            return false;
        }else{
            if($this->area == round($this->quantity * $this->totalLength/1000 * $this->totalWidth/1000,2)) {
                return true;
            }else{
                return false;
            }
        }
    }


}