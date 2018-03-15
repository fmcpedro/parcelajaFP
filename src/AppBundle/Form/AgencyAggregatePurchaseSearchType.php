<?php

namespace AppBundle\Form;

use AppBundle\Repository\TagencyRepository;
use AppBundle\Repository\TgroupRepository;
use AppBundle\Repository\TsubgroupRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class AgencyAggregatePurchaseSearchType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('status', ChoiceType::class, array(
                    'choices' => array(NULL => '', 'Activo' => 1, 'Inactivo' => 0)))
                ->add('numFiscal')
                ->add('nomeFiscal')
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
                    'choice_label' => 'fagencyname'
                    , 'required' => false
//                            ,'multiple' => true
//                            ,'expanded' => false
        ));
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'validation_groups' => false,
            'attr' => array('novalidate' => 'novalidate')
        ));
    }

}
