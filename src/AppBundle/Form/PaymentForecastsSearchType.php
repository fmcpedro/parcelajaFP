<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class PaymentForecastsSearchType extends AbstractType {

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
                ->add('forecastsType', ChoiceType::class
                        , array('choices' => array('Semanal' => 1, 'Mensal' => 2), 'data' => true
                    , 'multiple' => false
                    , 'expanded' => true));
    }

}
