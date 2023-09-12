<?php
/**
 * Studio controller.
 */

namespace App\Controller;

use App\Entity\Studio;
use App\Form\Type\StudioType;
use App\Service\StudioServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class StudioController.
 */
#[Route('/studio')]
class StudioController extends AbstractController
{
    /**
     * Studio service.
     */
    private StudioServiceInterface $studioService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param StudioServiceInterface $studioService Studio service
     * @param TranslatorInterface    $translator    Translator
     */
    public function __construct(StudioServiceInterface $studioService, TranslatorInterface $translator)
    {
        $this->studioService = $studioService;
        $this->translator = $translator;
    }


    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'studio_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->studioService->getPaginatedList(
            $request->query->getInt('page', 1)
        );

        return $this->render('studio/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Studio $studio Studio
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'studio_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    public function show(Studio $studio): Response
    {
        return $this->render('studio/show.html.twig', ['studio' => $studio]);
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
        name: 'studio_create',
        methods: 'GET|POST',
    )]
    public function create(Request $request): Response
    {
        $studio = new Studio();
        $form = $this->createForm(StudioType::class, $studio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studioService->save($studio);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('studio_index');
        }

        return $this->render(
            'studio/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Studio  $studio  Studio entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'studio_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Studio $studio): Response
    {
        $form = $this->createForm(
            StudioType::class,
            $studio,
            [
                'method' => 'PUT',
                'action' => $this->generateUrl('studio_edit', ['id' => $studio->getId()]),
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studioService->save($studio);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('studio_index');
        }

        return $this->render(
            'studio/edit.html.twig',
            [
                'form' => $form->createView(),
                'studio' => $studio,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Studio  $studio  Studio entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/delete', name: 'studio_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Studio $studio): Response
    {
        $form = $this->createForm(FormType::class, $studio, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('studio_delete', ['id' => $studio->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->studioService->delete($studio);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('studio_index');
        }

        return $this->render(
            'studio/delete.html.twig',
            [
                'form' => $form->createView(),
                'studio' => $studio,
            ]
        );
    }
}
