<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WsContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('email')
                ->add('subject')
                ->add('phone')
                ->add('message')
                ->add('firstValue', HiddenType::class)
                ->add('secondValue', HiddenType::class)
                ->add('validation');
        
        
//        $builder->add('name', TextType::class, array('required' => true))
//                ->add('email', EmailType::class, array('required' => true))
//                ->add('subject', TextType::class, array('required' => true))
//                ->add('phone', TextType::class, array('required' => true))
//                ->add('message', TextareaType::class, array('required' => true))
//                ->add('firstValue', HiddenType::class)
//                ->add('secondValue', HiddenType::class)
//                ->add('validation', TextType::class, array('required' => true));
        
        
        
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_wscontact';
    }


}
