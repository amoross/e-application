<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class ApiPostController extends AbstractController
{
    /**
     * @Route("/api/post", name="api_post_get",methods={"GET"})
     */
    public function index(ArticleRepository $post,SerializerInterface $serializer): Response
    {
        $posts = $post->findAll();

        $response = $this->json($posts,200,[],['groups'=> 'post:read']);

        return $response;
    }


    /**
     * @Route("/api/post", name="api_post_post",methods={"POST"})
     */
    public function store(SerializerInterface $serializer,Request $res ,EntityManagerInterface $em): Response
    {
        try {

                $jsonRecu = $res->getContent();

                $post = $serializer->deserialize($jsonRecu,Article::class,'json');

                $post->setCreatedAt( new \DateTime());
                $em->persist($post);
                $em->flush();

                dd($post);
                return $this->json($post,201,[],['groups'=> 'post:read']);
        } catch (NotEncodableValueException $e){
            return $this->json([
                'status'=>400,
                'message'=>$e->getMessage()
            ],400);
        }
    }
}
