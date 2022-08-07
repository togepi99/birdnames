<?php

namespace App\Controller;

use App\Entity\Bird;
use App\File\ImageUploader;
use App\Form\BirdType;
use App\Repository\BirdRepository;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/birds')]
class BirdAdminController extends AbstractController
{
    #[Route('/', name: 'app_bird_admin_index', methods: ['GET'])]
    public function index(BirdRepository $birdRepository): Response
    {
        return $this->render('admin/birds/index.html.twig', [
            'birds' => $birdRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_bird_admin_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BirdRepository $birdRepository): Response
    {
        $bird = new Bird();
        $form = $this->createForm(BirdType::class, $bird);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $birdRepository->add($bird, true);

            return $this->redirectToRoute('app_bird_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/birds/new.html.twig', [
            'bird' => $bird,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bird_admin_show', methods: ['GET'])]
    public function show(Bird $bird): Response
    {
        return $this->render('admin/birds/show.html.twig', [
            'bird' => $bird,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_bird_admin_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Bird $bird, BirdRepository $birdRepository, ImageRepository $imageRepository, ImageUploader $imageUploader): Response
    {
        $form = $this->createForm(BirdType::class, $bird);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newFile = $form->get('new_image')->get('file')->getData();
            if ($newFile) {
                $image = $form->get('new_image')->getData();
                $imageUploader->prepareFileAndSetOnImage($newFile, $image);
                $bird->addImage($image);
            }

            foreach ($form->get('images')->all() as $deleteFormItem) {
                if ($deleteFormItem->get('shouldDelete')->getData()) {
                    $image = $deleteFormItem->getData();
                    $bird->removeImage($image);
                    $imageRepository->remove($image);
                }
            }

            $birdRepository->add($bird, true);

            return $this->redirectToRoute('app_bird_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/birds/edit.html.twig', [
            'bird' => $bird,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_bird_admin_delete', methods: ['POST'])]
    public function delete(Request $request, Bird $bird, BirdRepository $birdRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $bird->getId(), $request->request->get('_token'))) {
            $birdRepository->remove($bird, true);
        }

        return $this->redirectToRoute('app_bird_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
