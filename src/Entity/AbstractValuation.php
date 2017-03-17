<?php

namespace Jedkirby\ValPal\Entity;

abstract class AbstractValuation
{
    /**
     * @var string
     */
    protected $minValuation;

    /**
     * @var string
     */
    protected $valuation;

    /**
     * @var string
     */
    protected $maxValuation;

    /**
     * @var string
     */
    protected $propertyType;

    /**
     * @var string
     */
    protected $tenure;

    /**
     * @var string
     */
    protected $bedrooms;

    /**
     * @var string
     */
    protected $propertyConstructionYear;

    /**
     * @var string
     */
    protected $minRentalValuation;

    /**
     * @var string
     */
    protected $rentalValuation;

    /**
     * @var string
     */
    protected $maxRentalValuation;

    /**
     * @param string $value
     */
    public function setMinValuation($value)
    {
        $this->minValuation = $value;
    }

    /**
     * @param string $value
     */
    public function setValuation($value)
    {
        $this->valuation = $value;
    }

    /**
     * @param string $value
     */
    public function setMaxValuation($value)
    {
        $this->maxValuation = $value;
    }

    /**
     * @param string $type
     */
    public function setPropertyType($type)
    {
        $this->propertyType = $type;
    }

    /**
     * @param string $tenure
     */
    public function setTenure($tenure)
    {
        $this->tenure = $tenure;
    }

    /**
     * @param string $bedrooms
     */
    public function setBedrooms($bedrooms)
    {
        $this->bedrooms = $bedrooms;
    }

    /**
     * @param string $year
     */
    public function setPropertyConstructionYear($year)
    {
        $this->propertyConstructionYear = $year;
    }

    /**
     * @param string $value
     */
    public function setMinRentalValuation($value)
    {
        $this->minRentalValuation = $value;
    }

    /**
     * @param string $value
     */
    public function setRentalValuation($value)
    {
        $this->rentalValuation = $value;
    }

    /**
     * @param string $value
     */
    public function setMaxRentalValuation($value)
    {
        $this->maxRentalValuation = $value;
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
     * @return string
     */
    public function getBedrooms()
    {
        return $this->bedrooms;
    }

    /**
     * @return string
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
