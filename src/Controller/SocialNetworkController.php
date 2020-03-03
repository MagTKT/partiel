<?php

namespace App\Controller;

use App\Repository\SocialNetworkRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SocialNetworkController extends AbstractController
{
    private $SocialNetworkRepository;

    public function __construct(SocialNetworkRepository $SocialNetworkRepository)
    {
        $this->SocialNetworkRepository = $SocialNetworkRepository;
    }
    /**
     * @Route("/social/network", name="social_network")
     */
    public function index()
    {
        $socialNetwork = $this->SocialNetworkRepository->findAll();

        return $this->render('social_network/index.html.twig', [
            'socialNetwork' => $socialNetwork
        ]);
    }
}
