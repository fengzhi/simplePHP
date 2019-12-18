<?php

namespace Simple\Controller;

use Simple\Models\{ User, Item, Order };
use Simple\Application;

class Api extends Controller {

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
        $startTime = isset($params['startTime']) ? date('Y-m-d H:i:s',$params['startTime']/1000) : date('Y-m-d H:i:s',strtotime('-7 days'));
        $endTime = isset($params['endTime']) ? date('Y-m-d H:i:s',$params['endTime']/1000) : date('Y-m-d H:i:s');
        if($endTime < $startTime) {
            return [ 'errNo' => -1, 'errMsg' => '时间设置错误'];
        }
        $condition['AND'] = [ 'orderTime[<>]' =>  [$startTime,$endTime] ];
        if(!empty($params['guest'])) {
            $condition['AND']['guest'] = $params['guest'];
        }
        if(!empty($params['tel'])) {
            $condition['AND']['tel'] = $params['tel'];
        }
        $orderModel = new Order();
        $columns = [ "id","guest", "tel", "orderTime", "address", "totalPrice"];

        $result = $orderModel->select($columns , $condition);
        return [ 'errNo' => 0, 'errMsg' => '', 'result' => $result];

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
            if($orderMoel->insert($condition)) {
                return [ 'errNo' => 0, 'errMsg' => '', 'result' => '新建成功'];
            }

        }else{
            return [ 'errNo' => -1, 'errMsg' => '总数数据计算错误'];
        }
    }

    /**
     * @return array
     */
    public function orderDetail() {
        $params =  Application::$app->get('request')->getQueryParams();
        if(empty($params['id'])) {
            return [ 'errNo' => -1, 'errMsg' => 'id为空', 'result' => ''];
        }
        $orderMoel = new Order();
        $result = $orderMoel->get("*",["id"=>$params['id']]);
        if($result) {
            return [ 'errNo' => 0, 'errMsg' => '', 'result' => $result];
        }else{
            return [ 'errNo' => -1, 'errMsg' => 'id不存在', 'result' => ''];
        }
    }
}