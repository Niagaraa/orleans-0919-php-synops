<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

/**
 * @Route("/admin/equipe")
 */
class AdminTeamController extends AbstractController
{
    /**
     * @Route("/", name="team_index", methods={"GET"})
     */
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('admin_team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="team_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $team->setUpdatedAt(new DateTime());
            $entityManager->persist($team);
            $entityManager->flush();
            $this->addFlash('success', 'Un nouveau membre a été ajouté à l\'équipe');


            return $this->redirectToRoute('team_index');
        }

        return $this->render('admin_team/new.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_show", methods={"GET"})
     */
    public function show(Team $team): Response
    {
        return $this->render('admin_team/show.html.twig', [
            'team' => $team,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="team_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $team->setUpdatedAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le membre de l\'équipe a été modifié');


            return $this->redirectToRoute('team_index');
        }

        return $this->render('admin_team/edit.html.twig', [
            'team' => $team,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="team_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Team $team): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($team);
            $entityManager->flush();
            $this->addFlash('danger', 'Le membre de l\'équipe a été supprimé');
        }

        return $this->redirectToRoute('team_index');
    }
}
