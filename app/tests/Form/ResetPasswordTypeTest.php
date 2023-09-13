<?php
/**
 * ResetPasswordType tests.
 */

namespace Form;

use App\Entity\User;
use App\Form\Type\ResetPasswordType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class ResetPasswordTypeTest.
 */
class ResetPasswordTypeTest extends TypeTestCase
{
    /**
     * Test for ResetPasswordType.
     *
     * @return void
     */
    public function testResetPasswordType(): void
    {
        $infoForForm =
            [
                'oldPassword' => 'oldPass',
                'newPassword' => 'newPass',
            ];

        $newObject = new User();
        $newObject->setEmail('email');
        $newObject->setNickname('nickname');
        $newObject->setPassword($infoForForm['newPassword']);

        $form = $this->factory->create(ResetPasswordType::class);
        $form->submit($infoForForm);

        $this->assertTrue($form->isSynchronized());
    }
}
