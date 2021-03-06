<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Tool;
use App\Form\CommentType;
use App\Repository\CategoryRepository;
use App\Repository\ToolRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ToolController extends AbstractController
{
    /**
     * @Route("outils/{slug}", name="tool")
     * @IsGranted("ROLE_USER")
     * @return Response
     */

    public function index(
        Category $category,
        ToolRepository $toolRepository,
        Request $request
    ): Response {
        $tools = $toolRepository->findAll();
        $comments = $category->getComments();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setDate(new DateTime());
            $comment->setAuthor($this->getUser());
            $comment->setCategory($category);

            $entityManager->persist($comment);
            $entityManager->flush();

            $toolSlug = $comment->getCategory()->getSlug();

            return $this->redirectToRoute('tool', ['slug' => $toolSlug, '_fragment' => 'comments']);
        }

        return $this->render('tool/index.html.twig', [
            'category' => $category,
            'tools' => $tools,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
