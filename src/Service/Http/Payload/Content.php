<?php

namespace Izopi4a\SpeedyBundle\Service\Http\Payload;

use Izopi4a\SpeedyBundle\Service\Http\PayloadInterface;

class Content implements PayloadInterface
{

    /**
     * @var int total number of parcels
     */
    protected int $itemCount = 0;
    /**
     * @var float total weight of packages in KG 0.1 for 100 grams
     */
    protected float $weight = 0;

    public function __construct(int $count = 1, float $weight = 0)
    {

        $this->setItemsCount($count);
        $this->setWeight($weight);
    }

    protected function setWeight(float $weight): self
    {

        $this->weight = $weight;

        return $this;
    }

    public function getWeight(): float
    {

        return $this->weight;
    }

    protected function setItemsCount(int $items): self
    {

        $this->itemCount = $items;

        return $this;
    }

    public function getItemsCount(): int
    {

        return $this->itemCount;
    }

    public function getData(): array
    {
        return [
            'parcelsCount' => $this->getItemsCount(),
            'totalWeight' => $this->getWeight()
        ];
    }

}