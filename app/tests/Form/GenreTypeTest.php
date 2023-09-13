<?php
/**
 * GenreType tests.
 */

namespace Form;

use App\Entity\Genre;
use App\Form\Type\GenreType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class GenreTypeTest.
 */
class GenreTypeTest extends TypeTestCase
{
    public function testGenreType(): void
    {
        $infoForForm =
            [
                'name' => 'newGenreName',
                'description' => 'Lorem ipsum dolor.'
            ];

        $newObject = new Genre();
        $form = $this->factory->create(GenreType::class, $newObject);
        $expected = new Genre();
        $expected->setName($infoForForm['name']);
        $expected->setDescription($infoForForm['description']);
        $form->submit($infoForForm);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $newObject);
        $this->assertEquals($expected->getId(), $newObject->getId());
    }
}
