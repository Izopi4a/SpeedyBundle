<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Response;

class Office implements \JsonSerializable
{

    /**
     * siteId
     *
     * @var int
     */
    protected int $id;

    /**
     * @var string City name
     */
    protected string $name = "";
    /**
     * @var string City name
     */
    protected string $nameEN = "";

    /**
     * @var int parent site id
     */
    protected int $siteId = 0;

    /**
     * OFFICE || ??
     * @var string
     */
    protected string $type = "";

    protected bool $pickUpAllowed;

    public function __construct(array $data)
    {
        $this->setId($data['id'])
            ->setName($data['name'])
            ->setNameEN($data['nameEn'])
            ->setSiteId($data['siteId'])
            ->setType($data['type'])
            ->setPickUpAllowed($data['pickUpAllowed']);
    }

    protected function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    protected function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNameEn(): string
    {
        return $this->nameEN;
    }

    protected function setNameEN(string $name): self
    {
        $this->nameEN = $name;
        return $this;
    }

    protected function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    protected function setSiteId(int $siteId): self
    {
        $this->siteId = $siteId;
        return $this;
    }

    public function getSiteId(): int
    {
        return $this->siteId;
    }

    protected function setPickUpAllowed(bool $allowed): self
    {
        $this->pickUpAllowed = $allowed;
        return $this;
    }

    public function getPickUpAllowed(): int
    {
        return $this->pickUpAllowed;
    }

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "name_en" => $this->getNameEn(),
            "type" => $this->getType(),
            "site_id" => $this->getSiteId(),
            "pickup_allowed" => $this->getPickUpAllowed()
        ];
    }
}