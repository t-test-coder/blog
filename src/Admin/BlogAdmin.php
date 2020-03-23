<?php

// src/Admin/BlogAdmin.php

namespace App\Admin;

use App\Entity\Blog;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class BlogAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title', TextType::class);
        $formMapper->add('author', TextareaType::class);
        $formMapper->add('blog', TextareaType::class);
        $formMapper->add('image', TextareaType::class);
        $formMapper->add('tags', TextareaType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
      $datagridMapper->add('title');
      $datagridMapper->add('author');
      $datagridMapper->add('blog');
      $datagridMapper->add('image');
      $datagridMapper->add('tags');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title');
        $listMapper->addIdentifier('author');
        $listMapper->addIdentifier('blog');
        $listMapper->addIdentifier('image');
        $listMapper->addIdentifier('tags');
    }
}
