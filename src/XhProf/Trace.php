<?php

namespace XhProf;

class Trace
{
    private $token;
    private $data;

    public function __construct($token, array $data)
    {
        $this->token = $token;
        $this->data = $data;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getData()
    {
        return $this->data;
    }
}