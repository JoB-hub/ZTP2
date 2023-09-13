<?php
/**
 * PlatformType tests.
 */

namespace Form;

use App\Entity\Platform;
use App\Form\Type\PlatformType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class PlatformTypeTest.
 */
class PlatformTypeTest extends TypeTestCase
{
    /**
     * Test for PlatformType.
     *
     * @return void
     */
    public function testPlatformType(): void
    {
        $infoForForm =
            [
                'name' => 'newPlatformName',
            ];

        $newObject = new Platform();
        $form = $this->factory->create(PlatformType::class, $newObject);
        $expected = new Platform();
        $expected->setName($infoForForm['name']);
        $form->submit($infoForForm);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $newObject);
        $this->assertEquals($expected->getId(), $newObject->getId());
    }
}
