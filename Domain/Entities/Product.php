<?php

namespace Domain\Entities;

use Domain\Entities\Traits\Identifiable;

/**
 * Class Product
 * @package Domain\Entities
 */
class Product
{
    use Identifiable;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var float $priceInUSD
     */
    private $priceInUSD;

    /**
     * @var Offer $offer
     */
    private $offer;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param float $priceInUSD
     */
    public function setPriceInUSD(float $priceInUSD): void
    {
        $this->priceInUSD = $priceInUSD;
    }

    /**
     * @return float
     */
    public function getPriceInUSD(): float
    {
        return $this->priceInUSD;
    }

    /**
     * @param Offer $offer
     */
    public function setOffer(Offer $offer): void
    {
        $this->offer = $offer;
    }

    /**
     * @return Offer|null
     */
    public function getOffer()
    {
        return $this->offer;
    }
}
