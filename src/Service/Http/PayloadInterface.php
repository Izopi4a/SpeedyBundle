<?php

namespace Izopi4a\SpeedyBundle\Service\Http;

interface PayloadInterface
{

    /**
     * returns data as required for speedy json_data passed to the request
     *
     * @return array
     */
    public function getData():array;
}