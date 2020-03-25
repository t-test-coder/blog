<?php

namespace App\Controller;


use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Form;
    /**
     * Creates an Blog resource
     * @Route("/api/comments", name="api_comment")
     * @param Request $request
     * @return View
     */
class CommentApiController extends FOSRestController
{
     /**
      * @Rest\Get("/getCommentsForBlog/{id}")
      *
      */
    public function getCommentsForBlog(int $id)
    {
      return $this->getDoctrine()->getRepository('App:Comment')->getCommentsForBlog($id);
    }

    /**
     * @Rest\Get("/all")
     *
     */
     public function getLatestComments()
     {
       return $this->getDoctrine()->getRepository('App:Comment')->getLatestComments(null);
     }

     /**
      * @Rest\Post("/new")
      *
      */
      public function createNewComment(Request $request)
       {
         $user = $request->request->get('user');
         $comment = $request->request->get('comment');
         $blog_id = $request->request->get('blog_id');

         $class_comment  = new Comment();
         $class_comment->setUser($user);
         $class_comment->setComment($comment);

         $blog = $this->getBlog($blog_id);
         $class_comment->setBlog($blog);

         $em = $this->getDoctrine()->getManager();
         $em->persist($class_comment);
         $em->flush();
         return 'ok';
        //  $form = $this->createForm(\App\Form\CommentType::class, null, [
        //      'csrf_protection' => false,
        //  ]);
        //
        //
        // $form->handleRequest($request);
        //
        // $form->submit($request->request->all());
        //
        // //return dump($form->getData());
        //
        // if($form->isSubmitted()) {
        //    if (!$form->isValid()) {
        //       return 'form invalid';
        //    }
        //  }
        //
        //  return $form->getData();

       }

       /**
        * @Rest\Post("/update")
        *
        */
        public function updateComment(Request $request)
         {
           $id = $request->request->get('id');
           $em = $this->getDoctrine()->getManager();

           $class_comment = new Comment();
           $class_comment = $em->getRepository('App:Comment')->find($id);

           if ($class_comment === null) {
               return new View(null, Response::HTTP_NOT_FOUND);
           }

           $form = $this->createForm(\App\Form\CommentType::class, $class_comment, [
               'csrf_protection' => false,
           ]);

           $form->submit($request->request->all(), false);

           $em->flush();

           return "ok";
         }

         /**
          * @Rest\Post("/delete")
          *
          */
          public function deleteComment(Request $request)
           {
             $id = $request->request->get('id');
             $em = $this->getDoctrine()->getManager();

             $class_comment = new Comment();
             $class_comment = $em->getRepository('App:Comment')->find($id);

             //return dump($class_comment);
             if ($class_comment === null) {
                 return new View(null, Response::HTTP_NOT_FOUND);
             }

             $em->remove($class_comment);
             $em->flush();

             return "ok";
           }
}
