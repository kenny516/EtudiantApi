<?php

namespace App\Controller;

use App\Entity\Semestre;
use App\Form\SemestreType;
use App\Repository\SemestreRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use SemestreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/semestre')]
final class SemestreController extends AbstractController
{
    #[Route(name: 'app_semestre_index', methods: ['GET'])]
    public function index(SemestreRepository $semestreRepository): Response
    {
        return $this->render('semestre/index.html.twig', [
            'semestres' => $semestreRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_semestre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $semestre = new Semestre();
        $form = $this->createForm(SemestreType::class, $semestre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($semestre);
            $entityManager->flush();

            return $this->redirectToRoute('app_semestre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('semestre/new.html.twig', [
            'semestre' => $semestre,
            'form' => $form,
        ]);
    }

    #[Route('/semestres', name: 'app_Rest_semestre_show', methods: ['GET'])]
    public function semestreDetail(SemestreRepository $semestreRepository): JsonResponse
    {
        // Assurez-vous de passer un entier valide à la méthode
        $etudiantId = 27757;
        $result = $semestreRepository->findEtudiantNotes($etudiantId);
        return new JsonResponse($result);
    }

    #[Route('/{id}', name: 'app_semestre_show', methods: ['GET'])]
    public function show(Semestre $semestre): Response
    {
        return $this->render('semestre/show.html.twig', [
            'semestre' => $semestre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_semestre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Semestre $semestre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SemestreType::class, $semestre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_semestre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('semestre/edit.html.twig', [
            'semestre' => $semestre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_semestre_delete', methods: ['POST'])]
    public function delete(Request $request, Semestre $semestre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $semestre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($semestre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_semestre_index', [], Response::HTTP_SEE_OTHER);
    }
}
