<?php
/**
 * Games controller tests.
 */

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GameControllerTest.
 */
class GameControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/game';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test game index route.
     */
    public function testGameIndexRoute(): void
    {
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
