<?php
/**
 * Genres controller tests.
 */

namespace Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class GenreControllerTest.
 */
class GenreControllerTest extends WebTestCase
{
    /**
     * Test route.
     *
     * @const string
     */
    public const TEST_ROUTE = '/genre';

    /**
     * Set up tests.
     */
    public function setUp(): void
    {
        $this->httpClient = static::createClient();
    }

    /**
     * Test genre index route.
     */
    public function testGenreIndexRoute(): void
    {
        $this->httpClient->request('GET', self::TEST_ROUTE);
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }

    /**
     * Test genre show route.
     *
     */
    public function testGenreShowRoute(): void
    {
        $newGenre = new Genre();
        $newGenre->setName('newGenre');
        $newGenre->setDescription('newGenre');
        $genreRepository = static::getContainer()->get(GenreRepository::class);

        $genreRepository->save($newGenre);

        $this->httpClient->request('GET', self::TEST_ROUTE.'/'.$newGenre->getId());
        $resultHttpStatusCode = $this->httpClient->getResponse()->getStatusCode();

        $this->assertEquals(200, $resultHttpStatusCode);
    }

}
