<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TposSearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
                $builder->add('fserial', TextType::class, array('required' => false))
                ->add('fstate', ChoiceType::class
                        , array('choices'  => array('Yes' => true,'No' => false, 'All'=> null)
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
            'data_class' => 'AppBundle\Entity\Tpos',
             'validation_groups' => false,
             'attr'=>array('novalidate'=>'novalidate')
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
