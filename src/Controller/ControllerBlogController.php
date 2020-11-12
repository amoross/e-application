<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;


use Symfony\Component\Routing\Annotation\Route;

class ControllerBlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
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
     * @Route("/blog/new",name="blog_create")
     * @Route("/blog/{id}/edit",name="blog_edit")
     */
    public function form(Article $article = null,Request $request, EntityManagerInterface $manager)
    {
        if(!$article) {
            $article = new Article();
        }
//        $form = $this->createFormBuilder($article)
//                ->add('title')
//                ->add('content')
//                ->add('image')
//                ->getForm();
        $form=$this->createForm(ArticleType::class,$article);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()) {
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('blog_show', ['id'=> $article->getId()]);
        }
        return $this->render('controller_blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode'=> $article->getId()!== null
        ]);

    }

    /**
     * @Route("/blog/{id}",name="blog_show")
     */
    public function show( Article $article,Request $request, EntityManagerInterface $manager)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTime())
                ->setRelation($article);

            $manager->persist($comment);
            $manager->flush();

            return  $this->redirectToRoute('blog_show', ['id' => $article->getId() ]);
        }

        return $this->render('controller_blog/show.html.twig',[
             'article'=>$article ,
            'commentForm'=> $form->createView()
        ]);

    }

}
