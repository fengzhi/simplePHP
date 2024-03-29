<?php

namespace Simple\Vendor;

class Request
{

    const CSRF_HEADER = 'X-CSRF-Token';

    const CSRF_MASK_LENGTH = 8;

    public $routeParam = 's';

    public $enableCsrfValidation = true;

    public $csrfParam = '_csrf';

    public $csrfCookie = ['httpOnly' => true];

    public $enableCsrfCookie = true;

    public $enableCookieValidation = true;

    public $cookieValidationKey;

    public $methodParam = '_method';

    public $parsers = [];

    public $trustedHosts = [];

    public $secureHeaders = [
        // Common:
        'X-Forwarded-For',
        'X-Forwarded-Host',
        'X-Forwarded-Proto',
    ];

    public $ipHeaders = [
        'X-Forwarded-For', // Common
    ];


    public $secureProtocolHeaders = [
        'X-Forwarded-Proto' => ['https'], // Common
    ];

    private $_cookies;
    private $_headers;
    private $_queryParams;
    private $_bodyParams;

    /**
     * for get
     * @return mixed
     */
    public function getQueryParams() {
        if ($this->_queryParams === null) {
            return $_GET;
        }
        return $this->_queryParams;
    }

    /**
     * just support post
     * @return null
     */
    public function getBodyParams() {
        file_get_contents("php://input");
        if($this->_bodyParams === null) {
            if($this->getMethod() === 'POST') {
                $this->_bodyParams =  json_decode(file_get_contents("php://input"),true);
                //unset($this->_bodyParams[$this->methodParam]);
                return $this->_bodyParams;
            }
        }
        return $this->_bodyParams;
    }

    /**
     * only for post and get
     * @return string
     */
    public function getMethod() {
        if(isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'],'POST')) {
            return 'POST';
        }
        return 'GET';
    }

    /**
     * @return array
     */
    public function resolve() {
        $this->_queryParams = $_GET;
        $uri = $_SERVER["REQUEST_URI"];
        list($route,) = explode("?",$uri);
        if(strpos($route,"mock")) {
            $route = str_replace("mock/","",$route);
        }
        return [$route, $this->getQueryParams()];
    }

    /**
     * get param
     * @param null $name
     * @param null $defaultvalue
     * @return mixed|null
     */
    public function get($name=null,$defaultvalue=null) {
        if($name === null) {
            return $this->getQueryParams();
        }else{
            $params = $this->getQueryParams();
            return isset($params[$name]) ? $params[$name] : $defaultvalue;
        }
    }

    /**
     * post param
     * @param null $name
     * @param null $defaultvalue
     * @return null
     */
    public function post($name=null, $defaultvalue=null) {
        if($name === null) {
            return $this->getBodyParams();
        }else{
            $params = $this->getBodyParams();
            return isset($params[$name]) ? $params[$name] : $defaultvalue;
        }
    }

}