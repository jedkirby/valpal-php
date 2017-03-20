<?php

namespace Jedkirby\ValPal\Entity;

use SimpleXMLElement as XML;

class BothValuation extends AbstractValuation
{
    /**
     * @var string
     */
    protected $type = 'both';

    /**
     * @param XML $xml
     *
     * @return LettingValuation
     */
    public static function fromXml(XML $xml)
    {
        $valuation = new static();
        $valuation->setMinValuation($xml->minvaluation);
        $valuation->setValuation($xml->valuation);
        $valuation->setMaxValuation($xml->maxvaluation);
        $valuation->setPropertyType($xml->propertytype);
        $valuation->setTenure($xml->tenure);
        $valuation->setBedrooms($xml->bedrooms);
        $valuation->setPropertyConstructionYear($xml->yearofpropertyconstruction);
        $valuation->setMinRentalValuation($xml->minrentalvaluation);
        $valuation->setRentalValuation($xml->rentalvaluation);
        $valuation->setMaxRentalValuation($xml->maxrentalvaluation);

        return $valuation;
    }
}
