<?php

namespace Avtenta\AngularBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('author')
            ->add('category')
            ->add('publishDate')
            ->add('summary')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Avtenta\AngularBundle\Entity\Book'
        ));
    }

    public function getName()
    {
        return 'avtenta_angularbundle_booktype';
    }
}
