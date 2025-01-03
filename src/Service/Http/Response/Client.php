<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Response;

class Client {

    protected $data;

    public function __construct($data)
    {

        $this->data = $data;
    }

}