<?php
/**
 * RegistrationType tests.
 */

namespace Form;

use App\Entity\User;
use App\Form\Type\RegistrationType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class RegistrationTypeTest.
 */
class RegistrationTypeTest extends TypeTestCase
{
    public function testRegistrationType(): void
    {
        $infoForForm =
            [
                'email' => 'newEmail',
                'nickname' => 'newNickname',
                'password' => 'newPassword'
            ];

        $newObject = new User();
        $newObject->setEmail($infoForForm['email']);
        $newObject->setNickname($infoForForm['nickname']);
        $newObject->setPassword($infoForForm['password']);

        $form = $this->factory->create(RegistrationType::class, $newObject);
        $form->submit($infoForForm);

        $this->assertTrue($form->isSynchronized());
    }
}
