<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BrokerType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('name')
                ->add('taxName')
                ->add('nif')
                ->add('address', TextareaType::class, array(
                    'attr' => array('class' => 'form-control'),
                ))
                ->add('email')
                ->add('contact')
                ->add('bank')
                ->add('iban')
                ->add('commission');
//                ->add('agencyList');
    }

    
    
    
    
    
    
//    
//    , EntityType::class, array('attr' => array('size' => '20'),
//    // query choices from this entity
//    'class' => 'AppBundle:Tagency',
//
//    // use the User.username property as the visible option string
//    'choice_label' => 'fagencyname',
//
//    // used to render a select box, check boxes or radios
//     'multiple' => true,
//    // 'expanded' => true,

    
    
    
    
    
    
    
    
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Broker'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_broker';
    }

}
