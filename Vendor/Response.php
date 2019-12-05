<?php

namespace Simple\Vendor;

Class Response {


    private $_statusCode = 200;

    private $isSent = false;

    private $content = "";

    private $errNo = 0;

    private $errMsg = "";

    /**
     * @param $errNo
     */
    public function setErrNo($errNo) {
        $this->errNo = $errNo;
    }

    /**
     * @param $errNo
     * @return mixed
     */
    public function getErrNo() {
        return $this->errNo;
    }

    /**
     * @param $errMsg
     */
    public function setErrMsg($errMsg) {
        $this->errMsg = $errMsg;
    }

    /**
     * @return mixed
     */
    public function getErrMsg() {
        return $this->errMsg;
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param array $result
     */
    public function setResult($result) {
        if(isset($result['errNo'])) {
            $this->setErrNo($result['errNo']);
        }
        if(isset($result['errMsg'])) {
            $this->setErrMsg($result['errMsg']);
        }
        if(isset($result['result'])) {
            $this->setContent($result['result']);
        }
    }

    /**
     * Sends the response to the client.
     */
    public function send() {
        if ($this->isSent) {
            return ;
        }
        $this->isSent = true;
        echo json_encode([
            "errNo" => $this->getErrNo(),
            "errMsg" => $this->getErrMsg(),
            "result" => $this->getContent(),
        ]);
    }
}