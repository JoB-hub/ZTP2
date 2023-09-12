<?php
/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ResetPasswordType;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class UserController.
 */
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * User service.
     */
    private UserServiceInterface $userService;

    /**
     * Constructor.
     */
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'user_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->userService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('user/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param User $user User
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'user_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * Reset password action.
     *
     * @param User $user User
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}/reset_password',
        name: 'user_reset',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET|POST'
    )]
    public function resetPassword(User $user, Request $request, TranslatorInterface $translator, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPassword = $form->get('oldPassword')->getData();
            if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash('incorrect', $translator->trans('message.wrong_old_password'));
                return $this->redirectToRoute('user_index');
            }
            $hashedPassword = $passwordHasher->hashPassword($user, $form->get('newPassword')->getData());
            $this->userService->changePassword($user, $hashedPassword);
            $this->addFlash(
                'success',
                $translator->trans('message.edited_successfully')
            );
            return $this->redirectToRoute('user_index');
        }
        return $this->render('user/change_password.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
