<?php
/**
 * User controller tests.
 */

namespace Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\OptimisticLockException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GameControllerTest.
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/login';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test register route.
     */
    public function testRegisterRoute(): void
    {
        $expectedCode = 302;
        $testUser = null;
        try {
            $testUser = $this->createUser(['ROLE_USER'], 'xyz@example.com', 'xyz');
        } catch (OptimisticLockException|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        }

        $crawler = $this->httpClient->request('GET', self::TEST_ROUTE);
        $form = $crawler->selectButton('Zaloguj')->form();

        $form['email'] = 'example@example.com';
        $form['password'] = 'user1234';


        $this->httpClient->submit($form);

        $result = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals($expectedCode, $result);
    }

    /**
     * Test logout route.
     */
    public function testLogoutRoute(): void
    {
        $expectedCode = 302;
        $testUser = null;
        try {
            $testUser = $this->createUser(['ROLE_USER'], 'xrt@example.com', 'pqo');
        } catch (OptimisticLockException|NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        }

        $this->httpClient->loginUser($testUser);
        $this->httpClient->request('GET', '/logout');

        $result = $this->httpClient->getResponse()->getStatusCode();
        $this->assertEquals($expectedCode, $result);
    }

    /**
     * Create user.
     *
     * @param array $roles User roles
     *
     * @return User User entity
     *
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|OptimisticLockException
     */
    protected function createUser(array $roles, string $email, string $nickname): User
    {
        $passwordHasher = static::getContainer()->get('security.password_hasher');
        $user = new User();
        $user->setNickname($nickname);
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword($passwordHasher->hashPassword($user, 'user1234'));
        $userRepository = static::getContainer()->get(UserRepository::class);
        $userRepository->save($user);

        return $user;
    }
}
