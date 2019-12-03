<?php

/**
 * @author    xiaoyunfeng
 * @copyright 2019
 *
 */

namespace Simple;

/**
 *  Class Application
 *
 *  just for fast
 */

use Simple\ServiceProvider\ServiceProviderInterface;

class Application extends Container {

    const VERSION = "1.0";

    /**
     * @var Application
     */
    public static $app;

    /**
     * @var string
     */
    protected $name;

    /**
     * AppKernel constructor.
     *
     * @param $path
     * @param $mode
     */
    public function __construct($config)
    {
        static::$app = $this;
        $this->add('app', $this);
        $this->bootstrap($config);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Application bootstrap.
     */
    public function bootstrap($config)
    {
        $this->name = $config['name'];
        date_default_timezone_set(isset($config['timezone']) ? $config['timezone'] : 'UTC');
        $this->add('config', new Config($config));
        //$this->add('logger', new Logger($this->name));
        $this->registerExceptionHandler($config);
        $this->registerServicesProviders($config['services']);
        unset($config);
    }

    protected function registerExceptionHandler($config)
    {
        $level = $config['error_reporting'] ?: E_ALL;
        error_reporting($level);
        //set_exception_handler([$this, 'handleException']);
        set_error_handler(function ($level, $message, $file, $line) {
            throw new \Exception($message, 0);
        }, $level);
    }
    /**
     * @param ServiceProviderInterface[] $services
     */
    protected function registerServicesProviders(array $services)
    {
        foreach ($services as $service) {
            $this->register(new $service());
        }
    }

    protected function register(ServiceProviderInterface $service) {
        if(is_object($service)) {
            $service->register($this);
        }
    }

    /**
     * @param \Simple\Vendor\Request $request
     *
     * @return \Simple\vendor\Response $reponse
     *
     * @throws Exception
     */
    public function handleRequest($request)
    {
        try {
            list($route, $params) = $request->resolve();
            $result = $this->runAction($route, $params);
            if ($result instanceof \Simple\Vendor\Response) {
                $response = $result;
            }else{
                $response = $this->getResponse();
            }
            return $response;
        } catch (\Exception $e) {
            throw new \Exception('Page not found.', $e->getCode(), $e);
        }
    }
    /**
     * @param \Simple\Vendor\Response $response
     */
    public function handleResponse($response)
    {
        $response->send();
    }

    public function run() {
        $response = $this->handleRequest($this->getRequest());
        $this->handleResponse($response);
    }

    public function getRequest() {
        return $this->get('request');
    }

    /**
     * @return \Simple\Vendor\Response
     */
    public function getResponse() {
        return $this->get('response');
    }

    /**
     * @param $route
     * @param $params
     * @return Vendor\Response
     */
    public function runAction($route,$params) {
        $response = $this->getResponse();
        list($controllerName,$action) = $this->createController($route);
        try{
            $controllerName = "Simple\Controller\\".ucfirst($controllerName);
            $controller = new $controllerName();
        }catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        if(method_exists($controller,$action)) {
            $result = $controller->$action($params);
            $response->setContent($result);
        }else{
            $response->setErrNo("-1");
            $response->setErrMsg("method is not exists");
        }
        return $response;
    }

    public function createController($route) {
        if ($route === '') {
            $route = "index";
        }
        $route = trim($route, '/');
        if (strpos($route, '/') !== false) {
            list($controller, $action) = explode('/', $route, 2);
        }else{
            $controller = $route;
            $action = '';
        }
        return [ $controller , $action ];

    }

}