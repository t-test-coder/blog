<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity;

class BlogViewController extends AbstractController
{

    /**
     * @Route("/blog/{id}/{slug}", name="blog_view", requirements={"page"="\d+", "methods"="GET"})
     */
    public function show($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('App:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

      $comments = $em->getRepository('App:Comment')
                           ->getCommentsForBlog($blog->getId());
        return $this->render('Blog/show.html.twig', array(
            'blog'      => $blog,
            'comments'  => $comments
        ));
    }
}
