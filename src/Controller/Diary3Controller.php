<?php

namespace App\Controller;

use App\Entity\Diary3;
use App\Form\Diary3Type;
use App\Repository\Diary3Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/diary3')]
class Diary3Controller extends AbstractController
{
    #[Route('/', name: 'app_diary3_index', methods: ['GET'])]
    public function index(Diary3Repository $diary3Repository): Response
    {
        return $this->render('diary3/index.html.twig', [
            'diary3s' => $diary3Repository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_diary3_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Diary3Repository $diary3Repository): Response
    {
        $diary3 = new Diary3();
        $form = $this->createForm(Diary3Type::class, $diary3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diary3Repository->save($diary3, true);

            return $this->redirectToRoute('app_diary3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diary3/new.html.twig', [
            'diary3' => $diary3,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diary3_show', methods: ['GET'])]
    public function show(Diary3 $diary3): Response
    {
        return $this->render('diary3/show.html.twig', [
            'diary3' => $diary3,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_diary3_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Diary3 $diary3, Diary3Repository $diary3Repository): Response
    {
        $form = $this->createForm(Diary3Type::class, $diary3);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $diary3Repository->save($diary3, true);

            return $this->redirectToRoute('app_diary3_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('diary3/edit.html.twig', [
            'diary3' => $diary3,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_diary3_delete', methods: ['POST'])]
    public function delete(Request $request, Diary3 $diary3, Diary3Repository $diary3Repository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$diary3->getId(), $request->request->get('_token'))) {
            $diary3Repository->remove($diary3, true);
        }

        return $this->redirectToRoute('app_diary3_index', [], Response::HTTP_SEE_OTHER);
    }
}
