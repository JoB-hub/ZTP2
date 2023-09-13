<?php
/**
 * Platforms controller tests.
 */

namespace Controller;

use App\Entity\Platform;
use App\Repository\PlatformRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class PlatformControllerTest.
 */
class PlatformControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/platform';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test platform index route.
     */
    public function testPlatformIndexRoute(): void
    {
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }

    /**
     * Test platform show route.
     *
     */
    public function testPlatformShowRoute(): void
    {
        $newPlatform = new Platform();
        $newPlatform->setName('newPlatform');
        $platformRepository = static::getContainer()->get(PlatformRepository::class);

        $platformRepository->save($newPlatform);

        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$newPlatform->getId());
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
