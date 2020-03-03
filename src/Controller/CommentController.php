<?php

namespace App\Controller;

use App\Repository\CommentRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class CommentController extends AbstractController
{
    private $CommentRepository;

    public function __construct(CommentRepository $CommentRepository)
    {
        $this->commentRepository = $CommentRepository;
    }
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        $comment = $this->commentRepository->findAll();

        return $this->render('comment/index.html.twig', [
            'comment' => $comment
        ]);
    }
}
