<?php

namespace Jedkirby\ValPal\Tests\Exception;

use Jedkirby\ValPal\Exception\ResponseExceptionFactory;
use Jedkirby\ValPal\Tests\AbstractTestCase;

/**
 * @group exception
 * @group exception.response
 * @group exception.response.factory
 */
class ResponseExceptionFactoryTest extends AbstractTestCase
{
    /**
     * @expectedException \Jedkirby\ValPal\Exception\ResponseException
     * @expectedExceptionMessage Unable to process valuation
     */
    public function testThrowsGenericException()
    {
        throw ResponseExceptionFactory::make(null);
    }

    public function testCanGetListOfMessages()
    {
        $this->assertInternalType(
            'array',
            ResponseExceptionFactory::getMessages()
        );
    }
}
