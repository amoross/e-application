<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/index", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/post")
     */
    public function post(): Response
    {
        return $this->render('blog/post.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

}
