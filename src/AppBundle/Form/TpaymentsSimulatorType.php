<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TpaymentsSimulatorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('valorCompra')->add('numeroParcelas')->add('taxa', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class
                        , array('choices'  => array('Desconto' => 1,'Serviço' => 2), 'data' => true
                    ,'multiple' => false
                    ,'expanded' => true));
    }
    
    
//    /**
//     * {@inheritdoc}
//     */
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'AppBundle\Entity\Tpos',
//             'validation_groups' => false,
//             'attr'=>array('novalidate'=>'novalidate')
//        ));
//    }
//    
//    
// 
//    
//    
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getBlockPrefix()
//    {
//        return 'appbundle_tpos';
//    }


}
