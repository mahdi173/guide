<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends BaseController
{
    /**
     * @Route("/blog", name="blog_index")
     */
    public function index()
    {
        $posts = $this->em->getRepository(Post::class)->findAll();
        return $this->render(
            'blog/index.html.twig', [
                'posts' => $posts,
            ]
        );
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     *
     *  @Route("/blog/{id}", name="blog_show")
     */
    public function show(Post $post)
    {
        return $this->render(
            'blog/show.html.twig', [
                'post' => $post,
            ]
        );
    }
}
