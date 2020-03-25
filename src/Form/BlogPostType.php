<?php
namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogPostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('title');
      $builder->add('blog');
      $builder->add('image');
      $builder->add('author');
      $builder->add('tags');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => 'App\Entity\Blog',
      ]);
    }

    public function getBlockPrefix()
    {
        return 'blog_post';
    }
}
