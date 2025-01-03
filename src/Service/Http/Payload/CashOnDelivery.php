<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Payload;


use Izopi4a\SpeedyBundle\Service\Http\Exception;
use Izopi4a\SpeedyBundle\Service\Http\PayloadInterface;

class CashOnDelivery implements PayloadInterface
{

    /**
     * @var int total number of parcels
     */
    protected int $amount = 0;
    /**
     * how we pay the money
     * @var string // (CASH, POSTAL_MONEY_TRANSFER)
     */
    protected string $type = "CASH";

    public function __construct(float $amount,string $type = "CASH")
    {

        $this->setAmount($amount);
        $this->setType($type);
    }

    /**
     * updates amount of cash that will be picked upon delivery
     *
     * @param float $amount
     *
     * @return $this
     */
    protected function setAmount(float $amount): self
    {

        $this->amount = $amount;

        return $this;
    }

    public function getAmount(): float
    {

        if ($this->amount === 0) {
            throw new Exception("No amount set for Cash on Delivery");
        }
        return $this->amount;
    }

    protected function validateType(string $type): bool
    {

        if (in_array($type, ['CASH','POSTAL_MONEY_TRANSFER']) === false) {
            throw new Exception("Wrong type for cash on delivery");
        }

        return true;
    }

    protected function setType(string $type): self
    {

        $this->validateType($type);

        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {

        return $this->type;
    }

    public function getData(): array
    {

        return [
            'amount' => $this->getAmount(),
            'processingType' => $this->getType()
        ];
    }

}