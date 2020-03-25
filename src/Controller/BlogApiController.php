<?php

namespace App\Controller;


use App\Entity\Blog;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Form;
    /**
     * Creates an Blog resource
     * @Route("/api/blog", name="api_blog")
     * @param Request $request
     * @return View
     */
class BlogApiController extends FOSRestController
{
     /**
      * @Rest\Get("/getPost/{id}")
      *
      */
    public function getSingleBlogPost(int $id)
    {
      return $this->getDoctrine()->getRepository('App:Blog')->find($id);
    }

    /**
     * @Rest\Get("/all")
     *
     */
     public function getAllBlogPost()
     {
       return $this->getDoctrine()->getRepository('App:Blog')->getLatestBlogs();
     }

      /**
       * @Rest\Post("/new")
       *
       */
       public function createNewPost(Request $request)
        {
            $form = $this->createForm(\App\Form\BlogPostType::class, null, [
                'csrf_protection' => false,
            ]);

            $form->handleRequest($request);
            $form->submit($request->request->all());

            if (!$form->isValid()) {
                return $form;
            }
            $blogPost = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($blogPost);
            $em->flush();

            return 'ok';

        }

        /**
         * @Rest\Post("/update")
         *
         */
         public function updatePost(Request $request)
          {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $blogPost = new Blog();
            $blogPost = $em->getRepository('App:Blog')->find($id);

            if ($blogPost === null) {
                return new View(null, Response::HTTP_NOT_FOUND);
            }

            //return dump($blogPost);
            $form = $this->createForm(\App\Form\BlogPostType::class, $blogPost, [
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
          public function deletePost(Request $request)
          {
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();

            $blogPost = new Blog();
            $blogPost = $em->getRepository('App:Blog')->find($id);

            if ($blogPost === null) {
                return new View(null, Response::HTTP_NOT_FOUND);
            }

            $em->remove($blogPost);
            $em->flush();

            return "ok";
          }
}
