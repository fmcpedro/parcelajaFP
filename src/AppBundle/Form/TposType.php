<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class TposType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fserial')->add('fstate')->add('fsoftversion')->add('agency');
        
                $builder->add('fserial', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
                ->add('fstate', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class
                        , array('choices'  => array('Yes' => true,'No' => false), 'data' => true
                    ,'multiple' => false
                    ,'expanded' => true))
                ->add('fsoftversion')
                ->add('agency');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tpos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_tpos';
    }


}
