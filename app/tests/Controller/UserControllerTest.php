<?php
/**
 * Users controller tests.
 */

namespace Controller;

use App\Entity\User;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest.
 */
class UserControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/user';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test user index route.
     */
    public function testUserIndexRoute(): void
    {
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }

    /**
     * Test user show route.
     *
     */
    public function testUserShowRoute(): void
    {
        $newUser = new User();
        $newUser->setEmail('newUser@mail.com');
        $newUser->setNickname('newUser');
        $newUser->setRoles(['ADMIN']);
        $newUser->setPassword('newUser');
        $userRepository = static::getContainer()->get(UserRepository::class);

        $userRepository->save($newUser);

        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$newUser->getId());
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }
}
