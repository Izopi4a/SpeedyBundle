<?php
declare(strict_types=1);

namespace Izopi4a\SpeedyBundle\Service\Http\Response;

class Delivery
{

    /**
     * @var int
     */
    protected int $serviceId = 0;

    /**
     * @var string
     */
    protected string $error = "";

    /**
     * @var float
     */
    protected float $total = 0.00;

    /**
     * @var float
     */
    protected float $vat = 0.00;

    /**
     * @var float
     */
    protected float $netAmount = 0.00;

    protected float $codPremium = 0.00;

    public function __construct(array $data)
    {
        $this->parse($data);
    }

    protected function parse(array $data): self
    {

        if (count($data['calculations']) === 0) {
            $this->error = "error";

            return $this;
        }

        $calc = $data['calculations'][0];

        if (!empty($calc['error']) && $calc['error']['message'] !== "") {
            $this->error = $calc['error']['message'];

            return $this;
        }

        $this->setServiceId($calc['serviceId']);

        $price = $calc['price'];

        if (isset($price['details']) && isset($price['details']['codPremium'])) {
            $this->codPremium = (float)$price['details']['codPremium']["amount"];
        }

        $this->setNetAmount($price['amount']);
        $this->setVat($price['vat']);
        $this->setTotal($price['total']);

        return $this;
    }

    public function getCashOnDeliveryTax() : float
    {
        return $this->codPremium;
    }

    public function setError(string $message) :self
    {
        $this->error = $message;
        return $this;
    }

    protected function setNetAmount(float $net): self
    {

        $this->netAmount = $net;

        return $this;
    }

    public function getNetAmount(): float
    {

        return $this->netAmount;
    }

    protected function setVat(float $vat): self
    {

        $this->vat = $vat;

        return $this;
    }

    public function getVat(): float
    {

        return $this->netAmount;
    }

    protected function setTotal(float $total): self
    {

        $this->total = $total;

        return $this;
    }

    public function getTotal(): float
    {

        return $this->total;
    }

    /**
     * @return bool
     */
    public function hasError(): bool
    {

        return $this->error !== "";
    }

    /**
     * returns the error as a string
     */
    public function getError(): string
    {

        return $this->error;
    }

    protected function setServiceId(?int $serviceId): self
    {

        if (!$serviceId) {
            $serviceId = 0;
        }

        $this->serviceId = $serviceId;

        return $this;
    }

    public function getServiceId(): int
    {

        return $this->serviceId;
    }

    public static function createEmpty(string $error = "error"): Delivery
    {

        $cls = new \stdClass();
        $cls->calculations = [];

        $instance = new Delivery($cls);

        $instance->setError($error);
        $instance->setNetAmount(0);
        $instance->setVat(0);
        $instance->setTotal(0);

        return $instance;
    }

}