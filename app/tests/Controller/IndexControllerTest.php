<?php
/**
 * IndexController tests.
 */

namespace Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class IndexControllerTest.
 */
class IndexControllerTest extends WebTestCase
{
    /**
     * Test index route.
     */
    public function testIndexRoute(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $resultHttpStatusCode = $client->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
