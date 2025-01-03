<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Payload;

use Izopi4a\SpeedyBundle\Service\Http\PayloadInterface;

class CourierServicePayer implements PayloadInterface
{
    public CONST string RECIPIENT = "RECIPIENT";
    public CONST string SENDER = "SENDER";
    public CONST string THIRD_PARTY = "THIRD_PARTY";

    /**
     * @var string chosen type
     */
    protected string $type;

    public function __construct(string $type = self::RECIPIENT)
    {

        $this->type = $type;
    }

    public function getData(): array
    {
        return [
            'courierServicePayer' => $this->type,
        ];
    }

}