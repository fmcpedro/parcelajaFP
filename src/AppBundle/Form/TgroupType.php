<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class TgroupType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('fgroupname')
                ->add('imageFile', VichImageType::class, ['required' => false, 
                    'allow_delete' => true,
                    'download_link' => true,
                    'label' => 'Picture to upload:',
                    'delete_label' => 'Delete image ?',
                    'download_label' => 'Download Image',
                    ])
                ->add('fgroupslugname')
                ->add('fstate', ChoiceType::class, array('choices' => array(
                        'Enabled' => true,
                        'Disabled' => false
//    )))->add('subgroupList')
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TGroup'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'appbundle_tgroup';
    }

}
