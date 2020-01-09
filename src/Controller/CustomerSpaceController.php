<?php


namespace App\Controller;

use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerSpaceController extends AbstractController
{
    /**
     * @Route("/espace-client", name="customer_space")
     * @IsGranted("ROLE_USER")
     * @return  Response
     */
    public function show(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('user/show.html.twig', [
            'user' => $this->getUser(),
            'categories' => $categories
        ]);
    }
}