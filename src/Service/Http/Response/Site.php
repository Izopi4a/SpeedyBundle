<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Response;

class Site
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
     * @var string
     */
    protected string $post_code = "";

    protected int $countryId = 0;

    /**
     * гр / село т.н.
     * @var string
     */
    protected string $type = "";
    /**
     * гр / село т.н.
     * @var string
     */
    protected string $typeEN = "";

    /**
     * @var string ex: 111111110
     */
    protected string $servingDays = "";

    /**
     * Site constructor.
     *
     * @param \stdClass $data
     */
    public function __construct(array $data)
    {

        $this->setId($data['id'])
            ->setName($data['name'])
            ->setNameEN($data['nameEn'])
            ->setPostCode($data['postCode'])
            ->setCountryId($data['countryId'])
            ->setType($data['type'])
            ->setTypeEN($data['typeEn'])
            ->setServingDays($data['servingDays']);
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

    protected function setNameEN(string $name): self
    {

        $this->nameEN = $name;

        return $this;
    }

    public function getNameEN(): string
    {

        return $this->nameEN;
    }

    protected function setPostCode(string $postCode): self
    {

        $this->post_code = $postCode;

        return $this;
    }

    public function getPostCode(): string
    {

        return $this->post_code;
    }

    protected function setCountryId(int $countryId): self
    {

        $this->countryId = $countryId;

        return $this;
    }

    public function getCountryId(): string
    {

        return $this->countryId;
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

    protected function setTypeEN(string $type): self
    {

        $this->typeEN = $type;

        return $this;
    }

    public function getTypeEN(): string
    {

        return $this->typeEN;
    }

    protected function setServingDays(string $numbers): self
    {

        $this->servingDays = $numbers;

        return $this;
    }

    public function getServingDays(): string
    {

        return $this->servingDays;
    }
}