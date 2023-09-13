<?php
/**
 * Categories controller tests.
 */

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Entity\Studio;
use App\Entity\User;
use App\Repository\GameRepository;
use App\Repository\StudioRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
    public const TEST_ROUTE = '/categories';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test index route.
     */
    public function testStudioRoute(): void
    {
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
