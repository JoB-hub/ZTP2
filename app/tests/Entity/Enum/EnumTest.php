<?php
/**
 * User role test.
 */

namespace Entity\Enum;

use App\Entity\Enum\UserRole;
use PHPUnit\Framework\TestCase;

/**
 * User role test.
 */
class EnumTest extends TestCase
{
    /**
     * Test for users role.
     *
     * @return void
     */
    public function testRole()
    {
        self::assertEquals('label.role_user', UserRole::ROLE_USER->label());
        self::assertEquals('label.role_admin', UserRole::ROLE_ADMIN->label());
    }
}
