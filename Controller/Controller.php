<?php

namespace Simple\Controller;

use Simple\Models\{ User, Item, Order };
use Simple\Application;

class Controller {

    public function __construct() {
        date_default_timezone_set("PRC");
    }
}