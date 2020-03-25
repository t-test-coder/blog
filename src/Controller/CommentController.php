<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Comment controller.
 */
class CommentController extends AbstractController
{
    public function new($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(CommentType::class, $comment);

        return $this->render('blog/comments/form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }

    /**
     * @Route("/comment/{blog_id}", name="comment_create",  defaults={"_controller": "App:Comment:create"}, requirements={"page"="\d+", "methods"="POST"})
     */

    public function create(Request $request, $blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment  = new Comment();
        $comment->setBlog($blog);

        $form    = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_view', array(
              'id'    => $comment->getBlog()->getId(),
              'slug'  => $comment->getBlog()->getSlug())) .
              '#comment-' . $comment->getId()
            );
        }


        return $this->render('blog/comments/Comment:create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $blog = $em->getRepository('App:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}
