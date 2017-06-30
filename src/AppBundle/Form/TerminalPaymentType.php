<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerminalPaymentType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('month', ChoiceType::class, array(
                    'choices' => array(
                        'Janeiro' => '1', 
                        'Fevereiro' => '2',
                        'Março' => '3',
                        'Abril' => '4',
                        'Maio' => '5',
                        'Junho' => '6',
                        'Julho' => '7',
                        'Agosto' => '8',
                        'Setembro' => '9',
                        'Outubro' => '10',
                        'Novembro' => '11',
                        'Dezembro' => '12',
                        )))
                ->add('year', ChoiceType::class, array(
                    'choices' => array(
                        '2016' => '2016', 
                        '2017' => '2017',
                        '2018' => '2018',
                        '2019' => '2019',
                        '2020' => '2020',
                        '2021' => '2021',
                        '2022' => '2022',
                        '2023' => '2023',
                        
                        )))
                ->add('value')
                ->add('terminal');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TerminalPayment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_terminalpayment';
    }

}
