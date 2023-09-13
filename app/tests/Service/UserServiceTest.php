<?php
/**
 * User service tests.
 */

namespace Service;

use App\Service\UserService;
use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * UserServiceTest class.
 */
class UserServiceTest extends TestCase
{
    private UserRepository $userRepository;
    private PaginatorInterface $paginator;
    private UserService $userService;

    /**
     * Set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);

        $this->userService = new UserService($this->userRepository, $this->paginator);
    }

    /**
     * Test paginated list.
     *
     * @return void
     */
    public function testGetPaginatedList(): void
    {
        $pagination = $this->createMock(PaginationInterface::class);

        $page = 1;
        $itemsPerPage = UserRepository::PAGINATOR_ITEMS_PER_PAGE;
        $this->paginator->expects($this->once())
            ->method('paginate')
            ->with(
                $this->userRepository->queryAll(),
                $page,
                $itemsPerPage
            )
            ->willReturn($pagination);

        $result = $this->userService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    /**
     * Test password change.
     *
     * @return void
     */
    public function testChangePassword(): void
    {
        $user = $this->createMock(User::class);

        $password = 'new_password';
        $this->userRepository->expects($this->once())
            ->method('changePassword')
            ->with($user, $password);

        $this->userService->changePassword($user, $password);
    }

    /**
     * Test save user.
     *
     * @return void
     */
    public function testSave(): void
    {
        $user = $this->createMock(User::class);

        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($user);

        $this->userService->save($user);
    }
}
