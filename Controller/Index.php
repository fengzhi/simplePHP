<?php

namespace Simple\Controller;

use Simple\Models\{ User, Item, Order };
use Simple\Application;

class Index {

    /**
     * @return array
     */
    public function login() {
       $params =  Application::$app->get('request')->getQueryParams();
       if(empty($params['username']) || empty($params['passwd'])) {
            return [ 'errNo' => -1, 'errMsg' => '帐号或密码为空' ];
       }
       $userModel = new User();
       $result = $userModel->get(["passwd"],["username"=>$params['username']]);
       if($params['passwd'] === $result['passwd']) {
           return [ 'errNo' => 0, 'errMsg' => '', 'result' => '登陆成功'];
       }else{
           return [ 'errNo' => -1, 'errMsg' => '账号或密码错误'];
       }
    }

    /**
     * @return array
     */
    public function getOrderLists() {
        $params =  Application::$app->get('request')->getQueryParams();
        $startTime = $params['startTime'] ? strtotime($params['startTime']) : strtotime('-7 days');
        $endTime = $params['endTime'] ? strtotime($params['endTime']) : time();
        if($endTime > $startTime) {
            return [ 'errNo' => -1, 'errMsg' => '时间设置错误'];
        }
        if(!empty($params['guest'])) {
            $condition['guest'] = $params['guest'];
        }
        if(!empty($params['tel'])) {
            $condition['tel'] = $params['tel'];
        }
        $orderModel = new Order();
        $columns = [ "guest", "tel", "orderTime", "address", "totalPrice"];
        $result = $orderModel->select($columns , $condition);

    }

    /**
     *
     */
    public function submit() {
        $params =  Application::$app->get('request')->getBodyParams();
        $orderMoel = new Order();
        foreach($params as $key => $value) {
            if(isset($orderMoel->$key)) {
                $condition[$key] = $value;
            }
        }
        $totalNumber = $totalPrice = $totalArea = 0;
        foreach($condition['detail'] as $itemDetail) {
            if($orderMoel->checkItemDetail($itemDetail)) {
                $totalNumber += $itemDetail['number'];
                $totalPrice += $itemDetail['totalPrice'];
                $totalArea += $itemDetail['area'];
            }else{
                return [ 'errNo' => -1, 'errMsg' => 'Item数据计算错误'];
            }
        }
        if( $totalNumber === $condition['totalNumber']
            && $totalPrice === $condition['totalPrice']
            && $totalArea === $condition['totalArea'] ) {
            $orderMoel->save();
        }else{
            return [ 'errNo' => -1, 'errMsg' => '总数数据计算错误'];
        }
    }
}