<?php

namespace Domain\Entities;

use Domain\Entities\Traits\Identifiable;

/**
 * Class Offer
 * @package Domain\Entities
 */
class Offer
{
    use Identifiable;

    /**
     * @var boolean $isDiscount
     */
    protected $isDiscount;

    /**
     * @var integer $buyCount
     */
    protected $buyCount;

    /**
     * @var integer $getCount
     */
    protected $getCount;

    /**
     * @var integer $percentage
     */
    protected $percentage;

    /**
     * @param bool $isDiscount
     */
    public function setIsDiscount(bool $isDiscount): void
    {
        $this->isDiscount = $isDiscount;
    }

    /**
     * @return boolean
     */
    public function getIsDiscount(): bool
    {
        return $this->isDiscount;
    }

    /**
     * @param int $percentage
     */
    public function setPercentage(int $percentage): void
    {
        $this->percentage = $percentage;
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }

    /**
     * @param int $buyCount
     */
    public function setBuyCount(int $buyCount)
    {
        $this->buyCount = $buyCount;
    }

    /**
     * @return int
     */
    public function getBuyCount(): int
    {
        return $this->buyCount;
    }

    /**
     * @param int $getCount
     */
    public function setGetCount(int $getCount): void
    {
        $this->getCount = $getCount;
    }

    /**
     * @return int
     */
    public function getGetCount(): int
    {
        return $this->getCount;
    }
}
