<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class TpaymentsSimulatorType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('valorCompra')
                ->add('numeroParcelas')
                ->add('taxa', ChoiceType::class
                        , array('choices' => array('Desconto' => 1, 'Serviço' => 2), 'data' => true
                    , 'multiple' => false
                    , 'expanded' => true));
    }

}
