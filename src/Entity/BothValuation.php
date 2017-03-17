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
        $valuation->setMinValuation((string) $xml->minvaluation);
        $valuation->setValuation((string) $xml->valuation);
        $valuation->setMaxValuation((string) $xml->maxvaluation);
        $valuation->setPropertyType((string) $xml->propertytype);
        $valuation->setTenure((string) $xml->tenure);
        $valuation->setBedrooms((int) $xml->bedrooms);
        $valuation->setPropertyConstructionYear((int) $xml->yearofpropertyconstruction);
        $valuation->setMinRentalValuation((string) $xml->minrentalvaluation);
        $valuation->setRentalValuation((string) $xml->rentalvaluation);
        $valuation->setMaxRentalValuation((string) $xml->maxrentalvaluation);

        return $valuation;
    }
}
