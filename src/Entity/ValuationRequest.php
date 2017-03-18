<?php

namespace Jedkirby\ValPal\Entity;

/**
 * @codeCoverageIgnore
 */
class ValuationRequest
{
    /**
     * @var string
     */
    private $buildingName;

    /**
     * @var string
     */
    private $subBuildingName;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $dependentStreet;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $reference;

    /**
     * @param string $buildingName
     * @param string $subBuildingName
     * @param string $number
     * @param string $street
     * @param string $dependentStreet
     * @param string $postcode
     * @param string $email
     * @param string $name
     * @param string $phone
     * @param string $reference
     */
    public function __construct(
        $buildingName,
        $subBuildingName,
        $number,
        $street,
        $dependentStreet,
        $postcode,
        $email = null,
        $name = null,
        $phone = null,
        $reference = null
    ) {
        $this->buildingName = (string) $buildingName;
        $this->subBuildingName = (string) $subBuildingName;
        $this->number = (string) $number;
        $this->street = (string) $street;
        $this->dependentStreet = (string) $dependentStreet;
        $this->postcode = (string) $postcode;
        $this->email = (string) $email;
        $this->name = (string) $name;
        $this->phone = (string) $phone;
        $this->reference = (string) $reference;
    }

    /**
     * @param string $buildingName
     */
    public function setBuildingName($buildingName)
    {
        $this->buildingName = (string) $buildingName;
    }

    /**
     * @param string $subBuildingName
     */
    public function setSubBuildingName($subBuildingName)
    {
        $this->subBuildingName = (string) $subBuildingName;
    }

    /**
     * @param string $number
     */
    public function setNumber($number)
    {
        $this->number = (string) $number;
    }

    /**
     * @param string $street
     */
    public function setStreet($street)
    {
        $this->street = (string) $street;
    }

    /**
     * @param string $dependentStreet
     */
    public function setDependentStreet($dependentStreet)
    {
        $this->dependentStreet = (string) $dependentStreet;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = (string) $postcode;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = (string) $phone;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = (string) $reference;
    }

    /**
     * @return string
     */
    public function getBuildingName()
    {
        return $this->buildingName;
    }

    /**
     * @return string
     */
    public function getSubBuildingName()
    {
        return $this->subBuildingName;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getDependentStreet()
    {
        return $this->dependentStreet;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }
}
