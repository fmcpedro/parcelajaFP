<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

use AppBundle\Repository\TagencyRepository;
use AppBundle\Repository\TgroupRepository;
use AppBundle\Repository\TsubgroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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
                
                ->add('groupId', EntityType::class, array(
                    'class' => 'AppBundle:Tgroup',
                    'query_builder' => function (TgroupRepository $er) {
                        return $er->createQueryBuilder('g')
                                ->orderBy('g.fgroupname', 'ASC');
                    },
                    'choice_label' => 'fgroupname',
                    'required' => false
                ))
                ->add('subgroupId', EntityType::class, array(
                    'class' => 'AppBundle:Tsubgroup',
                    'query_builder' => function (TsubgroupRepository $er) {
                        return $er->createQueryBuilder('sg')
                                ->orderBy('sg.fsubgroupname', 'ASC');
                    },
                    'choice_label' => 'fsubgroupname',
                    'required' => false
                ))
                ->add('agencyId', EntityType::class, array(
                    'class' => 'AppBundle:Tagency',
                    'query_builder' => function (TagencyRepository $er) {
                        return $er->createQueryBuilder('a')
                                ->orderBy('a.fagencyname', 'ASC');
                    },
                    'choice_label' => 'fagencyname',
                    'required' => false
        ))
                
                ->add('forecastsType', ChoiceType::class
                        , array('choices' => array('Semanal' => 1, 'Mensal' => 2), 'data' => true
                    , 'multiple' => false
                    , 'expanded' => true));
    }

}
