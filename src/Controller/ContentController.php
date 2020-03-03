<?php

namespace App\Controller;

use App\Repository\ContentRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
}
