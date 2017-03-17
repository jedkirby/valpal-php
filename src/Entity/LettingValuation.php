<?php

namespace Jedkirby\ValPal\Entity;

use SimpleXMLElement as XML;

class LettingValuation extends AbstractValuation
{
    /**
     * @var string
     */
    protected $type = 'letting';

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

        return $valuation;
    }
}
