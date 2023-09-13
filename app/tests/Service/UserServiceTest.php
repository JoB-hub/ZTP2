<?php

namespace App\Tests\Service;

use App\Service\UserService;
use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private UserRepository $userRepository;
    private PaginatorInterface $paginator;
    private UserService $userService;

    public function setUp(): void
    {
        // Create mock instances of UserRepository and PaginatorInterface
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->paginator = $this->createMock(PaginatorInterface::class);

        // Create an instance of UserService with the mock dependencies
        $this->userService = new UserService($this->userRepository, $this->paginator);
    }

    public function testGetPaginatedList(): void
    {
        // Create a mock for PaginationInterface
        $pagination = $this->createMock(PaginationInterface::class);

        // Define expected parameters and return value for paginator->paginate()
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

        // Call the getPaginatedList method and assert the returned value
        $result = $this->userService->getPaginatedList($page);
        $this->assertSame($pagination, $result);
    }

    public function testChangePassword(): void
    {
        // Create a mock User entity
        $user = $this->createMock(User::class);

        // Define expected method call to userRepository->changePassword()
        $password = 'new_password';
        $this->userRepository->expects($this->once())
            ->method('changePassword')
            ->with($user, $password);

        // Call the changePassword method and assert no exceptions are thrown
        $this->userService->changePassword($user, $password);
    }

    public function testSave(): void
    {
        // Create a mock User entity
        $user = $this->createMock(User::class);

        // Define expected method call to userRepository->save()
        $this->userRepository->expects($this->once())
            ->method('save')
            ->with($user);

        // Call the save method and assert no exceptions are thrown
        $this->userService->save($user);
    }

    // You can add more test methods for other functions as needed.
}
