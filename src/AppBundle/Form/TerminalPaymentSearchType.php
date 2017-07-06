<?php

namespace AppBundle\Form;

use AppBundle\Repository\TagencyRepository;
use AppBundle\Repository\TgroupRepository;
use AppBundle\Repository\TsubgroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerminalPaymentSearchType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('terminal')
                ->add('month', ChoiceType::class, array(
                    'choices' => array(
                        NULL => '',
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
                        NULL => '',
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
                ->add('group', EntityType::class, array(
                    'class' => 'AppBundle:Tgroup',
                    'query_builder' => function (TgroupRepository $er) {
                        return $er->createQueryBuilder('g')
                                ->orderBy('g.fgroupname', 'ASC');
                    },
                    'choice_label' => 'fgroupname',
                    'required' => false
                ))
                ->add('subGroup', EntityType::class, array(
                    'class' => 'AppBundle:Tsubgroup',
                    'query_builder' => function (TsubgroupRepository $er) {
                        return $er->createQueryBuilder('sg')
                                ->orderBy('sg.fsubgroupname', 'ASC');
                    },
                    'choice_label' => 'fsubgroupname',
                    'required' => false
                ))
                ->add('agency', EntityType::class, array(
                    'class' => 'AppBundle:Tagency',
                    'query_builder' => function (TagencyRepository $er) {
                        return $er->createQueryBuilder('a')
                                ->orderBy('a.fagencyname', 'ASC');
                    },
                    'choice_label' => 'fagencyname',
                    'required' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TerminalPayment',
            'validation_groups' => false,
            'attr' => array('novalidate' => 'novalidate')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_terminalpayment';
    }

}
