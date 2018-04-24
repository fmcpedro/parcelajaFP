<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TsubgroupType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fsubgroupname')->add('imageFile', VichImageType::class, [
            'required' => false,
            'label'     => 'Picture to upload:',
            'delete_label' => 'Delete image ?',
            'download_label' => 'Download Image',
        ])->add('fstate', ChoiceType::class
                , array(
            'choices' => array(
                'Enabled' => true,
                'Disabled' => false,
    )))->add('group');
    }

/**
     * {@inheritdoc}
     */

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Tsubgroup'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_tsubgroup';
    }

}
