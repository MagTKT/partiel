<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Form\CommentType;
use App\Entity\Comment;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


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
    /**
     * @Route("/new_comment", name="new_comment")
     * 
     */
    public function createCommentAction(Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->persist($comment);

            $entityManager->flush();
            $this->addFlash('notice', "Le commentaire à bien été créé");

            return $this->redirectToRoute('comment');

        }
        return $this->render('comment/new_comment.html.twig', [
            'commentForm' => $form->createView(),
        ]);
    }
}
