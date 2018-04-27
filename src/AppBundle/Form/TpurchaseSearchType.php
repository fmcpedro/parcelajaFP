<?php

namespace AppBundle\Form;

use AppBundle\Repository\TagencyRepository;
use AppBundle\Repository\TgroupRepository;
use AppBundle\Repository\TsubgroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TpurchaseSearchType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {

//        
//        add('startDate', DateType::class, [
//                    'widget' => 'single_text',
//                    'attr' => ['class' => 'js-datepicker'],
//                    'html5' => false,
//                ])



        $builder->add('startDate', DateType::class, array(
                    'widget' => 'choice',
                    'required' =>false,

            
                ))
                ->add('endDate', DateType::class, array(
                    'widget' => 'choice',
                    'required' => false,

                ))
                ->add('contractNumber')
                ->add('groupId', EntityType::class, array(
                    'class' => 'AppBundle:Tgroup',
                    'query_builder' => function (\AppBundle\Repository\TgroupRepository $er) {
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
                    'choice_label' => 'fagencyname'
                    , 'required' => false
//                            ,'multiple' => true
//                            ,'expanded' => false
                ))
                ->add('status', ChoiceType::class, array(
                    'choices' => array(
                        NULL => '',
                        'Enabled' => '1',
                        'Disabled' => '2',
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'validation_groups' => false,
            'attr' => array('novalidate' => 'novalidate')
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_tpurchase';
    }

}
