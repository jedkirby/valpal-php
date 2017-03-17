<?php

namespace Jedkirby\ValPal\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Jedkirby\ValPal\Client;
use Jedkirby\ValPal\Config;
use Jedkirby\ValPal\Entity\BothValuation;
use Jedkirby\ValPal\Entity\LettingValuation;
use Jedkirby\ValPal\Entity\SalesValuation;
use Jedkirby\ValPal\Entity\ValuationRequest;
use Jedkirby\ValPal\Exception\ResponseException;
use Jedkirby\ValPal\Exception\ResponseExceptionFactory;
use Mockery;

class ClientTest extends AbstractTestCase
{
    private function getConfig()
    {
        return new Config(
            'joe.bloggs',
            '1a2b3c4d5e6f'
        );
    }

    private function getHttpClient($body)
    {
        $stream = Mockery::mock(
            Stream::class,
            [
                'getBody' => $body,
            ]
        );

        $httpClient = Mockery::mock(
            HttpClient::class,
            [
                'request' => $stream,
            ]
        );

        return $httpClient;
    }

    private function getValuationRequest()
    {
        return new ValuationRequest(
            'Building Name',
            'Sub-Building Name',
            '2',
            'Street',
            'Dependent Street',
            'A12 3BC',
            'joe@email.com',
            'Joe Bloggs',
            '01789123456',
            '13S0A138G'
        );
    }

    private function getResponseFixture($filename)
    {
        return file_get_contents(
            sprintf(
                './tests/Fixtures/Responses/%s',
                $filename
            )
        );
    }

    public function errorResponseProvider()
    {
        $errors = [];
        foreach (ResponseExceptionFactory::$messages as $code => $message) {
            $errors[] = [$code, $message];
        }

        return $errors;
    }

    /**
     * @dataProvider errorResponseProvider
     * @expectedException \Jedkirby\ValPal\Exception\ResponseException
     */
    public function testErrorResponseHandling($code, $message)
    {
        $body = $this->getResponseFixture(
            sprintf(
                'Errors/%s.xml',
                $code
            )
        );

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($body)
        );

        try {
            $client->getLettingValuation(
                $this->getValuationRequest()
            );
        } catch (ResponseException $e) {
            $this->assertEquals($e->getCode(), $code);
            $this->assertEquals($e->getMessage(), $message);
            throw $e;
        }
    }

    /**
     * @expectedException \Jedkirby\ValPal\Exception\ResponseException
     */
    public function testExceptionErrorHandling()
    {
        $httpClient = Mockery::mock(HttpClient::class);
        $httpClient
            ->shouldReceive('request')
            ->andThrow(Mockery::mock(ClientException::class))
            ->once();

        $client = new Client(
            $this->getConfig(),
            $httpClient
        );

        $client->getLettingValuation(
            $this->getValuationRequest()
        );
    }

    /**
     * @expectedException \Jedkirby\ValPal\Exception\ResponseException
     */
    public function testInvalidXmlErrorHandling()
    {
        $body = $this->getResponseFixture('Invalid/pound.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($body)
        );

        try {
            $client->getLettingValuation(
                $this->getValuationRequest()
            );
        } catch (ResponseException $e) {
            $this->assertEquals($e->getMessage(), 'String could not be parsed as XML');
            throw $e;
        }
    }

    public function testSuccessForLettingsType()
    {
        $body = $this->getResponseFixture('Successful/lettings.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($body)
        );

        $valuation = $client->getLettingValuation(
            $this->getValuationRequest()
        );

        $this->assertInstanceOf(LettingValuation::class, $valuation);
        $this->assertEquals($valuation->getType(), 'letting');
        $this->assertEquals($valuation->getMinValuation(), '£150000');
        $this->assertEquals($valuation->getValuation(), '£200000');
        $this->assertEquals($valuation->getMaxValuation(), '£300000');
        $this->assertEquals($valuation->getPropertyType(), 'Flat');
        $this->assertEquals($valuation->getTenure(), 'Leasehold');
        $this->assertEquals($valuation->getBedrooms(), 1);
        $this->assertEquals($valuation->getPropertyConstructionYear(), 1973);
        $this->assertNull($valuation->getMinRentalValuation());
        $this->assertNull($valuation->getRentalValuation());
        $this->assertNull($valuation->getMaxRentalValuation());
        $this->assertTrue($valuation->isLetting());
        $this->assertFalse($valuation->isSales());
        $this->assertFalse($valuation->isLettingAndSales());
    }

    public function testSuccessForSalesType()
    {
        $body = $this->getResponseFixture('Successful/sales.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($body)
        );

        $valuation = $client->getSalesValuation(
            $this->getValuationRequest()
        );

        $this->assertInstanceOf(SalesValuation::class, $valuation);
        $this->assertEquals($valuation->getType(), 'sales');
        $this->assertEquals($valuation->getMinValuation(), '£120000');
        $this->assertEquals($valuation->getValuation(), '£190000');
        $this->assertEquals($valuation->getMaxValuation(), '£230000');
        $this->assertEquals($valuation->getPropertyType(), 'Apartment');
        $this->assertEquals($valuation->getTenure(), 'Freehold');
        $this->assertEquals($valuation->getBedrooms(), 3);
        $this->assertEquals($valuation->getPropertyConstructionYear(), 2001);
        $this->assertNull($valuation->getMinRentalValuation());
        $this->assertNull($valuation->getRentalValuation());
        $this->assertNull($valuation->getMaxRentalValuation());
        $this->assertFalse($valuation->isLetting());
        $this->assertTrue($valuation->isSales());
        $this->assertFalse($valuation->isLettingAndSales());
    }

    public function testSuccessForBothType()
    {
        $body = $this->getResponseFixture('Successful/both.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($body)
        );

        $valuation = $client->getBothValuations(
            $this->getValuationRequest()
        );

        $this->assertInstanceOf(BothValuation::class, $valuation);
        $this->assertEquals($valuation->getType(), 'both');
        $this->assertEquals($valuation->getMinValuation(), '£130000');
        $this->assertEquals($valuation->getValuation(), '£187500');
        $this->assertEquals($valuation->getMaxValuation(), '£256800');
        $this->assertEquals($valuation->getPropertyType(), 'Flat');
        $this->assertEquals($valuation->getTenure(), 'Leasehold');
        $this->assertEquals($valuation->getBedrooms(), 2);
        $this->assertEquals($valuation->getPropertyConstructionYear(), 1988);
        $this->assertEquals($valuation->getMinRentalValuation(), '£400');
        $this->assertEquals($valuation->getRentalValuation(), '£500');
        $this->assertEquals($valuation->getMaxRentalValuation(), '£600');
        $this->assertFalse($valuation->isLetting());
        $this->assertFalse($valuation->isSales());
        $this->assertTrue($valuation->isLettingAndSales());
    }

    public function testVerifyFormParamsAreCorrect()
    {
        $body = $this->getResponseFixture('Successful/both.xml');

        $stream = Mockery::mock(
            Stream::class,
            [
                'getBody' => $body,
            ]
        );

        $httpClient = Mockery::mock(HttpClient::class);
        $httpClient
            ->shouldReceive('request')
            ->with(
                'POST',
                'https://www.valpal.co.uk/api',
                [
                    'debug' => false,
                    'form_params' => [
                        'username' => 'joe.bloggs',
                        'pass' => '1a2b3c4d5e6f',
                        'type' => 'sales',
                        'reference' => '13S0A138G',
                        'buildname' => 'Building Name',
                        'subBname' => 'Sub-Building Name',
                        'number' => '2',
                        'street' => 'Street',
                        'depstreet' => 'Dependent Street',
                        'postcode' => 'A12 3BC',
                        'emailaddress' => 'joe@email.com',
                        'name' => 'Joe Bloggs',
                        'phone' => '01789123456',
                    ],
                ]
            )
            ->andReturn($stream)
            ->once();

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($body)
        );

        $client->getBothValuations(
            $this->getValuationRequest()
        );
    }
}
