<?php
// src/Blogger/BlogBundle/Tests/Controller/PageControllerTest.php

namespace Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testAbout()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/');

      // Check there are some blog entries on the page
      $this->assertTrue($crawler->filter('article.blog')->count() > 0);
    }

    public function testContact()
    {
      $client = static::createClient();

      $crawler = $client->request('GET', '/contact');

      $this->assertEquals(1, $crawler->filter('h1:contains("Contact symblog")')->count());

      // Select based on button value, or id or name for buttons
      $form = $crawler->selectButton('Submit')->form();

      $form['contact[name]']       = 'name';
      $form['contact[email]']      = 'email@email.com';
      $form['contact[subject]']    = 'Subject';
      $form['contact[body]']       = 'The comment body must be at least 50 characters long as there is a validation constrain on the Enquiry entity';

      $crawler = $client->submit($form);
      // Need to follow redirect
      $crawler = $client->followRedirect();

      $this->assertEquals(1, $crawler->filter('.blogger-notice:contains("Your contact enquiry was successfully sent. Thank you!")')->count());
    }
}
