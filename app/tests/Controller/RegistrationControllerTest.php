<?php
/**
 * Registration controller tests.
 */

namespace Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AlbumControllerTest.
 */
class RegistrationControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/register';

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
        $createEntityName = 'example@example.com';

        $crawler = $this->httpClient->request('GET', self::TEST_ROUTE);
        $form = $crawler->selectButton('Zarejestruj się')->form();

        $form['register[email]'] = 'example@example.com';
        $form['register[nickname]'] = 'register';
        $form['register[password]'] = 'password';

        $this->httpClient->submit($form);
        $entityRepository = static::getContainer()->get(UserRepository::class);

        $savedEntity = $entityRepository->findOneByEmail($createEntityName);

        $this->assertEquals($createEntityName, $savedEntity->getEmail());

        $result = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals($expectedCode, $result);
    }
}
