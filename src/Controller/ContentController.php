<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use App\Form\ContentType;
use App\Entity\Content;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContentController extends AbstractController
{
    private $ContentRepository;

    public function __construct(ContentRepository $ContentRepository)
    {
        $this->contentRepository = $ContentRepository;
    }
    /**
     * @Route("/content", name="content")
     */
    public function index()
    {
        $content = $this->contentRepository->findAll();

        return $this->render('content/index.html.twig', [
            'content' => $content
        ]);
    }
    /**
     * @Route("/new_content", name="new_content")
     * 
     */
    public function createContentAction(Request $request)
    {
        $content = new Content();
        $form = $this->createForm(ContentType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($content);

            $entityManager->flush();
            $this->addFlash('notice', "Le contenu a bien été créé");

            return $this->redirectToRoute('content');

        }
        return $this->render('content/new_content.html.twig', [
            'contentForm' => $form->createView(),
        ]);
    }

}
