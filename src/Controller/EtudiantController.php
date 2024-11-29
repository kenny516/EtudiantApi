<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use App\Utils\ResponseFormat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/etudiant')]
final class EtudiantController extends AbstractController
{
    #[Route(name: 'app_etudiant_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_etudiant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    /// rest api
    #[Route('/etudiants', name: "app_Rest_etudiant_show_all", methods: ["GET"])]
    public function getAllEtudiant(EtudiantRepository $etudiantRepository, Request $request): JsonResponse
    {
        $page = (int)$request->query->get('page', 1);
        $limit = (int)$request->query->get('limit', 10);
        $offset = ($page - 1) * $limit;
        $etudiants = $etudiantRepository->findBy([], [], $limit, $offset);
        $total = $etudiantRepository->count([]);
        $data = array_map(function ($etudiant) {
            return [
                'id' => $etudiant->getId(),
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
            ];
        }, $etudiants);
        $meta = [
            'pagination' => [
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'total_pages' => ceil($total / $limit),
            ]
        ];
        $response = (new ResponseFormat())->createApiResponse($data, 200, null, $meta);
        return $response;
    }
    #[Route('/etudiants/{id}', name: "app_Rest_etudiant_show", methods: ["GET"])]
    public function getById(int $id, EtudiantRepository $etudiantRepository): JsonResponse
    {
        // Récupérer l'étudiant par ID
        $etudiant = $etudiantRepository->find($id);

        // Vérifier si l'étudiant existe
        if (!$etudiant) {
            // Retourner une réponse d'erreur si l'étudiant n'existe pas
            return (new ResponseFormat())->createApiResponse(
                null,
                404,
                'Etudiant non trouvé',
                null
            );
        }

        // Si l'étudiant existe, retourner les données de l'étudiant
        $data = [
            'id' => $etudiant->getId(),
            'nom' => $etudiant->getNom(),
            'prenom' => $etudiant->getPrenom(),
        ];

        return (new ResponseFormat())->createApiResponse($data, 200, null, null);
    }


    #[Route('/{id}', name: 'app_etudiant_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('etudiant/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etudiant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('etudiant/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etudiant_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $etudiant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_etudiant_index', [], Response::HTTP_SEE_OTHER);
    }


}
