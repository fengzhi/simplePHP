<?php

namespace Simple\Controller;

class Index {

    public function index() {
       $params =  \Simple\Application::$app->get('request')->getQueryParams();

    }

}