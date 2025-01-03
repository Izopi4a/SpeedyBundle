<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Payload;


use Izopi4a\SpeedyBundle\Service\Http\Exception;
use Izopi4a\SpeedyBundle\Service\Http\PayloadInterface;

class Recipient implements PayloadInterface
{

    /**
     * @var bool
     */
    protected bool $isPrivatePerson = true;

    /**
     * @var int speedy siteId / city Id
     */
    protected int $stateId = 0;

    /**
     * @var int
     */
    protected int $officeId = 0;

    public function __construct(int $stateId = 0, int $officeId = 0)
    {
        $this->setStateId($stateId);
        $this->setOfficeId($officeId);
    }

    public function setOfficeId(int $officeId): self
    {
        $this->officeId = $officeId;
        return $this;
    }

    public function getOfficeId(): int
    {
        return $this->officeId;
    }

    public function isOfficePickup(): bool
    {
        if ($this->getOfficeId() === 0 && $this->getStateId() === 0) {
            throw new Exception("No office id provided or state id provided");
        }
        return $this->officeId !== 0;
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public function getData(): array
    {

        if ($this->isOfficePickup() === true) {
            return [
                'privatePerson' => true,
                'pickupOfficeId' => $this->getOfficeId()
            ];
        }

        return [
            'privatePerson' => $this->getIsPrivatePerson(),
            'addressLocation' => [
                'siteId' => $this->getStateId(),
            ]
        ];
    }

    public function getStateId(): int
    {

        return $this->stateId;
    }

    public function setStateId(int $stateId): self
    {
        $this->stateId = $stateId;
        return $this;
    }

    /**
     * returns if recipient / client is private person
     * @return bool
     */
    public function getIsPrivatePerson(): bool
    {

        return $this->isPrivatePerson;
    }

    /**
     * updates object property for is private person/client
     * i assume non private will be created in the DB
     *
     * @param bool $state
     *
     * @return $this
     */
    public function setPrivatePerson(bool $state): self
    {

        $this->isPrivatePerson = $state;

        return $this;
    }

}