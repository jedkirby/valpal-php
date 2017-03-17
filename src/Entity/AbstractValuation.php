<?php

namespace Jedkirby\ValPal\Entity;

abstract class AbstractValuation
{
    /**
     * @var string
     */
    private $minValuation;

    /**
     * @var string
     */
    private $valuation;

    /**
     * @var string
     */
    private $maxValuation;

    /**
     * @var string
     */
    private $propertyType;

    /**
     * @var string
     */
    private $tenure;

    /**
     * @var int
     */
    private $bedrooms;

    /**
     * @var int
     */
    private $propertyConstructionYear;

    /**
     * @var string
     */
    private $minRentalValuation;

    /**
     * @var string
     */
    private $rentalValuation;

    /**
     * @var string
     */
    private $maxRentalValuation;

    /**
     * @param string $value
     */
    public function setMinValuation($value)
    {
        $this->minValuation = (string) $value;
    }

    /**
     * @param string $value
     */
    public function setValuation($value)
    {
        $this->valuation = (string) $value;
    }

    /**
     * @param string $value
     */
    public function setMaxValuation($value)
    {
        $this->maxValuation = (string) $value;
    }

    /**
     * @param string $type
     */
    public function setPropertyType($type)
    {
        $this->propertyType = (string) $type;
    }

    /**
     * @param string $tenure
     */
    public function setTenure($tenure)
    {
        $this->tenure = (string) $tenure;
    }

    /**
     * @param int $bedrooms
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = (int) $bedrooms;
    }

    /**
     * @param int $year
     */
    public function setPropertyConstructionYear($year)
    {
        $this->propertyConstructionYear = (int) $year;
    }

    /**
     * @param string $value
     */
    public function setMinRentalValuation($value)
    {
        $this->minRentalValuation = (string) $value;
    }

    /**
     * @param string $value
     */
    public function setRentalValuation($value)
    {
        $this->rentalValuation = (string) $value;
    }

    /**
     * @param string $value
     */
    public function setMaxRentalValuation($value)
    {
        $this->maxRentalValuation = (string) $value;
    }

    /**
     * @return string
     */
    public function getMinValuation()
    {
        return $this->minValuation;
    }

    /**
     * @return string
     */
    public function getValuation()
    {
        return $this->valuation;
    }

    /**
     * @return string
     */
    public function getMaxValuation()
    {
        return $this->maxValuation;
    }

    /**
     * @return string
     */
    public function getPropertyType()
    {
        return $this->propertyType;
    }

    /**
     * @return string
     */
    public function getTenure()
    {
        return $this->tenure;
    }

    /**
     * @return int
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * @return int
     */
    public function getPropertyConstructionYear()
    {
        return $this->propertyConstructionYear;
    }

    /**
     * @return string
     */
    public function getMinRentalValuation()
    {
        return $this->minRentalValuation;
    }

    /**
     * @return string
     */
    public function getRentalValuation()
    {
        return $this->rentalValuation;
    }

    /**
     * @return string
     */
    public function getMaxRentalValuation()
    {
        return $this->maxRentalValuation;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isLetting()
    {
        return $this->type === 'letting';
    }

    /**
     * @return bool
     */
    public function isSales()
    {
        return $this->type === 'sales';
    }

    /**
     * @return bool
     */
    public function isLettingAndSales()
    {
        return $this->type === 'both';
    }
}
