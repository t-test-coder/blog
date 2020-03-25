<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\RouteRedirectView;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
