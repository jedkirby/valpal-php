<?php

namespace Jedkirby\ValPal\Tests;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
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

    private function getHttpClient($stream, $code = 200)
    {
        return Mockery::mock(
            HttpClient::class,
            [
                'request' => Mockery::mock(
                    Response::class,
                    [
                        'getBody' => new Stream($stream),
                        'getStatusCode' => $code,
                    ]
                ),
            ]
        );
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

    private function getResponseFixtureStream($filename)
    {
        return fopen(
            sprintf(
                './tests/Fixtures/Responses/%s',
                $filename
            ),
            'r'
        );
    }

    public function errorResponseProvider()
    {
        $errors = [];
        foreach (ResponseExceptionFactory::getMessages() as $code => $message) {
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
        $stream = $this->getResponseFixtureStream(
            sprintf(
                'Errors/%s.xml',
                $code
            )
        );

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($stream)
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
     * @expectedExceptionMessage Unable to process valuation
     */
    public function testEmptyResponseHandling()
    {
        $stream = $this->getResponseFixtureStream('Invalid/empty.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($stream)
        );

        $client->getLettingValuation(
            $this->getValuationRequest()
        );
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
     * @expectedExceptionMessage String could not be parsed as XML
     */
    public function testInvalidXmlErrorHandling()
    {
        $stream = $this->getResponseFixtureStream('Invalid/pound.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($stream)
        );

        $client->getLettingValuation(
            $this->getValuationRequest()
        );
    }

    public function guzzleResponseErrorCodes()
    {
        return [
            [100, 'Continue'],
            [101, 'Switching Protocols'],
            [102, 'Processing'],
            [201, 'Created'],
            [202, 'Accepted'],
            [203, 'Non-Authoritative Information'],
            [204, 'No Content'],
            [205, 'Reset Content'],
            [206, 'Partial Content'],
            [207, 'Multi-status'],
            [208, 'Already Reported'],
            [300, 'Multiple Choices'],
            [301, 'Moved Permanently'],
            [302, 'Found'],
            [303, 'See Other'],
            [304, 'Not Modified'],
            [305, 'Use Proxy'],
            [306, 'Switch Proxy'],
            [307, 'Temporary Redirect'],
            [400, 'Bad Request'],
            [401, 'Unauthorized'],
            [402, 'Payment Required'],
            [403, 'Forbidden'],
            [404, 'Not Found'],
            [405, 'Method Not Allowed'],
            [406, 'Not Acceptable'],
            [407, 'Proxy Authentication Required'],
            [408, 'Request Time-out'],
            [409, 'Conflict'],
            [410, 'Gone'],
            [411, 'Length Required'],
            [412, 'Precondition Failed'],
            [413, 'Request Entity Too Large'],
            [414, 'Request-URI Too Large'],
            [415, 'Unsupported Media Type'],
            [416, 'Requested range not satisfiable'],
            [417, 'Expectation Failed'],
            [418, 'I\'m a teapot'],
            [422, 'Unprocessable Entity'],
            [423, 'Locked'],
            [424, 'Failed Dependency'],
            [425, 'Unordered Collection'],
            [426, 'Upgrade Required'],
            [428, 'Precondition Required'],
            [429, 'Too Many Requests'],
            [431, 'Request Header Fields Too Large'],
            [451, 'Unavailable For Legal Reasons'],
            [500, 'Internal Server Error'],
            [501, 'Not Implemented'],
            [502, 'Bad Gateway'],
            [503, 'Service Unavailable'],
            [504, 'Gateway Time-out'],
            [505, 'HTTP Version not supported'],
            [506, 'Variant Also Negotiates'],
            [507, 'Insufficient Storage'],
            [508, 'Loop Detected'],
            [511, 'Network Authentication Required'],
        ];
    }

    /**
     * @dataProvider guzzleResponseErrorCodes
     * @expectedException \Jedkirby\ValPal\Exception\ResponseException
     */
    public function testGuzzleResponseErrorCodesConvertToExceptions($code, $message)
    {
        $httpClient = Mockery::mock(HttpClient::class);
        $httpClient
            ->shouldReceive('request')
            ->andReturn(
                new Response($code)
            )
            ->once();

        $client = new Client(
            $this->getConfig(),
            $httpClient
        );

        try {
            $client->getBothValuations(
                $this->getValuationRequest()
            );
        } catch (ResponseException $e) {
            $this->assertEquals($e->getCode(), $code);
            $this->assertEquals($e->getMessage(), $message);
            throw $e;
        }
    }

    public function testSuccessForLettingsType()
    {
        $stream = $this->getResponseFixtureStream('Successful/lettings.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($stream)
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
        $stream = $this->getResponseFixtureStream('Successful/sales.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($stream)
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
        $stream = $this->getResponseFixtureStream('Successful/both.xml');

        $client = new Client(
            $this->getConfig(),
            $this->getHttpClient($stream)
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
        $stream = $this->getResponseFixtureStream('Successful/both.xml');

        $response = Mockery::mock(
            Response::class,
            [
                'getBody' => new Stream($stream),
                'getStatusCode' => 200,
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
                        'type' => 'both',
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
            ->andReturn($response)
            ->once();

        $client = new Client(
            $this->getConfig(),
            $httpClient
        );

        $client->getBothValuations(
            $this->getValuationRequest()
        );
    }
}
