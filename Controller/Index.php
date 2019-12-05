<?php

namespace Simple\Controller;

use Simple\Models\User;
use Simple\Application;

class Index {

    public function login() {
       $params =  Application::$app->get('request')->getQueryParams();
       $database = Application::$app->get('db');
       $userModel = new User($database);
       $sql = "select * from user";
       $query = $userModel->query($sql);
       $result = $query->fetchAll();
       echo json_encode($result);
       exit;
       if(empty($params['username']) || empty($params['passwd'])) {
           return [ 'errNo'=>-1, 'errMsg'=>'帐号或密码为空' ];
       }

    }

}