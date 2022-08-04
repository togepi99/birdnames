<?php

namespace App\Controller;

use App\Repository\BirdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BirdController extends AbstractController
{
    #[Route('/', name: 'bird_index')]
    public function index(BirdRepository $birdRepository): Response
    {
        return $this->render('bird/index.html.twig', [
            'birds' => $birdRepository->findAll(),
        ]);
    }

    #[Route('/{birdSlug}', name: 'bird')]
    public function bird(string $birdSlug, Request $request, BirdRepository $birdRepository): Response
    {
        $bird = $birdRepository->findOneBy([ 'oldNameSlugged' => $birdSlug ]);
        if (!$bird)
            throw $this->createNotFoundException();

        return $this->render('bird/bird.html.twig', [
            'bird' => $bird,
        ]);
    }
}
