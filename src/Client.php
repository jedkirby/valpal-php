<?php

namespace Jedkirby\ValPal;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Jedkirby\ValPal\Entity\ValuationRequest;
use Jedkirby\ValPal\Exception\ResponseException;
use Jedkirby\ValPal\Exception\ResponseExceptionFactory;
use SimpleXMLElement as XML;

class Client
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @param Config $config
     * @param HttpClient $httpClient
     */
    public function __construct(
        Config $config,
        HttpClient $httpClient = null
    ) {
        $this->config = $config;
        $this->httpClient = ($httpClient ? $httpClient : new HttpClient());
    }

    /**
     * @param ValuationRequest $request
     *
     * @return Entity\AbstractValuation
     */
    public function getLettingValuation(ValuationRequest $request)
    {
        return $this->getValuation('letting', $request);
    }

    /**
     * @param ValuationRequest $request
     *
     * @return Entity\AbstractValuation
     */
    public function getSalesValuation(ValuationRequest $request)
    {
        return $this->getValuation('sales', $request);
    }

    /**
     * @param ValuationRequest $request
     *
     * @return Entity\AbstractValuation
     */
    public function getBothValuations(ValuationRequest $request)
    {
        return $this->getValuation('both', $request);
    }

    /**
     * @param string $type
     * @param ValuationRequest $request
     *
     * @throws ResponseException
     *
     * @return Entity\AbstractValuation
     */
    private function getValuation($type, ValuationRequest $request)
    {
        try {
            $response = $this->httpClient->request(
                'POST',
                $this->config->getEndpoint(),
                [
                    'debug' => $this->config->getDebug(),
                    'form_params' => [
                        'username' => $this->config->getUsername(),
                        'pass' => $this->config->getPassword(),
                        'type' => $type,
                        'reference' => $request->getReference(),
                        'buildname' => $request->getBuildingName(),
                        'subBname' => $request->getSubBuildingName(),
                        'number' => $request->getNumber(),
                        'street' => $request->getStreet(),
                        'depstreet' => $request->getDependentStreet(),
                        'postcode' => $request->getPostcode(),
                        'emailaddress' => $request->getEmail(),
                        'name' => $request->getName(),
                        'phone' => $request->getPhone(),
                    ],
                ]
            );

            $xml = new XML($response->getBody());
            $code = (int) $xml->responsecode;

            if (!in_array($code, [201])) {
                throw ResponseExceptionFactory::make($code);
            }

            $entity = sprintf(
                '\\Jedkirby\\ValPal\\Entity\\%sValuation',
                ucfirst($type)
            );

            return $entity::fromXml($xml);
        } catch (ResponseException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ResponseException(
                $e->getMessage(),
                $e->getCode()
            );
        }
    }
}
