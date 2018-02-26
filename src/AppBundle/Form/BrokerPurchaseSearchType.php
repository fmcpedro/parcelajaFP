<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;


use AppBundle\Repository\BrokerRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BrokerPurchaseSearchType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('startDate', DateType::class, array(
                    'widget' => 'choice',
                ))
                ->add('endDate', DateType::class, array(
                    'widget' => 'choice',
                ))
                
                ->add('brokerId', EntityType::class, array(
                    'class' => 'AppBundle:Broker',
                    'query_builder' => function (BrokerRepository $er) {
                        return $er->createQueryBuilder('b')
                                ->orderBy('b.name', 'ASC');
                    },
                    'choice_label' => 'labelToSelect',
                    'required' => false
                ));
    }

}
