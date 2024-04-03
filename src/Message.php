<?php

namespace Fakell\Bing;


class Message {
    const NAME = "message";
    private $data;
    public function __construct($data){
        $this->data = $data;
    }

    /**
     * Get the value of data
     */ 
    public function getData(){
        return $this->data;
    }
}