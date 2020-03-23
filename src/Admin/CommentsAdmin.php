<?php

// src/Admin/CommentsAdmin.php

namespace App\Admin;

use App\Entity\Comment;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

final class CommentsAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('blog_id', TextType::class);
        $formMapper->add('user', TextType::class);
        $formMapper->add('comment', TextType::class);

        $formMapper->add('approved', CheckboxType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
      $datagridMapper->add('blog');
      $datagridMapper->add('user');
      $datagridMapper->add('comment');
      $datagridMapper->add('approved');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('blog');
        $listMapper->addIdentifier('user');
        $listMapper->addIdentifier('comment');
        $listMapper->addIdentifier('approved');
    }
}
