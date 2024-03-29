<?php
/**
 * Studios controller tests.
 */

namespace Controller;

use App\Entity\Studio;
use App\Repository\StudioRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class StudioControllerTest.
 */
class StudioControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/studio';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test studio index route.
     */
    public function testStudioIndexRoute(): void
    {
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }

    /**
     * Test studio show route.
     *
     */
    public function testStudioShowRoute(): void
    {
        $newStudio = new Studio();
        $newStudio->setName('newStudio');
        $studioRepository = static::getContainer()->get(StudioRepository::class);

        $studioRepository->save($newStudio);

        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$newStudio->getId());
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
