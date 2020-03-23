<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// Import new namespaces
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Enquiry;
use App\Form\EnquiryType;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="index")
     */
    public function index()
    {
        $em = $this->getDoctrine()
                   ->getManager();

       $blogs = $em->getRepository('App:Blog')
                    ->getLatestBlogs();


        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'blogs' => $blogs,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('blog/about.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
      $enquiry = new Enquiry();

      $form = $this->createForm(EnquiryType::class, $enquiry);

      if ($request->isMethod($request::METHOD_POST)) {
        $form->handleRequest($request);

          if ($form->isValid()) {
            $message = (new \Swift_Message('Contact enquiry from symblog'))
                ->setFrom('enquiries@symblog.co.uk')
                ->setTo('email@email.com')
                ->setBody($this->renderView('contactEmail.txt.twig', ['enquiry' => $enquiry]));
            $mailer->send($message);
            $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

            return $this->redirect($this->generateUrl('contact'));
          }
      }

      return $this->render('blog/contact.html.twig', [
          'form' => $form->createView(),
          'controller_name' => 'BlogController',
      ]);

    }

}
