<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ControllerBlogController extends AbstractController
{
    /**
     * @Route("/blog", name="controller_blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll();
        return $this->render('controller_blog/index.html.twig', [
            'controller_name' => 'ControllerBlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/",name="home")
     */
    public function home()
    {
        return $this->render('controller_blog/home.html.twig',[
            'title' => 'Bienvenue sur le bloc'
        ]);

    }

    /**
     * @Route("/blog/{id}",name="blog_show")
     */
    public function show( Article $article)
    {
        return $this->render('controller_blog/show.html.twig',[
             'article'=>$article
        ]);

    }
}
