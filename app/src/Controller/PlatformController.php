<?php
/**
 * Platform controller.
 */

namespace App\Controller;

use App\Entity\Platform;
use App\Form\Type\PlatformType;
use App\Service\PlatformServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class PlatformController.
 */
#[Route('/platform')]
class PlatformController extends AbstractController
{
    /**
     * Platform service.
     */
    private PlatformServiceInterface $platformService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param PlatformServiceInterface $platformService
     * @param TranslatorInterface      $translator
     */
    public function __construct(PlatformServiceInterface $platformService, TranslatorInterface $translator)
    {
        $this->platformService = $platformService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'platform_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->platformService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('platform/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Platform $platform Platform
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'platform_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Platform $platform): Response
    {
        return $this->render('platform/show.html.twig', ['platform' => $platform]);
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route(
        '/create',
        name: 'platform_create',
        methods: 'GET|POST',
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request): Response
    {
        $platform = new Platform();
        $form = $this->createForm(PlatformType::class, $platform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->platformService->save($platform);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('platform_index');
        }

        return $this->render(
            'platform/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Platform $platform Platform entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'platform_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Platform $platform): Response
    {
        $form = $this->createForm(
            PlatformType::class,
            $platform,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('platform_edit', ['id' => $platform->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->platformService->save($platform);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('platform_index');
        }

        return $this->render(
            'platform/edit.html.twig',
            [
                'form' => $form->createView(),
                'platform' => $platform,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Platform $platform Platform entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'platform_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Platform $platform): Response
    {
        if (!$this->platformService->canBeDeleted($platform)) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.platform_contains_games')
            );

            return $this->redirectToRoute('platform_index');
        }

        $form = $this->createForm(
            FormType::class,
            $platform,
            [
                'method' => 'DELETE',
                'action' => $this->generateUrl('platform_delete', ['id' => $platform->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->platformService->delete($platform);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('platform_index');
        }

        return $this->render(
            'platform/delete.html.twig',
            [
                'form' => $form->createView(),
                'platform' => $platform,
            ]
        );
    }
}
