<?php
/**
 * StudioType tests.
 */

namespace Form;

use App\Entity\Studio;
use App\Form\Type\StudioType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class StudioTypeTest.
 */
class StudioTypeTest extends TypeTestCase
{
    public function testStudioType(): void
    {
        $infoForForm =
            [
                'name' => 'newStudioName',
            ];

        $newObject = new Studio();
        $form = $this->factory->create(StudioType::class, $newObject);
        $expected = new Studio();
        $expected->setName($infoForForm['name']);
        $form->submit($infoForForm);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $newObject);
        $this->assertEquals($expected->getId(), $newObject->getId());
    }
}
